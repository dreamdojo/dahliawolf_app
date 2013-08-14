<?
class API {
	private $api_key;
	private $private_key;
	private $api_domain = 'http://api.dahliawolf.com';
    private $api_url = 'http://api.dahliawolf.com/1-0';
	
	private $SoapClients = array();
	
	public function __construct($api_key, $private_key, $api_url = NULL) {
		$this->api_key = $api_key;
		$this->private_key = $private_key;
	}
	
	public function rest_api_request($api_service, $calls = array(), $reponse_format = 'json')
    {
        $api_domain = strpos($_SERVER['SERVER_NAME'], 'dev')>-1? "dev.api.dahliawolf.com" : "api.dahliawolf.com";

        $this->api_domain = "http://$api_domain";
        $this->api_url = "http://{$api_domain}/1-0";
		$api_url = $this->api_url . '/' . $api_service . '.' . $reponse_format;

		// Initialize
		$ch = curl_init();
		$this->set_rest_api_request_options($ch, $api_url, $calls);

		// Attempt to connect up to 3 times
		$attempts = 0;
		do {
			if ($attempts > 0) {
				sleep(1); // sleep for 5 seconds between retrys
			}
	
			$curlError = '';
			$errorNum = '';
			$result = curl_exec($ch); //execute post and get results
			$curlError = curl_error($ch);
			$errorNum = curl_errno($ch);
			$attempts++;
	
		} while ($curlError != '' && $attempts < 3); 
	
		curl_close($ch);
	
		// Call Failed
		if ($curlError != '') {
			$result = array(
				'errors' => 'Curl Error:' . $curlError
			);
	
			$result = json_encode($result);
		}
	
		return $result; 
	}
	
	private function set_rest_api_request_options(&$ch, $api_url, $calls = array()) {
		curl_setopt($ch, CURLOPT_URL, $api_url);
	
		// Use HTTP POST to send form data
		if (is_array($calls) && !empty($calls)) {
			$rest_request = $this->generate_rest_request($calls);
		
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $rest_request);
		}
		
		curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
		
		// Turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	
		// Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	}
	
	public function get_hmac($calls) {
		if (is_array($calls) && !empty($calls)) {
			$json_encoded_calls = json_encode($calls);
			$soap_request = array(
				'api_key' => $this->api_key
				, 'calls' => $json_encoded_calls
			);
			
			$param_string = urldecode(http_build_query($soap_request));
			$hmac = hash_hmac('sha256', $param_string, $this->private_key);
			
			return $hmac;
		}
		return NULL;
	}
	
	public function generate_soap_request($calls) {
		return array(
			'api_key' => $this->api_key
			, 'calls' => $calls
			, 'hmac' => $this->get_hmac($calls)
		);
	}
	
	public function generate_rest_request($calls) {
		return 'api_key=' . $this->api_key . '&calls=' . urlencode(json_encode($calls)) . '&hmac=' . $this->get_hmac($calls);
	}
	
	public function rest_api_requests($api_requests, $reponse_format = 'json') {
		$responses = array();
		if (!empty($api_requests)) {
			$handles = array();
			$mh = curl_multi_init();
			foreach ($api_requests as $api_service => $calls) {
				$ch = curl_init();
				$api_url = $this->api_url . '/' . $api_service . '.' . $reponse_format;
				$this->set_rest_api_request_options($ch, $api_url, $calls);
				$handles[$api_service] = $ch;
			}
			
			// multi handle
			$mh = curl_multi_init();
			
			// add handles to multi handle
			foreach ($handles as $handle) {
				curl_multi_add_handle($mh, $handle);
			}
			
			$active = NULL;
			

			do { // Mainly for creating connections. It does not wait for the full response.
				$mrc = curl_multi_exec($mh, $active);
			} while($mrc == CURLM_CALL_MULTI_PERFORM || $active);
			

			foreach ($api_requests as $api_service => $calls) {
				$curl_error = curl_error($ch);
				if ($curl_error != '') {
					$result = array(
						'errors' => 'Curl Error:' . $curl_error
					);
			
					$responses[$api_service] = json_encode($result);
				}
				else {
					$responses[$api_service] = curl_multi_getcontent($handles[$api_service]);
				}
				
				curl_multi_remove_handle($mh, $handles[$api_service]);

			}
			curl_multi_close($mh);
		}
		
		return $responses;
	}
	
	public function soap_api_request($api_service, $calls = array(), $reponse_format = 'xml') {
		try {
			if (empty($this->SoapClients[$api_service])) {
				$this->SoapClients[$api_service] = new SoapClient(
					NULL
					, array(
						'uri' => $this->api_domain,
						'location' => $this->api_url . '/' . $api_service . '.xml',
						'trace' => true
					)
				);
			}
			
			// Set Requests
			$soap_request = $this->generate_soap_request($calls);
			
			// Send Request
			$soap_result = $this->SoapClients[$api_service]->process_request($soap_request);
			
			// XML Request
			$soap_xml_request = $this->SoapClients[$api_service]->__getLastRequest();
			
			// XML Response
			$soap_xml_response = $this->SoapClients[$api_service]->__getLastResponse();
			return $soap_xml_response;
		} catch (Exception $e) {
			$soap_xml_request = $this->SoapClients[$api_service]->__getLastRequest();
			
			return 'SOAP Error: ' . $e->getMessage();
		}
	}
}
?>