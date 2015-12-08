<?php // This is used as the main starting page, basically it sets some of the basic navigation and things like that, can be used on most pages that users have already logged in for.
/*
TODO:
*/
	//connect to the database
	require "connect.php";
	// checks if the user is logged in based on their cookies, if they are not force them back to the login page.
	if(!isset($_COOKIE['userID'])){
		header("Location:login.php");
	}

	// check for events based on the users id from the cookies.
	function events(){
		global $conn;
		date_default_timezone_set("America/New_York");
		$eventmax = date('Y-m-d H:i:s', strtotime("+5 days")); // add an hour to the event for the end time
		$sql = "SELECT events.eventName,locations.locationName FROM events INNER JOIN locations ON events.locationID = locations.locationID WHERE events.userID = ".$_COOKIE['userID']." AND events.startTime <= '$eventmax' ORDER BY events.startTime LIMIT 10 ";
		$results = $conn->query($sql);
		if ($results->num_rows > 0){
			foreach($results as $val){ // does a display for the events, only showing their name and location for ease of visability.
				echo "<li><a href='currentgroups.php' >".$val['eventName']."</a></li>";
			}
		}
	}

	//Checks if user is an admin of anything
	function checkadmin2(){
		global $conn;
		if(isset($_COOKIE['userID'])){
			$userID = $_COOKIE['userID'];
			$sql = "SELECT admin FROM users WHERE userID = $userID";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				foreach($result as $val){
					if ($val['admin'] == 1){
						return true;
					}
					else{
						return false;
					}
				}
			}
		}
		else{
			return false;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Studyr </title>
		<!-- Import Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Bootstrap Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Custom Style -->
		<link rel="stylesheet" href="../css/main.css">

		<!-- Lato Font -->
		<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<!-- Bootstrap navigation -->
		<nav class="navbar navbar-default">
			<!-- Stacks Navbar when window is shrunk -->
			<div class="container-fluid">
				<!-- left side -->
				<div class="navbar-header">
					<a class="navbar-brand" href="../index.php">
						<img alt="Brand" src="../images/logo.png"  width="70px;">
					</a>
				</div>
				<!-- right side -->
				<ul class="nav navbar-nav navbar-right">
					<!-- function to change the right links depending if user is logged in -->
					<?php
						if(isset($_COOKIE['userID'])){ // Checks if the user is logged in and if so, supply them with some pages they can click other wise they can only go back to the main page.
							if(checkadmin2()){echo '<li><a href="php/admin.php">Admin</a></li>';}
							echo '<li><a href="calendar.php">Calendar</a></li>';
							echo '<li><a href="logout.php">Logout</a></li>';
						}
						else{
							echo '<li><a href="login.php">Login or Register</a></li>';
						}
					?>
				</ul>
			</div>
		</nav>

		<!-- Main Content of the page -->
		<div id="content">
			<div id="side">
				<!-- left-hand search menu - 'advanced search' -->
				<div id="top">
					<section class="leftheader">
						<center><h3> Search by..</h3></center>
					</section>
					<br>
					<section class="search">
						<form action="search.php" method="POST">
							<ul class="nav">
								<li>
									<div class="dropdown">
										<strong>Subject:</strong>
										<select name="submit" id="dropdownMenu1">
											<option value="<?php if(isset($_POST['submit'])){echo $_POST['submit'];}else{ echo '';}?>">
												<!-- Fetches data from json files of the subject name -->
												<?php if(isset($_POST['submit']) && $_POST['submit'] != ""){
														$json = file_get_contents("../json/courseprefixes.json");
														$jsondata = json_decode($json,true);
														echo $jsondata[$_POST['submit']];
													}else{
														echo "Subject";
													}
												?>
											</option>
											<!-- Finds unique values for dropdown based on our db -->
											<?php
												$stmt = "SELECT DISTINCT courseType FROM class ORDER BY courseType";
												$results= $conn->query($stmt);
												$json = file_get_contents("../json/courseprefixes.json");
												$jsondata = json_decode($json,true);
												while($prefixes = $results->fetch_row()){
													$pref = $prefixes[0];
													$desc = $jsondata[$pref];
													echo "<option value='$pref'>$desc</option>";
												}
											?>
										</select>
									</div>
								</li>

								<li><strong>Title:</strong><input type="text" name="submit_title" value="<?php if(isset($_POST['submit_title'])){echo $_POST['submit_title'];}else{ echo "";}?>"></li>
								<li><strong>Professor:</strong><input type="text" name="submit_prof" value="<?php if(isset($_POST['submit_prof'])){echo $_POST['submit_prof'];}else{ echo "";}?>"></li>
								<li><strong>CRN:</strong><input type="text" name="submit_crn" value="<?php if(isset($_POST['submit_crn'])){echo $_POST['submit_crn'];}else{ echo "";}?>"></li>
								<li><button type="submit" id="submit" class="btn btn-default">Search</button></li>
							</ul>
						</form>
					</section>
				</div>
			</div>
			<div id="main">
				<div id="main_contents">
