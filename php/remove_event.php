<?php

include_once "connect.php";

// --------------------------- RETRIEVE USER ID ---------------------------
// refer $conn to the global conn
global $conn;
	
// get email from cookie
$email = $_COOKIE['username'];

// get userID using email
$result = $conn->query("SELECT userID FROM users WHERE email ='$email'");
$userID = $result->fetch_assoc()['userID'];
// ------------------------------------------------------------------------


// get the start and end date/times and format them for MySQL
$time = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'] . ' ' . $_POST['hour'] . ':00:00';

// delete the event into the database
// there should be only one event at the time, so only the time field is needed
$conn->query("DELETE FROM events WHERE 
	userID = $userID AND
	startTime <= '$time' AND
	endTime > '$time';"
);

?>