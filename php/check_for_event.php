<?php 
	include_once "connect.php";
	
	$year = $_GET['year'];
	$month = $_GET['month'];
	$day = $_GET['day'];
	$start_hour = $_GET['hour'];
	$end_hour = $start_hour + 1;
	
	// refer $conn to the global conn
	global $conn;
	
	// get email from cookie
	$email = $_COOKIE['username'];
	
	// get userID using email
	$result = $conn->query("SELECT userID FROM users WHERE email ='$email'");
	$userID = $result->fetch_assoc()['userID'];
	
	// set startTime and endTime
	// DATETIME is in 'YYYY-MM-DD HH:MM:SS' format
	$startTime = "$year-$month-$day $start_hour:00:00";
	$endTime = "$year-$month-$day $end_hour:00:00";
	
	// check for events
	$result = $conn->query("SELECT eventName FROM events WHERE userID = '$userID' AND ((startTime BETWEEN '$startTime' AND '$endTime') OR (endTime BETWEEN '$startTime' AND '$endTime') OR (startTime <= '$startTime' AND endTime >= '$endTime'));");
	$eventName = $result->fetch_assoc()['eventName'];
	
	// end the connection
	$conn->close();
	
	// prepare the data into an array
	$data = array('year'=>$year, 'month'=>$month, 'day'=>$day, 'hour'=>$start_hour, 'event_name'=>$eventName);
	
	// echo the data with JSON encoding
	echo json_encode($data);
 ?>