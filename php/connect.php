<?php // simple connect script so we don't have to type this out over and over and over
    $servername = "localhost";
    $username = "phpuser1";
    $password = "*97BAD3C7F42787ED6270EE7BE634F59E64C23DF2";
    $dbname = "studyr";

    // Create connection
    $conn = new mysqli($servername, $username, $password,$dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
?>