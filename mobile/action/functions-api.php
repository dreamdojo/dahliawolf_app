<?
function api_request($service, $calls, $return_array = false) {
	if (!class_exists('API', false)) {
		require $_SERVER['DOCUMENT_ROOT'] . '/lib/php/API.php';
	}
	
	// Instantiate library helper
	$api = new API(API_KEY_DEVELOPER, PRIVATE_KEY_DEVELOPER);
	
	// Make request
	$result = $api->rest_api_request($service, $calls);
	
	if (!$return_array) {
		return $result;
	}
	
	$decoded = json_decode($result, true);
	if ($decoded) {
		return $decoded;
	}
	echo $result;
	return;
}

function api_call($endpoint, $function, $parameters = NULL, $return_array = false) {
	$query_string = empty($parameters) ? '' : http_build_query($parameters);
	$url = 'http://api.dahliawolf.com/api.php?api=' . $endpoint . '&function=' . $function . '&' . $query_string;
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec ($ch);
    curl_close ($ch);
	
	if (!$return_array) {
		return $result;
	}
	
	$decoded = json_decode($result, true);
	if ($decoded) {
		return $decoded;
	}
	echo $result;
	return;
}
?>