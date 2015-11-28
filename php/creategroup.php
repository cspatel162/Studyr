<?php 
	include_once "pageStart.php"; 
	include_once "connect.php";

	function createthegroup(){
		global $conn;
		$courseTitle = $_POST['courseTitle'];
		$Location = $_POST['Location'];
	  $eventTitle = $_POST['eventTitle'];
		$email = $_COOKIE['username'];
		$meetingTime = $_POST['startDate']." ".$_POST['startTime'];
		$meetingDateTime = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $meetingTime)));
		$repeat = $_POST['repeating'];
		$privacy = $_POST['privacy'];
		if($privacy == 'yes')
			$privacy = 1;
		else
			$privacy = 0;
		if($repeat == 'yes')
			$repeat = 1;
		else
			$repeat = 0;
		$courseID = $conn->query("SELECT courseID FROM class WHERE courseTitle = '$courseTitle';");
		$founderID = $conn->query("SELECT userID FROM users WHERE email = '$email';");
		$locationID = $conn->query("SELECT locationID FROM locations where locationName = '$Location'");
		foreach ($founderID as $val)
			$founderID = $val['userID'];
		foreach ($courseID as $val)
			$courseID = $val['courseID'];
		foreach ($locationID as $val)
			$locationID = $val['locationID'];
		$sql = "INSERT INTO study_groups (privacy,meetingTime,founderID,courseID) values($privacy,'$meetingDateTime',$founderID,$courseID)";
		$conn->query($sql);
		$groupID = $conn->query("SELECT groupID FROM study_groups WHERE founderID = '$founderID';");
		foreach ($groupID as $val)
			$groupID = $val['groupID'];
		$sql = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($founderID,'$eventTitle','$meetingDateTime','$meetingDateTime',$locationID,$repeat,$groupID)";
		$conn->query($sql);
	}

	if(isset($_POST['submit'])){
		createthegroup();
	} 
?>

	<section class="content">
		<nav class="leftnavbar">
			<section class="leftheader">
				<h1> Studyr       <em><?php echo $_COOKIE['fname']." ".$_COOKIE['lname'];?></em></h1>
			</section>
			<ul class="nav">
				<a href="myschedule.php"><li class="navitem">Edit User's Schedule</li></a>
				<a href="creategroup.php"><li class="navitem">Create a Study Group</li></a>
				<a href="currentgroups.php"><li class="navitem">Users Current Study Groups</li></a>
				<a href="joingroup.php"><li class="navitem">Join a Study Group</li></a>
			</ul>
			<section class="upcoming">
				<h1> UPCOMING EVENTS: </h1>
			</section>
		</nav>
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
			  <input type="radio" name="repeating" value="yes"> Yes
			  <input type="radio" name="repeating" value="no"> No
			  Private Group?
			  <input type="radio" name="privacy" value="yes"> Yes
			  <input type="radio" name="privacy" value="no"> No
			  <input type="submit" name="submit" value="Submit">
			</form>
		</section>
	</section>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</html>