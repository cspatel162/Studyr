if ($(document).ready()) {
	function settime(hour,day){
		var date = new Date();
		date.setDate(date.getDate()+day);
		date.setHours(hour);
		date.setMinutes(0);
		date.setSeconds(0);
		var stringdate = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
		alert(stringdate);	
		$('input[name=startDate]').val(stringdate);
	};
}