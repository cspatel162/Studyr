<?php //we can include other PHP Files here to keep the calendar file as clear as possible 
?>
<html>
<meta charset='utf-8'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<section class="content">
		<nav class="leftnavbar">
			<section class="leftheader">
				<h1> Studyr       <em>Username</em></h1>
			</section>
			<ul class="nav">
				<a href="myschedule.php"><li class="navitem">Edit User's Schedule</li></a>
				<a href="creategroup.php"><li class="navitem">Create a Study Group</li></a>
				<a href="currentgroups.php"><li class="navitem">Users Current Study Groups</li></a>
				<a href="joingroup.php"><li class="navitem">Join a Study Group</li></a>
			</ul>
			<section class="upcoming">
				<h1> UPCOMING EVENTS: </h1>
				<ul class="events">
					<li>Event1</li>
					<li>Event2</li>
					<li>Event3</li>
					<li>Event4</li>
					<li>Event5</li>
				</ul>
			</section>
		</nav>
		<section class="calendarheader">
			<h1> User's Schedule </h1>
		</section>
		<section class="calendar">
			<p> </p>
		</section>
	</section>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</html>