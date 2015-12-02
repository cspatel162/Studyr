<?php
// unsets the cookies and forces the user back to the main page.
	setcookie("username"," ",time()-3600,'/');
  setcookie("fname"," ",time()-3600,'/');
  setcookie("lname"," ",time()-3600,'/');
  setcookie("userID"," ",time()-3600,'/');
  header("Location:../index.php");
