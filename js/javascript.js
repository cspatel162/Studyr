$(document).ready(function () { 
	$(".show-repeat-info").hide();
	$('input[name$="repeating"]').click(function(){
		if($(this).val() == 1){
		 	$(".show-repeat-info").show();
		 }
		 else{
		 	$(".show-repeat-info").hide();
		 }
	});
});