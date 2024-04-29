<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	include('../define/checklogin.php');
	check_login();
	if(isset($_POST['submit']))
	{
		
		$patid=$_GET['infoid'];
		$bloodPress=$_POST['bloodpress'];
		$bloodSu=$_POST['bloodsuger'];
		$patWeight=$_POST['weight'];
		$patTemp=$_POST['temperature'];
	    $mdhpress=$_POST['pressure'];
		
		  $addmdh=mysqli_query($deal, "INSERT INTO  medicalhistory(PatientID,BloodPressure,BloodSugar,Weight,Temperature,MedicalPres)
		                               VALUES('$vid','$bp','$bs','$weight','$temp','$pres')");
		  
		if ($query) {
			echo '<script>alert("Medicle history has been added.")</script>';
			echo "<script>window.location.href ='managePatient.php'</script>";
		}
		else
			{
			  echo '<script>alert("Something Went Wrong. Please try again")</script>';
			}
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Users | Medical History</title>
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
							<div class="col-sm-8"><h1 class="mainTitle">Users | Medical History</h1></div>
							<ol class="breadcrumb">
								<li><span>Users</span></li>
								<li class="active"><span>Medical History</span></li>
							</ol>
						</div>
					</section>
					<!-- section:content -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<h5 class="over-title margin-bottom-15">Users <span class="text-bold">Medical History</span></h5>
								<?php
                               		$patid=$_GET['infoid'];
                               		$qPat=mysqli_query($deal,"SELECT * FROM patient WSHER ID='$patid'");
									$count=1;
									while ($result=mysqli_fetch_array($qPat))
									{
                               	?>
									<table border="1" class="table table-bordered">
 										   <tr align="center">
												<td colspan="4" style="font-size:20px;color:blue">Patient Details</td>
											</tr>
    										<tr>
    											<th scope>Patient Name</th>
    												<td><?php  echo $result['PatientName'];?></td>
    											<th scope>Patient Email</th>
    												<td><?php  echo $result['PatientEmail'];?></td>
  											</tr>
  											<tr>
    											<th scope>Patient Mobile Number</th>
    												<td><?php  echo $result['PatientContno'];?></td>
    											<th>Patient Address</th>
	    											<td><?php  echo $result['PatientAdd'];?></td>
  											</tr>
    										<tr>
    											<th>Patient Gender</th>
    												<td><?php  echo $result['PatientGender'];?></td>
    											<th>Patient Age</th>
    												<td><?php  echo $result['PatientAge'];?></td>
  											</tr>
  											<tr>											
    											<th>Patient Medical History(if any)</th>
    												<td><?php  echo $result['PatientMedhis'];?></td>
     											<th>Patient Reg Date</th>
    												<td><?php  echo $result['CreationDate'];?></td>
  											</tr>									
										<?php }?>
									</table>
								<?php  
									$qMdh=mysqli_query($deal,"SELECT * FROM medicalhistory  WHERE PatientID='$patid'");
 								?>
									<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  										<tr align="center">
   											<th colspan="8" >Medical History</th> 
  										</tr>
  										<tr>
    										<th>#</th>
											<th>Blood Pressure</th>
											<th>Weight</th>
											<th>Blood Sugar</th>
											<th>Body Temprature</th>
											<th>Medical Prescription</th>
											<th>Visit Date</th>
										</tr>
								<?php  
									while ($resultset=mysqli_fetch_array($qMdh))
									{ 
  								?>
										<tr>
  											<td><?php echo $count;?></td>
 											<td><?php  echo $resultset['BloodPressure'];?></td>
 											<td><?php  echo $resultset['Weight'];?></td>
 											<td><?php  echo $resultset['BloodSugar'];?></td> 
  											<td><?php  echo $resultset['Temperature'];?></td>
  											<td><?php  echo $resultset['MedicalPres'];?></td>
  											<td><?php  echo $resultset['CreationDate'];?></td> 
										</tr>
									<?php $count=$count+1;} ?>
							</table>                          
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
			<!--  FOOTER -->
	<?php include('../define/footer.php');?>
	<?php include('../define/setting.php');?>
	<!-- JAVASCRIPTS -->
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
