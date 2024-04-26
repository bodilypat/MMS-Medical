<?php
	session_start();
	error_reporting(0);
	include("../define/config.php");
	if(isset($_POST['submit']))
	{
		$userName=$_POST['username'];
		$userPass=$_POST['password'];

		$qAd=mysqli_query($deal,"SELECT * FROM admin WHERE username='$userName' and password='$userPass'");
		$result=mysqli_fetch_array($qAd);
		if($result > 0)
		{
			$_SESSION['login']=$_POST['username'];
			$_SESSION['id']=$result['id'];
			header("location:dashboard.php");
		}
		else
		{
			$_SESSION['errmsg']="Invalid username or password";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin-Login</title>
		<meta charset="utf-8" />
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
<body class="login">
	<div class="row">
		<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="logo margin-top-30"><h2>Admin Login</h2></div>
				<div class="box-login">
					<form class="form-login" method="post">
						<fieldset>
							<legend>Sign in to your account</legend>
							<p>Please enter your name and password to log in.<br />
								<span style="color:red;">
									<?php echo htmlentities($_SESSION['errmsg']); ?>
									<?php echo htmlentities($_SESSION['errmsg']="");?>
							    </span>
							</p>
							<div class="form-group">
								<span class="input-icon">
									<input name="username" type="text" class="form-control"  placeholder="Username">
									<i class="fa fa-user"></i> 
								</span>
							</div>
							<div class="form-group form-actions">
								<span class="input-icon">
									<input name="password" type="password" class="form-control password"  placeholder="Password">
									<i class="fa fa-lock"></i>
								</span>
							</div>
							<div class="form-actions">								
								<button name="submit" type="submit" class="btn btn-primary pull-right" >
									Login <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
							<a href="../index.php">Bacto Home Page</a>							
						</fieldset>
					</form>
					<div class="copyright">
						<span class="text-bold text-uppercase">Medical Management System</span>
					</div>			
				</div>
			</div>
		</div>
		<!-- javascript  -->	
		<script src="design/js/main.js"></script>
		<script src="design/js/login.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
	
	</body>
	<!-- end: BODY -->
</html>