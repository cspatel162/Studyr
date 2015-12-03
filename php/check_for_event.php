<?php 
	include_once "connect.php";
	
	$year = $_POST['year'];
	$month = $_POST['month'];
	$start_day = $_POST['day'];
	$start_hour = $_POST['hour'];
	$end_day = $start_day;
	$end_hour = $start_hour + 1;
	
	if ($end_hour == 24) {
		$end_day += 1;
		$end_hour = 0;
	}
	
	// refer $conn to the global conn
	global $conn;
	
	// get email from cookie
	$email = $_COOKIE['username'];
	
	// get userID using email
	$result = $conn->query("SELECT userID FROM users WHERE email ='$email'");
	$userID = $result->fetch_assoc()['userID'];
	
	// set startTime and endTime
	// DATETIME is in 'YYYY-MM-DD HH:MM:SS' format
	$startTime = "$year-$month-$start_day $start_hour:00:00";
	$endTime = "$year-$month-$end_day $end_hour:00:00";
	
	// check for events that make the user busy for the specified timeblock
	$result = $conn->query("SELECT eventName FROM events WHERE userID = '$userID' AND ((startTime >= '$startTime' AND startTime < '$endTime') OR (endTime > '$startTime' AND endTime <= '$endTime') OR (startTime <= '$startTime' AND endTime >= '$endTime'));");
	$eventName = $result->fetch_assoc()['eventName'];
	
	// prepare the data into an array
	$data = array('year'=>$year, 'month'=>$month, 'day'=>$start_day, 'hour'=>$start_hour, 'event_name'=>$eventName);
	
	// echo the data with JSON encoding
	echo json_encode($data);
 ?>