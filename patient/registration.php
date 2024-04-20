<?php
include_once('include/config.php');
if(isset($_POST['submit']))
{
	$userName=$_POST['fullname'];
	$userAdd=$_POST['address'];
	$userCity=$_POST['city'];
	$userGen=$_POST['gender'];
	$userEmail=$_POST['email'];
	$userPass=md5($_POST['password']);
	$qUser=mysqli_query($deal,"INSERT INTO users(fullname,address,city,gender,email,password) 
	                           VALUES('$userName','$userAdd','$userCity','$userGen','$userEmail','$userPass')");
	if($qUser)
	{
		echo "<script>alert('Successfully Registered. You can login now');</script>";
	}
}
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User Registration</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assign/css/styles.css">
		<link rel="stylesheet" href="assign/css/plugins.css">
		<link rel="stylesheet" href="assign/css/themes/theme-1.css" id="skin_color" />
		<script type="text/javascript">
			function valid()
			{
				if(document.registration.password.value!= document.registration.password_again.value)
				{
					alert("Password and Confirm Password Field do not match  !!");
					document.registration.password_again.focus();
					return false;
				}
				return true;
			}
		</script>
	</head>
<body class="login">
		<!-- REGISTRATION -->
	<div class="row">
		<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="logo margin-top-30"><a href="../index.php"><h2>MMS | Patient Registration</h2></a></div>
				<!-- start: REGISTER BOX -->
				<div class="box-register">
					<form id="registration" name="registration" method="post" onSubmit="return valid();">
						<fieldset>
							<legend>Sign Up</legend>
							<p>Enter your personal details below:</p>
							<div class="form-group">
								<input name="fullname" type="text" class="form-control"  placeholder="Full Name" required>
							</div>
							<div class="form-group">
								<input name="address" type="text" class="form-control"  placeholder="Address" required>
							</div>
							<div class="form-group">
								<input name="city" type="text" class="form-control"  placeholder="City" required>
							</div>
							<div class="form-group">
								<label class="block">Gender</label>
								<div class="clip-radio radio-primary">
									<input id="female" name="gender" type="radio"  value="female" >
									<label for="Female">Female</label>
									<input id="male" name="gender" type="radio"  value="male">
									<label for="Male">Male</label>
								</div>
							</div>
							<p>Enter your account details below:</p>
							<div class="form-group">
								<span class="input-icon">
									<input id="email" name="email" type="email" class="form-control"   onBlur="userAvailability()"  placeholder="Email" required>
									<i class="fa fa-envelope"></i> 
								</span>
								<span id="user-availability-status" style="font-size:12px;"></span>
							</div>
							<div class="form-group">
								<span class="input-icon">
									<input id="password" name="password" type="password" class="form-control"  placeholder="Password" required>
									<i class="fa fa-lock"></i> 
								</span>
							</div>
							<div class="form-group">
								<span class="input-icon">
									<input id="confirmpassword" name="confirmpassword" type="password" class="form-control"   placeholder="Password Again" required>
									<i class="fa fa-lock"></i> 
								</span>
							</div>

							<div class="form-group">
								<div class="checkbox clip-check check-primary">
									<input id="agree" type="checkbox"  value="agree" checked="true" readonly=" true">
									<label for="agree">I agree</label>
								</div>
							</div>

							<div class="form-actions">
								<p>Already have an account?<a href="userLogin.php">Log-in</a></p>
								<button id="submit" name="submit" type="submit" class="btn btn-primary pull-right" >
									    Submit <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
						</fieldset>
					</form>
					<div class="">
						&copy; <span class="current-year"></span>
						<span class="text-bold text-uppercase"> MMS</span>. 
						<span>All rights reserved</span>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<script src="assign/js/main.js"></script>
	<script src="assign/js/login.js"></script>
	<script>
		jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
	</script>
	<script>
		function userAvailability() 
		{
			$("#loaderIcon").show();
			jQuery.ajax({
			url: "checkAvailability.php",
			data:'email='+$("#email").val(),
			type: "POST",
			success:function(data){
				$("#user-availability-status").html(data);
				$("#loaderIcon").hide();
			},
				error:function (){}
			});
		}
	</script>	
</body>
</html>