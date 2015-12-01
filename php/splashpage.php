<?php?>
<html>
	<meta charset='utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<head>
		<link rel="stylesheet" type="text/css" href="../css/splashstyle.css">
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
			<img src="">
			<section class="search">
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
							<li><input type="submit" name="submit" value="ADMN" class="navitem"></li>
							<li><input type="submit" name="submit" value="ARCH" class="navitem"></li>
							<li><input type="submit" name="submit" value="ARTS" class="navitem"></li>
							<li><input type="submit" name="submit" value="ASTR" class="navitem"></li>
							<li><input type="submit" name="submit" value="BCBP" class="navitem"></li>
						</ul></li>
						<li><ul class="nav">
							<li><input type="submit" name="submit" value="BIOL" class="navitem"></li>
							<li><input type="submit" name="submit" value="BMED" class="navitem"></li>
							<li><input type="submit" name="submit" value="CHEM" class="navitem"></li>
							<li><input type="submit" name="submit" value="CHME" class="navitem"></li>
							<li><input type="submit" name="submit" value="Show All..." class="navitem"></li>
						</ul></li>
					</ul>
				</form>
			</section>
		</section>
	</body>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</html>
