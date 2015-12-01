<?php // This page displays all of the study groups the user is apart of. 
/* 
TODO:
	Setup pages for each study group, a page that gives facts about each group - stuff like members, meeting location, time, study materiels??? Something so this page can be useful.

*/

	include_once "pageStart.php"; 


	function fetchDate($datetime){
		$pos = strrpos($datetime, " ");
		$date = substr($datetime,0, $pos);
		$time = substr($datetime,$pos+1);
		$datel =  explode("-",$date);
		$months = array("00" => "notfound", "01" => "January", "02" => "February", "03" => "March",
	   "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August",
	   "09" => "September", "10" => "October", "11" => "November", "12" => "December" );
		return $months[$datel[1]] . " ". $datel[2] . ", " . $datel[0];
	}
	function currGroup(){
		global $conn;
		$sql = "SELECT events.*,locations.*,founderID FROM events INNER JOIN locations ON events.locationID = locations.locationID INNER JOIN study_groups ON events.groupID = study_groups.groupID WHERE events.userID = ".$_COOKIE['userID']; // gets events based on user id and displays more infromation about events
		$results = $conn->query($sql);
		if ($results->num_rows > 0){ // checks to make sure there are events, if 0 there are none and echos that out. 
			foreach($results as $val){
				if($val['founderID'] == $_COOKIE['userID']) {
					echo "<li class=\"currentgroup owngroup\"><p>".$val['eventName']."</p> Starting: ".fetchDate($val['startTime'])." At: ".$val['locationName']."</li>";
				} else {
					echo "<li class=\"currentgroup\"><p>".$val['eventName']."</p> Starting: ".fetchDate($val['startTime'])." At: ".$val['locationName']."</li>";
				}
			}
		}else{
			echo "<li>Sorry, but you're not apart of any study groups right now.</li>";
		}
	}
 ?>
		<section id="groups">
			<ul>
			<?php
				currGroup();
			?>
			</ul>
		</section>
	</section>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</html>