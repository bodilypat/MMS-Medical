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
				$addDS=mysqli_query($deal,"INSERT INTO doctorSpecialized(specilization) 
				                        VALUES('$docSpecial')");
				if($addDS)
				{
					$_SESSION['msg']="Doctor Specialization added successfully !!";
				}
			}
			/* delete doctorSpecial  */
			if(isset($_GET['del']))
			{
				$dsid=$_GET['delid'];	
				mysqli_query($deal,"DELETE FROM doctorSpecialized WHERE id = '$dsid'");
				$_SESSION['msg']="data deleted !!";
		}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Doctor Specialization</title>
		<!-- CSS custom -->		
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
	</head>
<body>
	<div id="application">		
		<?php include('../define/sidebar.php');?>
		<div class="appplication-content">				
			<?php include('../define/header.php');?>									
			<div class="main-content" >
				<div id="container" class="wrap-content container" >
					<!-- section: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8"><h1 class="mainTitle">Admin | Add Doctor Specialization</h1></div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>Add Doctor Specialization</span></li>
								</ol>
							</div>
						</section>
						<!-- section:content-->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">									
									<div class="row margin-top-30">
										<div class="col-lg-6 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Doctor Specialization</h5>
												</div>
												<div class="panel-body">
													<p style="color:red;">
														<?php echo htmlentities($_SESSION['msg']);?>
														<?php echo htmlentities($_SESSION['msg']="");?>
													</p>	
													<form name="doctorspecial" role="form"  method="post" >
														<div class="form-group">
															<label for="DoctorSpecial">Doctor Specialization</label>
															<input name="doctorSpecial" type="text"  class="form-control"  
							                                       placeholder="Enter Doctor Specialization">
														</div>																																																						
														<button name="submit" type="submit"  class="btn btn-o btn-primary">
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
						<div class="row">
							<div class="col-md-12">
								<h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Docter Specialization</span></h5>									
								<table class="table table-hover" id="sample-table-1">
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Specialization</th>
											<th class="hidden-xs">Creation Date</th>
											<th>Updation Date</th>
											<th>Action</th>											
										</tr>
									</thead>
									<tbody>
										<?php
											$qDS=mysqli_query($deal,"SELECT * FROM doctorSpecialized");
											$count=1;
											while($resultset=mysqli_fetch_array($qDS))
											{
										?>
										<tr>
											<td class="center"><?php echo $count;?>.</td>
											<td class="hidden-xs"><?php echo $resultset['specilization'];?></td>
											<td><?php echo $resultset['creationDate'];?></td>
											<td><?php echo $resultset['updationDate'];?></td>												
											<td >
												<div class="visible-md visible-lg hidden-sm hidden-xs">
													<a href="editDoctorSpecial.php?eid=<?php echo $resultset['id'];?>" 
													   class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit">
													   <i class="fa fa-pencil"></i>
													</a>													
													<a href="doctorSpecial.php?delid=<?php echo $result['id']?>&del=delete" 
													   onClick="return confirm('Are you sure you want to delete?')"
													   class="btn btn-transparent btn-xs tooltips" 
													   tooltip-placement="top" tooltip="Remove">
													   <i class="fa fa-times fa fa-white"></i>
													</a>
												</div>												
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
	</div>
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
