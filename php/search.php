<?php 
 include_once "pageStartNoNav.php";
	$results;
	function searchclasses($prefix){
		global $conn;
		if($prefix == '*')
			$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID";
		else
			$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID WHERE class.courseType = '$prefix'";
		global $results;
		$results = $conn->query($sql);
	}

	if($_POST['submit']=='Show All...'){searchclasses('*');}
	else {searchclasses($_POST['submit']);}

	function searcheventsandprint($results){
		global $conn;
		foreach ($results as $val){
			printf("<li id='result'>%u: %s %u, %s. Professor: %s %s <ul>",$val['crn'],$val['courseType'],$val['courseNumber'],$val['courseTitle'],$val['fname'],$val['lname']);
			$sql = "SELECT study_groups.* FROM study_groups WHERE study_groups.courseID = ".$val['courseID'];
			$groupresults = $conn->query($sql);
			foreach ($groupresults as $val2){
				if($val2['privacy'] == 0){
					$meeting_time = date('Y-m-d H:i:s',strtotime($val2['meetingTime']));
					printf("<li id='resultevent'>Group: %u, Meeting Time: %s </li>",$val2['groupID'],$meeting_time);
				}
			}
			printf("</ul></li>");
		}
	}
?>
		<section id="results">
			<ul id="resultlist">
				<?php
					searcheventsandprint($results);	
				?>
		</ul>
		</section>
	</section>
</body>
</html>