<?php

require 'config/config.php';
require 'includes/form_handlers/login_handler.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Health-Connect</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css" />
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
	<script src="assets/js/register.js"></script>
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	 <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter&family=Lato&family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
	<?php 

	if (isset($_POST['register_button'])) {
		echo '
    	<script>
		$(document).ready(function() {
			$("#first").hide();
			$("#second").show();
		});
		</script>
		';
	}
	?>
<section class="navbar-login">
	<img src="assets/images/logos/Health-Connect-Logo-white.png">
</section>

<section class="login-page-form" style="background-image: url('assets/images/backgrounds/blob-background-new.png');">
	<div class="wrapper container">
		<div class="login_box">
			<div class="login_header">
				<h1>Collaborate</h1>
				<p>Login or sign up below!</p>
			</div>
			<div id="first">
				<div class="row">
					<div class="col-lg-6">
						<form action="" method="POST">
							<input type="email" name="log_email" placeholder="Email Address" value="<?php if (isset($_SESSION['log_email'])) echo $_SESSION['log_email']; ?>" required>
    						<br />

							<input type="password" name="log_password" placeholder="Password">

							<br />

							<button type="submit" name="login_button">Login</button>

							<br />

							<?php if (in_array("Email or password was incorrect<br />", $error_array)) echo "Email or password was incorrect<br />"; ?>		

							<a href="register.php" id="signup" class="signup">Need an account? <span>Register here!</span></a>

						</form>

					</div>

					<div class="col-lg-6">

						<div class="login-page-image">

							<img src="https://health-connect.sagraphicswebproofs.co.uk/wp-content/uploads/2021/11/Gif-38.gif">

						</div>

					</div>

				</div>

				

				<br />

			</div>



			<div id="second">

				<form action="register.php" method="POST">

					<input type="text" name="reg_fname" placeholder="First Name" value="<?php if (isset($_SESSION['reg_fname'])) echo $_SESSION['reg_fname']; ?>" required />

					<br />



					<?php if (in_array("Your first name must be between 2 and 25 characters<br />", $error_array)) echo "Your first name must be between 2 and 25 characters<br />"; ?>	



					<input type="text" name="reg_lname" placeholder="Last Name" value="<?php if (isset($_SESSION['reg_lname'])) echo $_SESSION['reg_lname']; ?>" required />

					<br />



					<?php if (in_array("Your last name must be between 2 and 25 characters<br />", $error_array)) echo "Your last name must be between 2 and 25 characters<br />"; ?>	



					<input type="email" name="reg_email" placeholder="Email" value="<?php if (isset($_SESSION['reg_email'])) echo $_SESSION['reg_email']; ?>" required />

					<br />

					<input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php if (isset($_SESSION['reg_email2'])) echo $_SESSION['reg_email2']; ?>" required />

					<br />



					<?php if (in_array("Email already in use<br />", $error_array)) echo "Email already in use<br />"; 

					else if (in_array("Invalid email format<br />", $error_array)) echo "Invalid email format<br />"; 

					else if (in_array("Emails don't match<br />", $error_array)) echo "Emails don't match<br />"; ?>	





					<input type="password" name="reg_password" placeholder="Password" required />

					<br />

					<input type="password" name="reg_password2" placeholder="Confirm Password" required />

					<br />



					<?php if (in_array("Your passwords do not match<br />", $error_array)) echo "Your passwords do not match<br />";

					else if (in_array("Your password can only contain english characters or numbers<br />", $error_array)) echo "Your password can only contain english characters or numbers<br />"; 

					else if (in_array("Your password must be between 5 and 30 characters<br />", $error_array)) echo "Your password must be between 5 and 30 characters<br />"; ?>



					<button type="submit" name="register_button">Register</button>

					<br />

					<?php if (in_array("<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br />", $error_array)) echo "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br />"; ?>	

					<a href="register.php" id="signin" class="signin">Already have an account? Sign in here!</a>

				</form>		

			</div>

		</div>	

	</div>

</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>



</body>

</html>