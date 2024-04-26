<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{
	$docid=intval($_GET['did']);// get doctor id
	if(isset($_POST['submit']))
	{
		$docSpecial=$_POST['doctorspecial'];
		$doctorName=$_POST['doctorName'];
		$doctorAdd=$_POST['clinicaddress'];
		$doctorFees=$_POST['doctorFees'];
		$doctorContact=$_POST['doctorContact'];
		$doctorEmail=$_POST['doctorEmail'];

		$editDoc=mysqli_query($deal,"UPDATE doctors 
		                             SET specilized='$docSpecial',
								     	 doctorName='$docName',
									 	 address='$docAdd',
									 	 docFees='$docFees',
									 	 contactno='$docContact',
									 	 docEmail='$docEmail' 
								 WHERE id='$docid'");
		if($editDoc)
		{
			$msg="Doctor Details updated Successfully";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Edit Doctor Details</title>
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
					<div class="wrap-content container" id="container">
						<!-- section: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8"><h1 class="mainTitle">Admin | Edit Doctor Details</h1></div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>Edit Doctor Details</span></li>
								</ol>
							</div>
						</section>
						<!-- section: CONTENT -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<h5 style="color: green; font-size:18px; "><?php if($msg) { echo htmlentities($msg);}?></h5>
									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading"><h5 class="panel-title">Edit Doctor info</h5></div>
												<div class="panel-body">
													<?php $qDoc=mysqli_query($deal,"SELECT * FROM doctors where id='$docid'");
										  				while($resultset=mysqli_fetch_array($qDoc))										 
														{
													?>
													<h4><?php echo htmlentities($resultset['doctorName']);?>'s Profile</h4>
													<p><b>Profile Reg. Date: </b>
														<?php echo htmlentities($resultset['creationDate']);?></p>
														<?php if($resultset['updationDate']){?>
														<p><b>Profile Last Updation Date: </b>
														<?php echo htmlentities($resultset['updationDate']);?>
													</p>
														<?php } ?>
													<hr />
													<form role="form" name="adddoc" method="post" onSubmit="return valid();">
														<div class="form-group">
															<label for="DoctorSpecialization">Doctor Specialization</label>
							                                <select name="doctorspecial" class="form-control" 
															        required="required">
					                                            <option value="<?php echo htmlentities($resultset['specilization']);?>">
					                                            	<?php echo htmlentities($resultset['specilization']);?>
																</option>
																<?php $qDS=mysqli_query($deal,"SELECT * FROM doctorSpecilized");
																	  while($result=mysqli_fetch_array($qDS))
                                                                     {
																?>
																<option value="<?php echo htmlentities($result['specilization']);?>">
																	<?php echo htmlentities($result['specilization']);?>
																</option>
																	<?php } ?>																
															</select>
														</div>
														<div class="form-group">
															<label for="DoctorName">Doctor Name</label>
	                         								<input name="doctorname" type="text"  class="form-control" 
							 									   value="<?php echo htmlentities($resultset['doctorName']);?>" >
														</div>
														<div class="form-group">
															<label for="Address">Doctor Clinic Address</label>
					                                        <textarea name="clinicaddress" class="form-control">
																<?php echo htmlentities($resultset['address']);?>
															</textarea>
														</div>
														<div class="form-group">
															<label for="ConsultantFees">Doctor Consultancy Fees</label>
															<input name="doctorfees" type="text" class="form-control" required="required" 
															       value="<?php echo htmlentities($resultset['docFees']);?>" >
														</div>	
														<div class="form-group">
															<label for="fess">Doctor Contact no</label>
															<input name="contactno" type="text"  class="form-control" required="required"  
																   value="<?php echo htmlentities($resultset['contactno']);?>">
														</div>
														<div class="form-group">
															<label for="fess">Doctor Email</label>
															<input name="email" type="email"  class="form-control"  readonly="readonly"  
																   value="<?php echo htmlentities($infodoc['docEmail']);?>">
														</div>														
													<?php } ?>																											
														<button name="submit" type="submit"  class="btn btn-o btn-primary">
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
		</div>
	</div>
	<!-- FOOTER -->
	<?php include('../define/footer.php');?>
	<?php include('../define/setting.php');?>
	<script src="assets/js/main.js"></script>
	<!-- JAVASCRIPT -->
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
