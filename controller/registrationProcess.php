<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/OAuth.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/POP3.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';

    include('../config.php');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];
    $loginLink = 'http://localhost/intern/ticketing/controller/verificationProcess.php';

    if ($password != $repeatPassword){
        header('Location: ../view/registration/registration.php?pnm');
    }else{
        $chkMailQuery = "SELECT `customer_email` FROM `customer` WHERE `customer_email` = '$email'";
        $mailCheck = mysqli_query($conn, $chkMailQuery) or die(mysqli_error($conn));
        if ($mailCheck->fetch_array()[0] == $email){
            header('Location: ../view/registration/registration.php?me');
        }else{
            $encPassword = md5($password);
            $query = "INSERT INTO `customer` (`customer_email`, `customer_password`, `customer_name`, `customer_phone`, `status`)
                VALUES ('$email', '$encPassword', '$name', '$phoneNum', 'Pending')";
            $runQuery = mysqli_query($conn, $query) or die(mysqli_error($conn));
            $result = $conn->affected_rows;

            if ($result > 0){
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
                $mail->addAddress($email);
                $mail->Subject = "[Lumintu Events] Verifikasi Email";
                $mail->isHTML(true);
                $mail->Body = 'Hai ' . $name . ', silahkan klik link berikut untuk verifikasi email anda. <br/><br/>
                            <a href="' . $loginLink . '?m=' . base64_encode($email) .'">Verifikasi Email</a>';

                if ($mail->send()){
                    header('Location: ../view/registration/registration.php?success');
                }
                else{
                    header('Location: ../view/registration/registration.php?mailErr');
                }
            }
        }
    }

?>
