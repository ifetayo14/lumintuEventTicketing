<?php
    session_start();
    $_SESSION['cred'] = $_GET['m'];
//    $_SESSION['accessTime'] = time();
    include('../config.php');

    $email = base64_decode($_SESSION['cred']);
    $statusQuery = "SELECT `customer_status` FROM `customer` WHERE `customer_email` = '$email'";
    $runQuery = mysqli_query($conn, $statusQuery) or die(mysqli_error($conn));

    if ($runQuery->fetch_array()[0] == 'Pending'){
        $updateQuery = "UPDATE `customer` SET `customer_status` = 'Verified' WHERE `customer_email` = '$email'";
        $runQuery = mysqli_query($conn, $updateQuery) or die(mysqli_error($conn));
        $result = $conn->affected_rows;

        if ($result > 0){
            header('Location: ../view/main.php?scs');
        }
    }else{
        header('Location: ../view/main.php');
    }
?>
