<?php // This file is called from the login.php file, and is used to create the cookies, and verify the username and password match was entered.
	include_once "connect.php";
	if(isset($_POST['email2'])){ // get the email from the post and the password
		$name = $_POST['email2'];
	}
	else{
		$name = $_COOKIE['username'];
	}

	if(isset($_POST['password'])){
		$pass = $_POST['password'];
	}
  $found = false;
  $sql = "SELECT email, password FROM users WHERE email = '$name'"; // gather the hash that is associated with the email.
  $result = $conn->query($sql);
  foreach ($result as $val) { // go through the results
  	if(password_verify($pass,$val['password'])){ // verify the password matches what it should and then set the bool to true.
  		$found = true;
  	}
  }

  if($found){ // the username and password matches, gather the information about the user and then close the connection.
  	$sql = "SELECT fname, lname, userID FROM users WHERE email ='$name'";
	  $result = $conn->query($sql);
	  $row = $result->fetch_assoc();
	  $fname = $row["fname"];
	  $lname = $row["lname"];
	  $userID = $row["userID"];

	  $conn->close();

	  setcookie("username",$name,time()+86400,"/"); // sets the cookie last one day and sets all the information, then forward them back to the splashpage
	  setcookie("fname",$fname,time()+86400,"/");
	  setcookie("lname",$lname,time()+86400,"/");
	  setcookie("userID",$userID,time()+86400,"/");
	  header("Location:../index.php");
  }
  else{
  	echo "Incorrect password!";
  }
?>
