var toggled = true;
var toggled2 = false;

function toggle() {
	toggled=!toggled;

	if(toggled){
		toggled2 = false;
		$("#side *").hide();
		$("#side").css("width","0%");
		$("#main").css("width","100%");
	}
	else {
		$("#side *").show();
		$("#class_menu").hide();
		$("#side").css("width","25%");
		$("#main").css("width","75%");

	}
}

function show_class_menu() {
	toggled2 = !toggled2;
	if(toggled2)
		$("#class_menu").show();
	else 
		$("#class_menu").hide();
}



if(toggled){
	$("#side *").hide();

	$("#side").css("width","0%");
	$("#main").css("width","100%");



}
else {
	$("#side").show();
	$("#side").css("width","25%");
	$("#main").css("width","75%");

}