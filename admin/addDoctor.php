	<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{
		if(isset($_POST['submit']))
		{	
			$docSpecial=$_POST['doctorSpecial'];
			$docName=$_POST['doctorname'];
			$docAdd=$_POST['clinicaddress'];
			$docFees=$_POST['doctorfees'];
			$docContact=$_POST['doctorcontact'];
			$docEmail=$_POST['doctoremail'];
			$password=md5($_POST['npass']);
			$addDoc=mysqli_query($deal,"INSERT INTO doctors(specilization,doctorName,address,docFees,contactno,docEmail,password) 
			                            VALUES('$docSpecial','$docName','$docAdd','$docFees','$docContact','$docEmail','$password')");
			if($addDoc)
			{
			echo "<script>alert('Doctor info added Successfully');</script>";
			echo "<script>window.location.href ='manageDoctors.php'</script>";

		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Add Doctor</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	<script type="text/javascript">
		function valid()
		{
 			if(document.adddoc.npass.value!= document.adddoc.cfpass.value)
			{
				alert("Password and Confirm Password Field do not match  !!");
				document.adddoc.cfpass.focus();
				return false;
			}
			return true;
		}
	</script>

	<script>
		function checkemailAvailability() {
			$("#loaderIcon").show();
			jQuery.ajax({
			url: "checkAvailability.php",
			data:'emailid='+$("#doctoremail").val(),
			type: "POST",
			success:function(data){
				$("#email-availability-status").html(data);
				$("#loaderIcon").hide();
			},
			error:function (){}
		});
	}
	</script>

	</head>
<body>
	<div id="application">		
		<?php include('../define/sidebar.php');?>
		<div class="app-content">				
			<?php include('../define/header.php');?>						
			<div class="main-content" >
				<div class="wrap-content container" id="container">
				<!-- section: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Admin | Add Doctor</h1></div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>Add Doctor</span></li>
								</ol>
							</div>
						</section>					
						<!-- section: CONTENT -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">									
									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading"><h5 class="panel-title">Add Doctor</h5></div>
												<div class="panel-body">									
													<form role="form" name="adddoc" method="post" onSubmit="return valid();">
														<div class="form-group">
															<label for="DoctorSpecialized">Doctor Specialization</label>
															<select name="DoctorSpecial" class="form-control" required="true">
																<option value="">Select Specialization</option>
																<?php 
																	/* query object from DB */
																      $qDS=mysqli_query($deal,"SELECT * FROM doctorSpecialized");
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
															<label for="DoctorName">Doctor Name</label>
															<input name="doctorname" type="text" class="form-control"  
															       placeholder="Doctor Name" required="true">
														</div>
                                                        <div class="form-group">
															<label for="Address">Doctor Clinic Address</label>
															<textarea name="clinicaddress" class="form-control"  
															   	placeholder="Clinic Address" required="true">
															</textarea>
														</div>
														<div class="form-group">
															<label for="DoctorFess">Consultancy Fees</label>
															<input name="doctorfees" type="text" class="form-control"  
																   placeholder="Doctor Consultancy Fees" required="true">
														</div>	
														<div class="form-group">
															<label for="Contactno">Contact no</label>
															<input name="doctorcontact" type="text"  class="form-control"  
																   placeholder="Doctor Contact no" required="true">
														</div>
														<div class="form-group">
															<label for="DotorEmail">Email</label>
															<input id="doctoremail" name="docemail" type="doctoremail"  class="form-control"  
																   placeholder=" Doctor Email id" required="true" 
																   onBlur="checkemailAvailability()">
															<span id="email-availability-status"></span>
														</div>														
														<div class="form-group">
															<label for="NewPassword">Password</label>
															<input name="npass" type="password"  class="form-control"  
																	placeholder="New Password" required="required">
														</div>														
														<div class="form-group">
															<label for="ConfirmPassword">Confirm Password</label>
															<input name="cfpass" type="password"  class="form-control"  
																   placeholder="Confirm Password" required="required">
														</div>																																										
														<button id="submit" type="submit" name="submit"  class="btn btn-o btn-primary">
															Submit
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