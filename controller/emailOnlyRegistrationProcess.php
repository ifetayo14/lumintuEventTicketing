<?php

require_once '../config.php';
    require_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';

    $email = trim($_POST['email']);
    $message = '<html><head>
                <title>Email Verification</title>
                </head>
                <body>';
    $message .= '<h1>Hai ' . $email . '!</h1>';
    $message .= '<p><a href="' . VERIFY_URL . '?m=' . base64_encode($email) .'">Klik untuk melanjutkan registrasi';
    $message .= "</body></html>";

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    $mail->IsSMTP();

    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;

//    $mail->Username =
?>