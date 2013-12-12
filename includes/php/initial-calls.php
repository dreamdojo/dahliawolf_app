<?
$self = $_SERVER['PHP_SELF'];

// Mobile should use same logic per page
$self = str_replace('/mobile', '', $self);

function default_redirect() {
	header ("Location: error_pages/404.html");
	die();
}

$_data = array();

$_data['cart'] = get_cart();

if (IS_LOGGED_IN) {
	$friends = array();
	$params = array(
		'username' => $_SESSION['user']['username'],
		'viewer_user_id' => $_SESSION['user']['user_id']
	);

	$data = api_call('user', 'get_following', $params, true);
	$friends = $data['data'];

	$params = array(
		'user_id' => $_SESSION['user']['user_id']
	);
	$userConfig = api_call('user', 'get_user', $params, true);
	$userConfig = $userConfig['data'];

    $url = 'http://dev.api.dahliawolf.com/1-0/social_network.json?use_hmac_check=0&function=get_user_link&user_id='.$_SESSION['user']['user_id'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
    foreach($result->data->get_user_link->social_links as $network) {
           if($network->social_network_id == 6) {//twitter
               //$_SESSION['twitter']['access_token']['oauth_token'] = $network->token;
               //$_SESSION['twitter']['access_token']['oauth_token_secret'] = $network->token_secret;
           } else if($network->social_network_id == 14) {
               $_SESSION['tumblr']['access_token']['oauth_token'] = $network->token;
               $_SESSION['tumblr']['access_token']['oauth_token_secret'] = $network->token_secret;
           }
    }
}

?>