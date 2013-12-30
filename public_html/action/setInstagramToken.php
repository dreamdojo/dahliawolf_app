<?
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if( isset($_POST['token']) ){
	$_SESSION['user']['instagramToken'] = $_POST['token'];

    $url = 'http://dev.api.dahliawolf.com/1-0/social_network.json?use_hmac_check=0&function=save_link&user_id='.$_SESSION['user']['user_id'].'&social_network_id=12&token='.$_POST['token'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);
}
?>