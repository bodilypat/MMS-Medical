<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>B/w dates reports | Admin</title>
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
							<div class="col-sm-8"><h1 class="mainTitle">Between Dates | Reports</h1></div>
								<ol class="breadcrumb">
									<li><span>Between Dates</span></li>
									<li class="active"><span>Reports</span></li>
								</ol>
						</div>
					</section>
						<!-- section : -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">									
								<div class="row margin-top-30">
									<div class="col-lg-8 col-md-12">
										<div class="panel panel-white">
											<div class="panel-heading"><h5 class="panel-title">Between Dates Reports</h5></div>
												<div class="panel-body">
													<form role="form" method="post" action="betweendates-detailsreports.php">
														<div class="form-group">
															<label for="FromDate">From Date:</label>
					                                        <input id="fromdate" name="fromdate" type="date" class="form-control"   
										                           value="" required='true'>
														</div>		
														<div class="form-group">
															<label for="ToDate">To Date::</label>
										    				<input id="todate" name="todate" type="date" class="form-control"   
					                                               value="" required='true'>
														</div>																													
														<button name="submit" id="submit" type="submit"  class="btn btn-o btn-primary">
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
