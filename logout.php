<?php

	include("connectdb.php");
	session_destroy();
	setcookie("email", '', time()-3600); //3600 is in seconds. browsers use seconds

	header("location: login.php");

?>