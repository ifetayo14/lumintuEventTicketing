<?php
    require_once '../config.php';
    require_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';

    $email = trim($_POST['email']);
    $encodeMail = base64_encode($email);
    $message = '<html><head>
                <title>Email Verification</title>
                </head>
                <body>';
    $message .= '<h1>Hai ' . $email . '!</h1>';
    $message .= '<p><a '
?>