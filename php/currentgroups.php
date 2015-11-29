<?php 
	include_once "pageStart.php"; 

	function currGroup(){
		global $conn;
		$sql = "SELECT events.*,locations.* FROM events INNER JOIN locations ON events.locationID = locations.locationID WHERE events.userID = ".$_COOKIE['userID'];
		$results = $conn->query($sql);
		if ($results){
			foreach($results as $val){
				echo "<li>Event: ".$val['eventName']." Starting: ".$val['startTime']." Ending: ".$val['endTime']." At: ".$val['locationName']."</li>";
			}
		}else{
			echo "Sorry, but you're not apart of any study groups right now.";
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