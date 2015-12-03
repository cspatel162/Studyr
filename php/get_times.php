<?php
	date_default_timezone_set("America/New_York");
	//require "connect.php"; 
	function get_times($userIDarray){
		global $conn;
		$user_ids = $userIDarray;


		$array = [];
		for($i=0;$i<24;$i++){
			$array2 = array(false,false,false,false,false,false,false);
			array_push($array,$array2);
		}


		for($i=0;$i<count($user_ids);$i++){
			$tempID = $user_ids[$i];
			$sql = "SELECT * FROM events WHERE userID='$tempID'";
			$result = $conn->query($sql);
			while($row = $result->fetch_assoc()){
				$val = date_parse($row["startTime"]);
				$val2 = date_parse($row["endTime"]);
				
				
				$week = date_parse(date("Y/m/d h:i:sa",strtotime("+1 week")));
				
				$jd1 = gregoriantojd($val['month'],$val['day'],$val['year']);
				$jd2 = gregoriantojd($week['month'],$week['day'],$week['year']);
									 
									 
				
				if($week['year']==$val['year']){
					$day = 7-($jd2-$jd1);

					if($day<7 && $day>-1){
						$diff = $val2["hour"]-$val["hour"];
						
						for($j=0;$j<$diff;$j++){
							$hour = $val['hour']+$j;
							$array[$hour][$day] = true;

						}
						
					}
				}
			}
			
			
		}
		//$conn->close();

		
		for($i=0;$i<24;$i++){
			for($j=0;$j<7;$j++){
				if(!$array[$i][$j]){
					echo "<button onclick='settime(".$i.",".$j."); return false;' class='yes'>Y</button>" ;
				}
				else {
					echo "<button class='no' disabled>N</button>" ;
				}
			}
			echo " ".$i;
			echo "<br>";
		}
	}
?>