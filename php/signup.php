<?php
require 'connect.php';

    $email = $_POST['email'];
    $passname = $_POST['newpassword'];


    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$passname')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
?>
<a href="../index.php">go back</a>