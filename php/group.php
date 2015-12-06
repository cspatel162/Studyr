<?php
/* 
TODO:

*/
	require "connect.php";
	include_once "page_start.php";
	
	global $conn;
	$groupID = $_GET['id'];
	$sql = "SELECT * FROM study_groups WHERE groupID = $groupID";
	$sql2 = "SELECT * FROM events WHERE groupID = $groupID";	
	$locationName;
	$locationCity;
	$locationState;
	$studygroup = $conn->query($sql);
	$events = $conn->query($sql2);
	$passfail = false;
	$eventbool = false;

	//Code to add a new link to the useful links section
	if(isset($_POST['title']) && isset($_POST['link']) && isset($_POST['jsonf'])){
		$json = file_get_contents($_POST['jsonf']);
		$jsondata = json_decode($json,true);
		$arr = array("title"=>$_POST['title'],"link"=>$_POST['link']);
		array_push($jsondata['links'], $arr);
		$jsonwrite = json_encode($jsondata);
		file_put_contents($_POST['jsonf'], $jsonwrite);
		unset($_POST);
		header("Location:group.php?id=$groupID");
	}
	if (isset($_COOKIE['userID'])){
		$userID = $_COOKIE['userID'];
	}else{
		$userID = 0;
	}
	$members = array();
	foreach($studygroup as $val){
		if($val['privacy'] == 1){
			//Group is private - check to make sure that the current user is a member.
			foreach($events as $check){
				if($check['userID'] == $userID){
					$passfail = true;
					$eventbool = true; //Save the event ID so that we can pull the info later.
				}
				array_push($members,$check['userID']);
			}
		}
		else{
			$passfail = true;
			foreach($events as $check){
				if($check['userID'] == $userID){
					$eventbool = true;; // save the event ID so we can pull info later - as well this is a check to find out if the user is apart of this group or not. 
				}
				array_push($members,$check['userID']);
			}
		}
	}	

	function joingroup($events){ // if the join group button is hit
		global $conn; // get all of the neccessary information and create the data.
		global $userID;
		global $groupID;
		$eventTitle;
		$meetingDateTime;
		$meetingEndDateTime;
		$locationID;
		$repeat;
		foreach ($events as $data){
			$eventTitle = $data['eventName'];
			$meetingDateTime = $data['startTime'];
			$meetingEndDateTime = $data['endTime'];
			$locationID = $data['locationID'];
			$repeat = $data['repeating'];
		}	 // gathered all data needed when joining an event and now create the event
		$insertforevent = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($userID,'$eventTitle','$meetingDateTime','$meetingEndDateTime',$locationID,$repeat,$groupID)"; // 
		$insertresult = $conn->query($insertforevent);
		unset($_POST); // unset post so that the user can not hit the join button over and over and over and create multiple events that are exactly the same
		header("Location:group.php?id=$groupID"); // reload the page as well so that the new information shows up and that the post is truly unset.
	}

	if(isset($_POST['submit'])){ // join group submit button
		joingroup($events);
	}

	function fetchDate($datetime){ // take the date and time and then explode it and make it easier to read for humans.
		$pos = strrpos($datetime, " ");
		$date = substr($datetime,0, $pos);
		$time = substr($datetime,$pos+1,5);
		$datel =  explode("-",$date);
		$months = array("00" => "notfound", "01" => "January", "02" => "February", "03" => "March",
	   "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August",
	   "09" => "September", "10" => "October", "11" => "November", "12" => "December" );
		return $months[$datel[1]] . " ". $datel[2] . ", " . $datel[0] . " " .$time;
	}


	function addMember($events){ // founder is adding a member to the group
		global $conn;
		$userID = "SELECT userID FROM users WHERE email = '".$_POST['email']."'";// get the user id from the email
		$results = $conn->query($userID);
		if($results->num_rows > 0){
			foreach($results as $userid){
				$results = $userid['userID'];
			}
		}
		global $groupID;
		$eventTitle;
		$meetingDateTime;
		$meetingEndDateTime;
		$locationID;
		$repeat;
		foreach ($events as $data){ // set the data
			$eventTitle = $data['eventName'];
			$meetingDateTime = $data['startTime'];
			$meetingEndDateTime = $data['endTime'];
			$locationID = $data['locationID'];
			$repeat = $data['repeating'];
		}
		$insertforevent = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($results,'$eventTitle','$meetingDateTime','$meetingEndDateTime',$locationID,$repeat,$groupID)"; // create the event for the user
		$insertresult = $conn->query($insertforevent);
		unset($_POST);
		header("Location:group.php?id=$groupID");
	}


	if(isset($_POST['addemail'])){ // submit button calling the add memeber 
		addMember($events);
	}


	function removeself(){ // remove yourself from the grou
		global $conn;
		$groupID  = $_GET['id'];
		$sql = "DELETE FROM events WHERE userID = ".$_COOKIE['userID']." AND groupID = $groupID";
		$results = $conn->query($sql);
		unset($_POST); // unset the post so you dont get an error
		header("Location:group.php?id=$groupID"); // refresh the page to update everything
	}


	function deletegroup(){ // deleting the group if youre a founder
		global $conn;
		$groupID  = $_GET['id']; 
		$sql = "DELETE FROM events WHERE groupID = $groupID"; // delete all events where the groupID is the same
		$results = $conn->query($sql);
		$sql2 = "DELETE FROM study_groups WHERE groupID = $groupID"; // delete the study group itself
		$results2 = $conn->query($sql2);
		unset($_POST); // unset post to prevent errors and then force them back to index.php
		header("Location:../index.php");
	}


	if(isset($_POST['removeself'])){ // submit buttons for removing self and group
		removeself();
	}

	if(isset($_POST['removegroup'])){
		deletegroup();
	}


	function displaygroupinfo($groupID,$eventbool,$passfail,$members,$events){
		global $locationName;
		global $locationState;
		global $locationCity;
		global $conn;
		global $userID;
		$isfounder = false;
		if($passfail == true){ // part of the group/public group 
			//--- SECTION:VIEWABLE TO ALL USERS ---- 

			$classname = "SELECT class.courseTitle FROM class INNER JOIN study_groups ON class.courseID = study_groups.courseID WHERE study_groups.groupID = $groupID"; // Select the courseTitle
			$course = $conn->query($classname);
			foreach ($course as $name){
				echo "<h2 id='course'>".$name['courseTitle']."</h2>";//Course Title that the group is studing
			}
			echo "<section id='memberlist'><h4> Member List: </h4><ul>"; // MEMBERS LIST!
			for($i=0;$i<count($members);$i++){ // prints out all members of this group
					$sql = "SELECT fname,lname FROM users WHERE userID = ".$members[$i]; // select the fname and lname
					$membernamnes = $conn->query($sql);
					foreach ($membernamnes as $names){ // go through all values
						echo "<li>".$names['fname']." ".$names['lname']."</li>";	 // PRINT!
					}
			}
			echo "</ul></section>";
			//--- END SECTION ----
			if($eventbool == true){ 
				//--- SECTION:VIEWABLE TO ONLY MEMBERS OF THE GROUP ----
				$locationID;
				foreach ($events as $vent){
					$locationID = $vent['locationID'];
				}
				$locationsql = "SELECT locationName,locationCity,locationState FROM locations where locationID = $locationID"; // get the location
				$location = $conn->query($locationsql);
				foreach ($location as $local){ // print the location
					$locationName = $local['locationName'];
					echo "<section class='inline' id='location'>Where: ".$local['locationName']."</section>";
				}

				$meetingTime = "SELECT * FROM study_groups WHERE groupID = $groupID";
				$meetingTimeResult = $conn->query("$meetingTime");
				$time = $meetingTimeResult->fetch_assoc();
				echo "<p id='meetingtime'>When: ".fetchDate($time['meetingTime'])."</p>";

				if($time['founderID'] == $userID){ // if the userID in cookies is the same as the founder id
					$isfounder = true;
				}
				$jsonfile = $time['json'];
				$json = file_get_contents($jsonfile);
				$jsondata = json_decode($json,true);

				echo "<strong>Useful Links:</strong><ul>"; // display the useful links to the users 
				foreach($jsondata as $links){
					foreach($links as $anchor){
						echo "<li><a class=\"grouplinks\" target='_blank' href=\"".$anchor['link']."\">".$anchor['title']."</a></li>";
					}
				}
				echo "</ul>";
				if($isfounder){ // STUFF FOR THE FOUNDER ONLY
					echo "<h5 class='settingshead'>Add a link</h5>";
					echo "<form id=\"add\" action=\"group.php?id=$groupID\" method=\"POST\">Name: <input  id='txtpadname' type=\"text\" name=\"title\" ><button class='btn btn-default btnright' type=\"submit\">Add</button><br>"; // form to add useful links
					echo "Link: <input id='txtpadlink' type=\"text\" name=\"link\"><input type=\"hidden\" name=\"jsonf\" value=\"$jsonfile.\"></form>";				
					echo "<h5 class='settingshead'>Add a member</h5>";
					echo "<form method='POST' action='group.php?id=$groupID'>"; //For for the founder to add a member
					echo "<input type='text' name='email' value='Member Email'>";
					echo "<input class='btn btn-default btnright' type='submit' name='addemail' value='Add Member'>";
					echo "<h5 class='settingshead'>Leave Group</h5>";
					echo "<form method='POST' action='group.php?id=$groupID'>"; //Form to delete the group.
					echo "<input class='btn btn-default btnright' type='submit' name='removegroup' value='Delete Group'>";

				}else{ // STUFF FOR EVERYONE ELSE
					echo "<h5 class='settingshead'>Leave Group</h5>";
					echo "<form method='POST' action='group.php?id=$groupID'>"; // Creates a form that users can use to join the group is public - ONLY shows to users at a public group in which they are not members of and signed in
					echo "<input class='btn btn-default btnright' type='submit' name='removeself' value='Remove Me'>";
				}

				//--- END SECTION ----
			}
			else{ 
				//--- SECTION:VIEWABLE TO ALL USERS SIGNED IN----
				if ($userID == 0){
					echo "<h5 class='settingshead'> Join this Group </h5>";
					echo "<form method='POST' action='login.php'>"; // Creates a form that when submited will redirect to the login page because the user is not signed in.
					echo "<input class='btn btn-default' type='submit' name='submit' value='Join'>";
				}
				else{
					echo "<h5 class='settingshead'> Join this Group </h5>";
					echo "<form method='POST' action='group.php?id=$groupID'>"; // Creates a form that users can use to join the group is public - ONLY shows to users at a public group in which they are not members of.
					echo "<input class='btn btn-default' type='submit' name='submit' value='Join'>";

				}
				//--- END SECTION ----
			}

		}
		else{ // group private and not apart of the group
			echo "Sorry, you are not apart of this group and this group is private";
		}
	}
?>
<html>
	<head>
		<title> Group Page </title>
		<link rel="stylesheet" href="../css/group.css">
	</head>
	<body>
		<section id = "groupinfo">
			<?php displaygroupinfo($groupID,$eventbool,$passfail,$members,$events); ?>
		</section>
		</section>
	</body>
</html>