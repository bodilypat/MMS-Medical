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
		<title>Doctor | Manage Patients</title>
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
							<form name="search" role="form" method="post" >
								<div class="form-group">
									<label for="doctorname">Search by Name/Mobile No.</label>
									<input name="searchdata" id="searchdata" type="text" class="form-control" value="" required='true'>
								</div>
								<button id="submit" name="search" type="submit"   class="btn btn-o btn-primary">Search</button>
							</form>	
								<?php
									if(isset($_POST['search']))
									{ 
										$sdata=$_POST['searchdata'];
  								?>
							<h4 align="center">Result against "<?php echo $sdata;?>" keyword </h4>										
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
										                         FROM patient 
																 WHERE PatientName LIKE '%$sdata%'|| PatientContno LIKE '%$sdata%'");
										$numRows =mysqli_num_rows($qPat);
										if($numRows > 0){
										$count=1;
										while($recordset=mysqli_fetch_array($qPat))
										{
									?>
									<tr>
										<td class="center"><?php echo $count;?>.</td>
										<td class="hidden-xs"><?php echo $recordset['PatientName'];?></td>
										<td><?php echo $recordset['PatientContno'];?></td>
										<td><?php echo $recordset['PatientGender'];?></td>
										<td><?php echo $recordset['CreationDate'];?></td>
										<td><?php echo $recordset['UpdationDate'];?></td>
										<td>
											<a href="editPatient.php?editid=<?php echo $recordset['ID'];?>">
											<i class="fa fa-edit"></i></a> || 
											<a href="dataPatient.php?pid=<?php echo $recordset['ID'];?>">
												<i class="fa fa-eye"></i></a>
										</td>
									</tr>
										<?php $count=$count+1;
										} } else { ?>
										<tr>
											<td colspan="8"> No record found against this search</td>

										</tr>										
										<?php }} ?>
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
	<!--: FOOTER -->
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
