<?php 
	require "php/connect.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">
						<img alt="Brand" src="images/logo.png" width="70px;">
					</a>

					
				</div>
				<ul class="nav navbar-nav navbar-right">
					<?php 
						if(isset($_COOKIE['userID'])){ // Checks if the user is logged in and if so, supply them with some pages they can click other wise they can only go back to the main page.
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
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" onclick="show_class_menu();">Classes<span class="caret"></span></button>
										<ul class="dropdown-menu scrollable-menu" role="menu" aria-labelledby="dropdownMenu1" id="class_menu">
											<li value="admn">Administration</li>
											<li value="arch">Architecture</li>
											<li value="arts">Arts</li>
											<li value="astr">Astronomy</li>
											<li value="bcbp">Biochemistry and Biophysics</li>
											<li value="biol">Biology</li>
											<li value="bmed">Biomedical Engineering</li>
											<li value="chem">Chemistry</li>
											<li value="chme">Chemical Engineering</li>
											<li value="civl">Civl Engineering</li>
											<li value="cogs">Cognitive Science</li>
											<li value="comm">Communication</li>
											<li value="coop">Cooperative Education</li>
											<li value="csci">Computer Science</li>
											<li value="econ">Economics</li>
											<li value="ecse">Electrical, Computer, and Systems Engineering</li>
											<li value="engr">General Engineering</li>
											<li value="enve">Environmental Engineering</li>
											<li value="epow">Electric Power Engineering</li>
											<li value="ERTH">Earth and Environmental Sciences</li>
											<li value="esci">Engineering Science</li>
											<li value="ienv">Interdisciplinary Environmental</li>
											<li value="ihss">Interdisciplinary Studies</li>
											<li value="isci">Interdisciplinary Science</li>
											<li value="isye">Industrial and Systems Engineering</li>
											<li value="itws">Information Technology and Web Science</li>
											<li value="lang">Foreign Languages</li>
											<li value="lght">Lighting</li>
											<li value="mane">Mechanical, Aerospace, and Nuclear Engineering</li>
											<li value="math">Mathematics</li>
											<li value="matp">Mathematical Programming, Probability, and Statistics</li>
											<li value="mgmt">Management</li>
											<li value="mtle">Materials Science and Engineering</li>
											<li value="phil">Philosophy</li>
											<li value="phys">Physics</li>
											<li value="psych">Psychology</li>
											<li value="stsh">Science and Technology - Humanities</li>
											<li value="stss">Science and Technology - Social Sciences</li>
											<li value="usaf">Aerospace Studies (Air Force ROTC)</li>
											<li value="usar">Military Science (Army ROTC)</li>
											<li value="usna">Naval Science (Navy ROTC)</li>
											<li value="writ">Writing</li>
										 </ul>
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
				<button id="toggle" onclick="toggle();"><span class="glyphicon glyphicon-triangle-left" id="toggle"></span></button>
				<div id="main_contents">
					<center id="welcome"><h1>Search For Public Study Groups</h1></center>
					<center>
						<form method='POST' action='php/search.php'>
							<input id="searchbox" name="submit" type="text">
						</form>
					</center>

					<center id="buttons">
						<?php 
						$stmt = "SELECT courseType FROM class ORDER BY courseType";
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