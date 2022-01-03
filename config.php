<?php
    $host = "20.120.0.22";
    $user = "root";
    $pass = "Mia060600.";
    $name = "lumintu_tiket";

    $conn = mysqli_connect($host, $user, $pass, $name);

    if (mysqli_connect_errno()){
        echo "Failed to connect to DB. " . mysqli_connect_error();
    }
?>