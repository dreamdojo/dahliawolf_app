<?php

include_once "bots.php";

$posting_id = $_GET['posting_id'];
$limit = $_GET['limit'];


foreach($geobots as $i=>$bot) {
  if($i < $limit) {
      $url = 'http://www.dahliawolf.com/api/1-0/posting.json?user_id='.$bot.'&posting_id='.$posting_id.'&like_type_id=1&use_hmac_check=0&function=add_like';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $result = json_decode(curl_exec ($ch));
      curl_close ($ch);
      echo "adding like, ";
  }
}

?>