<?php
	require "connect.php";
	function events(){
		global $conn;
		$sql = "SELECT events.eventName,locations.locationName FROM events INNER JOIN locations ON events.locationID = locations.locationID WHERE events.userID = ".$_COOKIE['userID'];
		$results = $conn->query($sql);
		if ($results->num_rows > 0){
			foreach($results as $val){
				echo "<li><a href='currentgroups.php' >Event: ".$val['eventName']." At: ".$val['locationName']."</a></li>";
			}
		}
	}
?>

<html>
<meta charset='utf-8'>
<head>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  
</head>
<body>
	<section class="rightheader"><a href='logout.php'>Logout</a> | <a href="splashpage.php">Studyr</a> | <a href="calendar.php"> My Calendars</a></section>
	<section class="content">