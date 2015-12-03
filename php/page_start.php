<?php // This is used as the main starting page, basically it sets some of the basic navigation and things like that, can be used on most pages that users have already logged in for.
/*
TODO: 
*/
	require "connect.php";
	if(!isset($_COOKIE['userID'])){ // checks if the user is logged in based on their cookies, if they are not force them back to the login page.
		header("Location:login.php");
	}
	function fetchDate2($datetime){
		$pos = strrpos($datetime, " ");
		$date = substr($datetime,0, $pos);
		$time = substr($datetime,$pos+1,5);
		$datel =  explode("-",$date);
		$months = array("00" => "notfound", "01" => "Jan.", "02" => "Feb.", "03" => "Mar.",
	   "04" => "Apr.", "05" => "May", "06" => "June", "07" => "July", "08" => "Aug.",
	   "09" => "Sept.", "10" => "Oct.", "11" => "Nov.", "12" => "Dec." );
		return $months[$datel[1]] . " ". $datel[2] . ", " . $datel[0] . " " .$time;
	}

	function events(){ // check for events based on the users id from the cookies. 
		global $conn;
		date_default_timezone_set("America/New_York");
		$eventmax = date('Y-m-d H:i:s', strtotime("+5 days")); // add an hour to the event for the end time
		$eventmin = date('Y-m-d H:i:s');
		$sql = "SELECT events.eventName,events.startTime,locations.locationName, events.groupID FROM events INNER JOIN locations ON events.locationID = locations.locationID WHERE events.userID = ".$_COOKIE['userID']." AND events.startTime <= '$eventmax' AND events.startTime >= '$eventmin' ORDER BY events.startTime LIMIT 15 ";
		$results = $conn->query($sql);
		if ($results->num_rows > 0){
			foreach($results as $val){ // does a display for the events, only showing their name and location for ease of visability.
				if(!is_null($val['groupID'])){
					echo "<li class='upcoming'><a href='group.php?id=".$val['groupID']."'>".$val['eventName']." - ".fetchDate2($val['startTime'])."</a></li>";
				}else{
					echo "<li class='upcoming'><a href='currentgroups.php'>".$val['eventName']." - ".fetchDate2($val['startTime'])."</a></li>";
				}
			}
		}
	}
	function checkadmin1(){
		global $conn;
		if(isset($_COOKIE['userID'])){
			$userID = $_COOKIE['userID'];
			$sql = "SELECT admin FROM users WHERE userID = $userID";
			$result = $conn->query($sql);
			foreach($result as $val){
				if ($val['admin'] == 1){
					return true;
				}
				else{
					return false;
				}
			}
		}
		else{
			return false;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Studyr </title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
		<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="../css/calendar.css">
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="../index.php">
						<img alt="Brand" src="../images/logo.png" width="70px;">
					</a>

					
				</div>
				<ul class="nav navbar-nav navbar-right">
					<?php 
						if(isset($_COOKIE['userID'])){ // Checks if the user is logged in and if so, supply them with some pages they can click other wise they can only go back to the main page.
							if(checkadmin1()){echo '<li><a href="admin.php">Admin</a></li>';}
							echo '<li><a href="calendar.php">Calendar</a></li>';
							echo '<li><a href="logout.php">Logout</a></li>';
						}
					?>

				</ul>	
			</div>
		</nav>
		
		<div id="content">
			<div id="side_menu">
				<div id="top_calendar">
					<section class="leftheader"> 
						<center><h3><em><?php echo $_COOKIE['fname']." ".$_COOKIE['lname'];?></em></h3></center>
					</section>
					<br>
<!--					<a href="#"><center>Edit Schedule</center></a><br>-->
					<a href="creategroup.php"><center>Create a Study Group</center></a><br>
					<a href="currentgroups.php"><center>My Study Groups</center></a><br>
					<a href="../index.php"><center>Join a Study Group</center></a>
				</div>
				<div id="bottom">
					<center id="bot_search"><h3>Upcoming Events</h3></center>
					<ul>
						<?php
							events(); // Calls the event function to print out events in this section. 
						?>
					</ul>	
				</div>
			</div>
			<div id="calendar">
				
				
