<?php
//    $url = 'http://192.168.43.162:8001/items/ticket?fields=ticket_x_session.session_id';
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, "http://192.168.0.117:8001/items/order?fields=customer_id,invoice_id.invoice_status,ticket_id.ticket_x_session.session_id&filter[invoice_id][invoice_status]=1");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $responseID = curl_exec($curl);
    $resultID = json_decode($responseID, true);
    $dataLengthID = $resultID["data"];

    curl_close($curl);

    for ($x = 0; $x < sizeof($dataLengthID); $x++){
        $lengthDua = $resultID['data'][$x]['ticket_id']['ticket_x_session'];
//        echo $resultID['data'][$x]['customer_id'] . ' ';
        for ($i = 0; $i < sizeof($lengthDua); $i++){
//            echo $resultID['data'][$x]['ticket_id']['ticket_x_session'][$i]['session_id'];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "192.168.0.117:8002/items/registration?&filter[id_participant][_nin]=" . $resultID['data'][$x]['customer_id'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "id_participant": "' . $resultID['data'][$x]['customer_id'] . '",
                "id_session": "' . $resultID['data'][$x]['ticket_id']['ticket_x_session'][$i]['session_id'] . '"
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $result = json_decode($response, true);

            if (isset($result['errors'][0]['extensions']['code'])){
                echo $result['errors'][0]['extensions']['code'];
            }
            else{
                echo 'scs';
            }

            curl_close($curl);
        }
        echo '<br/>';
    }
?>
