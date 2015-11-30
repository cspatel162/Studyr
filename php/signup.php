<?php // Used to create an account, does password hashing and salting - Called from login.php
require 'connect.php'; 

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
  $email = $_POST['email'];
  $pass = $_POST['newpassword'];
  $passname = password_hash($pass,PASSWORD_DEFAULT); // Hashes and salts the password



    $check = "SELECT email FROM users WHERE email = '$email'"; // Checking if the email already exists... TODO - implement this on the login.php so we can give them the error before entering and submiting - or do it some better way.
    $result = $conn->query($check);
    if($result){
    	$sql = "INSERT INTO users (fname, lname, email, password) VALUES ('$fname','$lname','$email','$passname')"; // Storing the hashed password and information on the new user
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