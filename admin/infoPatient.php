<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
		} else{
		if(isset($_POST['submit']))
		{
		
			$patID=$_GET['pid'];
			$bloodPass=$_POST['bloodpressure'];
			$bloodSu=$_POST['bloodssuger'];
			$Weight=$_POST['weight'];
			$temperature=$_POST['temperature'];
			$pressure=$_POST['pressure'];

      		$qMhis=mysqli_query($deal, "INSERT INTO medicalhistory(PatientID,BloodPressure,BloodSugar,Weight,Temperature,MedicalPres)
			                            VALUES('$infoID','$bloodPrss','$bloodSu','$weight','$temperature','$pressure')");
    if ($qMdhis) {
    	echo '<script>alert("Medicle history has been added.")</script>';
    	echo "<script>window.location.href ='managePatients.php'</script>";
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
		<title>Doctor | Manage Patients</title>
		<!-- css -->
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
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
							<div class="col-sm-8"><h1 class="mainTitle">Doctor | Manage Patients</h1></div>
								<ol class="breadcrumb">
									<li><span>Doctor</span></li>
									<li class="active"><span>Manage Patients</span></li>
								</ol>
						</div>
					</section>
					<!-- section:CONTENT -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Patients</span></h5>
								<?php
                               		$patID=$_GET['infoid'];
                               		$qPat=mysqli_query($deal,"SELECT * FROM patients WHERE ID='$infoID'");
									$count=1;
									while ($resultset=mysqli_fetch_array($qPat)) {
                                ?>
								<table border="1" class="table table-bordered">
 									<tr align="center">
										<td colspan="4" style="font-size:20px;color:blue">Patient Details</td>
									</tr>

									<tr>
										<th scope>Patient Name</th>
											<td><?php  echo $resultset['PatientName'];?></td>
										<th scope>Patient Email</th>
										<td><?php  echo $resultset['PatientEmail'];?></td>
									</tr>
									<tr>
										<th scope>Patient Mobile Number</th>
											<td><?php  echo $resultset['PatientContno'];?></td>
										<th>Patient Address</th>
											<td><?php  echo $resultset['PatientAdd'];?></td>
									</tr>
									<tr>
										<th>Patient Gender</th>
											<td><?php  echo $resultset['PatientGender'];?></td>
										<th>Patient Age</th>
											<td><?php  echo $resultset['PatientAge'];?></td>
									</tr>
  									<tr>    
										<th>Patient Medical History(if any)</th>
											<td><?php  echo $resultset['PatientMedhis'];?></td>
										<th>Patient Reg Date</th>
											<td><?php  echo $resultset['CreationDate'];?></td>
								    </tr>
                            		<?php }?>
                                </table>
								<?php  
									 $qMhis=mysqli_query($deal,"SELECT * FROM medicalhistory  WHERE PatientID='$patID'");
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
										while ($recordset=mysqli_fetch_array($qMhis)) { 
  									?>
									<tr>
  										<td><?php echo $count;?></td>
 										<td><?php  echo $recordset['BloodPressure'];?></td>
 										<td><?php  echo $recordset['Weight'];?></td>
 										<td><?php  echo $recordset['BloodSugar'];?></td> 
  										<td><?php  echo $recordset['Temperature'];?></td>
  										<td><?php  echo $recordset['MedicalPres'];?></td>
  										<td><?php  echo $recordset['CreationDate'];?></td> 
									</tr>
									<?php $count=$count+1;} ?>
								</table>                          
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
