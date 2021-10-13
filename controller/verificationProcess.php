<?php
    include('../config.php');

    $email = base64_decode($_GET['m']);
    $statusQuery = "SELECT `status` FROM `customer` WHERE `customer_email` = '$email'";
    $runQuery = mysqli_query($conn, $statusQuery) or die(mysqli_error($conn));

    if ($runQuery->fetch_array()[0] == 'Pending'){
        $updateQuery = "UPDATE `customer` SET `status` = 'Verified' WHERE `customer_email` = '$email'";
        $runQuery = mysqli_query($conn, $updateQuery) or die(mysqli_error($conn));
        $result = $conn->affected_rows;

        if ($result > 0){
            header('Location: ../view/details.php?scs&m=' . base64_encode($email));
        }
    }else{
        header('Location: ../view/details.php?m=' . base64_encode($email));
    }
?>
