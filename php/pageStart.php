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
	<section class="rightheader"><a href='logout.php'>Logout</a> | <a href="splashpage.php">Studyr</a></section>
	<section class="content">
		<nav class="leftnavbar">
			<section class="leftheader"> 
				<h1> Studyr       <em><?php echo $_COOKIE['fname']." ".$_COOKIE['lname'];?></em></h1>
			</section>
			<ul class="nav">
				<a href="myschedule.php"><li class="navitem">Edit User's Schedule</li></a>
				<a href="creategroup.php"><li class="navitem">Create a Study Group</li></a>
				<a href="currentgroups.php"><li class="navitem">Users Current Study Groups</li></a>
				<a href="splashpage.php"><li class="navitem">Join a Study Group</li></a>
			</ul>
			<section class="upcoming">
				<h1> UPCOMING EVENTS: </h1>
				<ul>
					<?php
						events();
					?>
				</ul>	
			</section>
		</nav>