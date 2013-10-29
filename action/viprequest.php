<?php
$to = "vip@dahliawolf.com, paxton@dahliawolf.com";
$subject = "user submitted vip request";
$message = "VIP ME FOO! ".$_POST['user'];
$from = "admin@dahliawolf.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?>