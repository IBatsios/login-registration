<?php

	include("connectdb.php");
	include("functions.php");

	$error = "";
	$return = "";

	if(isset($_POST['savepass']))
	{
		$password = $_POST['password'];
		$passwordconfirm = $_POST['passwordconfirm'];

		if(strlen($password) < 8)
		{
			$error = "Password length must be greater than 8 characters";
		}
		elseif ($password !== $passwordconfirm) 
		{
			$error = "Passwords do not match";
		}
		else
		{
			$password = md5($password);

			$email = $_SESSION['email'];

			if(mysqli_query($conn, "UPDATE users SET password='$password' WHERE email='$email'"))
			{
				$error = "Password successfully changed";
				$return = "<a href=\"profile.php\">Return to Profile page</a>";

			}
		}
	}

	if(logged_in())
	{

	}
	else 
	{
		header("location: login.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile Page</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo $timestamp;?>"/>
</head>
<body>
	<div id="error" style="<?php if($error !="") { ?> display:block;<?php }?>">
		<?php
			echo $error;
		?>	
	</div>
	<div id="wrapper">
		<div id="menu">
			<a href="index.php">Registration</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="profile.php">Profile Page</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="login.php">Login</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="logout.php">Logout</a>
		</div>
		<hr/>
		<div id="formDiv">
			<form method="POST" action="changepassword.php">
				<input type="password" name="password" placeholder="New Password" class="inputFields" required/><br /><br />
				<input type="password" name="passwordconfirm" placeholder="Confirm New Password" class="inputFields" required/><br /><br />
				<input type="submit" name="savepass" value="Save New Password" class="buttons"><br />
			</form>
			<br />
			<?php
				echo $return;
			?>
		</div>
	</div>
</body>
</html>