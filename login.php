<?php
	
	include("connectdb.php");
	include("functions.php");

	if(logged_in())
	{
		header("location: profile.php");
		exit();
	}

	$error = "";	
	
	if(isset($_POST['submit']))
	{
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$checkbox = isset($_POST['keep']);

		if(email_exists($email, $conn))
		{
			$result = mysqli_query($conn, "SELECT password FROM users WHERE email='$email'");
			$retrievePassword = mysqli_fetch_assoc($result);

			if(!password_verify($password, $retrievePassword['password']))
			{
				$error = "Password does not match";
			}
			else 
			{
				$_SESSION['email'] = $email;
				
				if($checkbox == "on")
				{
					setcookie("email", $email, time()+3600);
				}

				header("location: profile.php");
			}
			
		}
		else
		{
			$error = "Email does not exist.";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
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
			<form method="POST" action="login.php">
				<input type="text" name="email" placeholder="Email Address" class="inputFields" required/><br /><br />
				<input type="password" name="password" placeholder="Password" class="inputFields" required/><br /><br />
				<input type="checkbox" name="keep" class="checkbox" /><label class="checkbox">Keep me logged in</label><br /><br />
				<input type="submit" name="submit" value="Login" class="buttons"><br />
			</form>
		</div>
	</div>
</body>
</html>