<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$cursor = $_POST['cursor'];
$screen_name = $_POST['screen_name'];

$access_token = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
$content = $connection->get('https://api.twitter.com/1.1/friends/list.json?cursor='.$cursor.'&screen_name='.$screen_name.'&skip_status=true&include_user_entities=false');

echo json_encode($content);

?>