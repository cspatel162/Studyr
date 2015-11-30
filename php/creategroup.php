<?php // Page to create a group
	include_once "pageStart.php"; 

	function createthegroup(){ // Does all the processing and data gathering for a study_group
		global $conn;
		$founderID = $_COOKIE['userID']; // gather the users id from cookies
		$courseTitle = $_POST['courseTitle']; // the title of the gclass that the group is for.
		$Location = $_POST['Location']; // location the group will me
	  $eventTitle = $_POST['eventTitle']; // the title of the study group
		$email = $_COOKIE['username']; // gather the founders email address
		$hours = $_POST['hours'];
		$meetingTime = $_POST['startDate']." ".$_POST['startTime']; // gather the start date and time of the group
		$meetingDateTime = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $meetingTime))); //adjust it into something that mysql can easy store
		$meetingEndDateTime = date('Y-m-d H:i:s', strtotime("+$hours hours",strtotime(str_replace('-', '/', $meetingTime)))); // add an hour to the event for the end time
		$repeat = $_POST['repeating']; // gather whether or not the event is repeating - This may be removed...
		$privacy = $_POST['privacy']; // is this a private study group? (something like we have for websys, only 4 member instead of open to everyone.)
		$courseID = $conn->query("SELECT courseID FROM class WHERE courseTitle = '$courseTitle';"); // gather the courseID
		$locationID = $conn->query("SELECT locationID FROM locations where locationName = '$Location'"); // gather the locationID
		foreach ($courseID as $val) // only one value should be returned - take the first one and set the $courseID value to that
			$courseID = $val['courseID'];
		foreach ($locationID as $val) // does the same thign that the courseID one does but for locations
			$locationID = $val['locationID'];
		$sql = "INSERT INTO study_groups (privacy,meetingTime,founderID,courseID) values($privacy,'$meetingDateTime',$founderID,$courseID)"; // insert the study group
		$conn->query($sql);
		$groupID = $conn->query("SELECT groupID FROM study_groups WHERE founderID = '$founderID';"); // gather that group ID based on the founder ID ... this is probably not good... - need to fix this. 
		foreach ($groupID as $val)
			$groupID = $val['groupID'];
		$sql = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($founderID,'$eventTitle','$meetingDateTime','$meetingEndDateTime',$locationID,$repeat,$groupID)"; // finally add the event into the list - this needs to be adjusted as well to implement the repeating functioniality.
		$conn->query($sql);
	}

	if(isset($_POST['submit'])){ // only create the group when the submit is hit - this needs to be adjusted so that it's checked to make sure that values are actyually entered. 
		createthegroup();
	} 
?>
		<section id="creategroup">
			<form method="post" action="creategroup.php">
			  <select name="courseTitle">
			  	<option value=""> Course Title </option>
			  	<?php
			  		global $conn;
			  		$result = $conn->query("SELECT courseTitle FROM class;");
			  		foreach($result as $val){
			  			echo "<option value='".$val['courseTitle']."'>".$val['courseTitle']."</option>";
			  		}
			  	?>
			  </select>
			  <select name="Location">
			  	<option value=""> Location </option>
			  	<?php
			  		global $conn;
			  		$result = $conn->query("SELECT locationName FROM locations;");
			  		foreach($result as $val){
			  			echo "<option value='".$val['locationName']."'>".$val['locationName']."</option>";
			  		}
			  	?>
			  </select>
			  <input type="text" name="eventTitle" value="Event Title">
			  <input type="date" name="startDate">
			  <input type="time" name="startTime">
			  How long with the meeting last? (hours);
			  <input type-'number' name='hours'>
			  Repeating?
			  <input type="radio" name="repeating" value="1"> Yes
			  <input type="radio" name="repeating" value="0"> No
			  Private Group?
			  <input type="radio" name="privacy" value="1"> Yes
			  <input type="radio" name="privacy" value="0"> No
			  <input type="submit" name="submit" value="Submit">
			</form>
		</section>
	</section>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</html>