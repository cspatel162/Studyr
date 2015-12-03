<?php // This is used as the main starting page, basically it sets some of the basic navigation and things like that, can be used on most pages that users have already logged in for.
/*
TODO: 
*/
	require "connect.php";
	if(!isset($_COOKIE['userID'])){ // checks if the user is logged in based on their cookies, if they are not force them back to the login page.
		header("Location:login.php");
	}

	function events(){ // check for events based on the users id from the cookies. 
		global $conn;
		date_default_timezone_set("America/New_York");
		$eventmax = date('Y-m-d H:i:s', strtotime("+5 days")); // add an hour to the event for the end time
		$sql = "SELECT events.eventName,locations.locationName FROM events INNER JOIN locations ON events.locationID = locations.locationID WHERE events.userID = ".$_COOKIE['userID']." AND events.startTime <= '$eventmax' ORDER BY events.startTime LIMIT 10 ";
		$results = $conn->query($sql);
		if ($results->num_rows > 0){
			foreach($results as $val){ // does a display for the events, only showing their name and location for ease of visability.
				echo "<li><a href='currentgroups.php' >".$val['eventName']."</a></li>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
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
		
					<a href="myschedule.php"><center>Edit Schedule</center></a><br>
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
				
				
			</div>
		</div>
	</body>
</html>