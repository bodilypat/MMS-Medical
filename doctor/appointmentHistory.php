	<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{

		if(isset($_GET['cancel']))
			{
				mysqli_query($deal,"UPDATE appointment SET doctorStatus='0' WHERE id ='".$_GET['id']."'");
				$_SESSION['msg']="Appointment canceled !!";
		  }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Doctor | Appointment History</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assign/css/styles.css">
		<link rel="stylesheet" href="assign/css/plugins.css">
		<link rel="stylesheet" href="assign/css/themes/theme-1.css" id="skin_color" />
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
							<div class="col-sm-8"><h1 class="mainTitle">Doctor  | Appointment History</h1></div>
							<ol class="breadcrumb">
								<li><span>Doctor </span></li>
								<li class="active"><span>Appointment History</span></li>
							</ol>
						</div>
					</section>					
					<!-- section: CONTENT -->
					<div class="container-fluid container-fullw bg-white">						
						<div class="row">
							<div class="col-md-12">									
								<p style="color:red;">
									<?php echo htmlentities($_SESSION['msg']);?>
									<?php echo htmlentities($_SESSION['msg']="");?>
								</p>	
								<table id="app-patient-table" class="table table-hover" >
									<thead>
										<tr>
											<th class="center">#</th>
											<th class="hidden-xs">Patient  Name</th>
											<th>Specialization</th>
											<th>Consultancy Fee</th>
											<th>Appointment Date / Time </th>
											<th>Appointment Creation Date  </th>
											<th>Current Status</th>
											<th>Action</th>												
										</tr>
									</thead>
									<tbody>
										<?php
										$qUser=mysqli_query($deal,"SELECT users.fullName as fname,appointment.*  
										                           FROM  appointment join users on users.id=appointment.userId 
																   WHERE appointment.doctorId='".$_SESSION['id']."'");
										$count=1;
										while($resultset=mysqli_fetch_array($qUser))
										{
										?>
										<tr>
											<td class="center"><?php echo $count;?>.</td>
											<td class="hidden-xs"><?php echo $resultset['fname'];?></td>
											<td><?php echo $resultset['doctorSpecialization'];?></td>
											<td><?php echo $resultset['consultancyFees'];?></td>
											<td><?php echo $resultset['appointmentDate'];?> / <?php echo $resultset['appointmentTime'];?></td>
											<td><?php echo $resultset['postingDate'];?></td>
											<td>
												<?php if(($resultset['userStatus']==1) && ($resultset['doctorStatus']==1))  
												{
													echo "Active";
												}
												if(($resultset['userStatus']==0) && ($resultset['doctorStatus']==1))  
												{
													echo "Cancel by Patient";
												}

												if(($resultset['userStatus']==1) && ($resultset['doctorStatus']==0))  
												{
													echo "Cancel by you";
												}
												?><
											</td>
											<td >
												<div class="visible-md visible-lg hidden-sm hidden-xs">
													<?php if(($resultset['userStatus']==1) && ($resultset['doctorStatus']==1))  
													{ ?>
													
														<a href="appointmentHistory.php?id=<?php echo $resultset['id']?>&cancel=update" 
														   onClick="return confirm('Are you sure you want to cancel this appointment ?')"
														   class="btn btn-transparent btn-xs tooltips" title="Cancel Appointment"
	 													   tooltip-placement="top" tooltip="Remove">Cancel</a>
													<?php } else {
														   echo "Canceled";
														} ?>
												</div>
												</td>
											</tr>											
											<?php  $count=$count+1;  }?>	
										</tbody>
									</table>
								</div>
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
	<script src="assign/js/main.js"></script>
	<script src="assign/js/form-elements.js"></script>
	<script>
		jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
</body>
</html>
<?php } ?>
