<?php
	
	include("connectdb.php");
	include("functions.php");

	$error = "";

	if(logged_in())
	{
		header("location: profile.php");
		exit();
	}

	if(isset($_POST['submit']))
	{
		$firstName = mysqli_real_escape_string($_POST['fname']);
		$lastName = mysqli_real_escape_string($_POST['lname']);
		$email = mysqli_real_escape_string($_POST['email']);
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordconfirm'];

		$image = $_FILES['image']['name'];
		$tmp_image = $_FILES['image']['tmp_name'];
		$imageSize = $_FILES['image']['size'];

		$terms = isset($_POST['terms']);

		if(strlen($firstName) < 1)
		{
			$error = "First name is too short";
		}

		elseif (strlen($lastName) < 1) 
		{
			$error = "Last name is too short";
		}

		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
			$error = "Please enter a valid email address";
		}

		else if(email_exists($email, $conn))
		{
			$error = "Email already registered";
		}

		elseif (strlen($password) < 8)
		{
			$error = "Password must be greater than 7 characters";
		}

		elseif ($password !== $passwordConfirm) 
		{
			$error = "Passwords do not match";
		}

		elseif ($image == '')
		{
			$error = "Please upload your profile image";
		}

		elseif ($imageSize > 1048576) 
		{
			$error = "Image size must not be larger than 1 mb";
		}

		elseif (!$terms) 
		{
			$error = "You must agree with terms and conditions to continue.";
		}

		else 
		{
			$password = password_hash($password, PASSWORD_DEFAULT);

			$imageExt = explode(".", $image);
			$imageExtension = $imageExt[1];

			$date = date("F d, Y");

			if($imageExtension == 'PNG' || $imageExtension == 'png' || $imageExtension == 'JPG' || $imageExtension == 'jpg' || $imageExtension == 'JPEG' || $imageExtension == 'jpeg' || $imageExtension == 'GIF' || $imageExtension == 'gif') {

				$image = rand(0, 10000000).rand(0, 1000000).rand(0, 1000000).time().".".$imageExtension;

				$insertQuery = "INSERT INTO users(firstName, lastName, email, password, image, date) VALUES ('$firstName','$lastName','$email','$password','$image', '$date')";
				if(mysqli_query($conn, $insertQuery))
				{
					if(move_uploaded_file($tmp_image, "images/$image"))
					{
						$error = "You are successfully registered";
					}
					else
					{
						$error = "Image is not uploaded";
					}
				}
			}
			else
			{
				$error = "Image must be an image.";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration Page</title>
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
		<hr />
		<div id="formDiv">
			<form method="POST" action="index.php" enctype="multipart/form-data">
				<input type="text" name="fname" placeholder="First Name" class="inputFields" required/><br /><br />
				<input type="text" name="lname" placeholder="Last Name" class="inputFields" required/><br /><br />
				<input type="text" name="email" placeholder="Email Address" class="inputFields" required/><br /><br />
				<input type="password" name="password" placeholder="Password" class="inputFields" required/><br /><br />
				<input type="password" name="passwordconfirm" placeholder="Confirm Password" class="inputFields" required/><br /><br />
				<div id="imageUpload">
					<div id="para">
						<p>Profile Picture:</p>
					</div>
					<input type="file" name="image">
				</div>
				<input type="checkbox" name="terms" class="checkbox"><label class="checkbox">I agree with terms and conditions</label><br /><br />
				<input type="submit" name="submit" class="buttons" value="Submit"><br />
			</form>
		</div>
	</div>
</body>
</html>