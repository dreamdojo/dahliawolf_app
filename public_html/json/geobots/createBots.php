<?php

    $names = Array();
    $users = Array();
    foreach($names as $i=>$user) {
        $url = 'http://api.dahliawolf.com/api.php?api=user&function=register&use_hmac_check=0&email=geoBotv1_'.$i.'@dahliawolf.com&username='.$user.'&password=password&api_website_id=2';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec ($ch));
        curl_close ($ch);

        $users[$i] = $result;
    }

    echo json_encode($users);
?>