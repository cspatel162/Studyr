<?php // This page displays all of the study groups the user is apart of. 
/* 
TODO:
	Setup pages for each study group, a page that gives facts about each group - stuff like members, meeting location, time, study materiels??? Something so this page can be useful.

*/

	include_once "pageStart.php"; 

	function currGroup(){
		global $conn;
		$sql = "SELECT events.*,locations.* FROM events INNER JOIN locations ON events.locationID = locations.locationID WHERE events.userID = ".$_COOKIE['userID']; // gets events based on user id and displays more infromation about events
		$results = $conn->query($sql);
		if ($results->num_rows > 0){ // checks to make sure there are events, if 0 there are none and echos that out. 
			foreach($results as $val){
				echo "<li>Event: ".$val['eventName']." Starting: ".$val['startTime']." Ending: ".$val['endTime']." At: ".$val['locationName']."</li>";
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