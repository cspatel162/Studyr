if ($(document).ready()) {
	// create array of months
	var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	// get today's date
	var today = new Date();
	var todayDay = today.getDate();
	var todayMonth = today.getMonth();
	var todayYear = today.getFullYear();
	
	// load in the foundation for the schedule
	$("#calendar").html(
		'<button type="button" class="weekButton" onclick="changeWeek(-1)"><</button><h2 id="weekLabel">Week of: ' + monthNames[todayMonth] + ' ' + todayDay + ', ' + todayYear + '</h2><button type="button" class="weekButton" onclick="changeWeek(1)">></button>\
		<button type="button" id="importButton" onclick="promptImportForm()">Import Google Calendar</button>\
		<table id="schedule">\
			<tr class="labels">\
				<td class="hour"><h4>Time</h4></td>\
				<td><h4>Monday</h4><h5></h5></td>\
				<td><h4>Tuesday</h4><h5></h5></td>\
				<td><h4>Wednesday</h4><h5></h5></td>\
				<td><h4>Thursday</h4><h5></h5></td>\
				<td><h4>Friday</h4><h5></h5></td>\
				<td><h4>Saturday</h4><h5></h5></td>\
				<td><h4>Sunday</h4><h5></h5></td>\
			</tr>\
		</table>\
		<form id="addEventForm" action="add_event.php" method="post">\
			<h3>Add an Event</h3>\
			<p>Event Title:</p><p><input type="text" name="eventName" required></p>\
			<p>Hours:</p><p><input type="datetime-local" class="startDateTime" name="startDateTime" value="" required></p>to\
			<p><input type="datetime-local" class="endDateTime" name="endDateTime" value="" required></p>\
			<p class="error"></p>\
			<input type="submit" class="submitButton" value="Submit" onclick="closePopupForm(&quot;addEventForm&quot;)">\
			<button type="button" class="closeButton" onclick="closePopupForm(&quot;addEventForm&quot;)">X</button>\
		</form>\
		<form id="importForm" onsubmit="importCalendar(); return false;">\
			<h3>Import Events</h3>\
			<p>From:</p><p><input type="datetime-local" class="startDateTime" name="startDateTime" value="" required></p>to:\
			<p><input type="datetime-local" class="endDateTime" name="endDateTime" value="" required></p>\
			<p class="error"></p>\
			<input type="submit" class="submitButton" value="Submit" onclick="closePopupForm(&quot;importForm&quot;)">\
			<button type="button" class="closeButton" onclick="closePopupForm(&quot;importForm&quot;)">X</button>\
		</form>\
		<div id="background"><div>'
	);
	
	// create variable to hold the date offset - used to determine the day number for each column's class in the table
	var offset = today.getDay() - 1;
	// create variable to hold the overall change in days - used for updating the week label above the calendar
	var changeInDays = 0;
	
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
		for (var day = 0-offset; day < 7-offset; day++) {
			rows += "<td class=\"day_" + day + "\"></td>";
		}
		
		// end the row
		rows += "</tr>";
	}
	// append the rows
	$("#schedule").append(rows);
	// update the rows
	updateSchedule();
	// add scroll listener to center the forms
	$(window).scroll(function() {
		updateFormLocation("addEventForm");
		updateFormLocation("importForm");
	});
	// add submit listener for the forms
	$("#addEventForm").submit(function(e) {validateForm(e, "popupForm");});
	// add click listener for background
	$("#background").click(function(){
		closePopupForm("addEventForm");
		closePopupForm("importForm");
	});
}

