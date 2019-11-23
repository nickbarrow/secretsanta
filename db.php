<?php
    # Host, user, pass, and db have been removed to cover my dumb ass
    $host = 'remotemysql.com';
    $user = '';
    $pass = '';
    $db = '';
    # $port = 8889;

    // Opens connection, dies on connect_error
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        echo "Failed to connect.";
        die("Connection failed: " . $conn->connect_error);
    }
    # echo "CONNECTED SUCCESSFULLY.";
?>
