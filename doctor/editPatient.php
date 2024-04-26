<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0))
	{
		header('location:logout.php');
	  } else{

	if(isset($_POST['submit']))
	{	
		$eid=$_GET['editid'];
		$patname=$_POST['patientname'];
		$patcontact=$_POST['patientcontact'];
		$patemail=$_POST['patientemail'];
		$patGen=$_POST['gender'];
		$patAdd=$_POST['patientaddress'];
		$patAge=$_POST['patientage'];
		$medhis=$_POST['medhis'];
		$editPat=mysqli_query($con,"UPDATE patient SET PatientName='$patName',
									               PatientContno='$patContact',
												   PatientEmail='$patEmail',
												   PatientGender='$patGen',
												   PatientAdd='$patAdd',
												   PatientAge='$patAge',
												   PatientMedhis='$medhis' 
											WHERE ID='$eid'");
		if($editPat)
		{
			echo "<script>alert('Patient info updated Successfully');</script>";
			header('location:managePatient.php');
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Doctor | Edit Patient</title>
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
					<!-- section: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Patient | Edit Patient</h1></div>
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
											<div class="panel-heading">
												<h5 class="panel-title">Add Patient</h5>
											</div>
											<div class="panel-body">
												<form name="edit-patient" role="form"  method="post">
													<?php
														$eid=$_GET['editid'];
														$qPat=mysqli_query($deal,"SELECT * FROM patient WHERE ID='$eid'");
														$count=1;
														while ($resultset=mysqli_fetch_array($qPat)) 
														{
													?>
													<div class="form-group">
														<label for="Doctorname">Patient Name</label>
														<input name="patientname" type="text"  class="form-control"  
														       value="<?php  echo $resultset['PatientName'];?>" required="true">
													</div>
													<div class="form-group">
														<label for="PatientContact">Patient Contact no</label>
														<input name="patientcontact" type="text"  class="form-control"  
															   value="<?php  echo $resultset['PatientContno'];?>" 
															   required="true" maxlength="10" pattern="[0-9]+">
													</div>
													<div class="form-group">
														<label for="PatientEmail">Patient Email</label>
														<input id="patientemail" name="patientemail" type="email" class="form-control"  value="<?php  echo $row['PatientEmail'];?>" readonly='true'>
														<span id="email-availability-status"></span>
													</div>
													<div class="form-group">
														<label class="control-label">Gender: </label>
           												   <?php  if($resultset['Gender']=="Female"){ ?>
														<input name="gender" id="gender" type="radio"  value="Female" checked="true">Female
														<input name="gender" id="gender" type="radio"  value="male">Male
            											  <?php } else { ?>
														<label>
															<input name="gender" id="gender" type="radio"  value="Male" checked="true">Male
															<input name="gender" id="gender" type="radio"  value="Female">Female
														</label>
            											 <?php } ?>
													</div>
													<div class="form-group">
														<label for="PatientAddress">Patient Address</label>
														<textarea name="patientaddress" class="form-control" required="true">
															     <?php  echo $resulset['PatientAdd'];?>
														</textarea>
													</div>
													<div class="form-group">
														<label for="PatientAge">Patient Age</label>
														<input name="patientage" type="text"  class="form-control"  
														       value="<?php  echo $resultset['PatientAge'];?>" required="true">
													</div>
													<div class="form-group">
														<label for="MedicalHistory">Medical History</label>
														<textarea name="medhis" type="text"  class="form-control"  
														          placeholder="Patient Medical History(if any)" required="true">
																  <?php  echo $resultset['PatientMedhis'];?>
														</textarea>
													</div>	
													<div class="form-group">
														<label for="fess">Creation Date</label>
														<input type="text" class="form-control"  
														       value="<?php  echo $resultset['CreationDate'];?>" readonly='true'>
													</div>
													<?php } ?>
													<button name="submit" id="submit" type="submit"  class="btn btn-o btn-primary">Update</button>
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
	<!-- FOOTER -->
	<?php include('../define/footer.php');?>	
	<?php include('../define/setting.php');?>	
	<!-- JAVASCRIPT -->
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