function updateSchedule() {
	// reserve for Date object to use for date calculation
	var date = new Date();
	
	// boolean to check if the header dates have been set yet
	var areHeaderDatesSet = false;
	// track which header to set
	var headerNumber = 2; // the days start at the 2nd child of label class and end at 8th child
	
	// find events for each hour specified by the class of the row/column
	for (var hour = 0; hour < 24; hour++) {		
		for (var day = 0-offset; day < 7-offset; day++) {
			
			// reset the date to today
			date.setFullYear(todayYear);
			date.setMonth(todayMonth);
			date.setDate(todayDay+day);
			// get the date while accounting for the offset
			date.setHours(hour);
			// create variables hold the starting and ending date/time
			var startYear, startMonth, startDay, startHour, endYear, endMonth, endDay, endHour;
			// set the start date/time variables using the date object
			startYear = date.getFullYear();
			startMonth = date.getMonth() + 1;
			startDay = date.getDate();
			startHour = date.getHours();
			// check if the headers have been set
			if (!areHeaderDatesSet) {
				// append the date
				$(".labels td:nth-child(" + headerNumber + ") h5").html(startMonth + "/" + startDay);
				// increment to move to next header
				headerNumber += 1;
			}			
			
			// check if the hour is 23 and set the ending date/time variables accordingly
			if (hour == 23) {
				// if its 23, the end date should be set to the correct hour (the month or year may change)
				date.setHours(date.getHours()+1);
				endYear = date.getFullYear();
				endMonth = date.getMonth()+1;
				endDay = date.getDate();
				endHour = 0;
			} else {
				// if its not 23, we can assume that the next hour is just +1, within the same day
				endYear = startYear;
				endMonth = startMonth;
				endDay = startDay;
				endHour = startHour + 1;
			}
			
			// check for an event in the specified time slot
			$.post("check_for_event.php", {
				start_year: startYear, start_month: startMonth, start_day: startDay, start_hour: startHour,
				end_year: endYear, end_month: endMonth, end_day: endDay, end_hour: endHour,
				day_timeslot: day // also include the timeslot that the data belongs to so we know where to put it afterwards
			}, function(data){
			
				// set the html of the timeslot to the event name
				$(".hour_" + data['start_hour'] + " .day_" + (data['day_timeslot'])).html(data['event_name']);
				
				// check if an event was added and set 'button' accordingly
				var button, buttonText, preText;
				if (data['event_name']) {
					button = "remove";
					buttonText = "-";
					preText = "<br>"; // break is needed so that the 'remove' button can be displayed on the next line after the event title
				}
				else {
					button = "add";
					buttonText = "+";
					preText = "";
				}	
				
				// add the button to the time slot
				$(".hour_" + data['start_hour'] + " .day_" + (data['day_timeslot'])).append(
					preText + "<button type=\"button\" class=\"" + button + "Button\"onclick=\"" + button + "Event(" + data['start_year'] + ", " + data['start_month'] + ", " + data['day_timeslot'] + "," + data['start_hour'] + ")\">" + buttonText + "</button>"
				);
				
			}, "json");
		}
		
		// after looping through all the days, the header dates have been set
		areHeaderDatesSet = true;
	}
}

function promptImportForm() {
	// create date object to get time right now
	var now = new Date();
	// initialize the start value to the today's date/time
	$("#importForm .startDateTime").val(now.getFullYear() + "-" + pad(now.getMonth()+1) + "-" + pad(now.getDate()) + "T" + pad(now.getHours()) + ":" + pad(now.getMinutes()) + ":00");
	// add a week
	now.setDate(now.getDate() + 7);
	// initialize the end value
	$("#importForm .endDateTime").val(now.getFullYear() + "-" + pad(now.getMonth()+1) + "-" + pad(now.getDate()) + "T" + pad(now.getHours()) + ":" + pad(now.getMinutes()) + ":00");
	// show the popup form
	openPopupForm("importForm");
}

function importCalendar() {
	// run backend code to get the user's calendar and add events to the database
	// cannot use a normal GET/POST request here since the calendar_functions.php needs to redirect
	// to Google's authorization page without any origin/cross-domain errors
	window.location = "calendar_functions.php?startDateTime=" + $("#importForm .startDateTime").val() + "&endDateTime=" + $("#importForm .endDateTime").val();	
}

// function to pad a field of a time or date (such as month, day, hour, etc.) with a zero
// if two digits are necessary
function pad(number) {
	var numberString = "0" + number;
	return numberString.substr(numberString.length-2)
}

