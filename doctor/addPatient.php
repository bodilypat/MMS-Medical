<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{

		if(isset($_POST['submit']))
		{	
			$docid=$_SESSION['id'];
			$patName=$_POST['patientname'];
			$patContact=$_POST['patientcontact'];
			$patEmail=$_POST['patientemail'];
			$patGen=$_POST['gender'];
			$patAdd=$_POST['patientaddress'];
			$patAge=$_POST['patientage'];
			$medhis=$_POST['medhis'];
			$addPat=mysqli_query($deal,"INSERT INTO tblpatient(Docid,
			                                                   PatientName,
															   PatientContno,
															   PatientEmail,
															   PatientGender,
															   PatientAdd,
															   PatientAge,
															   PatientMedhis) 
			                            VALUES('$docid','$patName','$patContact','$patEmail','$patGen','$patAdd','$patAge','$medhis')");
		if($addPat)
		{
		echo "<script>alert('Patient info added Successfully');</script>";
		header('location:addPatient.php');

		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Doctor | Add Patient</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assign/css/styles.css">
		<link rel="stylesheet" href="assign/css/plugins.css">
		<link rel="stylesheet" href="assign/css/themes/theme-1.css" id="skin_color" />

	<script>
		function userAvailability() {
			$("#loaderIcon").show();
				jQuery.ajax({
				url: "checkAvailability.php",
				data:'email='+$("#patemail").val(),
				type: "POST",
			success:function(data){
				$("#user-availability-status").html(data);
				$("#loaderIcon").hide();
			},
			error:function (){}
			});
		}
	</script>
	</head>
<body>
	<div id="app">		
		<?php include('include/sidebar.php');?>
		<div class="app-content">
			<?php include('include/header.php');?>						
			<div class="main-content" >
				<div class="wrap-content container" id="container">
				<!-- section: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Patient | Add Patient</h1></div>
							<ol class="breadcrumb">
								<li><span>Patient</span></li>
								<li class="active"><span>Add Patient</span></li>
							</ol>
						</div>
					</section>
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<div class="row margin-top-30">
									<div class="col-lg-8 col-md-12">
										<div class="panel panel-white">
											<div class="panel-heading"><h5 class="panel-title">Add Patient</h5></div>
												<div class="panel-body">
													<form role="form" name="" method="post">		
														<div class="form-group">
															<label for="DoctorName">Patient Name</label>
															<input name="patientname" type="text"  class="form-control"  placeholder="Patient Name" required="true">
														</div>
														<div class="form-group">
															<label for="ContactNo">Patient Contact no</label>
															<input name="patientcontact" type="text"  class="form-control"  placeholder="Patient Contact no" required="true" maxlength="10" pattern="[0-9]+">
														</div>
														<div class="form-group">
															<label for="fess">Patient Email</label>
															<input id="patientemail" name="pattientemail" type="email"  class="form-control"  placeholder="Patient Email" required="true" onBlur="userAvailability()">
															<span id="user-availability-status" style="font-size:12px;"></span>
														</div>
															<div class="form-group">
															<label class="block">Gender</label>
																<div class="clip-radio radio-primary">
																	<input id="female" name="gender" type="radio"   value="female" >
																	<label for="Female">Female</label>
																	<input id="Male" name="gender" type="radio"  value="male">
																	<label for="male">Male</label>
																</div>
														</div>
														<div class="form-group">
															<label for="Address">Patient Address</label>
															<textarea name="patientaddress" class="form-control"  placeholder="Patient Address" required="true"></textarea>
														</div>
														<div class="form-group">
															<label for="Age">Patient Age</label>
															<input name="patientage" type="text"  class="form-control"  placeholder="Patient Age" required="true">
														</div>
														<div class="form-group">
															<label for="fess">Medical History</label>
															<textarea name="medhis" type="text"  class="form-control"  placeholder="Patient Medical History(if any)" required="true"></textarea>
														</div>	
														<button name="submit" id="submit" type="submit"  class="btn btn-o btn-primary">
															Add
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
	<!-- javascript -->
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
