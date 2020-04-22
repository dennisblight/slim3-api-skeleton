<?php

use PHPMailer\PHPMailer\PHPMailer;

return $container->factory(function() {

    $mail = new PHPMailer();
    $settings = load_setting('mail');

    foreach($settings as $key => $value)
    {
        $mail->$key = $value;
    }
    
    return $mail;
});