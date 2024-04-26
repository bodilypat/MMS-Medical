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
		<title>Admin | Manage Unread Queries</title>
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
							<div class="col-sm-8"><h1 class="mainTitle">Admin | Manage Unread Queries</h1></div>
							<ol class="breadcrumb">
								<li><span>Admin</span></li>
								<li class="active"><span>Unread Queries</span></li>
							</ol>
						</div>
					</section>
					<!-- section: content -->
					<div class="container-fluid container-fullw bg-white">						
						<div class="row">
							<div class="col-md-12">
								<h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Unread Queries</span></h5>
								<table class="table table-hover" id="sample-table-1">
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Name</th>
											<th class="hidden-xs">Email</th>
											<th>Contact No. </th>
											<th>Message </th>
											<th>Query Date</th>
											<th>Action</th>												
										</tr>
									</thead>
									<tbody>
									<?php
										$qCon=mysqli_query($con,"SELECT * FROM contactus WHERE IsRead is null");
										$count=1;
										while($resultset=mysqli_fetch_array($qCon))
										{
									?>

											<tr>
												<td class="center"><?php echo $count;?>.</td>
												<td class="hidden-xs"><?php echo $resultset['fullname'];?></td>
												<td><?php echo $resultset['email'];?></td>
												<td><?php echo $resultset['contactno'];?></td>
												<td><?php echo $resultset['message'];?></td>
												<td><?php echo $resultset['PostingDate'];?></td>												
												<td >
													<div class="visible-md visible-lg hidden-sm hidden-xs">
														 <a href="enquireDetails.php?enid=<?php echo $resultset['id'];?>" 
													        class="btn btn-transparent btn-lg" title=" Enquire Details">
														    <i class="fa fa-file"></i>
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
	</div>
	<!-- section: FOOTER -->
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