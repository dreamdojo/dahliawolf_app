<?php
session_start();
require_once('tumblroauth/tumblroauth.php');

// Define the needed keys
$consumer_key = "CVzhkkyjfjeKsGeDuOflRGddP14Y3jzDLGUi0QnHTfvnAF010D";
$consumer_secret = "7LZAUDAreohtQ50IrdOz2WjrRoxQ3d5MPdRLXb2h75Zhw43XLz";

$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $_SESSION['tumblr']['access_token']['oauth_token'], $_SESSION['tumblr']['access_token']['oauth_token_secret']);

// Make an API call with the TumblrOAuth instance.  There's also a post and delete method too.
$userinfo = $tum_oauth->get('http://api.tumblr.com/v2/user/info');

$params = array(data => file_get_contents( $_GET['url'] ), type => "photo", source=>urlencode($_GET['url']), tags => 'dahliawolf', caption=>'Love this on Dahlia\wolf', link=>urlencode('http://www.dahliawolf.com') );
$newPost = $tum_oauth->post('http://api.tumblr.com/v2/blog/'.$userinfo->response->user->name.'.tumblr.com/post',$params);

echo json_encode($newPost);
?>