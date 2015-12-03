<?php 
 include_once "page_start_index.php";
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
		$sql = "SELECT class.*, professors.fname, professors.lname, levenshtein(class.courseTitle, '$title') AS distance FROM class INNER JOIN professors ON class.professorID = professors.professorID WHERE levenshtein(class.courseTitle, '$title') < 10 ORDER BY distance desc"; // if the user clicks on one of the prefixes.
		global $results; // gets the global results and then sets them.
		$results = $conn->query($sql);
	}
	if(isset($_POST['submit'])){
		searchclasses($_POST['submit']);
		$searchingfor = $_POST['submit'];
	}
	
	if(isset($_POST['submit_crn'])){
		if($_POST['submit_crn'] != ''){
			searchcrn($_POST['submit_crn']);
			$searchingfor = $_POST['submit_crn'];
		} else if($_POST['submit_title'] != ''){
			searchtitle($_POST['submit_title']);
			$searchingfor = $_POST['submit_title'];
		} else if($_POST['submit_prof'] != ''){
			searchprof($_POST['submit_prof']);
			$searchingfor = $_POST['submit_prof'];
		}
	}

	function searcheventsandprint($results){ // does the search for groups that are public for each class - then does all the displaying.
		global $conn;
		global $searchingfor;
		if($results->num_rows > 0){
			echo "<h3 style=\"color: #7CB4B4;\">Showing results for $searchingfor ...</h3>";
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
					
					<section id="results"> <!-- Results print within this and therefore can be styled easily.-->
						<ul id="resultlist">
						<?php
							searcheventsandprint($results);	// get all of the classes and groups and print them out.
						?>
						</ul>
					</section>
				</div>
			</div>
		</div>
		
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
<!--		<script src="../js/toggle.js"></script>-->
	</body>
</html>