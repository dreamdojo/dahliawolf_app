<?php
// Start a session, load the library
session_start();
require_once('tumblroauth/tumblroauth.php');

// Define the needed keys
$consumer_key = "CVzhkkyjfjeKsGeDuOflRGddP14Y3jzDLGUi0QnHTfvnAF010D";
$consumer_secret = "7LZAUDAreohtQ50IrdOz2WjrRoxQ3d5MPdRLXb2h75Zhw43XLz";

// Once the user approves your app at Tumblr, they are sent back to this script.
// This script is passed two parameters in the URL, oauth_token (our Request Token)
// and oauth_verifier (Key that we need to get Access Token).
// We'll also need out Request Token Secret, which we stored in a session.

// Create instance of TumblrOAuth.
// It'll need our Consumer Key and Secret as well as our Request Token and Secret
$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $_SESSION['request_token'], $_SESSION['request_token_secret']);

// Ok, let's get an Access Token. We'll need to pass along our oauth_verifier which was given to us in the URL. 
$access_token = $tum_oauth->getAccessToken($_REQUEST['oauth_verifier']);

// We're done with the Request Token and Secret so let's remove those.
unset($_SESSION['request_token']);
unset($_SESSION['request_token_secret']);

// Make sure nothing went wrong.
if (200 == $tum_oauth->http_code) {
  // good to go
} else {
  //die('Unable to authenticate');
}

// What's next?  Now that we have an Access Token and Secret, we can make an API call.

// Any API call that requires OAuth authentiation will need the info we have now - (Consumer Key,
// Consumer Secret, Access Token, and Access Token secret).

// You should store the Access Token and Secret in a database, or if you must, a Cookie in the user's browser.
// Never expose your Consumer Secret.  It should stay on your server, avoid storing it in code viewable to the user.

// I'll make the /user/info API call to get some baisc information about the user

// Start a new instance of TumblrOAuth, overwriting the old one.
// This time it will need our Access Token and Secret instead of our Request Token and Secret
//$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, 'hCM6GehPbCeonrWBFB6ytCAmOa8kgWYGm4CL0hgPRQx0zIY5zz', 'MT2qpUnE2NIIxQpJTyx2KkcD1MBjNo71AB3g8h8iRTySpUdKft');

// Make an API call with the TumblrOAuth instance.  There's also a post and delete method too.
//$userinfo = $tum_oauth->get('http://api.tumblr.com/v2/user/info');

//$params = array(data => file_get_contents('http://www.dahliawolf.com/postings/uploads/image.php?imagename=736_1379465290.jpg'), type => "photo", source=>urlencode('http://www.dahliawolf.com/postings/uploads/image.php?imagename=736_1379465290.jpg') );

//$newPost = $tum_oauth->post('http://api.tumblr.com/v2/blog/monk3ypoop.tumblr.com/post',$params);


//var_dump($userinfo);

// You don't actuall have to pass a full URL,  TukmblrOAuth will complete the URL for you.
// This will also work: $userinfo = $tum_oauth->get('user/info');

// Check for an error.
/*if (200 == $tum_oauth->http_code) {
  // good to go
} else {
  die('Unable to get info');
}*/

// find primary blog.  Display its name.

$url = 'http://dev.api.dahliawolf.com/1-0/social_network.json?use_hmac_check=0&function=save_link&user_id='.$_SESSION['user']['user_id'].'&social_network_id=14&token='.$access_token['oauth_token'].'&token_secret='.$access_token['oauth_token_secret'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = json_decode(curl_exec ($ch));
curl_close ($ch);

$_SESSION['tumblr']['access_token']['oauth_token'] = $access_token['oauth_token'];
$_SESSION['tumblr']['access_token']['oauth_token_secret'] = $access_token['oauth_token_secret'];


// And that's that.  Hopefully it will help.
?>
<script>
    opener.dahliawolf.tumblrToken = "<?= $access_token['oauth_token'] ?>";
    if(opener.globalCallback) {
        opener.globalCallback(); 
        opener.globalCallback = false;
    };
    close();
</script>