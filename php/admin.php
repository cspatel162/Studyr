<?php
	require "connect.php";
	include_once "page_start.php";
	function checkadmin(){ // function can be called to verify that you are a user
		global $conn;
		if(isset($_COOKIE['userID'])){ // checks to make sure the cookie has a userid set
			$userID = $_COOKIE['userID'];
			$sql = "SELECT admin FROM users WHERE userID = $userID"; // pulls the admin column from a specific user
			$result = $conn->query($sql);
			foreach($result as $val){ 
				if ($val['admin'] == 1){//if 1 it returns true otherwise it returns false. 
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

	function addAdmin(){ // Function to add another user as an admin, takes only an email.
		global $conn;
		echo "Adding Admin ".$_POST['adminemail'];
		$sql = "UPDATE users SET admin = 1 WHERE email = '".$_POST['adminemail']."'";
		$result = $conn->query($sql);
	}

	function addLocation(){ // Function to add another location, requires start time, end time, location name, city and state.
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

	function addProfessor(){ // Adding another professor, takes a first name and last name only.
		global $conn;
		echo "Adding Professor ".$_POST['pfname']." ".$_POST['plname'];
		$pfname = $_POST['pfname'];
		$plname = $_POST['plname'];
		$sql = "INSERT INTO professors(fname,lname) values('$pfname','$plname')";
		$result = $conn->query($sql);
	}
	
	function addClass(){ // function to add a class - requires a professor, course title, CRN, prefix, course number, and optionally takes a description.
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

	function tools(){ // does a second check to ensure you still are an admin and got to this page some how.
		if(checkadmin()){ 
			//add admin
			if(isset($_POST['addAdmin'])){ // if the add admin button is selected do the add admin function
				addAdmin();
			}

			//add location
			if(isset($_POST['addLocation'])){ // same thing as the add admin but for locations
				addLocation();
			}

			//add professor
			if(isset($_POST['addProfessor'])){ // now for professors
				addProfessor();
			}

			//add class
			if(isset($_POST['addClass'])){ // finally for classes
				addClass();
			}
		}
		else{
			header("Location:../index.php"); // if you fail the check go back to index.php and does give the user an error.
		}
	}

?>

<html>
<head>
	<title>Admin Tools</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../css/admin.css">
</head>
<body>
	<?php tools(); ?><div style="position:absolute;padding-left:30px;" class="content">
		<ul class="column">
			<li>
				<ul class="col1">
					<li>
						<form method="post" action="admin.php" class="input_group">
							<h5 class="settingshead">Add an admin from existing users</h5>
							<p><input type="text" name="adminemail" value="Enter user's email"></p>
							<p class="btnright"><input class='btn btn-default widerbtn' type="submit" name="addAdmin" value="Add Admin"></p>
						</form>
					</li>
					<li>
						<form method="post" action="admin.php" class="input_group">
							<h5 class="settingshead">Add a location</h5>
							<ul class="nav">
								<li><p>Location name: <input type="text" name="locationName" value=""></p></li>
								<li><p>City: <input type="text" name="locationCity" value=""></p></li>
								<li><p>State: <input type="text" name="locationState" value=""></p></li>
								<li><p>Open Time: <input type="time" name="openTime"></p></li>
								<li><p>Close Time: <input type="time" name="closeTime"></p></li>
								<li><p class="btnright"><input class='btn btn-default widerbtn' type="submit" name="addLocation" value="Add Location"></p></li>
							</ul>
						</form>
					</li>
					<li>
						<form method="post" action="admin.php" class="input_group">
							<h5 class="settingshead">Add a professor</h5>
							<ul class="nav">
								<li><p>First name: <input type="text" name="pfname" value=""></p></li>
								<li><p>Last name: <input type="text" name="plname" value=""></p></li>
								<li><p class="btnright"><input class='btn btn-default widerbtn' type="submit" name="addProfessor" value="Add Professors"></p></li>
							</ul>
						</form>
					</li>
				</ul>
			</li>
			<li>
				<ul class="col2">
					<li><form method="post" action="admin.php" class="input_group">
								<h5 class="settingshead">Add a course</h5>
								<p>Professor: <select name="pid" value="">
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
								<p>CRN: <input type="text" name="crn" value=""></p>
								<p>Title: <input type="text" name="courseTitle" value=""></p>
								<p>Prefix: <input type="text" name="courseType" value=""></p>
								<p>Course number: <input type="text" name="courseNumber" value=""></p>
								<p>Description: <input type="text" name="description" value=""></p>
								<p class="btnright"><input class='btn btn-default widerbtn' type="submit" name="addClass" value="Add Course"></p>
							</form></li>
					</ul>
				</li>
			</ul>
</div>
</body>
</html>
