<?php 
 include_once "pageStartNoNav.php";
	$results; // This is so that we can call the results down below where they should actually be output.
	function searchclasses($prefix){ // Function to search all the classes
		global $conn;
		if($prefix == '*')
			$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID"; // If the user clicks show all on the splashpage.php
		else
			$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID WHERE class.courseType = '$prefix'"; // if the user clicks on one of the prefixes.
		global $results; // gets the global results and then sets them.
		$results = $conn->query($sql);
	}

	if($_POST['submit']=='Show All...'){searchclasses('*');} // calling the class search based on what is submitted. 
	else {searchclasses($_POST['submit']);}

	function searcheventsandprint($results){ // does the search for groups that are public for each class - then does all the displaying.
		global $conn;
		foreach ($results as $val){//FIRST prints out the class - THEN searching that courseID within all the study_groups, IF any groups are not private for that class then print them out, otherwise end it. 
			printf("<li id='result'>%u: %s %u, %s. Professor: %s %s <ul>",$val['crn'],$val['courseType'],$val['courseNumber'],$val['courseTitle'],$val['fname'],$val['lname']);
			$sql = "SELECT study_groups.* FROM study_groups WHERE study_groups.courseID = ".$val['courseID'];//search for study groups based on their courseID
			$groupresults = $conn->query($sql);
			foreach ($groupresults as $val2){ // Goes through the results of the search for study_groups.
				if($val2['privacy'] == 0){ // if there are any study_groups that are NOT private, then display them.
					$meeting_time = date('Y-m-d H:i:s',strtotime($val2['meetingTime']));
					printf("<li id='resultevent'>Group: %u, Meeting Time: %s </li>",$val2['groupID'],$meeting_time);
				}
			}
			printf("</ul></li>"); // now that all of the other display is done and we know each of the classes are finished being search add the end tags.
		}
	}
?>
		<section id="results"> <!-- Results print within this and therefore can be styled easily.-->
			<ul id="resultlist">
				<?php
					searcheventsandprint($results);	// get all of the classes and groups and print them out.
				?>
		</ul>
		</section>
	</section>
</body>
</html>