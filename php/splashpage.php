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
			<section class="rightheader"><a href="login.php" id="signin">Login or Register</a></section>
			<img src="">
			<section class="search">
				<p>Search for Public Study Groups:</p>
				<input type="text" name="search" class ="find">
				<input type="submit" value="Search" class="find">
			</section>
			<section class="menu">
				<p>Search Groups by Course Offerings:</p>
				<form method="POST" src="search.php">
					<ul class="nav">
						<li><input type="button" name="search" value="ADMN" class="navitem"></li>
						<li><input type="button" name="search" value="ARCH" class="navitem"></li>
						<li><input type="button" name="search" value="ARTS" class="navitem"></li>
						<li><input type="button" name="search" value="ASTR" class="navitem"></li>
						<li><input type="button" name="search" value="BCBP" class="navitem"></li>
					</ul>
					<ul class="nav">
						<li><input type="button" name="search" value="BIOL" class="navitem"></li>
						<li><input type="button" name="search" value="BMED" class="navitem"></li>
						<li><input type="button" name="search" value="CHEM" class="navitem"></li>
						<li><input type="button" name="search" value="CHME" class="navitem"></li>
						<li><input type="button" name="more" value="Show more..." class="navitem"></li>
					</ul>
				</form>
			</section>
		</section>
	</body>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</html>
