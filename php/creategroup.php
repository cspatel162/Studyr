<?php // Page to create a group
	include_once "page_start.php"; 
	$emailarray = array();
	function createthegroup(){ // Does all the processing and data gathering for a study_group
		global $emailarray;
		$emailarray = unserialize($_POST['input_name']);
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
		$course = $conn->query("SELECT courseID FROM class WHERE courseTitle = '$courseTitle';"); // gather the courseID
		$location = $conn->query("SELECT locationID FROM locations where locationName = '$Location'"); // gather the locationID
		$val = $course->fetch_assoc();
			$courseID = $val['courseID'];
		$val = $location->fetch_assoc();
		$locationID = $val['locationID'];
		$sql = "INSERT INTO study_groups (privacy,meetingTime,founderID,courseID) values($privacy,'$meetingDateTime',$founderID,$courseID)"; // insert the study group
		$conn->query($sql);
		
		// Selects the most recently created groupID from the groups created by the founder
		$group = $conn->query("SELECT groupID FROM study_groups WHERE founderID = $founderID ORDER BY groupID;"); // gather that group ID based on the founder ID ... this is probably not good... - need to fix this. 
		if($group->num_rows > 0){
			while($val = $group->fetch_row()){
				$groupID = $val[0];
			}
			$empty=array("links"=>array());
			$jsonstart = json_encode($empty);
			file_put_contents("../json/studygroup_$groupID.json", $jsonstart);
			$sql = "UPDATE study_groups SET json='../json/studygroup_$groupID.json' WHERE groupID = $groupID;"; // insert the study group
			$conn->query($sql);
		}
		
		$sql = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($founderID,'$eventTitle','$meetingDateTime','$meetingEndDateTime',$locationID,$repeat,$groupID)"; // finally add the event into the list - this needs to be adjusted as well to implement the repeating functioniality.
		$conn->query($sql);
		for($i=0;$i<count($emailarray);$i++){
			$userID = "SELECT userID FROM users WHERE email = '$emailarray[$i]'";
			$results = $conn->query($userID);
			if($results->num_rows > 0){
				foreach($results as $userid){
					$results = $userid['userID'];
				}
			$insertevent = "INSERT INTO events (userID,eventName,startTime,endTime,locationID,repeating,groupID) values($results,'$eventTitle','$meetingDateTime','$meetingEndDateTime',$locationID,$repeat,$groupID)"; // finally add the event into the list - this needs to be adjusted as well to implement the repeating functioniality.
			$results = $conn->query($insertevent);
			}

		}
		unset($_POST);
		header("Location:group.php?id=$groupID");
		
	}


	if(isset($_POST['submit'])){ // only create the group when the submit is hit - this needs to be adjusted so that it's checked to make sure that values are actyually entered. 
		createthegroup();
	} 

	function checkemail($email){
		global $conn;
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$results = $conn->query($sql);
		if($results->num_rows>0 && $results->num_rows<2){
			return true;
		}else{
			return false;
		}
	}

	function returnemailarray(){	
		global $emailarray;
		for($i=0;$i<count($emailarray);$i++){
				echo "<li>".$emailarray[$i]."</li>";
		}
	}

	function getuserID(){
		global $conn;
		global $emailarray;
		$userIDarray = array();
		for($i=0;$i<count($emailarray);$i++){
			$sql = "SELECT userID FROM users WHERE email = '".$emailarray[$i]."'";
			$results = $conn->query($sql);
			if($results->num_rows>0){
				foreach($results as $val){
					array_push($userIDarray,$val['userID']);
					//echo $val['userID'];
				}
			}
		}
		//echo json_encode($userIDarray);
		return $userIDarray;
	}

	function addemail(){
		global $emailarray;
		$emailarray = unserialize($_POST['input_name']);
		if (checkemail($_POST['emails'])){
			array_push($emailarray,$_POST['emails']);
			for($i=0;$i<count($emailarray);$i++){
				//echo $emailarray[$i];
			}
		}else{
			for($i=0;$i<count($emailarray1);$i++){
				//echo $emailarray[$i];
			}
		}	
		getuserID();	
	}



	if(isset($_POST['addemail'])){ // only create the group when the submit is hit - this needs to be adjusted so that it's checked to make sure that values are actyually entered. 
		addemail();
	}

?>
				<section id="creategroup">
					<h5 class='settingshead'>Please fill out the following form</h5>
					<form method="post" action="creategroup.php">
					  <p><select name="courseTitle" value="Course Title">
									<option value="<?php if(isset($_POST['courseTitle'])){echo $_POST['courseTitle'];}else{ echo "Course Title";}?>"><?php if(isset($_POST['courseTitle'])){echo $_POST['courseTitle'];}else{ echo "Course Title";}?> </option>
									<?php
										global $conn;
										$result = $conn->query("SELECT courseTitle FROM class;");
										foreach($result as $val){
											echo "<option value='".$val['courseTitle']."'>".$val['courseTitle']."</option>";
										}
									?>
								  </select></p>
					  <p><select name="Location">
									<option value="<?php if(isset($_POST['Location'])){echo $_POST['Location'];}else{ echo "Location";}?>"> <?php if(isset($_POST['Location'])){echo $_POST['Location'];}else{ echo "Location";}?> </option>
									<?php
										global $conn;
										$result = $conn->query("SELECT locationName FROM locations;");
										foreach($result as $val){
											echo "<option value='".$val['locationName']."'>".$val['locationName']."</option>";
										}
									?>
								  </select></p>
					  <p><input type="text" name="eventTitle" value="<?php if(isset($_POST['eventTitle'])){echo $_POST['eventTitle'];}else{ echo "Event Title";}?>"></p>
					  <p><input type="date" name="startDate" value="<?php if(isset($_POST['startDate'])){echo $_POST['startDate'];}else{ echo "";}?>"></p>
					  <p><input type="time" name="startTime" value="<?php if(isset($_POST['startTime'])){echo $_POST['startTime'];}else{ echo "";}?>"></p>
					  <p>How long with the meeting last? (hours):
					  <input type-'number' name='hours' value="<?php if(isset($_POST['hours'])){echo $_POST['hours'];}else{ echo "";}?>"></p>
					  <!--<p>Repeating?
			  			  <input type="radio" name="repeating" value="1" <?php if(isset($_POST['repeating'])){echo ($_POST['repeating']==1)?'checked':'' ;}else{ echo "";}?>> Yes
			  			  <input type="radio" name="repeating" value="0"<?php if(isset($_POST['repeating'])){echo ($_POST['repeating']==0)?'checked':'' ;}else{ echo "";}?>> No</p>
					  </p>-->
					  <input type="hidden" name="repeating" value="0">
					  <p>Private Group?
								  <input type="radio" name="privacy" value="1" <?php if(isset($_POST['privacy'])){echo ($_POST['privacy']==1)?'checked':'' ;}else{ echo "";}?>> Yes
								  <input type="radio" name="privacy" value="0" <?php if(isset($_POST['privacy'])){echo ($_POST['privacy']==0)?'checked':'' ;}else{ echo "";}?>> No</p>
					  <p><input type="text" name="emails" value="Group Member Email">
						 <input type="submit" name="addemail" value="Add Member"></p>
						 <input type='hidden' name='input_name' value="<?php echo htmlentities(serialize($emailarray)); ?>" />
					  <p><input type="submit" name="submit" value="Submit"></p>
					</form>
					<p><ul><?php if(isset($_POST['addemail'])){returnemailarray();} ?></ul></p>
				</section>
			</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	</body>
</html>