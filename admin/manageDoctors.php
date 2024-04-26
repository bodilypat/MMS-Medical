<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0)) {
	header('location:logout.php');
	} else{
	if(isset($_GET['del']))
			{
				$docid=$_GET['did'];
					mysqli_query($deal,"DELETE FROM doctors WHERE id ='$docid'");
					$_SESSION['msg']="data deleted !!";
			}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Manage Doctors</title>
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
							<div class="col-sm-8"><h1 class="mainTitle">Admin | Manage Doctors</h1></div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>Manage Doctors</span></li>
								</ol>
							</div>
						</section>						
						<!-- section:CONTENT -->
						<div class="container-fluid container-fullw bg-white">						
						<div class="row">
							<div class="col-md-12">
								<h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Doctors</span></h5>
								<p style="color:red;">
								    <?php echo htmlentities($_SESSION['msg']);?>
									<?php echo htmlentities($_SESSION['msg']="");?>
								</p>	
								<table id="doctor-table" class="table table-hover" >
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Specialization</th>
											<th class="hidden-xs">Doctor Name</th>
											<th>Creation Date </th>
											<th>Action</th>												
										</tr>
									</thead>
									<tbody>
								<?php
								$qDoc=mysqli_query($deal,"SELECT * FROM doctors");
								$count=1;
								while($resultset=mysqli_fetch_array($qDoc))
								{
								?>
										<tr>
											<td class="center"><?php echo $count;?>.</td>
											<td class="hidden-xs"><?php echo $resultset['specilization'];?></td>
											<td><?php echo $resultset['doctorName'];?></td>
											<td><?php echo $resultset['creationDate'];?></td>												
											<td >
												<div class="visible-md visible-lg hidden-sm hidden-xs">
													<a  href="editDoctor.php?eid=<?php echo $resultset['id'];?>" 
													    class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit">
													   <i class="fa fa-pencil"></i>
													</a>													
													<a href="manageDoctors.php?did=<?php echo $resultset['id']?>&del=delete" 
													   onClick="return confirm('Are you sure you want to delete?')"
													   class="btn btn-transparent btn-xs tooltips" 
													   tooltip-placement="top" tooltip="Remove">
													   <i class="fa fa-times fa fa-white"></i>
													</a>
												</div>												
											</td>
										</tr>											
											<?php $count=$count+1;}?>											
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