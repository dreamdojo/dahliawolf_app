<?php
	require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

	$access_token = $_SESSION['access_token'];
	
	/* Create a TwitterOauth object with consumer/user tokens. */
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	/* If method is set change API call made. Test is called by default. */
	$account = $connection->get('https://api.twitter.com/1.1/account/verify_credentials.json');
	
	echo json_encode($account);

?>