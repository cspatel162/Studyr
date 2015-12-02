<?php
/* 
TODO:
	Setup pages for each study group, a page that gives facts about each group - stuff like members, meeting location, time, study materiels??? Something so this page can be useful.

*/
	require "connect.php";
	include_once "pageStart.php";
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
		unset($_POST['title']);
		unset($_POST['link']);
		unset($_POST['jsonf']);
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

	function joingroup($events){
		global $conn;
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
		}
		$insertforevent = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($userID,'$eventTitle','$meetingDateTime','$meetingEndDateTime',$locationID,$repeat,$groupID)"; // 
		$insertresult = $conn->query($insertforevent);
		unset($_POST);
		header("Location:group.php?id=$groupID");
	}

	if(isset($_POST['submit'])){
		joingroup($events);
	}

	function fetchDate($datetime){
		$pos = strrpos($datetime, " ");
		$date = substr($datetime,0, $pos);
		$time = substr($datetime,$pos+1,5);
		$datel =  explode("-",$date);
		$months = array("00" => "notfound", "01" => "January", "02" => "February", "03" => "March",
	   "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August",
	   "09" => "September", "10" => "October", "11" => "November", "12" => "December" );
		return $months[$datel[1]] . " ". $datel[2] . ", " . $datel[0] . " " .$time;
	}
	function addMember($events){
		global $conn;
		$userID = "SELECT userID FROM users WHERE email = '".$_POST['email']."'";
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
		foreach ($events as $data){
			$eventTitle = $data['eventName'];
			$meetingDateTime = $data['startTime'];
			$meetingEndDateTime = $data['endTime'];
			$locationID = $data['locationID'];
			$repeat = $data['repeating'];
		}
		$insertforevent = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($results,'$eventTitle','$meetingDateTime','$meetingEndDateTime',$locationID,$repeat,$groupID)"; // 
		$insertresult = $conn->query($insertforevent);
		unset($_POST);
		header("Location:group.php?id=$groupID");
	}
	if(isset($_POST['addemail'])){
		addMember($events);
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

			echo "<section id='memberlist'><h3 > Member List: </h3><ul>"; // MEMBERS LIST!
			for($i=0;$i<count($members);$i++){ // prints out all members of this group
					$sql = "SELECT fname,lname FROM users WHERE userID = ".$members[$i]; // select the fname and lname
					$membernamnes = $conn->query($sql);
					foreach ($membernamnes as $names){ // go through all values
						echo "<li>".$names['fname']." ".$names['lname']."</li>";	 // PRINT!
					}
			}
			echo "</ul></section>";
			$classname = "SELECT class.courseTitle FROM class INNER JOIN study_groups ON class.courseID = study_groups.courseID WHERE study_groups.groupID = $groupID"; // Select the courseTitle
			$course = $conn->query($classname);
			foreach ($course as $name){
				echo "<h2 id='course'>".$name['courseTitle']."</h2>";//Course Title that the group is studing
			}
			//--- END SECTION ----
			if($eventbool == true){ // group public or private but you are apart of the groups
				//--- SECTION:VIEWABLE TO ONLY MEMBERS OF THE GROUP! ----
				$locationID;
				foreach ($events as $vent){
					$locationID = $vent['locationID'];
				}
				$locationsql = "SELECT locationName,locationCity,locationState FROM locations where locationID = $locationID"; // get the location
				$location = $conn->query($locationsql);
				foreach ($location as $local){ // print the location
					$locationName = $local['locationName'];
					$locationCity = $local['locationCity'];
					$locationState = $local['locationState']; 	
					echo "<section id='location'>Where:<h1>".$local['locationName']."</h1></section>";
				}

				$meetingTime = "SELECT * FROM study_groups WHERE groupID = $groupID";
				$meetingTimeResult = $conn->query("$meetingTime");
				$time = $meetingTimeResult->fetch_assoc();
				echo "<p id='meetingtime'>When: ".fetchDate($time['meetingTime'])."</p>";
				if($time['founderID'] == $userID){
					$isfounder = true;
				}
				$jsonfile = $time['json'];
				$json = file_get_contents($jsonfile);
				$jsondata = json_decode($json,true);

				echo "<p id='usefullinks'>Useful Links: </p><ul>";
				foreach($jsondata as $links){
					foreach($links as $anchor){
						echo "<li><a class=\"grouplinks\" href=\"".$anchor['link']."\">".$anchor['title']."</a></li>";
					}
				}
				echo "</ul>";
				if($isfounder){
					echo "<form id=\"add\" action=\"group.php?id=$groupID\" method=\"POST\">Name: <input type=\"text\" name=\"title\" >";
					echo "Link: <input type=\"text\" name=\"link\"><input type=\"hidden\" name=\"jsonf\" value=\"$jsonfile.\"><button type=\"submit\">Add</button></form>";				
				}
				echo "<form method='POST' action='group.php?id=$groupID'>"; // Creates a form that users can use to join the group is public - ONLY shows to users at a public group in which they are not members of.
				echo "<input type='text' name='email' value='Member Email'>";
				echo "<input type='submit' name='addemail' value='Add Member'>";


				//--- END SECTION ----
			}
			else{ // not part of the group but the group is public and therefore you can view some of the data.
				//--- SECTION:VIEWABLE TO ALL USERS ----
				if ($userID == 0){
					echo "<form method='POST' action='login.php'>"; // Creates a form that users can use to join the group is public - ONLY shows to users at a public group in which they are not members of.
					echo "<input type='submit' name='submit' value='Join'>";
				}
				else{
					echo "<form method='POST' action='group.php?id=$groupID'>"; // Creates a form that users can use to join the group is public - ONLY shows to users at a public group in which they are not members of.
					echo "<input type='submit' name='submit' value='Join'>";

				}
				//--- END SECTION ----
			}
		}
		else{ // group private and not apart of the group
			echo "Sorry, you are not apart of this group and this group is private";
		}
	}
?>

	<section id = "groupinfo">
		<?php displaygroupinfo($groupID,$eventbool,$passfail,$members,$events); ?>


		<div id="map"></div>
	</section>
	</section>






	<script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
      function initialize() {
        var mapCanvas = document.getElementById('map');
        var mapOptions = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
        var geocoder = new google.maps.Geocoder();
				var location = <?php echo '"'.$locationName.','.$locationCity.' '.$locationState.'"'; ?>;
				geocoder.geocode( { 'address': location }, function(results, status) {
				    if (status == google.maps.GeocoderStatus.OK) {
				        map.setCenter(results[0].geometry.location);
				    } else {
				        alert("Could not find location: " + location);
				    }
				});
      }
      var booltest = 	<?php echo $eventbool ? 'true' : 'false'; ?>;
      if(booltest){
      	google.maps.event.addDomListener(window, 'load', initialize);
      }

      
    </script>
</body>
</html>