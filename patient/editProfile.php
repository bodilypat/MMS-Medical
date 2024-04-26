<?php
	session_start();
	include('../define/config.php');
	include('../define/checklogin.php');
	check_login();
	
		if(isset($_POST['submit']))
		{
				$fullName=$_POST['fullname'];
				$userAdd=$_POST['address'];
				$userCity=$_POST['city'];
				$userGen=$_POST['gender'];

				$editUser=mysqli_query($deal,"UPDATE users 
				                         SET fullName='$fullName',address='$userAdd',city='$userCity',gender='$userGen' 
				                         WHERE id='".$_SESSION['id']."'");				
				if($editUser)
				{
					$msg="Your Profile updated Successfully";
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
					<!-- sector: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">User | Edit Profile</h1></div>
							<ol class="breadcrumb">
								<li><span>User</span></li>
								<li class="active"><span>Edit Profile</span></li>
							</ol>
						</div>
					</section>
					<!-- section: CONTENT  -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
							<h5 style="color: green; font-size:18px; "><?php if($msg) { echo htmlentities($msg);}?></h5>
							<div class="row margin-top-30">
								<div class="col-lg-8 col-md-12">
									<div class="panel panel-white">
										<div class="panel-heading"><h5 class="panel-title">Edit Profile</h5></div>
											<div class="panel-body">
												<?php 																						
													$qUser=mysqli_query($deal,"SELECT * FROM users WHERE id='".$_SESSION['id']."'");
													while($resultset=mysqli_fetch_array($qUser))
													{
												?>
													<h4><?php echo htmlentities($resultset['fullName']);?>'s Profile</h4>
													<p><b>Profile Reg. Date: </b>
													    <?php echo htmlentities($resultset['regDate']);?>
													</p>
														<?php if($resultset['updationDate']){?>
													<p><b>Profile Last Updation Date: </b>
														<?php echo htmlentities($resultset['updationDate']);?>
													</p>
													<?php } ?>													
													<form name="edit" role="form"  method="post">															
														<div class="form-group">
															<label for="FullName">User Name</label>
															<input name="fullname" type="text"  class="form-control" 
															       value="<?php echo htmlentities($resultset['fullName']);?>" >
														</div>																		
														<div class="form-group">
															<label for="Address">Address</label>
															<textarea name="address" class="form-control">
																<?php echo htmlentities($resultset['address']);?>
															</textarea>
														</div>															
														<div class="form-group">
															<label for="City">City</label>
															<input name="city" type="text"  class="form-control" required="required"  
															       value="<?php echo htmlentities($data['city']);?>" >
														</div>			
														<div class="form-group">
															<label for="Gender">Gender</label>
																<select name="gender" class="form-control" required="required" >
																	<option value="<?php echo htmlentities($resultset['gender']);?>">
																		<?php echo htmlentities($resultset['gender']);?>
																	</option>
																	<option value="male">Male</option>	
																	<option value="female">Female</option>	
																	<option value="other">Other</option>	
																</select>
																</div>
																<div class="form-group">
																	<label for="UserEmail">User Email</label>
																	<input name="useremail" type="email"  class="form-control"readonly="readonly"  
																		   value="<?php echo htmlentities($resultset['email']);?>">
																	<a href="changeEmail.php">Update your email </a>
																</div>														
															<button name="submit" type="submit"  class="btn btn-o btn-primary">
																 Update
															</button>
														</form>
													<?php } ?>
													<!--end: while loop -->													
											</div>
										</div>
									</div>											
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
								<div class="panel panel-white">										
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
	<!-- JAVASCRIPTS -->
	<script src="../ssign/js/main.js"></script>
	<script src="../assign/js/form-elements.js"></script>
	<script>
		jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
	</script>
	</body>
</html>
