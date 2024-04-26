	<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	include('../define/checklogin.php');
		check_login();
		if(isset($_POST['submit']))
		{
			$userEmail=$_POST['useremail'];
			$qUser=mysqli_query($deal,"UPDATE users SET email='$userEmail' WHERE id='".$_SESSION['id']."'");
			if($qUser)
			{
				$msg="Your email updated Successfully";
			}
		}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User | Edit Profile</title>
		<!-- CSS -->
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />

</head>
<body>
	<div id="application">		
		<?php include('../define/sidebar.php');?>
		<div class="application-content">				
			<?php include('../define/header.php');?>						
			<div class="main-content" >
				<div id="container" class="wrap-content container" >
					<!-- section : PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">User | Edit Profile</h1></div>
							<ol class="breadcrumb">
								<li><span>User </span></li>
								<li class="active"><span>Edit Profile</span></li>
							</ol>
						</div>
					</section>
					<!-- section : CONTENT -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<h5 style="color: green; font-size:18px; ">
									<?php if($msg) { echo htmlentities($msg);}?> 
								</h5>
								<div class="row margin-top-30">
									<div class="col-lg-8 col-md-12">
										<div class="panel panel-white">
											<div class="panel-heading"><h5 class="panel-title">Edit Profile</h5></div>
											<div class="panel-body">
												<form name="registration" id="updatemail"  method="post">
													<div class="form-group">
														<label for="UserEmail">User Email</label>
														<input name="useremail" id="useremail" type="email" class="form-control"  
															   onBlur="userAvailability()"  placeholder="Email" required>
									 					<span id="user-availability-status" style="font-size:12px;"></span>
													</div>					
													<button id="submit" name="submit"  type="submit" class="btn btn-o btn-primary">
															Update
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
	<?php include('../define/footer.php');?>		
	<?php include('../define/setting.php');?>
	<!-- javascript -->
	<script src="../assign/js/main.js"></script>
	<script src="../assign/js/form-elements.js"></script>
	<script>
		jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
	</script>
	<script>
		function userAvailability() {
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
