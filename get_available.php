<?php
	require "php/connect.php"; 

	function get_available(){
		$array = [];
		for($i=0;$i<24;$i++){
			$array2 = array(false,false,false,false,false,false,false);
			array_push($array,$array2);
		}

		$group_id = 4;
		$sql = "SELECT * FROM events WHERE groupID='$group_id'";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$tempID = $row["userID"];
				echo $tempID;
				echo "<br>";
				
				$sql2 = "SELECT * FROM events WHERE userID='$tempID'";
				$result2 = $conn->query($sql2);
	//			if($result2->num_rows>0){
					while($row2 = $result2->fetch_assoc()){
						if( strtotime($row2['endTime']) < strtotime('-7 day') ) {
							echo 'past 7 days';
						}
									
						echo "Start:".$row2["startTime"]." - End:".$row2["endTime"];
					}
	//			}

				echo "<br>";
			}
		} else {
			echo "0 results";
		}
		$conn->close();
		

		for($i=0;$i<24;$i++){
			
			for($j=0;$j<7;$j++){
				if(!$array[$i][$j]){
					echo "[ f ]" ;
				}
				else {
					echo "[ t ]";
				}
			}
			echo "  ".$i;
			echo "<br>";
		}
	}

?>