<?php 
	include_once "connect.php";
	
	// refer $conn to the global conn
	global $conn;
	
	// get email from cookie
	$email = $_COOKIE['username'];
	
	// get userID using email
	$result = $conn->query("SELECT userID FROM users WHERE email ='$email'");
	$userID = $result->fetch_assoc()['userID'];
	
	// set startTime and endTime
	// DATETIME is in 'YYYY-MM-DD HH:MM:SS' format
	$startTime = "{$_POST['start_year']}-{$_POST['start_month']}-{$_POST['start_day']} {$_POST['start_hour']}:00:00";
	$endTime = "{$_POST['end_year']}-{$_POST['end_month']}-{$_POST['end_day']} {$_POST['end_hour']}:00:00";
	
	// check for events that make the user busy for the specified timeblock
	$result = $conn->query("SELECT eventName FROM events WHERE userID = '$userID' AND ((startTime >= '$startTime' AND startTime < '$endTime') OR (endTime > '$startTime' AND endTime <= '$endTime') OR (startTime <= '$startTime' AND endTime >= '$endTime'));");
	$eventName = $result->fetch_assoc()['eventName'];
	
	// prepare the data into an array
	$data = array(
		'event_name'=>$eventName,
		'start_year'=>$_POST['start_year'], 'start_month'=>$_POST['start_month'], 'start_day'=>$_POST['start_day'], 'start_hour'=>$_POST['start_hour'],
		'end_year'=>$_POST['end_year'], 'end_month'=>$_POST['end_month'], 'end_day'=>$_POST['end_day'], 'end_hour'=>$_POST['end_hour'],
		'day_timeslot'=>$_POST['day_timeslot']
	);
	
	// echo the data with JSON encoding
	echo json_encode($data);
 ?>