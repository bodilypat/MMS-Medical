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
		<title>Doctor | Manage Patients</title>
		<!-- CSS -->
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
							<div class="col-sm-8"><h1 class="mainTitle">Doctor | Manage Patients</h1></div>
							<ol class="breadcrumb">
								<li><span>Doctor</span></li>
								<li class="active"><span>Manage Patients</span></li>
							</ol>
						</div>
					</section>
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Patients</span></h5>
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
											$docid=$_SESSION['id'];
											$qPat=mysqli_query($deal,"SELECT * from patient where Docid='$docid' ");
											$count=1;
											while($resultset=mysqli_fetch_array($qPat))
											{
										?>
										<tr>
											<td class="center"><?php echo $count;?>.</td>
											<td class="hidden-xs"><?php echo $resultset['PatientName'];?></td>
											<td><?php echo $resultset['PatientContno'];?></td>
											<td><?php echo $resultset['PatientGender'];?></td>
											<td><?php echo $resultset['CreationDate'];?></td>
											<td><?php echo $resultset['UpdationDate'];?></td>
											<td>
												<a href="editPatient.php?editid=<?php echo $resultset['ID'];?>">
													<i class="fa fa-edit"></i>
												</a> || 
												<a href="dataPatient.php?viewid=<?php echo $resultset['ID'];?>">
													<i class="fa fa-eye"></i>
											    </a>
											</td>
										</tr>
									<?php  $cnt=$cnt+1;}?> 
									</tbody>
								</table>
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
	<!-- JAVASCRIPTS -->
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