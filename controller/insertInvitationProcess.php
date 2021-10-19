<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/OAuth.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/POP3.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';

    include('../config.php');

    $name1 = $_POST['peserta1'];

    $buyTicketLink = 'http://localhost/intern/ticketing/view/main.php';
    $bioLink = 'http://localhost/intern/ticketing/view/invitation.php';

    if ($_POST['peserta2'] == ''){
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mintuticketing@gmail.com';
        $mail->Password = 'Mintu123';
        $mail->Port = 587;

        $mail->setFrom('mintuticketing@gmail.com', 'Lumintu Events');
        $mail->addAddress($name1);
        $mail->Subject = "[Lumintu Events] Link Pemesanan Tiket";
        $mail->isHTML(true);
        $mail->Body = 'Hai ' . $name1 . ', silahkan klik link berikut untuk melakukan pemesanan tiket<br/><br/>
                            <a href="' . $buyTicketLink . '?m=' . base64_encode($name1) .'">Pesan Tiket</a>';

        if ($mail->send()){
            header('Location: ../view/details.php?scs');
        }
        else{
            header('Location: ../view/details.php?mailErrSolo');
        }
    }

    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'alvinsimbolon6@gmail.com';
    $mail->Password = 'powerofbr4in';
    $mail->Port = 587;

    $mail->setFrom('mintuticketing@gmail.com', 'Lumintu Events');
    $mail->Subject = "[Lumintu Events] Link Pengisian Biodata Pemesanan Tiket";
    $mail->isHTML(true);

    if (!isset($_POST['peserta3'])){
        $name2 = $_POST['peserta2'];
        $mail->addAddress($_POST['peserta2']);
        $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name2) .'">Pesan Tiket</a>';
    }
    elseif (!isset($_POST['peserta4'])){
        for ($x = 2; $x <= 3; $x++){
            $name = $_POST['peserta' . $x];
            $mail->addAddress($_POST['peserta' . $x]);
            $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name) . '">Pesan Tiket</a>';

            if (!$mail->send()){
                header('Location: ../view/details.php?mailErr');
            }
            $mail->clearAddresses();
        }
    }
    elseif (!isset($_POST['peserta5'])){
        for ($x = 2; $x <= 4; $x++){
            $name = $_POST['peserta' . $x];
            $mail->addAddress($_POST['peserta' . $x]);
            $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name) . '">Pesan Tiket</a>';

            if (!$mail->send()){
                header('Location: ../view/details.php?mailErr');
            }
            $mail->clearAddresses();
        }
    }
    elseif (isset($_POST['peserta5'])){
        for ($x = 2; $x <= 5; $x++){
            $name = $_POST['peserta' . $x];
            $mail->addAddress($_POST['peserta' . $x]);
            $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name) . '">Pesan Tiket</a>';

            if (!$mail->send()){
                header('Location: ../view/details.php?mailErr');
            }
            $mail->clearAddresses();
        }
    }
?>