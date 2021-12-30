<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;
    use Spipu\Html2Pdf\Exception\ExceptionFormatter;

    require "../vendor/autoload.php";
    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/OAuth.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/POP3.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';
    require "../vendor/autoload.php";

    require_once '../vendor/dompdf/dompdf/src/Autoloader.php';

    use Endroid\QrCode\QrCode;

    $urlIP = '192.168.18.67:8001';
    $html2pdf = new Html2Pdf('P','A4','en', false, 'UTF-8', array(25,15,30,0));

    $ticketDataURL ="http://192.168.18.226:8001/items/order?fields=invoice_id,customer_id.customer_id,customer_id.customer_name,customer_id.customer_email,ticket_id.ticket_type,ticket_id.ticket_x_day.day_id.day_date,ticket_id.event_id.event_name,ticket_id.event_id.event_address&filter[invoice_id][invoice_status]=1&filter[customer_id][customer_id]=2";
    $qrCodeURL = 'http://192.168.18.226:8001/items/qrcode';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $ticketDataURL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    $hasil = json_decode($response, true);
    $data = $hasil["data"];
    $length = 0;

    $detailType = "";
    $detailDay = "";

    curl_close($curl);

    for($i = 0; $i < sizeof($data); $i++) {
        $customerId = $data[$i]["customer_id"]["customer_id"];
        $ticketDay = $data[$i]["ticket_id"];
        $eventName = $data[$i]["ticket_id"]["event_id"]["event_name"];
        $eventAddress = $data[$i]["ticket_id"]["event_id"]["event_address"];
        $customerEmail = $data[$i]["customer_id"]["customer_email"];

        if(sizeof($data) == 1) {
            $length = sizeof($ticketDay["ticket_x_day"]);
        }

        $customerName = "
            <td class='detailName' colspan='".sizeof($data[$i]["ticket_id"]["ticket_x_day"])."'>". $data[$i]['customer_id']['customer_name'] ."</td>
        ";

        $detailType .= "<td class='detailType' colspan='". sizeof($data[$i]["ticket_id"]["ticket_x_day"]) ."'>". $data[$i]['ticket_id']['ticket_type'] ."</td>";
        $ticketDay = $data[$i]["ticket_id"]["ticket_x_day"];

        $fileName = 'QRcode_' . $customerId . '_' . $data[$i]['ticket_id']['ticket_type'] . '.png';

        // Create QR code
        $qrCode = new QrCode();
        $qrCode->setEncoding('UTF-8');
        $qrCode->setSize(800);
        $qrCode->setMargin(10);
        $qrCode->setWriterByName('png');
    // $qrCode->setText('Arafat Maku');
        $qrCode->setText($customerId);
        $qrCode->writeFile('../public/temporaryImg/' . $fileName);

        for($j = 0; $j < sizeof($ticketDay); $j++) {
            $detailDay .= "<td class='detailType'>". $data[$i]["ticket_id"]["ticket_x_day"][$j]['day_id']['day_date'] ."</td>";
        }

        $mailMessage = '
                <html>
                    <style>
                        .ticket {
                            background-color: #38435F;
                            height: auto;
                            padding-bottom: 32px;
                            border-radius: 8px;
                            box-shadow:
                                0px 0px 5.3px rgba(0, 0, 0, 0.053),
                                0px 0px 17.9px rgba(0, 0, 0, 0.077),
                                0px 0px 80px rgba(0, 0, 0, 0.13);
                        }
                    
                        .bgTicket {
                            border-radius: 8px 8px 0 0;
                        }
                    
                        .bgTicket img {
                            width: 100%;
                            border-radius: 8px 8px 0 0;
                        }
                    
                        .bgTicket p {
                            font-size: small;
                            font-weight: 600;
                            padding-top: 8px;
                        }
                    
                        .headerTicket {
                            margin: 32px;
                        }
                    
                        .headerTicket h3 {
                            color: #D4AF37;
                            margin: 0 0 5px 0;
                        }
                    
                        .headerTicket p {
                            color: #ffffff;
                            font-size: 10px;
                            margin: 0;
                        }
                    
                        .qrTicket {
                            text-align: center;
                        }
                    
                        .qrTicket img {
                            width: 120px;
                            height: 120px;
                            border: 2px dashed white;
                            padding: 10px;
                        }
                    
                        .detailTicket {
                            margin: 32px;
                            text-align: center;
                        }
                    
                        .detailTicket table td {
                            border: 0.5px solid white;
                            padding: 5px 20px;
                        }
                    
                        .detailTicket table {
                            border-collapse: collapse;
                            text-align: center;
                        }
                    
                        .detailName {
                            color: #D4AF37;
                            font-size: large;
                            font-weight: 600;
                            
                        }
                    
                        .detailType {
                            font-weight: 600;
                            font-size: small;
                            color: white;
                        }
                    
                        .datailDay td {
                            font-size: 12px;
                            color: white;
                        }
                    
                        .footerTicket {
                            text-align: center;
                            color: white;
                            font-size: smaller;
                            margin-top: 160px;
                        }
                    </style>
                
                <body style="margin:0;padding:0;">
    <table role="presentation"
        style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
        <tr>
            <td align="center" style="padding:0;">
                <table role="presentation"
                    style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                    <tr>
                        <td>
                            <table role="presentation"
                                style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <td style="color:#153643;">
                                        <div class="ticket">
                                            <!-- <img src="../public/img/bg_ticket.svg" alt=""> -->
                                            <div class="bgTicket">
                                                <!-- <img src="../public/img/kraton.png" alt="">
                                                <p>KRATON <br>NGAYOGYAKRTA <br>HADININGRAT</p> -->
                                                <img src="https://raw.githubusercontent.com/ifetayo14/lumintuEventTicketing/master/public/img/header.png" alt="">
                                            </div>
                                            <div class="headerTicket">
                                                <h3 id="eventName">
                                                    ' . $eventName . '
                                                </h3>
                                                <p id="eventAddress">
                                                    ' . $eventAddress . '
                                                </p>
                                            </div>
                                            <div class="qrTicket">
                                                <img src="data:image/png;base64,' . base64_encode($qrCode->writeString()) . '"
                                                    alt="" />
                                            </div>
                                            <div class="detailTicket">
                                                <table align="center">
                                                    <tr>
                                                        ' . $customerName . '
                                                    </tr>
                                                    <tr>
                                                        ' . $detailType . '
                                                    </tr>
                                                    <tr class="datailDay">
                                                        ' . $detailDay . '
                                                    </tr>

                                                </table>
                                            </div>
                                            <div class="footerTicket">
                                                <p>www.lumintu-events.com</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
        </html>
    ';

        $detailType = '';
        $detailDay = '';

//        $pdfName = 'QR-' . $customerId . '-' . $data[$i]['ticket_id']['ticket_type'] . '.pdf';
//
//        $html2pdf->pdf->SetDisplayMode('fullpage');
//        $html2pdf->writeHTML($mailMessage);
//        $html2pdf->output(__DIR__ . DIRECTORY_SEPARATOR . '..' . '/public/pdfFile/' . $pdfName, 'F');
////        file_put_contents('../public/pdfFile/QR-' . $customerId . '-' . $data[$i]['ticket_id']['ticket_type'] . '.pdf', $html2pdf->output());
//        $html2pdf->clean();

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
        $mail->addAddress($customerEmail);
        $mail->Subject = "[Lumintu Events] Ticket for Event";
        $mail->isHTML(true);
        $mail->Body = $mailMessage;

//        $mail->addAttachment(__DIR__ . DIRECTORY_SEPARATOR . '..' . '../public/pdfFile/QR-' . $customerId . '-' . $data[$i]['ticket_id']['ticket_type'] . '.pdf', $qrOutput);

        $mail->send();
    }

?>
