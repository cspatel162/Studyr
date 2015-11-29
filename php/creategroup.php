<?php 
	include_once "pageStart.php"; 

	function createthegroup(){
		global $conn;
		$founderID = $_COOKIE['userID'];
		$courseTitle = $_POST['courseTitle'];
		$Location = $_POST['Location'];
	  $eventTitle = $_POST['eventTitle'];
		$email = $_COOKIE['username'];
		$meetingTime = $_POST['startDate']." ".$_POST['startTime'];
		$meetingDateTime = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $meetingTime)));
		$meetingEndDateTime = date('Y-m-d H:i:s', strtotime('+1 hour',strtotime(str_replace('-', '/', $meetingTime))));
		$repeat = $_POST['repeating'];
		$privacy = $_POST['privacy'];
		$courseID = $conn->query("SELECT courseID FROM class WHERE courseTitle = '$courseTitle';");
		$locationID = $conn->query("SELECT locationID FROM locations where locationName = '$Location'");
		foreach ($courseID as $val)
			$courseID = $val['courseID'];
		foreach ($locationID as $val)
			$locationID = $val['locationID'];
		$sql = "INSERT INTO study_groups (privacy,meetingTime,founderID,courseID) values($privacy,'$meetingDateTime',$founderID,$courseID)";
		$conn->query($sql);
		$groupID = $conn->query("SELECT groupID FROM study_groups WHERE founderID = '$founderID';");
		foreach ($groupID as $val)
			$groupID = $val['groupID'];
		$sql = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($founderID,'$eventTitle','$meetingDateTime','$meetingEndDateTime',$locationID,$repeat,$groupID)";
		$conn->query($sql);
	}

	if(isset($_POST['submit'])){
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