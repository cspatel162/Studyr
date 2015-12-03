<?php 
	include_once "page_start.php";
?>
				<script>
					document.getElementById("calendar").innerHTML = '<button type="button" onclick="importCalendar()">Import Google Calendar</button>\
					<table id="schedule">\
						<tr>\
							<td>Time</td> \
							<td>Monday</td> \
							<td>Tuesday</td> \
							<td>Wednesday</td> \
							<td>Thursday</td> \
							<td>Friday</td> \
							<td>Saturday</td> \
							<td>Sunday</td> \
						</tr>\
					</table>';
				</script>
			</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="../js/calendar.js"></script>
	</body>
</html>