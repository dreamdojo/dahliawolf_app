<?php
$to = "geoff@offlinela.com";
$subject = "NEW GIFT CARD REQUEST";
$message = "MSG: ".$_POST['msg'];
$from = "admin@dahliawolf.com";
$headers = "From:admin@dahliawolf.com";
mail($to,$subject,$message,$headers);
?>