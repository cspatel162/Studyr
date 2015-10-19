<?php
    $servername = "localhost";
    $usern = "chens16";
    $password = "websysproject";
    $dbname = "term_project";

    // Create connection
    $conn = new mysqli($servername, $usern, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }   
    

    $username = $_POST['newuser'];
    $passname = $_POST['newpassword'];


    $sql = "INSERT INTO user (username, password) VALUES ('$username', '$passname')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
?>
<a href="index.php">go back</a>