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

<html>
<meta charset='utf-8'>
<head>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  
</head>
<body>
	<section class="rightheader"><!-- top nav bar -->
		<?php 
			if(isset($_COOKIE['userID'])){ // Checks if the user is logged in and if so, supply them with some pages they can click other wise they can only go back to the main page.
				echo '<a href="calendar.php"> My Calendars</a> | <a href="../index.php">Studyr</a> | <a href="logout.php">Logout</a>';
			}
			else{
				echo '<a href="splashpage.php">Studyr</a>';
			}
		?>
	</section>
	<section class="content">
		<nav class="leftnavbar"> <!-- SIDE NAV BAT -->
			<section class="leftheader"> 
				<h1> Studyr       <em><?php echo $_COOKIE['fname']." ".$_COOKIE['lname'];?></em></h1><!-- A little personalization -->
			</section>
			<ul class="nav">
				<a href="myschedule.php"><li class="navitem">Edit User's Schedule</li></a>
				<a href="creategroup.php"><li class="navitem">Create a Study Group</li></a>
				<a href="currentgroups.php"><li class="navitem">Users Current Study Groups</li></a>
				<a href="../index.php"><li class="navitem">Join a Study Group</li></a>
			</ul>
			<section class="upcoming">
				<h1> UPCOMING EVENTS: </h1>
				<ul>
					<?php
						events(); // Calls the event function to print out events in this section. 
					?>
				</ul>	
			</section>
		</nav>