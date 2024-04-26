<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{
		date_default_timezone_set('America/Los_Angeles');// change according timezone
		$currentTime = date( 'd-m-Y h:i:s A', time () );
		if(isset($_POST['submit']))
		{
			$cpass=md5($_POST['cpass']);
			$did=$_SESSION['id'];
			$qDoc=mysqli_query($deal,"SELECT password FROM  doctors WHERE password='$cpass' && id='$did'");
			$result=mysqli_fetch_array($qDoc);
			if($sesult > 0)
			{
				$npass=md5($_POST['npass']);
				$editDoc=mysqli_query($deal,"UPDATE doctors SET password='$npass', updationDate='$currentTime' WHERE id='$did'");
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
		<title>Doctor  | change Password</title>
		<!-- CSS -->		
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
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
	<div id="app">		
		<?php include('../define/sidebar.php');?>
		<div class="app-content">				
			<?php include('../define/header.php');?>										
			<div class="main-content" >
				<div class="wrap-content container" id="container">
					<!-- section : PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Doctor | Change Password</h1></div>
							<ol class="breadcrumb">
								<li><span>Doctor</span></li>
								<li class="active"><span>Change Password</span></li>
							</ol>
						</div>
					</section>					
					<!-- section: CONTENT -->
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
															<input name="cpass" type="password"  class="form-control"  placeholder="Enter Current Password">
														</div>
														<div class="form-group">
															<label for="NewPassword">New Password</label>
															<input name="npass" type="password"  class="form-control"  placeholder="New Password">
														</div>														
														<div class="form-group">
																<label for="ConfirmPassword">Confirm Password</label>
																<input name="cfpass" type="password"  class="form-control"  placeholder="Confirm Password">
														</div>																																										
														<button name="submit" type="submit"  class="btn btn-o btn-primary">
															Submit
														</button>
													</form>
												</div>
											</div>
										</div>											
									</div>
								</div>									
							</div>
						</div>						
					</div>
				</div>
			</div>
		</div>
			<!-- FOOTER -->
	<?php include('../define/footer.php');?>
	<?php include('../define/setting.php');?>
	</div>
	<!-- JAVASCRIPT  -->
	<script src="../assign/js/main.js"></script>	
	<script src="../assign/js/form-elements.js"></script>
	<script>
		jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
	</script>
</body>
</html>
<?php } ?>
