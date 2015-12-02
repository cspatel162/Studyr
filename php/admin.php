<?php
	require "connect.php";
	function checkadmin(){
		global $conn;
		if(isset($_COOKIE['userID'])){
			$userID = $_COOKIE['userID'];
			$sql = "SELECT admin FROM users WHERE userID = $userID";
			$result = $conn->query($sql);
			foreach($result as $val){
				if ($val['admin'] == 1){
					return true;
				}
				else{
					return false;
				}
			}
		}
		else{
			return false;
		}
	}

	function addAdmin(){
		global $conn;
		echo "Adding Admin ".$_POST['adminemail'];
		$sql = "UPDATE users SET admin = 1 WHERE email = '".$_POST['adminemail']."'";
		$result = $conn->query($sql);
	}

	function addLocation(){
		global $conn;
		$locationName = $_POST['locationName'];
		$locationCity = $_POST['locationCity'];
		$locationState = $_POST['locationState'];
		$openTime = $_POST['openTime'];
		$closeTime = $_POST['closeTime'];
		echo "Adding Location ".$_POST['locationName'];
		$sql = "INSERT INTO locations(locationName,locationCity,locationState,openTime,closeTime) values('$locationName','$locationCity','$locationState','$openTime','$closeTime')";
		$result = $conn->query($sql);
	}

	function addProfessor(){
		global $conn;
		echo "Adding Professor ".$_POST['pfname']." ".$_POST['plname'];
		$pfname = $_POST['pfname'];
		$plname = $_POST['plname'];
		$sql = "INSERT INTO professors(fname,lname) values('$pfname','$plname')";
		$result = $conn->query($sql);
	}
	
	function addClass(){
		echo "Adding Class ".$_POST['courseTitle'];
		global $conn;
		$courseTitle = $_POST['courseTitle'];
		$crn = $_POST['crn'];
		$courseType = $_POST['courseType'];
		$courseNumber = $_POST['courseNumber'];
		$description = $_POST['description'];
		$professorID = $_POST['pid'];
		$sql = "INSERT INTO class(crn,courseType,courseTitle,courseNumber,description,professorID) values($crn,'$courseType','$courseTitle',$courseNumber,'$description',$professorID)";
		$result = $conn->query($sql);
	}

	function tools(){
		if(checkadmin()){
			//add admin
			if(isset($_POST['addAdmin'])){
				addAdmin();
			}

			//add location
			if(isset($_POST['addLocation'])){
				addLocation();
			}

			//add professor
			if(isset($_POST['addProfessor'])){
				addProfessor();
			}

			//add class
			if(isset($_POST['addClass'])){
				addClass();
			}
		}
		else{
			header("Location:../index.php");
		}
	}

?>

<html>
<head>
	<title>Admin Tools</title>
</head>
<body>
	<?php tools(); ?>
	<form method="post" action="admin.php">
		<p><input type="text" name="adminemail" value="Email to add Admin"></p>
		<p><input type="submit" name="addAdmin" value="Add Admin"></p>
	</form>
	<form method="post" action="admin.php">
		<p><input type="text" name="locationName" value="Location Name"></p>
		<p><input type="text" name="locationCity" value="Location City"></p>
		<p><input type="text" name="locationState" value="Location State"></p>
		<p>Open Time:<input type="time" name="openTime"></p>
		<p>Close Time:<input type="time" name="closeTime"></p>
		<p><input type="submit" name="addLocation" value="Add Location"></p>
	</form>
	<form method="post" action="admin.php">
		<p><input type="text" name="pfname" value="Professors First Name"></p>
		<p><input type="text" name="plname" value="Professors Last Name"></p>
		<p><input type="submit" name="addProfessor" value="Add Professors"></p>
	</form>
	<form method="post" action="admin.php">
		<p><select name="pid" value="">
			  			  	<option value="">Professor</option>
			  			  	<?php
			  			  		global $conn;
			  			  		$result = $conn->query("SELECT * FROM professors;");
			  			  		foreach($result as $val){
			  			  			echo "<option value='".$val['professorID']."'>".$val['fname']." ".$val['lname']."</option>";
			  			  		}
			  			  	?>
			  </select>
		</p>
		<p><input type="text" name="crn" value="CRN"></p>
		<p><input type="text" name="courseTitle" value="Course Title"></p>
		<p><input type="text" name="courseType" value="Course Prefix"></p>
		<p><input type="text" name="courseNumber" value="Course Number"></p>
		<p><input type="text" name="description" value="Description of Course"></p>
		<p><input type="submit" name="addClass" value="Add Course"></p>
	</form>
</body>
</html>
