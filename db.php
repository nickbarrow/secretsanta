<?php 
    $host = 'remotemysql.com';
    $user = 'fIH3AfGhcO';
    $pass = 'oTS3WjYJ1k';
    $db = 'fIH3AfGhcO';
    //  $port = 8889;

    // Opens connection, dies on connect_error
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        echo "Failed to connect.";
        die("Connection failed: " . $conn->connect_error);
    }
    // echo "CONNECTED SUCCESSFULLY.";
?>