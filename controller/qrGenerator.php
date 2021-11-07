<?php
    require "../vendor/autoload.php";

    use Endroid\QrCode\QrCode;

    $urlIP = '192.168.0.125:8001';

    $ticketDataURL ="http://192.168.0.125:8001/items/order?fields=invoice_id,customer_id.customer_id,customer_id.customer_name,ticket_id.ticket_type,ticket_id.ticket_x_day.day_id.day_date,ticket_id.event_id.event_name,ticket_id.event_id.event_address&filter[invoice_id][invoice_status]=1";
    $fileURL = 'http://192.168.0.125:8001/files';
    $qrCodeURL = 'http://192.168.0.125:8001/items/qrcode';

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

        echo '
            <!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width,initial-scale=1">
                    <meta name="x-apple-disable-message-reformatting">
                
                    <title>Email Ticket</title>
                    <style>
                        @import url(' . 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap' . ');
                
                        table,
                        td,
                        div,
                        h1,
                        button,
                        p {
                            font-family: "Montserrat", sans-serif;
                        }
                
                        .btnVerif {
                            display: block;
                            width: 50%;
                            padding: 12px;
                            margin: 10px 0;
                            border: none;
                            background-color: #D4AF37;
                            color: #38435F;
                            font-weight: 600;
                            text-align: center;
                            text-decoration: none;
                            border-radius: 5px;
                        }
                
                        .btnVerif:hover {
                            background-color: #38435F;
                            color: #D4AF37;
                        }
                
                        #containerTicket {
                            border-radius: 8px;
                            margin-bottom: 20px;
                        }
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
                </head>
                
                <body style="margin:0;padding:0;">
                    <table role="presentation"
                        style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                        <tr>
                            <td align="center" style="padding:0;">
                                <table role="presentation"
                                    style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                    <tr>
                                        <td align="center" style="padding:40px 0 30px 0;background:#38435F;">
                                            <img src="./assets/kraton.png" alt="" width="20%" height="20%"
                                                style="height:auto;display:block;" />
                                            <h2 style="color: #D4AF37;">Welcome to Symposium</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:20px 40px;">
                                            <table role="presentation"
                                                style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                <tr>
                                                    <td style="color:#153643;">
                                                        <h2 style="font-size:24px;margin:0 0 20px 0; text-align: center;">
                                                            Ticket Submission Confirmed</h2>
                                                        <p style="margin:0;font-size:16px;line-height:24px;">
                                                            Hi <b>' . $data[$i]['customer_id']['customer_name'] . '</b>, <br> Thank you for your order. You can use this ticket to check in to the event.<br><br>
                                                        </p>
                                                        <div id="containerTicket">
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
                                                                                                        <img src="./assets/header.png" alt="">
                                                                                                    </div>
                                                                                                    <div class="headerTicket">
                                                                                                        <h3 id="eventName">
                                                                                                            ' . $eventName . '
                                                                                                        </h3>
                                                                                                        <p id="eventAddress">
                                                                                                            <?php echo $eventAddress ?>
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
                                                        </div>
                                                        <p style="font-size:16px;line-height:24px; margin: 0px;">
                                                            To download ticket, click this button below.</p>
                                                        <div align="center"><a class="btnVerif" href="pdf.php">Download
                                                                Ticket</a>
                                                        </div>
                
                                                        <p>QnA Link for this ticket : <span><a href="https://www.google.com/">Click
                                                                    here</a></span></p>
                                                        <p>or</p>
                                                        <p>Copy this link : <u>https://www.google.com/</u></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:20px 40px;background:#38435F;">
                                            <table role="presentation"
                                                style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;">
                                                <tr>
                                                    <td style="padding:0;width:50%;" align="center">
                                                        <p style="margin:0;font-size:14px;line-height:16px;color:#ffffff;">
                                                            &reg; Send by Lumintu Events<br />
                                                        </p>
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
                
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
                
                <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
                
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
                    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
                
                <script src="jquery.js"></script>
        </html>
    ';

        $detailType = '';
        $detailDay = '';

        $curl = curl_init();

        $fileLocation = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . '/public/temporaryImg/' . $fileName);

        // post to directus_file first before to payment
        curl_setopt_array($curl, array(
            CURLOPT_URL => $fileURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('filename_download'=> new CURLFILE($fileLocation, 'image/png', $fileName)),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: multipart/form-data'
            ),
        ));

        $uploadPayment = curl_exec($curl);
        $postResponse = json_decode($uploadPayment, true);

        curl_close($curl);

        if (isset($postResponse['errors'][0]['extensions']['code'])) {
            echo 'errPostFile';
            echo $postResponse['errors'][0]['extensions']['code'];
        }else{
            $curl = curl_init();

            //      get fileID
            curl_setopt($curl, CURLOPT_URL, $fileURL . '?fields=id&filter[filename_download]=' . $fileName);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $responseFile = curl_exec($curl);
            $resultFile = json_decode($responseFile, true);
            $fileID = $resultFile['data'][0]['id'];

            echo $i . '<br>';
            echo 'QRcode_' . $customerId . '_' . $data[$i]['ticket_id']['ticket_type'] . '.png' . '<br>';
            echo $fileID . '<br>';


            curl_close($curl);

            $curl = curl_init();

            //post to payment
            curl_setopt_array($curl, array(
                CURLOPT_URL => $qrCodeURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                            "customer_id": "' . $customerId . '",
                            "qrcode_files": "' . $fileID . '"
                        }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $uploadPayment = curl_exec($curl);
            $postResponse = json_decode($uploadPayment, true);

            curl_close($curl);

            if (isset($postResponse['errors'][0]['extensions']['code'])) {
                echo $postResponse['errors'][0]['extensions']['code'];
            }else{
                echo 'scsAll';
            }
        }
    }

?>
