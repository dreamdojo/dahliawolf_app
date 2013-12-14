<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if($_SESSION['user']['user_id'] && $_POST['platform']) {
    $url = 'http://dev.api.dahliawolf.com/1-0/social_network.json?use_hmac_check=0&function=save_link&user_id='.$_SESSION['user']['user_id'].'&social_network_id='.$_POST['platform'].'&token='.''.'&token_secret='.'';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec ($ch));
    curl_close ($ch);

    switch($_POST['platform']) {
        case 3 :
            unset($_SESSION['facebook']);
            break;
        case 6 :
            unset($_SESSION['twitter']);
            break;
        case 14 :
            unset($_SESSION['tumblr']);
            break;
    }

}

?>