<?php 
require "connect.php";

function search($prefix){
	global $conn;
	if($prefix == '*')
		$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID";
	else
		$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID WHERE class.courseType = '$prefix'";
	$results = $conn->query($sql);
	printres($results);
}
if($_POST['submit']=='Show All...'){search('*');}
else {search($_POST['submit']);}
?>





<html>
<head>
	<title> Search Results </title>
</head>
<body>
	<section id="results">
		<ul id="resultlist">
		<?php
		function printres($results){
			foreach ($results as $val){
				printf("<li id='result'>%u: %s %u, %s. Professor: %s %s </li>",$val['crn'],$val['courseType'],$val['courseNumber'],$val['courseTitle'],$val['fname'],$val['lname']); 
			}
		}
		?>
	</ul>
	</section>
</body>
</html>