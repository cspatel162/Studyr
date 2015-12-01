<html>
	<meta charset='utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<head>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<title>Studyr</title>
	</head>
	<body>
		<section class="content">
			<section class="rightheader"><!-- top nav bar -->
				<?php 
					if(isset($_COOKIE['userID'])){ // Checks if the user is logged in and if so, supply them with some pages they can click other wise they can only go back to the main page.
						echo '<a href="calendar.php"> My Calendars</a> | <a href="splashpage.php">Studyr</a> | <a href="logout.php">Logout</a>';
					}
					else{
						echo '<a href="login.php">Login or Register</a>';
					}
				?>
		</section>
			<nav id="side" class="leftnavbar"> <!-- SIDE NAV BAT -->
			<section class="leftheader"> 
				<h1> Search by..</h1>
			</section>
			<section class="search">
				
				<form action="search.php" method="POST">
					<ul class="nav">
						<li>Subject:</li>
						<li>Title:</li>
						<li>Professor:</li>
						<li>CRN:</li>
					</ul>
					<ul class="nav">
						<li><select name="submit" class="find">
													<option value="admn">Administration</option><option value="arch">Architecture</option>
													<option value="arts">Arts</option><option value="astr">Astronomy</option>
													<option value="bcbp">Biochemistry and Biophysics</option><option value="biol">Biology</option>
													<option value="bmed">Biomedical Engineering</option><option value="chem">Chemistry</option>
													<option value="chme">Chemical Engineering</option><option value="civl">Civl Engineering</option>
													<option value="cogs">Cognitive Science</option><option value="comm">Communication</option>
													<option value="coop">Cooperative Education</option><option value="csci">Computer Science</option>
													<option value="econ">Economics</option><option value="ecse">Electrical, Computer, and Systems Engineering</option>
													<option value="engr">General Engineering</option><option value="enve">Environmental Engineering</option>
													<option value="epow">Electric Power Engineering</option><option value="ERTH">Earth and Environmental Sciences</option>
													<option value="esci">Engineering Science</option><option value="ienv">Interdisciplinary Environmental</option>
													<option value="ihss">Interdisciplinary Studies</option><option value="isci">Interdisciplinary Science</option>
													<option value="isye">Industrial and Systems Engineering</option><option value="itws">Information Technology and Web Science</option>
													<option value="lang">Foreign Languages</option><option value="lght">Lighting</option>
													<option value="mane">Mechanical, Aerospace, and Nuclear Engineering</option><option value="math">Mathematics</option>
													<option value="matp">Mathematical Programming, Probability, and Statistics</option><option value="mgmt">Management</option>
													<option value="mtle">Materials Science and Engineering</option><option value="phil">Philosophy</option>
													<option value="phys">Physics</option><option value="psych">Psychology</option>
													<option value="stsh">Science and Technology - Humanities</option><option value="stss">Science and Technology - Social Sciences</option>
													<option value="usaf">Aerospace Studies (Air Force ROTC)</option><option value="usar">Military Science (Army ROTC)</option>
													<option value="usna">Naval Science (Navy ROTC)</option><option value="writ">Writing</option>
												</select></li>
					
						<li><input type="text" name="submit_title" class="find"></li>
					
						<li><input type="text" name="submit_prof" class="find"></li>
					
						<li><input type="text" name="submit_crn" class="find"></li>
						<li><button type="submit" class="find">Search</button></li>
					</ul>
				</form>
			</section>
		</nav>
			<a class="ui-icon ui-icon-triangle-1-e" href="#" id="adv"></a>
			<section class="menu">
				<p>Search for Public Study Groups:</p>
				<form action="search.php" method="POST">
					<input type="text" name="submit" class ="find">
					<button type="submit" class="find">Search</button>
				</form>
			</section>
			<section class="menu">
				<p>Search Groups by Course Offerings:</p>
				<form method="POST" action="search.php">
					<ul>
						<li><ul class="nav">
							<li><input type="submit" name="submit" value="ADMN" class="navitem1"></li>
							<li><input type="submit" name="submit" value="ARCH" class="navitem1"></li>
							<li><input type="submit" name="submit" value="ARTS" class="navitem1"></li>
							<li><input type="submit" name="submit" value="ASTR" class="navitem1"></li>
							<li><input type="submit" name="submit" value="BCBP" class="navitem1"></li>
						</ul></li>
						<li><ul class="nav">
							<li><input type="submit" name="submit" value="BIOL" class="navitem1"></li>
							<li><input type="submit" name="submit" value="BMED" class="navitem1"></li>
							<li><input type="submit" name="submit" value="CHEM" class="navitem1"></li>
							<li><input type="submit" name="submit" value="CHME" class="navitem1"></li>
							<li><input type="submit" name="submit" value="Show All..." class="navitem1"></li>
						</ul></li>
					</ul>
				</form>
			</section>
		</section>
	</body>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>
		$("#side").hide();
		$("#adv").hover(function(){
			$("#side").toggle('slide');
			$("#adv").toggleClass("ui-icon-triangle-1-e");
		},function(){
			$("#adv").toggleClass("ui-icon-triangle-1-w");
		});
	</script>
</html>
