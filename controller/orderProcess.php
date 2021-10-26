<?php
    session_start();
    $url = '192.168.0.130:8055/items/invitation?fields=invitation_id,customer_id.customer_id,customer_id.customer_email,customer_id.customer_name,customer_inviter_id.customer_email,invitation_status&filter[customer_inviter_id][customer_code]=' . $_SESSION['cred'];
    $invoiceURL = '192.168.0.130:8055/items/invoice';
    $customerURL = '192.168.0.130:8055/items/customer';
    $orderURL = '192.168.0.130:8055/items/order';
    $voucherURL = '192.168.0.130:8055/items/voucher';

    $price = $_POST['total-harga'];
    $curl = curl_init();

    //get customer ID
    curl_setopt($curl, CURLOPT_URL, $customerURL . '?&filter[customer_code]=' . $_SESSION['cred']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $responseID = curl_exec($curl);
    $resultID = json_decode($responseID, true);
    $dataLengthID = $resultID["data"];
    $customerID = $resultID['data'][0]['customer_id'];

    curl_close($curl);
    $curl = curl_init();

    //get customer-invitation-data
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    $result = json_decode($response, true);
    $invitationDataLength = $result["data"];

    curl_close($curl);
    $curl = curl_init();

    if (sizeof($invitationDataLength) == 1){
        if (isset($_POST['voucher'])){
            $voucher = $_POST['voucher'];
            //      get voucher
            curl_setopt($curl, CURLOPT_URL, $voucherURL . '?&filter[voucher_code]=' . $voucher);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $responseVoucher = curl_exec($curl);
            $resultVoucher = json_decode($responseVoucher, true);
            $voucherID = $resultVoucher['data'][0]['voucher_id'];
            $discPrice = $resultVoucher['data'][0]['voucher_discount'];
            $totalPrice = (int)$price - (int)$discPrice;

            curl_close($curl);
            $curl = curl_init();

            //post to invoice
            curl_setopt_array($curl, array(
                CURLOPT_URL => $invoiceURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "customer_id": "' . $customerID . '",
                "invoice_total": "' . $totalPrice . '",
                "invoice_status": 0
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
        }else{
            $curl = curl_init();

            //post to invoice
            curl_setopt_array($curl, array(
                CURLOPT_URL => $invoiceURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "customer_id": "' . $customerID . '",
                "invoice_total": "' . $price . '",
                "invoice_status": 0
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
        }

        $server_response = curl_exec($curl);
        $postResponse = json_decode($server_response, true);

        curl_close($curl);

        if (isset($postResponse['errors'][0]['extensions']['code'])){
            echo $postResponse['errors'][0]['extensions']['code'];
//            header('Location: ../view/statuspesanan.php?errInv');
        }else{
            $curl = curl_init();
            //      get invoice
            curl_setopt($curl, CURLOPT_URL, $invoiceURL . '?&filter[customer_id]=' . $customerID);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $responseInvID = curl_exec($curl);
            $resultInvID = json_decode($responseInvID, true);
            $invID = $resultInvID['data'][0]['invoice_id'];

            curl_close($curl);
            $curl = curl_init();

            if ($_POST['tiket-peserta-0'] > 3) {
                $curl2 = curl_init();
                if ($_POST['tiket-peserta-0'] == 4){
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $orderURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "invoice_id": "' . $invID . '",
                        "customer_id": "' . $customerID . '",
                        "ticket_id": "1",
                        "order_quantity": "1"
                    }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => $orderURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "invoice_id": "' . $invID . '",
                        "customer_id": "' . $customerID . '",
                        "ticket_id": "2",
                        "order_quantity": "1"
                    }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));
                }elseif ($_POST['tiket-peserta-0'] == 5){
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $orderURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "invoice_id": "' . $invID . '",
                        "customer_id": "' . $customerID . '",
                        "ticket_id": "1",
                        "order_quantity": "1"
                    }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => $orderURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "invoice_id": "' . $invID . '",
                        "customer_id": "' . $customerID . '",
                        "ticket_id": "3",
                        "order_quantity": "1"
                    }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));
                }elseif ($_POST['tiket-peserta-0'] == 6){
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $orderURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "invoice_id": "' . $invID . '",
                        "customer_id": "' . $customerID . '",
                        "ticket_id": "2",
                        "order_quantity": "1"
                    }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => $orderURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "invoice_id": "' . $invID . '",
                        "customer_id": "' . $customerID . '",
                        "ticket_id": "3",
                        "order_quantity": "1"
                    }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));
                }elseif ($_POST['tiket-peserta-0'] == 7){
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $orderURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "invoice_id": "' . $invID . '",
                        "customer_id": "' . $customerID . '",
                        "ticket_id": "4",
                        "order_quantity": "1"
                    }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));
                }
                $customer_server_response2 = curl_exec($curl2);
                $customerPostResponse = json_decode($customer_server_response2, true);

                curl_close($curl2);
            }else{
                $tiket = $_POST['tiket-peserta-0'];
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $orderURL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "invoice_id": "' . $invID . '",
                        "customer_id": "' . $customerID . '",
                        "ticket_id": "' . $tiket . '",
                        "order_quantity": "1"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));
            }

            $customer_server_response = curl_exec($curl);
            $customerPostResponse = json_decode($customer_server_response, true);

            curl_close($curl);
        }
    }
    else {

        $curl = curl_init();

        //post to invoice
        curl_setopt_array($curl, array(
            CURLOPT_URL => $invoiceURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "customer_id": "' . $customerID . '",
                "invoice_total": "' . $price . '",
                "invoice_status": "0"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $customer_server_response = curl_exec($curl);
        $customerPostResponse = json_decode($customer_server_response, true);

        curl_close($curl);
        $curl = curl_init();

        if (isset($customerPostResponse['errors'][0]['extensions']['code'])) {
        echo $customerPostResponse['errors'][0]['extensions']['code'];
//            header('Location: ../view/statuspesanan.php?errInv');
        } else {
            //      get invoice
            curl_setopt($curl, CURLOPT_URL, $invoiceURL . '?&filter[customer_id]=' . $customerID);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $responseInvID = curl_exec($curl);
            $resultInvID = json_decode($responseInvID, true);
            $invID = $resultInvID['data'][0]['invoice_id'];

            for ($x = 0; $x < sizeof($invitationDataLength); $x++) {
                $curl1_[$x] = curl_init();
                $tiketID = $_POST['tiket-peserta-' . $x];

                if ($tiketID > 3) {
                    $curl2_[$x] = curl_init();

                    if ($tiketID == 4) {
                        curl_setopt_array($curl1_[$x], array(
                            CURLOPT_URL => $orderURL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => '{
                            "invoice_id": "' . $invID . '",
                            "customer_id": "' . $result['data'][$x]['customer_id']['customer_id'] . '",
                            "ticket_id": "1",
                            "order_quantity": "1"
                        }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                        ));

                        curl_setopt_array($curl2_[$x], array(
                            CURLOPT_URL => $orderURL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => '{
                            "invoice_id": "' . $invID . '",
                            "customer_id": "' . $result['data'][$x]['customer_id']['customer_id'] . '",
                            "ticket_id": "2",
                            "order_quantity": "1"
                        }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                        ));
                    } elseif ($tiketID == 5) {
                        curl_setopt_array($curl1_[$x], array(
                            CURLOPT_URL => $orderURL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => '{
                            "invoice_id": "' . $invID . '",
                            "customer_id": "' . $result['data'][$x]['customer_id']['customer_id'] . '",
                            "ticket_id": "1",
                            "order_quantity": "1"
                        }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                        ));

                        curl_setopt_array($curl2_[$x], array(
                            CURLOPT_URL => $orderURL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => '{
                            "invoice_id": "' . $invID . '",
                            "customer_id": "' . $result['data'][$x]['customer_id']['customer_id'] . '",
                            "ticket_id": "3",
                            "order_quantity": "1"
                        }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                        ));
                    } elseif ($tiketID == 6) {
                        curl_setopt_array($curl1_[$x], array(
                            CURLOPT_URL => $orderURL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => '{
                            "invoice_id": "' . $invID . '",
                            "customer_id": "' . $result['data'][$x]['customer_id']['customer_id'] . '",
                            "ticket_id": "2",
                            "order_quantity": "1"
                        }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                        ));

                        curl_setopt_array($curl2_[$x], array(
                            CURLOPT_URL => $orderURL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => '{
                            "invoice_id": "' . $invID . '",
                            "customer_id": "' . $result['data'][$x]['customer_id']['customer_id'] . '",
                            "ticket_id": "3",
                            "order_quantity": "1"
                        }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                        ));
                    } elseif ($tiketID == 7) {
                        curl_setopt_array($curl1_[$x], array(
                            CURLOPT_URL => $orderURL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => '{
                            "invoice_id": "' . $invID . '",
                            "customer_id": "' . $result['data'][$x]['customer_id']['customer_id'] . '",
                            "ticket_id": "4",
                            "order_quantity": "1"
                        }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json'
                            ),
                        ));
                    }

                    $response2 = curl_exec($curl2_[$x]);
                    curl_close($curl2_[$x]);

                } else {
                    curl_setopt_array($curl1_[$x], array(
                        CURLOPT_URL => $orderURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{
                            "invoice_id": "' . $invID . '",
                            "customer_id": ' . $result['data'][$x]['customer_id']['customer_id'] . ',
                            "ticket_id": "' . $tiketID . '",
                            "order_quantity": "1"
                        }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));
                }

                $response1 = curl_exec($curl1_[$x]);
                curl_close($curl1_[$x]);

            }
        }
    }
?>