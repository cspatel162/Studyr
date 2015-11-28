<?php
function logout(){
	setcookie("username"," ",time()-3600,'/');
  setcookie("fname"," ",time()-3600,'/');
  setcookie("lname"," ",time()-3600,'/');
  header("Location:splashpage.php");
}
logout();
?>

<html>
<head>
	<title> Logout </title>
</head>
<body>
</body>
</html>