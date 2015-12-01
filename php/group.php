<?php
	require "connect.php";
	include_once "pageStartNoNav.php";
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

	function displaygroupinfo($groupID,$eventbool,$passfail,$members,$events){
		global $locationName;
		global $locationState;
		global $locationCity;
		global $conn;
		global $userID;
		if($passfail == true){ // part of the group/public group 
			//--- SECTION:VIEWABLE TO ALL USERS ---- 

			echo "<ul>"; // MEMBERS LIST!
			for($i=0;$i<count($members);$i++){ // prints out all members of this group
					$sql = "SELECT fname,lname FROM users WHERE userID = ".$members[$i]; // select the fname and lname
					$membernamnes = $conn->query($sql);
					foreach ($membernamnes as $names){ // go through all values
						echo "<li>".$names['fname']." ".$names['lname']."</li>";	 // PRINT!
					}
			}
			echo "</ul>";
			$classname = "SELECT class.courseTitle FROM class INNER JOIN study_groups ON class.courseID = study_groups.courseID WHERE study_groups.groupID = $groupID"; // Select the courseTitle
			$course = $conn->query($classname);
			foreach ($course as $name){
				echo "<h1>".$name['courseTitle']."</h1>";//Course Title that the group is studing
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
					echo "<h5>".$local['locationName']."</h5>";
				}

				$meetingTime = "SELECT * FROM study_groups WHERE groupID = $groupID";
				$meetingTimeResult = $conn->query("$meetingTime");
				foreach ($meetingTimeResult as $time){
					echo $time['meetingTime'];
				}

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
		<?php displaygroupinfo($groupID,$eventbool,$passfail,$members,$events); ?>
		<div id="map"></div>
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