<?php // This page displays all of the study groups the user is apart of. 


	include_once "page_start.php"; 


	function fetchDate($datetime){ // gets the date and time, explodes it and then returns 
		$date = substr($datetime,0, $pos);a user readable value with the Month instead of a number and in a common format.
		$pos = strrpos($datetime, " ");
		$time = substr($datetime,$pos+1,5);
		$datel =  explode("-",$date);
		$months = array("00" => "notfound", "01" => "January", "02" => "February", "03" => "March",
	   "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August",
	   "09" => "September", "10" => "October", "11" => "November", "12" => "December" );
		return $months[$datel[1]] . " ". $datel[2] . ", " . $datel[0] . " " .$time;
	}
	function currGroup(){ // retrives all groups - and returns information about them, such as the event, the time it starts and the location.
		global $conn;
		$id = $_COOKIE['userID'];
		$sql = "SELECT events.*,locations.*,study_groups.founderID FROM events INNER JOIN locations ON events.locationID = locations.locationID 
				INNER JOIN study_groups ON events.groupID = study_groups.groupID WHERE events.userID = ".$id ." ORDER BY events.startTime"; // gets events based on user id and displays more infromation about events
		$results = $conn->query($sql);
		if ($results->num_rows > 0){ // checks to make sure there are events, if 0 there are none and echos that out. 
			foreach($results as $val){
				if($val['founderID'] == $id) {
					echo "<li class=\"currentgroup owngroup\"><a class='atitle' href='group.php?id=".$val['groupID']."'>".$val['eventName']."</a> When: ".fetchDate($val['startTime'])." At: ".$val['locationName']."</li>"; // if you are the founder of a group it turns a different color
				} else {
					echo "<li class=\"currentgroup\"><a class='atitle' href='group.php?id=".$val['groupID']."'>".$val['eventName']."</a> When: ".fetchDate($val['startTime'])." At: ".$val['locationName']."</li>";
				}
			}
		}else{
			echo "<li>Sorry, but you're not apart of any study groups right now.</li>"; // no groups to return
		}
	}
	function CurrEvents(){ // returns all events you are apart of except for groups
		global $conn;
		date_default_timezone_set("America/New_York");
		$eventmax = date('Y-m-d H:i:s', strtotime("+5 days")); // add an hour to the event for the end time
		$sql = "SELECT events.eventName,events.startTime FROM events WHERE events.userID = ".$_COOKIE['userID']." AND events.startTime <= '$eventmax' AND events.groupID IS NULL ORDER BY events.startTime LIMIT 20 "; // returns only the events that are from todays date to +5 days.
		$results = $conn->query($sql);
		if ($results->num_rows > 0){ // checks to make sure there are events, if 0 there are none and echos that out. 
			foreach($results as $val){
				echo "<li class=\"currentgroup owngroup\"><p>".$val['eventName']."</p> Starting: ".fetchDate($val['startTime'])."</li>";		// if it finds any then it returns them. 
			}
		}
	}
 ?>
<html>
	<head>
		<title> My Study Groups </title>
		<link rel="stylesheet" href="../css/group.css">
	</head>
	<body>
				<section id="groups">
					<ul>
						<?php
							currGroup(); // gruops will always be on top.
							CurrEvents();
						?>
					</ul>
				</section>

			</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	</body>
</html>