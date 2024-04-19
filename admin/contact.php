<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{
	//Code for Update the Content
		if(isset($_POST['submit']))
		{
		
			$pageTitle=$_POST['pagetitle'];
			$pageDes=$_POST['pagedescription'];
			$email=$_POST['email'];
			$mobilenum=$_POST['mobile'];
			$qPage=mysqli_query($deal,"	UPDATE tblpage 
										SET PageTitle='$pagetitle',PageDescription='$pageDes',Email='$email',MobileNumber='$mobilenum'  
										WHERE PageType='contactus'");
			if ($qPage) {
		
			echo '<script>alert("Contact Us has been updated.")</script>';
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
		<title>Admin | Cotnact Us </title>
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
							<div class="col-sm-8"><h1 class="mainTitle">Admin  | Update the Cotnact us Content</h1></div>
								<ol class="breadcrumb">
									<li><span>Admin </span></li>
									<li class="active"><span>Update the Cotnact us Content</span></li>
								</ol>
						</div>
					</section>					
					<!-- section: CONTENT -->
					<div class="container-fluid container-fullw bg-white">						
						<div class="row">
							<div class="col-md-12">																		
                                <form class="forms-sample" method="post">
                    				<?php                
										 $qPage=mysqli_query($deal,"SELECT * FROM  tblpage WHERE PageType='contactus'");
										 $count=1;
										 while ($resultset=mysqli_fetch_array($qPage)) {
									?>
                    				<div class="form-group">
                       					<label for="PageTitle">Page Title</label>
                      					<input id="pagetitle" name="pagetitle" type="text" class="form-control" required="true" 
										       value="<?php  echo $resultset['PageTitle'];?>">
                    				</div>
                    				<div class="form-group">
                      					<label for="PageDescription">Page Description</label>
                      					<textarea name="pagedescription" id="pagedescription" class="form-control"   rows="5">
											<?php  echo $resultset['PageDescription'];?>
										</textarea>
                    				</div>
                    				<div class="form-group">
                      					<label for="EmailAddress">Email Addresss</label>
                     					<input name="email" type="email" class="form-control"  
										       value="<?php  echo $resultset['Email'];?>" required='true'>
                    				</div>
                    				<div class="form-group">
                      					<label for="MobileNumber">Mobile Number</label>
                     					<input name="mobile" type="text" class="form-control"  
										       value="<?php  echo $resultset['MobileNumber'];?>" 
											   required='true' maxlength="10" pattern='[0-9]+'>
                    				</div>                    
				                    <?php } ?>
                    				<button name="submit" type="submit" class="btn btn-primary mr-2" >Update</button>
                  				</form>
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
