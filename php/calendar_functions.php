<?php
include_once "connect.php";
require_once '../google-api-php-client-1.1.6/src/Google/autoload.php';

// ---------------------------------- GOOGLE CALENDAR CONFIGURATION ----------------------------------
$client = new Google_Client();
$client->setApplicationName('Studyr');
$client->setAuthConfigFile('../client_secret.json');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"],'?'));
// ---------------------------------------------------------------------------------------------------


// ------------------------- AUTHENTICATION CHECK -------------------------
// check if the code is not set
if (! isset($_GET['code'])) {
	// create an Auth URL and go to it
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}	
// authenticate using the code
$client->authenticate($_GET['code']);
// store the access token in this session
$_SESSION['access_token'] = $client->getAccessToken();
// update the client with the access token
$client->setAccessToken($_SESSION['access_token']);
// ------------------------------------------------------------------------


// --------------------------- RETRIEVE USER ID ---------------------------
// refer $conn to the global conn
global $conn;
	
// get email from cookie
$email = $_COOKIE['username'];

// get userID using email
$result = $conn->query("SELECT userID FROM users WHERE email ='$email'");
$userID = $result->fetch_assoc()['userID'];
// ------------------------------------------------------------------------


// set service to Google Calendar
$service = new Google_Service_Calendar($client);

// use the user's primary calendar
$calendarID = 'primary';

// create a DateTime object for the max time limit
$max_time = new DateTime();
// the max time will be two weeks after the current day
$max_time->add(date_interval_create_from_date_string("2 weeks"));

// set the appropriate optional parameters
// timeMin is today
$optionalParameters = array(
    'timeMin' => date('c'),
	'timeMax' => $max_time->format(DateTime::RFC3339),
    'singleEvents' => TRUE
);

// get the results
$results = $service->events->listEvents($calendarID, $optionalParameters);

// go through each one
foreach ($results->getItems() as $event) {

	// get the title
	$title = $event->summary;
	
	// get the start and end date/times
	$start = new DateTime($event->start->dateTime);
	$end = new DateTime($event->end->dateTime);
	
	// round the times and format them correctly
	$formatted_start = getMySQLFormat($start, -1);	
	$formatted_end = getMySQLFormat($end, 1);	
	
	// insert the event into the database
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating) values ($userID, '$title', '$formatted_start', '$formatted_end', 1, 1)");
}

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

// return to calendar page when done
header("Location:test_calendar.php");

?>