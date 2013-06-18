<?php
session_start();
//include("include/config.php");
//include("include/functions/import.php");
//require_once 'oauth/importInstagram.php';
$user_id = $_GET['user_id'];
function get_curl($url){
	if(function_exists('curl_init')){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}else{
		return file_get_contents($url);
	}
}	

if ($_SESSION['USERID'] != "" && $_SESSION['USERID'] >= 0 && is_numeric($_SESSION['USERID']))
{
	if($config['instagram_en'] == "1")
	{
		require_once 'oauth/importInstagram.php';
		$configII = array(
			'client_id' => '1bfee63f88c14624821ae8f58eb5d46c',
			'client_secret' => '3f012f997f6a4e88a1645af7ee51eb67',
			'grant_type' => 'authorization_code',
			'redirect_uri' => 'http://www.dahliawolf.com/getfeedfrominstagram.php?response_type=code',
		);
		if(!isset($_SESSION['InstagramAccessToken'])){
			$instagram = new Instagram($configII);
			$accessToken = $instagram->getAccessToken();
			$_SESSION['InstagramAccessToken'] = $accessToken;
			$instagram->setAccessToken($_SESSION['InstagramAccessToken']);
		}	
		
		$thebaseurl = $config['baseurl'];
		//variables//
		$query = "select instagram_id,unixtime_instagram as  unixtime from members where USERID='".mysql_real_escape_string($_SESSION['USERID'])."'"; 
		$executequery = $conn->execute($query);
		$u = $executequery->getrows();
		$instagramid=$u[0]['instagram_id'];
		$api ='https://api.instagram.com/v1/users/'.$instagramid.'/media/recent/?access_token='.$_SESSION['InstagramAccessToken'];
		$response = get_curl($api);
		if($response){
			header('Content-Type: application/json');
			echo $response;
			return;
			//echo "access: ".$_SESSION['InstagramAccessToken'];	
		}
		else{
			echo "ERROR";
			}
	}
}else{
	echo $user_id."error!!".$config['instagram_en'];
}
?>

