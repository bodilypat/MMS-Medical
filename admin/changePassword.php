<?php
	session_start();
	//error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{

		date_default_timezone_set('America/Los_Angeles');// change according timezone
		$currentTime = date( 'd-m-Y h:i:s A', time () );

		if(isset($_POST['submit']))
		{
			$currentPass=$_POST['cpass'];	
			$userName=$_SESSION['login'];
			$qAd=mysqli_query($deal,"SELECT password FROM  admin WHERE password='$currentPass' && username='$userName'");
			$result=mysqli_fetch_array($qAd);
			if($result > 0)
			{
				$npass=$_POST['nPass'];
			    $editAd=mysqli_query($deal,"UPDATE admin SET password='$npass', updationDate='$currentTime' where username='$userName'");
			    $_SESSION['msg1']="Password Changed Successfully !!";
			}
			else
			{
				$_SESSION['msg1']="Old Password not match !!";
			}
		}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | change Password</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		<script type="text/javascript">
		function valid()
		{
			if(document.changpwd.cpass.value=="")
			{
				alert("Current Password Filed is Empty !!");
				document.changpwd.cpass.focus();
				return false;
			}
			else if(document.changpwd.npass.value=="")
			{
				alert("New Password Filed is Empty !!");
				document.changpwd.npass.focus();
				return false;
			}
			else if(document.changpwd.cfpass.value=="")
			{
				alert("Confirm Password Filed is Empty !!");
				document.changpwd.cfpass.focus();
				return false;
			}
			else if(document.changpwd.npass.value!= document.changpwd.cfpass.value)
			{
				alert("Password and Confirm Password Field do not match  !!");
				document.changpwd.cfpass.focus();
				return false;
			}
			return true;
		}
	</script>
	</head>
<body>
	<div id="application">		
		<?php include('include/sidebar.php');?>
		<div class="application-content">				
			<?php include('include/header.php');?>
			</header>			
			<div class="main-content" >
				<div class="wrap-content container" id="container">
					<!-- section: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Admin | Change Password</h1></div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>Change Password</span></li>
								</ol>
						</div>
					</section>					
					<!-- section:CONTENT -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">									
								<div class="row margin-top-30">
									<div class="col-lg-8 col-md-12">
										<div class="panel panel-white">
											<div class="panel-heading"><h5 class="panel-title">Change Password</h5></div>
											<div class="panel-body">
												<p style="color:red;">
													<?php echo htmlentities($_SESSION['msg1']);?>
													<?php echo htmlentities($_SESSION['msg1']="");?>
												</p>	
												<form name="changpwd" role="form"  method="post" onSubmit="return valid();">
													<div class="form-group">
														<label for="CurrentPassword">Current Password</label>
														<input name="cpass" type="password"  class="form-control"  
														       placeholder="Enter Current Password">
													</div>
													<div class="form-group">
														<label for="New Password">New Password</label>
					                                    <input name="npass" type="password"  class="form-control"  
														       placeholder="New Password">
													</div>														
													<div class="form-group">
														<label for="ConfirmPassword">Confirm Password</label>
														<input name="cfpass" type="password"  class="form-control"  
														       placeholder="Confirm Password">
													</div>	
													<button type="submit" name="submit" class="btn btn-o btn-primary">
														Submit
													</button>
												</form>
											</div>
										</div>
									</div>											
								</div>
							</div>
						<div class="col-lg-12 col-md-12">
							<div class="panel panel-white"></div>
						</div>
	                </div>
				</div>
			</div>
		</div>						
	</div>	
		<!--  FOOTER -->
	<?php include('include/footer.php');?>
	<?php include('include/setting.php');?>
	<!-- JAVASCRIPT -->
	<script src="assets/js/main.js"></script>
	<script src="assets/js/form-elements.js"></script>
	<script>
		jQuery(document).ready(function() {
			Main.init();
			FormElements.init();
			});
	</script>
</body>
</html>
<?php } ?>
