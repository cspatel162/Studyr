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
   
  $sql = "SELECT email FROM users";
  $result = $conn->query($sql);

  $sql = "SELECT email, password FROM users";
  $result = $conn->query($sql);
  
  $found = false;
  if($result->num_rows>0){
      while($row = $result->fetch_assoc()) {
          if($row["email"]==$name && $row["password"] == $pass){
              $found = true;
              break;
          }
      }
  }
  if($found){
  	$sql = "SELECT fname, lname FROM users WHERE email ='$name'";
	  $result = $conn->query($sql);
	  $row = $result->fetch_assoc();
	  $fname = $row["fname"];
	  $lname = $row["lname"];

	  $conn->close();
		setcookie("username",$name,time()+86400,"/");
	  setcookie("fname",$fname,time()+86400,"/");
	  setcookie("lname",$lname,time()+86400,"/");
	  header("Location:calendar.php");
  }
  else{
  	header("Location:splashpage.php");
  }
?>