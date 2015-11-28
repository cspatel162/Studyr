<?php
require_once '\google-api-php-client-1.1.6\src\Google\autoload.php';

// start session
session_start();

// configure the client for google calendar
$client = new Google_Client();
$client->setAuthConfigFile('client_secret.json');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

// ----- BEGIN AUTHENTICATION CHECK -----

// check if the access token is not set
//if (!(isset($_SESSION['access_token']) && $_SESSION['access_token'])) {

	// check if the code is not set
	//if (! isset($_GET['code'])) {
		// create an Auth URL and go to it
		$auth_url = $client->createAuthUrl();
		header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
	//}
	
	// authenticate using the code
	$client->authenticate($_GET['code']);
	// store the access token in this session
	$_SESSION['access_token'] = $client->getAccessToken();
	// update the client with the access token
	$client->setAccessToken($_SESSION['access_token']);
//}

// -----  END AUTHENTICATION CHECK  -----


$service = new Google_Service_Calendar($client);
 
// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);
/*
if (count($results->getItems()) == 0) {
  print "No upcoming events found.\n";
} else {
  print "Upcoming events:\n";
  foreach ($results->getItems() as $event) {
    $start = $event->start->dateTime;
    if (empty($start)) {
      $start = $event->start->date;
    }
    printf("%s (%s)\n", $event->getSummary(), $start);
  }
}*/

  




?>