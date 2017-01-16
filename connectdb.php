<?php

    //for local:
	$conn = mysqli_connect("localhost", "root", "", "registration");

	if(mysqli_connect_errno())
	{
		echo "Error occurred while connecting with database ".mysqli_connect_errno();
	}
	
	session_start();
?>