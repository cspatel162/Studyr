if ($(document).ready()) {
	function settime(hour,day){
		var date = new Date();
		date.setDate(date.getDate()+day);
		date.setHours(hour);
		date.setMinutes(0);
		date.setSeconds(0);
		var day = ("0" + date.getDate()).slice(-2);
		var month = ("0" + (date.getMonth() + 1)).slice(-2);
		var stringdate = date.getFullYear()+"-"+(month)+"-"+(day);
		//alert(stringdate);	
		$('input[name=startDate]').val(stringdate);
		var minutes = ("0" + date.getMinutes()).slice(-2);
		var hours = ("0" + (date.getHours())).slice(-2);
		var stringtime = (hours)+":"+(minutes);
		//alert(stringtime);
		$('input[name=startTime]').val(stringtime);
	};
}