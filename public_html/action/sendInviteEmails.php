<?php
    $emails = $_POST['emails'];

    if(!empty($emails) && isset($emails) ) {
        foreach($emails as $mail) {
            $to      = $mail;
            $subject = 'Join me at Dahliawolf';
            $message = 'Come and play with me at Dahliawolf and help inspire the future of fashion!! '.$_POST['message'].' http://www.dahliawolf.com';
            $headers = 'From: '.$_POST['user_email'].'' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
        }
    }

?>