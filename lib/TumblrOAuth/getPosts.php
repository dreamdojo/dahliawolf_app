<?php
session_start();
require_once('tumblroauth/tumblroauth.php');

// Define the needed keys
$consumer_key = "CVzhkkyjfjeKsGeDuOflRGddP14Y3jzDLGUi0QnHTfvnAF010D";
$consumer_secret = "7LZAUDAreohtQ50IrdOz2WjrRoxQ3d5MPdRLXb2h75Zhw43XLz";

$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $_SESSION['tumblr']['access_token']['oauth_token'], $_SESSION['tumblr']['access_token']['oauth_token_secret']);

// Make an API call with the TumblrOAuth instance.  There's also a post and delete method too.
$userinfo = $tum_oauth->get('http://api.tumblr.com/v2/user/info');

$params = array('type' => 'photo');

$newPost = $tum_oauth->get($userinfo->response->user->url, $params);
//http://api.tumblr.com/v2/blog/cultoftomorrow.tumblr.com/posts/photo?&limit=20&offset=20&api_key=3d18fdI6UxAa52wJAaM3y9XkdcYt0RP9VXaB4MztNghZjO0N85

$url = "http://api.tumblr.com/v2/blog/".$userinfo->response->user->name.".tumblr.com/posts/photo?&limit=20&offset=20&api_key=CVzhkkyjfjeKsGeDuOflRGddP14Y3jzDLGUi0QnHTfvnAF010D";
/*$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);
/*
$xml = new SimpleXmlElement($data, LIBXML_NOCDATA);
$cnt = count($xml->channel->item);

for($i=0; $i<$cnt; $i++){
    $img    = $xml->channel->item[$i]->description;
    $title  = $xml->channel->item[$i]->title;
    $description 		= split("<p>",$img);
    $fulldescription 	= substr($description[2], 0, -4);
    $unixdate 			= strtotime($xml->channel->item[$i]->pubDate);
    $source 			= "http://www.pinterest.com";
    $hashash 			= strpos($img,$hashtag);
    $theurl 			= getimg($img);
    $caption 			= $fulldescription;
    $description 		= cleanit($caption);
    $sourceurl 			= cleanit($source);
    $url 				= cleanit($theurl);
    $big_url	 		= $url;//substr($url, 0, -6).substr($url,-4);
    $big_url			= str_replace('192', '736', $big_url);
    $money[] 			= array('images' => array('thumbnail' => array('url' => $url), 'standard_resolution' => array('url' => $big_url), 'source' => array('src' => 'pinterest')));
}*/
//header('Content-Type: application/json');
$result = file_get_contents($url);
// Will dump a beauty json :3
var_dump(json_decode($result, true));
//echo $url;
//echo json_encode($ch);
?>