<?php

    session_start();
    $cred = base64_decode($_SESSION['cred']);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/OAuth.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/POP3.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';

    include('../config.php');

    $name1 = $_POST['peserta1'];
    $sql = "SELECT `customer_id` FROM `customer` WHERE `customer_email` = '$cred'";
    $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $inviterID = $runQuery->fetch_array()[0];

    $buyTicketLink = 'http://localhost/intern/ticketing/view/statuspesanan.php';
    $bioLink = 'http://localhost/intern/ticketing/view/invitation.php';

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

    if (!isset($_POST['peserta2'])){
        if ($cred == $name1){
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
        }else{
            $sql = "INSERT INTO `customer` (`customer_email`, `customer_status`) VALUES ('$name1', 'Pending')";
            $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $aff = $conn->affected_rows;

            if ($aff > 0){
                $mail->Subject = "[Lumintu Events] Link Pengisian Biodata Pemesanan Tiket";
                $mail->isHTML(true);
                $mail->addAddress($name1);
                $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name1) .'">Pesan Tiket</a>';
                if (!$mail->send()){
                    header('Location: ../view/details.php?mailErr');
                }
                else{
                    header('Location: ../view/details.php?scs');
                }
            }
        }
    }else{
        $mail->Subject = "[Lumintu Events] Link Pengisian Biodata Pemesanan Tiket";
        $mail->isHTML(true);

        if (!isset($_POST['peserta3'])){
            $name2 = $_POST['peserta2'];
            $sql = "INSERT INTO `customer` (`customer_email`, `customer_status`) VALUES ('$name2', 'Pending')";
            $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $aff = $conn->affected_rows;

            if ($aff > 0){
                $sql = "SELECT `customer_id` FROM `customer` WHERE `customer_email` = '$name2'";
                $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $cusID = $runQuery->fetch_array()[0];

                $insertInvite = "INSERT INTO `invitation` (`customer_id`, `invitation_status`, `customer_inviter_id`)
                                VALUES ('$cusID', 'Pending', '$inviterID')";
                $runQuery = mysqli_query($conn, $insertInvite) or die(mysqli_error($conn));
                $aff2 = $conn->affected_rows;

                if ($aff2 > 0){
                    $mail->addAddress($_POST['peserta2']);
                    $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name2) .'">Pesan Tiket</a>';
                    if (!$mail->send()){
                        header('Location: ../view/details.php?mailErr');
                    }
//                    else{
//                        header('Location: ../view/details.php?scs');
//                    }
                }else{
                    header('Location: ../view/details.php?errindb');
                }
            }
        }
        elseif (!isset($_POST['peserta4'])){
            for ($x = 2; $x <= 3; $x++){
                $name = $_POST['peserta' . $x];
                $sql = "INSERT INTO `customer` (`customer_email`, `customer_status`) VALUES ('$name', 'Pending')";
                $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $aff = $conn->affected_rows;

                if ($aff > 0){
                    $sql = "SELECT `customer_id` FROM `customer` WHERE `customer_email` = '$name'";
                    $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $cusID = $runQuery->fetch_array()[0];

                    $insertInvite = "INSERT INTO `invitation` (`customer_id`, `invitation_status`, `customer_inviter_id`)
                                VALUES ('$cusID', 'Pending', '$inviterID')";
                    $runQuery = mysqli_query($conn, $insertInvite) or die(mysqli_error($conn));
                    $aff2 = $conn->affected_rows;

                    if ($aff2 > 0){
                        $mail->addAddress($_POST['peserta' . $x]);
                        $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name) . '">Pesan Tiket</a>';

                        if (!$mail->send()){
                            header('Location: ../view/details.php?mailErr');
                        }
//                        else{
//                            header('Location: ../view/details.php?scs');
//                        }

                        $aff2 = 0;

                    }else{
                        header('Location: ../view/details.php?errindb');
                    }

                    $aff = 0;
                }
                $mail->clearAddresses();
            }
        }
        elseif (!isset($_POST['peserta5'])){
            for ($x = 2; $x <= 4; $x++){
                $name = $_POST['peserta' . $x];
                $sql = "INSERT INTO `customer` (`customer_email`, `customer_status`) VALUES ('$name', 'Pending')";
                $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $aff = $conn->affected_rows;

                if ($aff > 0){
                    $sql = "SELECT `customer_id` FROM `customer` WHERE `customer_email` = '$name'";
                    $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $cusID = $runQuery->fetch_array()[0];

                    $insertInvite = "INSERT INTO `invitation` (`customer_id`, `invitation_status`, `customer_inviter_id`)
                                VALUES ('$cusID', 'Pending', '$inviterID')";
                    $runQuery = mysqli_query($conn, $insertInvite) or die(mysqli_error($conn));
                    $aff2 = $conn->affected_rows;

                    if ($aff2 > 0){
                        $mail->addAddress($_POST['peserta' . $x]);
                        $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name) . '">Pesan Tiket</a>';

                        if (!$mail->send()){
                            header('Location: ../view/details.php?mailErr');
                        }
//                        else{
//                            header('Location: ../view/details.php?scs');
//                        }

                        $aff2 = 0;

                    }else{
                        header('Location: ../view/details.php?errindb');
                    }

                    $aff = 0;
                }
                $mail->clearAddresses();
            }
        }
        elseif (isset($_POST['peserta5'])){
            for ($x = 2; $x <= 5; $x++){
                $name = $_POST['peserta' . $x];
                $sql = "INSERT INTO `customer` (`customer_email`, `customer_status`) VALUES ('$name', 'Pending')";
                $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $aff = $conn->affected_rows;

                if ($aff > 0){
                    $sql = "SELECT `customer_id` FROM `customer` WHERE `customer_email` = '$name'";
                    $runQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $cusID = $runQuery->fetch_array()[0];

                    $insertInvite = "INSERT INTO `invitation` (`customer_id`, `invitation_status`, `customer_inviter_id`)
                                VALUES ('$cusID', 'Pending', '$inviterID')";
                    $runQuery = mysqli_query($conn, $insertInvite) or die(mysqli_error($conn));
                    $aff2 = $conn->affected_rows;

                    if ($aff2 > 0){
                        $mail->addAddress($_POST['peserta' . $x]);
                        $mail->Body = 'Silahkan klik link berikut untuk melakukan pengisian biodata untuk pemesanan tiket.<br/><br/>
                        <a href="' . $bioLink . '?invm=' . base64_encode($name) . '">Pesan Tiket</a>';

                        if (!$mail->send()){
                            header('Location: ../view/details.php?mailErr');
                        }
//                        else{
//                            header('Location: ../view/details.php?scs');
//                        }

                        $aff2 = 0;

                    }else{
                        header('Location: ../view/details.php?errindb');
                    }

                    $aff = 0;
                }
                $mail->clearAddresses();
            }
        }

        $mail->addAddress($cred);
        $mail->Subject = "[Lumintu Events] Status Invitasi Pemesanan";
        $mail->isHTML(true);
        $mail->Body = 'Hai ' . $cred . ', silahkan klik link berikut untuk memantau status invitasi dan melakukan pemesanan tiket<br/><br/>
                            <a href="' . $buyTicketLink . '?m=' . base64_encode($cred) .'">Pesan Tiket</a>';
        if (!$mail->send()){
            header('Location: ../view/details.php?errstatusmail');
        }else{
            header('Location: ../view/details.php?scs');
        }
    }

?>