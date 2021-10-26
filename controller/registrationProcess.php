<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/OAuth.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/POP3.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';

    $customerURL = '192.168.0.145:8055/items/customer';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];
    $cusCode = hash('sha512', $email.$phoneNum);
    $loginLink = 'http://localhost/intern/ticketing/controller/verificationProcess.php';

    $curl = curl_init();

    //get customer ID
    curl_setopt($curl, CURLOPT_URL, $customerURL . '?&filter[customer_email]=' . $email);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $responseID = curl_exec($curl);
    $resultID = json_decode($responseID, true);
    $dataLengthID = $resultID["data"];

    curl_close($curl);

    if ($responseID > 0){
        header('Location: ../view/registration/registration.php?pnm');
    }else{

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $customerURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "customer_email": "' . $email . '",
                "customer_code": "' . $cusCode . '",
                "customer_name": "' . $name .'",
                "customer_phone": "' . $phoneNum . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $getResponse = curl_exec($curl);
        $onCreateResponse = json_decode($getResponse, true);

//        echo $onCreateReponse['errors'][0]['extensions']['code'];

        curl_close($curl);

        if (isset($onCreateResponse['errors'][0]['extensions']['code'])){
            header('Location: ../view/registration/registration.php?errCus');
        }
        else{
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
            $mail->Body = 'Hai ' . $name . ', silahkan klik link berikut untuk verifikasi email anda. Link ini juga digunakan untuk akses landing page<br/><br/>
                        <a href="' . $loginLink . '?m=' . $cusCode .'">Verifikasi Email</a>';

            if ($mail->send()){
                header('Location: ../view/registration/registration.php?scs');
            }
            else{
                header('Location: ../view/registration/registration.php?mailErr');
            }
        }
    }

?>
