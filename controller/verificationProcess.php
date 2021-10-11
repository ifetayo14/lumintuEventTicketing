<?php
    include('../config.php');

    $email = base64_decode($_GET['m']);

    $query = "UPDATE `customer` SET `status` = 'Verified' WHERE `customer_email` = '$email'";
    $runQuery = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $result = $conn->affected_rows;

    if ($result > 0){
        header('Location: ../view/login.php?success');
    }
?>
