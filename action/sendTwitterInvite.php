<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if( !empty($_POST['user_name']) ){
	$username = $_POST['user_name'];
	
	$access_token = $_SESSION['access_token'];
	
	/* Create a TwitterOauth object with consumer/user tokens. */
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	/* If method is set change API call made. Test is called by default. */
	$content = $connection->post('https://api.twitter.com/1.1/direct_messages/new.json', array('text' => 'Hey come check out Dahliawolf! www.dahliawolf.com', 'screen_name' => $username) );
	
	var_dump($content);
}

?>