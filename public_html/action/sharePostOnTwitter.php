<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$cursor = $_POST['cursor'];
$screen_name = $_POST['screen_name'];

$access_token = $_SESSION['twitter']['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
$params = array('status' => 'Just posted this on #Dahliawolf '.$_GET['url']);

$content = $connection->post('https://api.twitter.com/1.1/statuses/update.json', $params, true, true);

echo json_encode($content);

?>