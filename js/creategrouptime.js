if ($(document).ready()) {
	function settime(hour,day){
		var date = new Date();
		date.setDate(date.getDate()+day);
		date.setHours(hour);
		date.setMinutes(0);
		date.setSeconds(0);
		alert(date);
		$('startDate').
	};
}