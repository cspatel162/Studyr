<?php // used for tpages that we don't want the left side nav bar on. 
	require "connect.php";
	if(!isset($_COOKIE['userID'])){ // checks if the user is logged in based on their cookies, if they are not force them back to the login page.
		header("Location:login.php");
	}
?>

<html>
<meta charset='utf-8'>
<head>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  
</head>
<body>
	<section class="rightheader"><?php 
		if(isset($_COOKIE['userID'])){ // Checks if the user is logged in and if so, supply them with some pages they can click other wise they can only go back to the main page.
			echo '<a href="logout.php">Logout</a> | <a href="splashpage.php">Studyr</a> | <a href="calendar.php"> My Calendars</a>';
		}
		else{
			echo '<a href="splashpage.php">Studyr</a>';
		}
			?>
	</section> <!-- top nav bar -->
	<section class="content">