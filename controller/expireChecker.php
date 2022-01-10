<?php
    $cred = $_GET['m'];

    $invitationURL = 'http://lumintu-tiket.tamiaindah.xyz:8055/items/invitation?fields=invitation_date,customer_id.customer_code';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $invitationURL . '&filter[customer_id][customer_code]=' . $cred);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    $result = json_decode($response, true);

    $invDate = date('d-m-Y H:m:s', strtotime($result['data'][0]['invitation_date'] . '+7 hours'));
    $datePieces = explode(" ", $invDate);

    echo $datePieces[0] . '</br>';
    echo $datePieces[1] . '</br>';

    echo $result['data'][0]['invitation_date'] . '</br>';
    echo $invDate;
?>