// validate the form to ensure the inputted data is correct
function validateForm(event, formID) {
	// get the start and end times
	var start = new Date($("#" + formID + " .startDateTime").val());
	var end = new Date($("#" + formID + " .endDateTime").val());
	// ensure the start date/time is less than the end date/time
	if (start > end) {
		$("#" + formID + " .error").html("Start time cannot be greater than end time!");
		event.preventDefault();
		return false;
	// ensure they are not equal
	} else if (start == end) {
		$("#" + formID + " .error").html("Start time cannot be the same as the end time!");
		event.preventDefault();
		return false;
	} else {
		$("#" + formID).hide();
		return true;
	}
}

function addEvent(year, month, day, hour) {
	// initialize the start value to the start time of the timeblock that was clicked
	$("#addEventForm .startDateTime").val(year + "-" + pad(month) + "-" + pad(day+todayDay) + "T" + pad(hour) + ":00:00");
	// add an hour using the Date object to ensure it gets changed to the correct date/time
	var newDate = new Date();
	newDate.setDate(newDate.getDate()+day); // var day is the day offset, so setDate() will automatically change the month and year if needed
	newDate.setHours(hour+1);	
	// initialize the end value to the end time of the timeblock that was clicked
	$("#addEventForm .endDateTime").val(newDate.getFullYear() + "-" + pad(newDate.getMonth()+1) + "-" + pad(newDate.getDate()) + "T" + pad(newDate.getHours()) + ":00:00");
	// show the popup form
	openPopupForm("addEventForm");
}

function removeEvent(year, month, day, hour) {
	// ensure the user really wants to remove this event
	if (confirm("Are you sure you want to remove '" + $("#schedule tr.hour_" + hour + " .day_" + day).text().slice(0,-1) + "' from your calendar?")) {
		// send the data to remove_event.php to remove the event
		$.post("remove_event.php", {year:year, month:month, day:todayDay+day, hour:hour}, function() {
			// reload the page so the calendar & Upcoming Events list gets updated
			location.reload();
		});		
	}
}

function openPopupForm(formID) {
	// fade the background and show the form in the center
	$("#" + formID).css("top", ( $(window).height() - $("#" + formID).height() ) / 2+$(window).scrollTop() + "px");
	$("#" + formID).css("left", ( $(window).width() - $("#" + formID).width() ) / 2+$(window).scrollLeft() + "px");
	$("#background").fadeIn(100);
	$("#" + formID).fadeIn(100);
}

function closePopupForm(formID) {
	// only close it if its currently open
	if ($("#" + formID).css("display") != "none") {
		$("#background").fadeOut(100);
		$("#" + formID).fadeOut(100);
	}
}

function updateFormLocation(formID) {
	// only adjust the values if the form can be seen
	if ($("#" + formID).css("display") != "none") {
		$("#" + formID).css("top", ( $(window).height() - $("#" + formID).height() ) / 2+$(window).scrollTop() + "px");
		$("#" + formID).css("left", ( $(window).width() - $("#" + formID).width() ) / 2+$(window).scrollLeft() + "px");
	}
}

// this function is called when one of the buttons next to the week label is clicked
function changeWeek(numberOfWeeks) {	
	// create a variable to store the change for the offset
	var changeInOffset = numberOfWeeks * 7;
	// update the overall change in days
	changeInDays += changeInOffset;
	// go through the table
	for (var hour = 0; hour < 24; hour++) {
		for (var day = 0-offset; day < 7-offset; day++) {
			// replace the old class names with the new ones
			$(".hour_" + hour + " .day_" + day).toggleClass("day_" + day + " day_" + (day+changeInOffset));
		}
	}
	// create Date object to get the new date
	var newDate = new Date();
	newDate.setDate(newDate.getDate()+changeInDays);
	// update the date label
	$("#weekLabel").html("Week of: " + monthNames[newDate.getMonth()] + " " + newDate.getDate() + ", " + newDate.getFullYear());
	// update the offset
	offset -= changeInOffset;
	// update calendar with the correct events for the new week
	updateSchedule();
}