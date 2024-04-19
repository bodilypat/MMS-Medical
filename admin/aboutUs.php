<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
		} else{
			// Update the Content
			if(isset($_POST['submit']))
			{   
				$pageTitle=$_POST['pagetitle'];
				$pageDes=$deal->real_escape_string($_POST['pageDescript']);
				$qPage=mysqli_query($deal,"UPDATE tblpage 
				                           SET PageTitle='$pageTitle',PageDescription='$pageDes' 
										   WHERE  PageType='aboutus'");
				if ($qPage) {
					echo '<script>alert("About Us has been updated.")</script>';
				}
				else
				{
					echo '<script>alert("Something Went Wrong. Please try again.")</script>';
				} 
			}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | About Us </title>
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
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
							<div class="col-sm-8"><h1 class="mainTitle">Admin  | Update the About us </h1></div>
							<ol class="breadcrumb">
								<li><span>Admin </span></li>
								<li class="active"><span>Update the About us </span></li>
							</ol>
						</div>
					</section>
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">						
								<form class="forms-sample" method="post">
									<?php
										$qPage=mysqli_query($deal,"SELECT * FROM  tblpage WHERE PageType='aboutus'");
										$count=1;
										while ($resultpage=mysqli_fetch_array($qPage)) 
										{
									?>
									<div class="form-group">
										<label for="exampleInputUsername1">Page Title</label>
										<input id="pagetitle" name="pagetitle" type="text" class="form-control" required="true" 
										        value="<?php  echo $resultpage['PageTitle'];?>">
									</div>													
									<div class="form-group">
										<label for="exampleInputEmail1">Page Description</label>
										<textarea class="form-control" name="pagedes" id="pagedes" rows="12">
											<?php  echo $resultpage['PageDescription'];?>
										</textarea>
									</div>										
									<?php } ?>
									<!--end :while loop -->
									<button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
								</form>
							</div>
						</div>
					</div>						
				</div>
			</div>
			<!-- FOOTER -->
			<?php include('include/footer.php');?>			
			<?php include('include/setting.php');?>						
		</div>
	</div>		
	<script src="assets/js/main.js"></script>
	<!-- JAVASCRIPT -->
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
