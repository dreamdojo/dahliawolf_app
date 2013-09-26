<?php
session_start();
require_once('tumblroauth/tumblroauth.php');

// Define the needed keys
$consumer_key = "CVzhkkyjfjeKsGeDuOflRGddP14Y3jzDLGUi0QnHTfvnAF010D";
$consumer_secret = "7LZAUDAreohtQ50IrdOz2WjrRoxQ3d5MPdRLXb2h75Zhw43XLz";

$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $_SESSION['tumblr']['access_token']['oauth_token'], $_SESSION['tumblr']['access_token']['oauth_token_secret']);

// Make an API call with the TumblrOAuth instance.  There's also a post and delete method too.
$userinfo = $tum_oauth->get('http://api.tumblr.com/v2/user/info');

//$newPost = $tum_oauth->get('http://api.tumblr.com/v2/blog/'.$userinfo->response->user->name.'.tumblr.com/posts',$params);

echo json_encode($userinfo);
?>