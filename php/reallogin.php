<?php
	include_once "connect.php";
	if(isset($_POST['email2'])){
		$name = $_POST['email2'];
	}
	else{
		$name = $_COOKIE['username'];
	}

	if(isset($_POST['password'])){
		$pass = $_POST['password'];
	}
  
  $sql = "SELECT email, password FROM users WHERE email = '$name'";
  $result = $conn->query($sql);
  foreach ($result as $val) {
  	if(password_verify($pass,$val['password'])){
  		$found = true;
  	}
  }

  if($found){
  	$sql = "SELECT fname, lname, userID FROM users WHERE email ='$name'";
	  $result = $conn->query($sql);
	  $row = $result->fetch_assoc();
	  $fname = $row["fname"];
	  $lname = $row["lname"];
	  $userID = $row["userID"];

	  $conn->close();
		setcookie("username",$name,time()+86400,"/");
	  setcookie("fname",$fname,time()+86400,"/");
	  setcookie("lname",$lname,time()+86400,"/");
	  setcookie("userID",$userID,time()+86400,"/");
	  header("Location:splashpage.php");
  }
  else{
  	header("Location:splashpage.php");
  }
?>