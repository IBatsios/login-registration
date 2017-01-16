<?php
	
	include("connectdb.php");
	include("functions.php");

	$error = "";

	if(logged_in())
	{
		$error = "<div class=\"good\">You are logged in</div>";
	}
	else
	{
		header("location: login.php");
		exit();
	}

	$sql = 'SELECT image FROM users WHERE id ='31'';

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
		<div class="content">
			<div class="image">
				<img src="<?php echo $sql; ?>" alt="profile picture">
			</div>
			<a href="changepassword.php">Change Password</a>
		</div>
	</div>
</body>
</html>