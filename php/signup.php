<?php
require 'connect.php';

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
  $email = $_POST['email'];
  $pass = $_POST['newpassword'];
  $passname = password_hash($pass,PASSWORD_DEFAULT);



    $check = "SELECT email FROM users WHERE email = '$email'";
    $result = $conn->query($check);
    if($result){
    	$sql = "INSERT INTO users (fname, lname, email, password) VALUES ('$fname','$lname','$email','$passname')";
	    if ($conn->query($sql) === TRUE) {
	        echo "New record created successfully";
	    } else {
	        echo "Error: " . $sql . "<br>" . $conn->error;
	    }
 	} else {
 		echo "Error: that email already exists\n";
 	}


    
?>
<a href="login.php"> go back</a>