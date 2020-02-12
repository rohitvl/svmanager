<?php

    $servername = "localhost";
    $username = "phpmyadmin";
    $password = "Rohit@123";
    $dbname = "svmanage";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>