<?php
    include '../config.php';

    $customerURL = '192.168.0.130:8055/items/customer';
    $invitationURL = '192.168.0.130:8055/items/invitation';

    if (isset($_GET['invm'])){
        $myEmail = base64_decode($_GET['invm']);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $customerURL . '?&filter[customer_email]=' . $myEmail);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $responseID = curl_exec($curl);
        $resultID = json_decode($responseID, true);
        $customerID = $resultID['data'][0]['customer_id'];

        curl_close($curl);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $invitationURL . '?fields=customer_inviter_id.customer_name&filter[customer_id]=' . $customerID);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $responseID = curl_exec($curl);
        $resultID = json_decode($responseID, true);
        $customerName = $resultID['data'][0]['customer_inviter_id']['customer_name'];

        curl_close($curl);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- CSS Independent -->
    <link rel="stylesheet" href="../public/css/main.css">

    <title>Invitation</title>
</head>
<body>
<div class="container p-5 container-invitation position-relative">
    <div class="text-center header">
        <p class="h3 title-status">Event Invitation</p>
        <p class="text-white">From <?php if (isset($_GET['invm'])) echo $customerName; ?></p>
    </div>
    <div class="content">
        <div class="invitation-form text-white">
            <form name="formReg" method="post" action="../controller/biodataProcess.php">
                <div class="form-group email-form">
                    <input readonly hidden type="text" name="custID" value="<?php echo $customerID; ?>">
                    <label for="email">Email</label>
                    <input readonly type="email" name="email" class="form-control" id="email" oninput="validate()" placeholder="example : ex@gmail.com" value="<?php if (isset($_GET['invm'])) echo $myEmail; ?>">
                    <small id="emailHelpBlock" class="form-text text-danger d-none">
                        Your email is not valid!
                    </small>
                </div>

                <div class="form-group">
                    <label for="username">Name</label>
                    <input type="text" name="name" class="form-control name-input" id="username" oninput="allLetter(document.formReg.name)" placeholder="example : Bambang">
                    <small id="nameHelpBlock" class="form-text text-danger">
                        Your name will be place in your certificate
                    </small>
                </div>

                <div class="form-group">
                    <label for="phone">No. Hp</label>
                    <input id="phone" name="phoneNum" type="text" class="form-control phone-input" placeholder="example : 081234567890" oninput="allNumber(document.formReg.phoneNum)">
                    <small id="phoneHelpBlock" class="form-text text-danger d-none">
                        Letters Not Allowed!
                    </small>
                </div>

                <div class="form-check text-left">
                    <input type="checkbox" class="form-check-input" id="selectAgree">
                    <label class="form-check-label" for="select1">I have accepted</label>
                </div>

                <div class="text-center position-absolute footer-accept container px-5 pb-5">

                    <div class="container text-center mt-2">
                        <button disabled class="btn btn-accept rounded">Accept Invitation</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
        src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"
></script>
<script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"
></script>
<script
        src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"
></script>

<script src="https://use.fontawesome.com/7a7a4d3981.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../public/js/invitation.js"></script>
</body>
</html>