<?php // Used to create an account, does password hashing and salting - Called from login.php
	include_once 'connect.php'; 

   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $pass = $_POST['newpassword'];
   $passname = password_hash($pass,PASSWORD_DEFAULT); // Hashes and salts the password



    $check = "SELECT email FROM users WHERE email = '$email'"; // Checking if the email already exists
    $result = $conn->query($check);
  if($result->num_rows == 0){
    $sql = "INSERT INTO users (fname, lname, email, password) VALUES ('$fname','$lname','$email','$passname')"; // Storing the hashed password and information on the new user
	   if ($conn->query($sql) === TRUE) {
        echo "<p>New record created successfully, please login.</p>";
    } else {
        echo "<p>Error: " . $conn->error."</p>";
    }
 	} else {
 		echo "<p>Error: that email already exists</p>";
 	}    
?>