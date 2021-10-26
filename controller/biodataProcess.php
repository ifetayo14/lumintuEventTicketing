<?php
    include('../config.php');

    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['phoneNum'];



    $sql = "UPDATE `customer` SET `customer_name` = '$name', `customer_phone` = '$phone', `customer_status` = 'Verified' WHERE `customer_email` = '$email'";
    $runQuery = mysqli_query($conn, $sql) or die (mysqli_error($conn));
    $aff = $conn->affected_rows;

    if ($aff > 0){
        $sql = "UPDATE `invitation` SET `invitation_status` = 'Accepted' WHERE `customer_id` = (SELECT `customer_id` FROM `customer` WHERE `customer_email` = '$email')";
        $runQuery = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        $aff2 = $conn->affected_rows;

        if ($aff2 > 0){
            header('Location: ../view/invitation.php?scs');
        }else{
            header('Location: ../view/invitation.php?errInv');
        }
    }else{
        header('Location: ../view/invitation.php?errCus');
    }
?>