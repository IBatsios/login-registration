<?php

	function email_exists($email, $conn){
		$result = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");


		if(mysqli_num_rows($result) == 1)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	function logged_in()
	{
		if(isset($_SESSION['email']) || isset($_COOKIE['email']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	$timestamp = date("YmdHis");

?>