	<?php
	session_start();
	error_reporting(0);
	include("../define/config.php");
	//Checking Details for reset password
	if(isset($_POST['submit']))
	{
		$userName=$_POST['fullname'];
		$userEmail=$_POST['email'];
		$qUser=mysqli_query($deal,"SELECT id FROM  users WHERE fullName='$userName' and email='$userEmail'");
		$num=mysqli_num_rows($qUser);

		if($num>0){

			$_SESSION['name']=$userName;
			$_SESSION['email']=$userEmail;
			header('location:resetPassword.php');
			} else {
				echo "<script>alert('Invalid details. Please try with valid details');</script>";
				echo "<script>window.location.href ='forgotPassword.php'</script>";
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Pateint  Password Recovery</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
<body class="login">
	<div class="row">
		<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="logo margin-top-30"><a href="../index.php"><h2> HMS | Patient Password Recovery</h2></a></div>
				<div class="box-login">
					<form class="form-login" method="post">
						<fieldset>
							<legend>Patient Password Recovery</legend>
							<p>Please enter your Email and password to recover your password.<br /></p>
							<div class="form-group form-actions">
								<span class="input-icon">
									<input name="fullname" type="text" class="form-control"  placeholder="Registred Full Name">
									<i class="fa fa-lock"></i>
								</span>
							</div>
							<div class="form-group">
								<span class="input-icon">
									<input name="email" type="email" class="form-control"  placeholder="Registred Email">
									<i class="fa fa-user"></i> 
								</span>
							</div>
							<div class="form-actions">								
								<button name="submit" type="submit" class="btn btn-primary pull-right" >
									Reset <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
							<div class="new-account">Already have an account? 
								<a href="userLogin.php">Log-in</a>
							</div>
						</fieldset>
					</form>
					<div class="">
						&copy; <span class="text-bold text-uppercase">Medical Management System</span>
					</div>
				</div>
			</div>
		</div>
		<!-- JAVASCRIPT -->
		<script src="assets/js/main.js"></script>
		<script src="assets/js/login.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>	
	</body>
</html>