	<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0)) {
	header('location:logout.php');
	} else{

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Information Patients</title>
	    <!-- css -->
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
						<!-- PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Admin | Patients</h1></div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>Patients</span></li>
								</ol>
							</div>
					</section>
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<h5 class="over-title margin-bottom-15">View <span class="text-bold">Patients</span></h5>	
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
										$qPat=mysqli_query($deal,"SELECT * FROM patients");
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
												<a href="infoPatient.php?pid=<?php echo $result['ID'];?>">
                                                   <i class="fa fa-eye"></i>
                                                </a>
											</td>
										</tr>
								     	<?php $count=$counnt+1;}?>
								    </tbody>
							    </table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--FOOTER -->
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
