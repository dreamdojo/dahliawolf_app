<?php
$to = "vip@dahliawolf.com, geoff@offlinela.com, justin@offlinela.com";
$subject = "NEW GIFT CARD REQUEST";
$message = "this user: ".$_POST['user'].' entered this code: '.$_POST['code'];
$from = "admin@dahliawolf.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?>