<?php 
 include_once "pageStartNoNav.php";
	$results;
	function searchclasses($prefix){
		global $conn;
		if($prefix == '*')
			$sql = "SELECT class.*, professors.fname, professors.lname,study_groups.* FROM class INNER JOIN professors ON class.professorID = professors.professorID INNER JOIN study_groups ON class.courseID = study_groups.courseID";
		else
			$sql = "SELECT class.*, professors.fname, professors.lname,study_groups.* FROM class INNER JOIN professors ON class.professorID = professors.professorID INNER JOIN study_groups on class.courseID = study_groups.courseID WHERE class.courseType = '$prefix'";
		global $results;
		$results = $conn->query($sql);
	}

	if($_POST['submit']=='Show All...'){searchclasses('*');}
	else {searchclasses($_POST['submit']);}

	function printres($results){
		foreach ($results as $val){
			if($val['privacy'] == 0){
				$meeting_time = date('Y-m-d H:i:s',strtotime($val['meetingTime']));
				printf("<li id='result'>%u: %s %u, %s. Professor: %s %s <ul>",$val['crn'],$val['courseType'],$val['courseNumber'],$val['courseTitle'],$val['fname'],$val['lname']); 
				printf("<li id='resultevent'>Group: %u, Meeting Time: %s </li>",$val['groupID'],$meeting_time);
				printf("</ul></li>");
			}
			else{
				printf("<li id='result'>%u: %s %u, %s. Professor: %s %s </li>",$val['crn'],$val['courseType'],$val['courseNumber'],$val['courseTitle'],$val['fname'],$val['lname']);
			}
		}
	}
?>
		<section id="results">
			<ul id="resultlist">
				<?php
					printres($results);	
				?>
		</ul>
		</section>
	</section>
</body>
</html>