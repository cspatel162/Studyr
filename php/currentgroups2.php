<?php // This page displays all of the study groups the user is apart of. 
/* 
TODO:

*/

	include_once "pageStart.php"; 


	function fetchDate($date){
		
	}
	function currGroup(){
		global $conn;
		date_default_timezone_set("America/New_York");
		$eventmax = date('Y-m-d H:i:s', strtotime("+5 days")); // add an hour to the event for the end time
		$sql = "SELECT events.eventName,events.startTime,locations.locationName FROM events INNER JOIN locations ON events.locationID = locations.locationID WHERE events.userID = ".$_COOKIE['userID']." AND events.startTime <= '$eventmax' ORDER BY events.startTime LIMIT 20 ";
		$results = $conn->query($sql);
		if ($results->num_rows > 0){ // checks to make sure there are events, if 0 there are none and echos that out. 
			foreach($results as $val){
				echo "<li class='navitem'>".$val['eventName']." Starting at: ".$val['startTime']."</li>";
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