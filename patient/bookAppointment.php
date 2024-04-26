<?php
	session_start();
	include('../define/config.php');
	include('../define/checklogin.php');
	check_login();

	if(isset($_POST['submit']))
	{
			$docSpecial=$_POST['doctorspecial'];
			$did=$_POST['doctor'];
			$uid=$_SESSION['userid'];
			$consultFees=$_POST['consultfees'];
			$appDate=$_POST['appointmentdate'];
			$appTime=$_POST['appointmenttime'];
			$userStatus=1;
			$docStatus=1;
			$addApp=mysqli_query($deal,"INSERT INTO appointment(doctorSpecial,doctorId,userId,consultancyFees,appointDate,appointTime,userStatus,doctorStatus) 
									VALUES('$docSpecial','$did','$uid','$consultFees','$appDate','$appTime','$userstatus','$docStatus')");
			if($addApp)
			{
				echo "<script>alert('Your appointment successfully booked');</script>";
			}

	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User  | Book Appointment</title>
		<!-- CSS -->
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
		<script>
			function getdoctor(val) {
				$.ajax({
				type: "POST",
				url: "getDoctor.php",
				data:'specializationid='+val,
				success: function(data){
					$("#doctor").html(data);
				}
				});
			}
		</script>	
		<script>
			function getfee(val) {
				$.ajax({
				type: "POST",
				url: "getDoctor.php",
				data:'doctor='+val,
				success: function(data){
					$("#fees").html(data);
				}
				});
			}
		</script>	
</head>
	<body>
		<div id="app">		
        <?php include('../define/sidebar.php');?>
		<div class="app-content">
			<?php include('../define/header.php');?>			
			<div class="main-content" >
				<div id="container" class="wrap-content container" >
					<!-- section: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">User | Book Appointment</h1></div>
							<ol class="breadcrumb">
							    <li><span>User</span></li>
								<li class="active"><span>Book Appointment</span></li>
							</ol>
						</div>
					</section>
					<!-- select: PAGE TITLE -->						
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">									
								<div class="row margin-top-30">
									<div class="col-lg-8 col-md-12">										
										<div class="panel panel-white">
											<div class="panel-heading"><h5 class="panel-title">Book Appointment</h5></div>
											<div class="panel-body">
												<p style="color:red;">
													<?php echo htmlentities($_SESSION['msg1']);?>
													<?php echo htmlentities($_SESSION['msg1']="");?>
												</p>													
												<form role="form" name="book" method="post" >													
													<div class="form-group">
														<label for="DoctorSpecial">Doctor Specialization</label>
														<select name="doctorspecial" class="form-control" 
														        onChange="getdoctor(this.value);" required="required">
															<option value="">Select Specialization</option>																																					
																<?php $qDS=mysqli_query($deal,"SELECT * FROM doctorSpecial");
																	while($result=mysqli_fetch_array($qDS))
																	{
																?>																			
																<option value="<?php echo htmlentities($result['specialization']);?>">
																		<?php echo htmlentities($result['specialization']);?>
																</option>
																		
																<?php } ?>																		
														</select>
													</div>
													<div class="form-group">
														<label for="Doctor">Doctors</label>
														<select id="doctor" name="doctor" class="form-control"  onChange="getfee(this.value);" required="required">
															   <option value="">Select Doctor</option>
															   <?php
															        $qDoc=mysqli_query($deal,"SELECT docName FROM doctor");
																	while($data=mysqli_fetch_array($qDoc))
																	{
																?>
																<option value="<?php echo htmlentities($data['docName']);?>">
																		<?php echo htmlentities($data['docName']);?>
																</option>
																<?php 	}?>
														</select>
													</div>														
													<div class="form-group">
														<label for="ConsultancyFees">Consultancy Fees</label>
														<select name="consultfees" class="form-control" id="fees"  readonly></select>
													</div>														
													<div class="form-group">
														<label for="AppointmentDate">Date</label>
														<input name="appointmentdate" class="form-control datepicker"   required="required" data-date-format="yyyy-mm-dd">
													</div>														
													<div class="form-group">
														<label for="AppointmentTime">Time</label>
														<input name="appointmentime" id="timepicker1" class="form-control"  required="required">eg : 10:00 PM
													</div>																												
													<button name="submit" type="submit"  class="btn btn-o btn-primary">Submit</button>
												</form>
											</div>
										</div>
									</div>											
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
		$('.datepicker').datepicker({
    	format: 'yyyy-mm-dd',
	    startDate: '-3d'
	});
	</script>
	<script type="text/javascript">
            $('#timepicker1').timepicker();
    </script>
</body>
</html>
