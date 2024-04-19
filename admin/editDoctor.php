<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{
	$docid=intval($_GET['did']);// get doctor id
	if(isset($_POST['submit']))
	{
		$docSpecialized=$_POST['Doctorspecial'];
		$doctorName=$_POST['doctorName'];
		$doctorAdd=$_POST['clinicaddress'];
		$doctorFees=$_POST['doctorFees'];
		$doctorContact=$_POST['doctorContact'];
		$doctorEmail=$_POST['doctorEmail'];

		$editDoc=mysqli_query($deal,"UPDATE doctors 
		                         SET specilized='$docSpecialized',
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
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
<body>
	<div id="application">		
		<?php include('include/sidebar.php');?>
		<div class="application-content">				
			<?php include('include/header.php');?>
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
										  				while($infodoc=mysqli_fetch_array($qDoc))										 
														{
													?>
													<h4><?php echo htmlentities($infodoc['doctorName']);?>'s Profile</h4>
													<p><b>Profile Reg. Date: </b>
														<?php echo htmlentities($infodoc['creationDate']);?></p>
														<?php if($infodoc['updationDate']){?>
														<p><b>Profile Last Updation Date: </b>
														<?php echo htmlentities($infodoc['updationDate']);?>
													</p>
														<?php } ?>
													<hr />
													<form role="form" name="adddoc" method="post" onSubmit="return valid();">
														<div class="form-group">
															<label for="DoctorSpecialization">Doctor Specialization</label>
							                                <select name="Doctorspecialization" class="form-control" 
															        required="required">
					                                            <option value="<?php echo htmlentities($infodoc['specilization']);?>">
					                                            	<?php echo htmlentities($infodoc['specilization']);?>
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
															<label for="doctorname">Doctor Name</label>
	                         								<input type="text" name="docname" class="form-control" 
							 									   value="<?php echo htmlentities($infodoc['doctorName']);?>" >
														</div>
														<div class="form-group">
															<label for="address">Doctor Clinic Address</label>
					                                        <textarea name="clinicaddress" class="form-control">
																<?php echo htmlentities($infodoc['address']);?>
															</textarea>
														</div>
														<div class="form-group">
															<label for="fess">Doctor Consultancy Fees</label>
															<input type="text" name="docfees" class="form-control" required="required" 
															       value="<?php echo htmlentities($infodoc['docFees']);?>" >
														</div>	
														<div class="form-group">
															<label for="fess">Doctor Contact no</label>
															<input type="text" name="doccontact" class="form-control" required="required"  
																   value="<?php echo htmlentities($infodoc['contactno']);?>">
														</div>
														<div class="form-group">
															<label for="fess">Doctor Email</label>
															<input type="email" name="docemail" class="form-control"  readonly="readonly"  
																   value="<?php echo htmlentities($infodoc['docEmail']);?>">
														</div>														
													<?php } ?>																											
														<button type="submit" name="submit" class="btn btn-o btn-primary">
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
	<?php include('include/footer.php');?>
	<?php include('include/setting.php');?>
	<script src="assets/js/main.js"></script>
	<!-- JAVASCRIPT -->
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
