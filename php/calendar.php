<?php include_once "pageStart.php"; 
			include_once "connect.php";

  $name = $_POST['email2'];
  $pass = $_POST['password'];
  
  $sql = "SELECT email FROM users";
  $result = $conn->query($sql);

  $sql = "SELECT email, password FROM users";
  $result = $conn->query($sql);
  
  $found = false;
  if($result->num_rows>0){
      while($row = $result->fetch_assoc()) {
          if($row["email"]==$name && $row["password"] == $pass){
              echo $row["email"];
              echo $row["password"];
              $found = true;
              break;
          }
      }
  }

  if($found)
      echo "found";
  else 
      echo "not found";
  
  $conn->close();
 ?>

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