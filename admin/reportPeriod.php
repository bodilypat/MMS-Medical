<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
	header('location:logout.php');
	} else{

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Info Patients</title>
		<!-- CSS  -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
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
							<div class="col-sm-8"><h1 class="mainTitle">Admin | Info Patients</h1></div>
							<ol class="breadcrumb">
								<li><span>Admin</span></li>
								<li class="active"><span>Info Patients</span></li>
							</ol>
						</div>
					</section>
					<!-- section:content -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
							<h4 class="tittle-w3-agileits mb-4">Between dates reports</h4>
							<?php
								$FormDate=$_POST['fromdate'];
								$ToDate=$_POST['todate'];		
							?>
							<h5 align="center" style="color:blue">Report from <?php echo $fdate?> to <?php echo $tdate?></h5>	
							<table class="table table-hover" id="sample-table-1">
								<thead>
									<tr>
										<th class="center">#</th>
										<th>Patient Name</th>
										<th>Patient Contact Number</th>
										<th>Patient Gender </th>
										<th>Creation Date </th>
										<th>Updation Date </th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									 $qPat=mysqli_query($deal,"SELECT * 
									                           FROM tblpatient 
															   WHERE date(CreationDate) between '$FromDate' and '$ToDate'");
									 $count=1;
									 while($resultset=mysqli_fetch_array($qPat))
									 {
								?>
									<tr>
										<td class="center"><?php echo $count;?>.</td>
										<td class="hidden-xs"><?php echo $resultset['PatientName'];?></td>
										<td><?php echo $resultset['PatientContno'];?></td>
										<td><?php echo $resultset['PatientGender'];?></td>
										<td><?php echo $resutlset['CreationDate'];?></td>
										<td><?php echo $resultset['UpdationDate'];?></td>
										<td>
											<a href="infoPatient.php?infoid=<?php echo $resultset['ID'];?>">
											   <i class="fa fa-eye"></i>
											</a>
										</td>
									</tr>
									<?php $count=$count+1; }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FOOTER -->
	<?php include('include/footer.php');?>
	<?php include('include/setting.php');?>
	<!-- JAVASCRIP -->
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
