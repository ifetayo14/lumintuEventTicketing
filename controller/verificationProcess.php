<?php
    include('../config.php');

    $email = base64_decode($_GET['m']);
    $statusQuery = "SELECT `customer_status` FROM `customer` WHERE `customer_email` = '$email'";
    $runQuery = mysqli_query($conn, $statusQuery) or die(mysqli_error($conn));

    if ($runQuery->fetch_array()[0] == 'Pending'){
        $updateQuery = "UPDATE `customer` SET `customer_status` = 'Verified' WHERE `customer_email` = '$email'";
        $runQuery = mysqli_query($conn, $updateQuery) or die(mysqli_error($conn));
        $result = $conn->affected_rows;

        if ($result > 0){
            header('Location: ../view/main.php?scs&m=' . base64_encode($email));
        }
    }else{
        header('Location: ../view/main.php?m=' . base64_encode($email));
    }
?>
