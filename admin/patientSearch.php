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
		<title>Admin | Info Patients</title>
		<!-- CSS -->
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assing/css/themes/theme-1.css" id="skin_color" />
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
							<div class="col-sm-8"><h1 class="mainTitle">Admin | Info Patients</h1></div>
							<ol class="breadcrumb">
								<li><span>Admin</span></li>
								<li class="active"><span>Info Patients</span></li>
							</ol>
						</div>
					</section>
					<!-- section:CONTENT -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<form role="form" method="post" name="search">
									<div class="form-group">
										<label for="SearchName/Mobile">Search by Name/Mobile No.</label>
										<input id="searchdata" name="searchdata" type="text"   class="form-control" 
										       value="" required='true'>
									</div>
									<button id="submit" name="search" type="submit"   class="btn btn-o btn-primary">
											Search
									</button>
								</form>
								<?php
									if(isset($_POST['search']))
									{ 
										$sdata=$_POST['searchdata'];
								?>
  								<h4 align="center">Result against "<?php echo $sdata;?>" keyword </h4>
								<table id="patient-table"class="table table-hover">
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
											                        FROM patients 
																	WHERE PatientName LIKE '%$sdata%'|| PatientContno like '%$sdata%'");
											$countRows=mysqli_num_rows($qPat);
											if($countRows > 0){
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
												<a href="infoPatient.php?pid=<?php echo $resultset['ID'];?>">
													<i class="fa fa-eye"></i>
												</a>
											</td>
										</tr>
											<?php $count=$count+1;
										} } else { ?>
										<tr>
											<td colspan="8"> No record found against this search</td>
										</tr>										
										<?php } }?>
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
