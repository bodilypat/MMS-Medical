<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{

	//updating Admin Remark
	if(isset($_POST['update']))
	{
		$qid=intval($_GET['enid']);
		$adminremark=$_POST['adminremark'];
		$isread=1;
		$eCon=mysqli_query($deal,"UPDATE tblcontactus 
		                          SET  AdminRemark='$adminremark',IsRead='$isread' 
								  WHERE id='$qid'");
		if($eCon){
		echo "<script>alert('Admin Remark updated successfully.');</script>";
		echo "<script>window.location.href ='readEnquire.php'</script>";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Enquire Details</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
<body>
	<div id="application">		
		<?php include('include/sidebar.php');?>
		<div class="application-content">				
			<?php include('include/header.php');?>		
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- section: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8"><h1 class="mainTitle">Admin | Enqire Details</h1></div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>Enqire Details</span></li>
								</ol>
							</div>
						</section>
						<!-- section: CONTENT -->
						<div class="container-fluid container-fullw bg-white">						
							<div class="row">
								<div class="col-md-12">
									<h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Enquire Details</span></h5>
									<hr />
									<table class="table table-hover" id="contact-table">		
										<tbody>
										<?php
											$qid=intval($_GET['id']);
											$qCon=mysqli_query($deal,"SELECT * FROM tblcontactus WHERE id='$qid'");
											$count=1;
											while($result=mysqli_fetch_array($qCon))
											{
										?>
											<tr>
												<th>Full Name</th>
												<td><?php echo $result['fullname'];?></td>
											</tr>

											<tr>
												<th>Email Id</th>
												<td><?php echo $result['email'];?></td>
											</tr>
											<tr>
												<th>Conatact Numner</th>
												<td><?php echo $result['contactno'];?></td>
											</tr>
											<tr>
												<th>Message</th>
												<td><?php echo $result['message'];?></td>
											</tr>
											<tr>
												<th>Query Date</th>
												<td><?php echo $result['PostingDate'];?></td>
											</tr>
											<?php if($result['AdminRemark']==""){?>	
											<form name="Enquire" method="post">
												<tr>
													<th>Admin Remark</th>
													<td>
														<textarea name="adminremark" class="form-control" required="true"></textarea>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>	
														<button name="update" type="submit" class="btn btn-primary pull-left" >
															  Update <i class="fa fa-arrow-circle-right"></i>
														</button>
													</td>
												</tr>
											</form>												
											<?php } else {?>											
												<tr>
													<th>Admin Remark</th>
													<td><?php echo $result['AdminRemark'];?></td>
												</tr>
												<tr>
													<th>Last Updatation Date</th>
													<td><?php echo $result['LastupdationDate'];?></td>
												</tr>											
											<?php 
											 }} ?>																						
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
