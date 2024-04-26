	<?php
	session_start();
	error_reporting(0);
	include("../define/config.php");
	if(isset($_POST['submit']))
	{
		$userName=$_POST['username'];	
		$userPass=md5($_POST['password']);
		$qUser=mysqli_query($deal,"SELECT * 
		                           FROM users 
								   WHERE email='$userName' AND password='$userPass'");
		$result=mysqli_fetch_array($qUser);
		if($result > 0)
		{
			$_SESSION['login']=$_POST['username'];
			$_SESSION['id']=$result['id'];
			$patid=$result['id'];
			$host=$_SERVER['HTTP_HOST'];
			$userip=$_SERVER['REMOTE_ADDR'];
			$status=1;

			/* For stroing log if user login successfull*/
			$addUL=mysqli_query($deal,"INSERT INTO userlog(uid,username,userip,status) 
			                         VALUES('$patid','$userName','$userip','$status')");
			header("location:dashboard.php");
		}
		else
		{
			/* For stroing log if user login unsuccessfull  */
			$_SESSION['login']=$_POST['username'];	
			$userip=$_SERVER['REMOTE_ADDR'];
			$status=0;
			mysqli_query($deal,"INSERT INTO userlog(username,userip,status) 
			                    VALUES('$userName','$userip','$status')");
			$_SESSION['errmsg']="Invalid username or password";
			header("location:userLogin.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User-Login</title>
		<!-- CSS -->
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
	</head>
<body class="login">
	<div class="row">
		<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="logo margin-top-30"><a href="../index.php"><h2> Medical | Patient Login</h2></a></div>
				<div class="box-login">
					<form class="form-login" method="post">
						<fieldset>
							<legend>Sign in to your account</legend>
							<p>
								Please enter your name and password to log in.<br />
								<span style="color:red;">
								      <?php echo $_SESSION['errmsg']; ?>
									  <?php echo $_SESSION['errmsg']="";?>
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
								<a href="forgotPassword.php">Forgot Password ?</a>
							</div>
							<div class="form-actions">								
								<button name="submit" type="submit" class="btn btn-primary pull-right" >
									Login <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
							<div class="new-account">Don't have an account yet?
								<a href="registration.php">Create an account</a>
							</div>							
						</fieldset>
					</form>
					<div class="copyright">
						  <span class="text-bold text-uppercase">Medical Management System</span>.
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="../assign/js/main.js"></script>
	<script src="../assign/js/login.js"></script>
	<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
	</script>
	</body>
</html>