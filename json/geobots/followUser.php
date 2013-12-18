<?php

include_once "bots.php";

$user_id = $_POST['user_id'];
$limit = $_POST['limit'];


if( !empty($user_id) ) {
    foreach($geobots as $i=>$bot) {
        if($i < $limit) {
            $url = 'http://dev.dahliawolf.com/api/1-0/user.json?user_follow_id='.$user_id.'&user_id='.$bot.'&use_hmac_check=0&function=follow';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = json_decode(curl_exec ($ch));
            curl_close ($ch);
            echo "adding like, ";
        }
    }
}

?>