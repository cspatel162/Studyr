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
	function searchcrn($crn){ // Function to search all the classes
		global $conn;
		$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID WHERE class.crn = '$crn'"; // if the user clicks on one of the prefixes.
		global $results; // gets the global results and then sets them.
		$results = $conn->query($sql);
	}
	function searchprof($prof){ // Function to search all the classes
		global $conn;
		$pos = strrpos($prof, " ");
		if(!$pos){
			$findpid = "SELECT professorID FROM professors WHERE lname='$prof'";
		} else {
			$proff = substr($prof, 0, $pos); //find first name
			$profl = substr($prof,$pos+1);  //find last name
			$findpid = "SELECT professorID FROM professors WHERE (fname='$proff' AND lname='$profl')";
		}
		$res1=$conn->query($findpid);
		$res=$res1->fetch_row();
		$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID WHERE class.professorID = '$res[0]'"; // if the user clicks on one of the prefixes.
		global $results; // gets the global results and then sets them.
		$results = $conn->query($sql);
	}
	function searchtitle($title){ // Function to search all the classes
		global $conn;
		$sql = "SELECT class.*, professors.fname, professors.lname FROM class INNER JOIN professors ON class.professorID = professors.professorID WHERE class.courseTitle = '$title'"; // if the user clicks on one of the prefixes.
		global $results; // gets the global results and then sets them.
		$results = $conn->query($sql);
	}
	if(isset($_POST['submit'])){
		if($_POST['submit']=='Show All...'){searchclasses('*');} // calling the class search based on what is submitted. 
		else {searchclasses($_POST['submit']);}
	}
	
	if(isset($_POST['submit_crn'])){
		if($_POST['submit_crn'] != ''){
			searchcrn($_POST['submit_crn']);
		} else if($_POST['submit_title'] != ''){
			searchtitle($_POST['submit_title']);
		} else if($_POST['submit_prof'] != ''){
			searchprof($_POST['submit_prof']);
		}
	}

	function searcheventsandprint($results){ // does the search for groups that are public for each class - then does all the displaying.
		global $conn;
		if($results->num_rows > 0){
			foreach ($results as $val){//FIRST prints out the class - THEN searching that courseID within all the study_groups, IF any groups are not private for that class then print them out, otherwise end it. 
				printf("<li id='result'>%u: %s %u, %s. Professor: %s %s <ul>",$val['crn'],$val['courseType'],$val['courseNumber'],$val['courseTitle'],$val['fname'],$val['lname']);
				$sql = "SELECT study_groups.* FROM study_groups WHERE study_groups.courseID = ".$val['courseID'];//search for study groups based on their courseID
				$groupresults = $conn->query($sql);
				foreach ($groupresults as $val2){ // Goes through the results of the search for study_groups.
					if($val2['privacy'] == 0){ // if there are any study_groups that are NOT private, then display them.
						$meeting_time = date('Y-m-d H:i:s',strtotime($val2['meetingTime']));
						printf("<a href='group.php?id=%u'><li id='resultevent'>Group: %u, Meeting Time: %s </li></a>",$val2['groupID'],$val2['groupID'],$meeting_time);
					}
				}
				printf("</ul></li>"); // now that all of the other display is done and we know each of the classes are finished being search add the end tags.
			}
		} else {
			printf("<li>No courses found!</li>");
		}
	}
?>
		<nav class="leftnavbar"> <!-- SIDE NAV BAT -->
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