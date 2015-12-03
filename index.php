<?php 
	require "php/connect.php";
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		
		<link rel="stylesheet" href="css/main.css">
		<title> Studyr </title>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">
						<img alt="Brand" src="images/logo.png"  width="70px;">
					</a>

					
				</div>
				<ul class="nav navbar-nav navbar-right">
					<?php 
						if(isset($_COOKIE['userID'])){ // Checks if the user is logged in and if so, supply them with some pages they can click other wise they can only go back to the main page.
							if(checkadmin2()){echo '<li><a href="php/admin.php">Admin</a></li>';}
							echo '<li><a href="php/calendar.php">Calendar</a></li>';
							echo '<li><a href="php/logout.php">Logout</a></li>';
						}
						else{
							echo '<li><a href="php/login.php">Login or Register</a></li>';
						}
					?>
				</ul>	
			</div>
		</nav>
		
		<div id="content">
			<div id="side">
				<div id="top">
			
					
					<section class="leftheader"> 
						<center><h3> Search by..</h3></center>
					</section>
					<br>
					<section class="search">
						<form action="php/search.php" method="POST">
							<ul class="nav">
								<li>	
									<div class="dropdown">
										<strong>Subject:</strong>
										<select name="submit" id="dropdownMenu1">
											<option value="">Subject</option>
											<?php
											$stmt = "SELECT DISTINCT courseType FROM class ORDER BY courseType";
											$results= $conn->query($stmt);
											$json = file_get_contents("json/courseprefixes.json");
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

								<li><strong>Title:</strong><input type="text" name="submit_title"></li>
								<li><strong>Professor:</strong><input type="text" name="submit_prof"></li>
								<li><strong>CRN:</strong><input type="text" name="submit_crn"></li>
								<li><button type="submit" id="submit" class="btn btn-default">Search</button></li>
							</ul>
						</form>
					</section>
				</div>
			</div>
			<div id="main">
				<button id="toggle" onclick="toggle();"><span class="glyphicon glyphicon-search" id="toggle"></span></button>
				<div id="main_contents">
					<center id="welcome"><h1>Search For Public Study Groups</h1></center>
					<center>
						<form method='POST' action='php/search.php'>
							<input id="searchbox" name="submit_title" type="text">
						</form>
					</center>

					<center id="buttons">
						<?php 
						//$stmt = "SELECT DISTINCT courseType FROM class ORDER BY courseType";
						$results= $conn->query($stmt);
						echo "<form method='POST' action='php/search.php'>";
						echo "<ul class='input_group'>";
						$i=0;
						while($prefixes = $results->fetch_row()){
							if($i != 0 && $i % 5 == 0){
								echo "</ul><ul class='input_group'>";
							}
							echo "<li><input type='submit' name='submit' class='btn btn-default' value='".$prefixes[0]."'></li>";
							$i += 1;
						}
						echo "</ul></form>";
						?>
					</center>
				</div>
				
			</div>
		</div>
		
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
		<script src="js/toggle.js"></script>
	</body>
</html>