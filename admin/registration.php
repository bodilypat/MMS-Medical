<?php
	include_once('include/config.php');
	if(isset($_POST['submit']))
	{
		$fullName=$_POST['fullname'];
		$userAdd=$_POST['address'];
		$userCity=$_POST['city'];
		$userGender=$_POST['gender'];
		$userEmail=$_POST['email'];
		$userPass=md5($_POST['password']);

		$qUser=mysql_query("INSERT INTO users(fullname,address,city,gender,email,password) 
		                    VALUES('$fullName','$userAdd','$userCity','$userGender','$userEmail','$pass')");
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
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
<body class="login">
	<!-- start: REGISTRATION -->
	<div class="row">
		<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="logo margin-top-30"><img src="assets/images/logo.png" alt="Clip-Two"/></div>
				<!-- start: REGISTER BOX -->
				<div class="box-register">
					<form name="registration" id="registration"  method="post">
						<fieldset>
							<legend>Sign Up</legend>
							<p>
								Enter your personal details below:
							</p>
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
									<input type="radio" id="rg-female" name="gender" value="female" >
									<label for="rg-female">Female</label>
									<input type="radio" id="rg-male" name="gender" value="male">
									<label for="rg-male">Male</label>
								</div>
							</div>
							<p>Enter your account details below:</p>
							<div class="form-group">
								<span class="input-icon">
									<input id="email" name="email" type="email" class="form-control"   
									       onBlur="userAvailability()"  placeholder="Email" required>
										  <i class="fa fa-envelope"></i>
								</span>
								<span id="user-availability-status" style="font-size:12px;"></span>
							</div>
							<div class="form-group">
								<span class="input-icon">
									<input id="password" name="password" type="password" class="form-control"   
									       placeholder="Password" required>
									<i class="fa fa-lock"></i> 
								</span>
							</div>
							<div class="form-group">
								<span class="input-icon">
									<input id="cfpassword" name="cfpassword" type="password" class="form-control"  
									       placeholder="Confirm Password" required>
									<i class="fa fa-lock"></i> 
								</span>
							</div>
							<div class="form-group">
								<div class="checkbox clip-check check-primary">
									<input id="agree" type="checkbox"  value="agree">
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
						       <span class="text-bold text-uppercase">MMS</span>. 
							   <span>All rights reserved</span>
					</div>
				</div>
			</div>
		</div>
		<!-- javascript -->
		<script src="assets/js/main.js"></script>
		<script src="assets/js/login.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
	<script>
		function userAvailability() {
			$("#loaderIcon").show();
			jQuery.ajax({
			url: "check_availability.php",
			data:'email='+$("#email").val(),
			type: "POST",
			success:function(data){
				$("#user-availability-status1").html(data);
				$("#loaderIcon").hide();
				},
				error:function (){}
			});
		}
	</script>		
</body>
</html>