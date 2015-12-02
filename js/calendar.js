	if ($(document).ready()) { 
		
		var startDay = 7;
		var startMonth = 12;
		var startYear = 2015;
	
		var rows = "";
		for (var hour = 0; hour < 24; hour++) {
	
			rows += "<tr class=\"hour_" + hour + "\"><td class=\"hour\">" + hour + "</td>";
	
			for (var day = 0; day < 7; day++) {
				rows += "<td class=\"day_" + day + "\"></td>";
			}
	
			rows += "</tr>";
		}

		$("#schedule").append(rows);

		updateSchedule();
	}
	
	function updateSchedule() {

		for (var hour = 0; hour < 24; hour++) {
			for (var day = 0; day < 7; day++) {
				$.get("check_for_event.php", {year:startYear, month:startMonth, day:startDay+day, hour:hour}, function(data){
					$(".hour_" + data['hour'] + " .day_" + (data["day"]-startDay)).html(data["event_name"]);
				}, "json");
			}
		}
	}
	
	function importCalendar() {
		window.location = "calendar_functions.php";
	}