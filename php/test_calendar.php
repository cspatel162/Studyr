<?php 
	include_once "pageStart.php";
 ?>
 
	<!-- table to display schedule -->
	<table id="schedule">
		<!-- header row -->
		<tr>
			<td>Time</td>
			<td>Monday</td>
			<td>Tuesday</td>
			<td>Wednesday</td>
			<td>Thursday</td>
			<td>Friday</td>
			<td>Saturday</td>
			<td>Sunday</td>
		</tr>
	</table>
	</section>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
	
	// weekly calendar will start December 7 (for testing purposes)
	var startDay = 7;
	var startMonth = 12;
	var startYear = 2015;
	
	// each <tr> represents an hour
	// each <td> in <tr> corresponds to the day
	// create the rows, giving each row and column a class value that represents the hour and day it represents
	var rows = "";
	for (var hour = 0; hour < 24; hour++) {
		// first column contains the number of the hour
		rows += "<tr class=\"hour_" + hour + "\"><td class=\"hour\">" + hour + "</td>";
		// create the rest of the columns
		for (var day = 0; day < 7; day++) {
			rows += "<td class=\"day_" + day + "\"></td>";
		}
		// end the row
		rows += "</tr>";
	}
	// append the rows
	$("#schedule").append(rows);
	
	// find events for each hour specified by the class of the row/column
	for (var hour = 0; hour < 24; hour++) {
		for (var day = 0; day < 7; day++) {
			$.get("check_for_event.php", {year:startYear, month:startMonth, day:startDay+day, hour:hour}, function(data){
				$(".hour_" + data['hour'] + " .day_" + (data['day']-startDay)).append(data['event_name']);
			}, "json");
		}
	}
</script>
</html>