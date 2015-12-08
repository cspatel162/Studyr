if ($(document).ready()) {
	// load in the foundation for the schedule
	$("#calendar").html(
		'<button type="button" id="importButton" onclick="importCalendar()">Import Google Calendar</button>\
		<table id="schedule">\
			<tr class="labels">\
				<td class="hour">Time</td>\
				<td>Monday</td>\
				<td>Tuesday</td>\
				<td>Wednesday</td>\
				<td>Thursday</td>\
				<td>Friday</td>\
				<td>Saturday</td>\
				<td>Sunday</td>\
			</tr>\
		</table>\
		<form id="popupForm" action="add_event.php" method="post">\
			<h3>Add an Event</h3>\
			<p>Event Title:</p><p><input type="text" name="eventName" required></p>\
			<p>Hours:</p><p><input type="datetime-local" id="startDateTime" name="startDateTime" value="" required></p>to\
			<p><input type="datetime-local" id="endDateTime" name="endDateTime" value="" required></p>\
			<p id="error"></p>\
			<input type="submit" id="submitButton" value="Submit">\
			<button type="button" id="closeButton" onclick="closePopupForm()">X</button>\
		</form>\
		<div id="background"><div>'
	);
	
	
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
		rows += "<tr class=\"hour_" + hour + "\"><td class=\"hour\">";
		
		// check if hour is 0 or after 12, then display the appropriate hour
		if (hour == 0)			
			rows += 12;
		else if (hour > 12)
			rows += hour%12;
		else
			rows += hour;
			
		// check if it is AM or PM
		if (hour < 12)
			rows += " AM";
		else
			rows += " PM";
			
		// end the table data
		rows += "</td>";
		
		// create the rest of the columns
		for (var day = 0; day < 7; day++) {
			rows += "<td class=\"day_" + day + "\"></td>";
		}
		
		// end the row
		rows += "</tr>";
	}
	// append the rows
	$("#schedule").append(rows);
	// update the rows
	updateSchedule();
	// add scroll listener to center the form
	$(window).scroll(function() {
		// only adjust the values if the form can be seen
		if ($("popupForm").css("display") != "none") {
			$("#popupForm").css("top", ( $(window).height() - $("#popupForm").height() ) / 2+$(window).scrollTop() + "px");
			$("#popupForm").css("left", ( $(window).width() - $("#popupForm").width() ) / 2+$(window).scrollLeft() + "px");
		}
	});
	// add submit listener for the form
	$("#popupForm").submit(function(e) {validateForm(e);});
	// add click listener for background
	$("#background").click(function(){
		closePopupForm();
	});
}

function updateSchedule() {
	// find events for each hour specified by the class of the row/column
	for (var hour = 0; hour < 24; hour++) {
		for (var day = 0; day < 7; day++) {
			$.post("check_for_event.php", {year:startYear, month:startMonth, day:startDay+day, hour:hour}, function(data){
				$(".hour_" + data['hour'] + " .day_" + (data['day']-startDay)).html(data['event_name']);
				
				
				
				// check if an event was added and set 'button' accordingly
				var button, buttonText, preText;
				if (data['event_name']) {
					button = "remove";
					buttonText = "-";
					preText = "<br>";
				}
				else {
					button = "add";
					buttonText = "+";
					preText = "";
				}	
					
				$(".hour_" + data['hour'] + " .day_" + (data['day']-startDay)).append(
					preText + "<button type=\"button\" class=\"" + button + "Button\"onclick=\"" + button + "Event(" + (data['day']-startDay) + "," + data['hour'] +" )\">" + buttonText + "</button>"
				);
				
			}, "json");
		}
	}
}

// only imports the next 2 weeks now since GET request isn't working like we would like it to
function importCalendar() {
	// run backend code to get the user's calendar and add events to the database
	// cannot use a GET/POST request here since the calendar_functions.php needs to redirect
	// to Google's authorization page
	window.location = 'calendar_functions.php';
}

// function to pad a field of a time or date (such as month, day, hour, etc.) with a zero
// if two digits are necessary
function pad(number) {
	var numberString = "0" + number;
	return numberString.substr(numberString.length-2)
}

// validate the form to ensure the inputted data is correct
function validateForm(event) {
	// get the start and end times
	var start = new Date($("#popupForm #startDateTime").val());
	var end = new Date($("#popupForm #endDateTime").val());
	// ensure the start date/time is less than the end date/time
	if (start > end) {
		$("#error").html("Start time cannot be greater than end time!");
		event.preventDefault();
		return false;
	// ensure they are not equal
	} else if (start == end) {
		$("#error").html("Start time cannot be the same as the end time!");
		event.preventDefault();
		return false;
	} else {
		$("#popupForm").hide();
		return true;
	}
}

function addEvent(day, hour) {
	// set day to the actual day
	day += startDay;
	// initialize the start value to the start time of the timeblock that was clicked
	$("#popupForm #startDateTime").val("2015-12-" + pad(day) + "T" + pad(hour) + ":00:00");//" + day + "T" + hour + "00:00.00")
	// add an hour
	hour += 1;
	// check if it's 24
	if (hour == 24) {
		day += 1;
		hour = 0;
	}
	// initialize the end value to the end time of the timeblock that was clicked
	$("#popupForm #endDateTime").val("2015-12-" + pad(day) + "T" + pad(hour) + ":00:00");
	// show the popup form
	openPopupForm();
}

function removeEvent(day, hour) {
	// ensure the user really wants to remove this event
	if (confirm("Are you sure you want to remove '" + $("#schedule tr.hour_" + hour + " .day_" + day).text().slice(0,-1) + "' from your calendar?")) {
		// send the data to remove_event.php to remove the event
		$.post("remove_event.php", {year:startYear, month:startMonth, day:startDay+day, hour:hour}, function() {
			// reload the page so the calendar & Upcoming Events list gets updated
			location.reload();
		});		
	}
}

function openPopupForm() {
	// fade the background and show the form in the center
	$("#popupForm").css("top", ( $(window).height() - $("#popupForm").height() ) / 2+$(window).scrollTop() + "px");
	$("#popupForm").css("left", ( $(window).width() - $("#popupForm").width() ) / 2+$(window).scrollLeft() + "px");
	$("#background").fadeIn(100);
	$("#popupForm").fadeIn(100);
}

function closePopupForm() {
	$("#background").fadeOut(100);
	$("#popupForm").fadeOut(100);
}