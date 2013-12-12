<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
session_start();
require_once('lib/twitteroauth/twitteroauth.php');
require_once('config/config.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: ./clearsessions.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['twitter']['access_token'] = $access_token;

$url = 'http://dev.api.dahliawolf.com/1-0/social_network.json?use_hmac_check=0&function=save_link&user_id='.$_SESSION['user']['user_id'].'&social_network_id=6&token='.$_SESSION['twitter']['access_token']['oauth_token'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = json_decode(curl_exec ($ch));
curl_close ($ch);

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code): ?>
  <?/* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';?>
<? else: ?>
  /* Save HTTP status for error dialog on connnect page.*/
  <? header('Location: ./clearsessions.php'); ?>
<? endif ?>
<script>
    opener.dahliawolf.twitterToken = <?= json_encode($_SESSION['twitter']['access_token']['oauth_token']) ?>;
    if(opener.globalCallback) {
        opener.globalCallback();
        opener.globalCallback = false;
    }
    close();
</script>
