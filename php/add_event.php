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

// get the event title
$title = $_POST['eventName'];
// get the start and end date/times and format them for MySQL
$formatted_start = getMySQLFormat(new DateTime($_POST['startDateTime']), -1);
$formatted_end = getMySQLFormat(new DateTime($_POST['endDateTime']), 1);

// insert the event into the database
$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating) values ($userID, '$title', '$formatted_start', '$formatted_end', 1, 0)");

// return to calendar page when done
header("Location:calendar.php");

/* 
   getMySQLFormat : converts DateTime object into DATETIME formatted string for MySQL

   @param DateTime $dateTime : the DateTime object to convert
   @param int      $round    : indicates if the date/time should be rounded
								-1 to round down to nearest hour
								0 to leave it as is (default)
                                1 to round up to the nearest hour
								NOTE: time is left as is if it is already at the hour (minutes is 0)
   @return string $formatstr : the formatted string for MySQL
*/
function getMySQLFormat($dateTime, $round=0) {
	// format as YYYY-MM-DD HH:MM:SS
	$formatstr = $dateTime->format('Y-m-d H:i:s');
	
	// check if round is -1 to round down
	if ($round == -1) {
		// get the minutes
		$minutes = date_parse($formatstr)['minute'];
		// check if it already is at the nearest hour (if minutes = 0)
		if ($minutes != 0) {
			// subtract the minutes
			$dateTime->sub(date_interval_create_from_date_string("$minutes minutes"));
			// reset the string
			$formatstr = $dateTime->format('Y-m-d H:i:s');
		}
		
	// check if round is 1 to round up
	} else if ($round == 1) {
		// get the minutes
		$minutes = date_parse($formatstr)['minute'];
		// check if it already is at the nearest hour (if minutes = 0)
		if ($minutes != 0) {
			// determine the minutes to be added
			$minutes = 60-$minutes;
			// add the minutes
			$dateTime->add(date_interval_create_from_date_string("$minutes minutes"));
			// reset the string
			$formatstr = $dateTime->format('Y-m-d H:i:s');
		}
	}
	
	// return the formatted string
	return $formatstr;
}
?>