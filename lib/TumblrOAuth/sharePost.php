<?php
session_start();
require_once('tumblroauth/tumblroauth.php');

// Define the needed keys
$consumer_key = "CVzhkkyjfjeKsGeDuOflRGddP14Y3jzDLGUi0QnHTfvnAF010D";
$consumer_secret = "7LZAUDAreohtQ50IrdOz2WjrRoxQ3d5MPdRLXb2h75Zhw43XLz";

$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $_SESSION['access_token']['oauth_token'], $_SESSION['access_token']['oauth_token_secret']);

// Make an API call with the TumblrOAuth instance.  There's also a post and delete method too.
$userinfo = $tum_oauth->get('http://api.tumblr.com/v2/user/info');

echo $_GET['url'];

$params = array(data => file_get_contents( $_GET['url'] ), type => "photo", source=>urlencode($_GET['url']) );
$newPost = $tum_oauth->post('http://api.tumblr.com/v2/blog/'.$userinfo['name'].'.tumblr.com/post',$params);
echo json_encode($newPost);

?>