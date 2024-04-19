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
		<title>Admin | User Session Logs</title>
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
					<!-- section : PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Admin  | User Session Logs</h1></div>
							<ol class="breadcrumb">
								<li><span>Admin </span></li>
								<li class="active"><span>User Session Logs</span></li>
							</ol>
						</div>
					</section>					
					<!-- section: CONTENT -->
					<div class="container-fluid container-fullw bg-white">						
						<div class="row">
							<div class="col-md-12">									
								<p style="color:red;">
								    <?php echo htmlentities($_SESSION['msg']);?>
								    <?php echo htmlentities($_SESSION['msg']="");?>
								</p>	
								<table class="table table-hover" id="sample-table-1">
									<thead>
										<tr>
											<th class="center">#</th>
											<th class="hidden-xs">User id</th>
											<th>Username</th>
											<th>User IP</th>
											<th>Login time</th>
											<th>Logout Time </th>
											<th> Status </th>																								
										</tr>
									</thead>
									<tbody>
										<?php
											$qUl=mysqli_query($deal,"SELECT * FROM userlog ");
											$count=1;
											while($recordset=mysqli_fetch_array($qUl))
											{
										?>
										<tr>
											<td class="center"><?php echo $count;?>.</td>
											<td class="hidden-xs"><?php echo $recordset['uid'];?></td>
											<td class="hidden-xs"><?php echo $recordset['username'];?></td>
											<td><?php echo $recordset['userip'];?></td>
											<td><?php echo $recordset['loginTime'];?></td>
											<td><?php echo $recordset['logout'];?></td>												
											<td>
												<?php if($recordset['status']==1)
												{
													echo "Success";
												}
												else
												{
													echo "Failed";
												}?>

											</td>												
										</tr>											
										<?php $count=$count+1;  }?>																						
									</tbody>
								</table>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>
		<!-- FOOTER -->
		<?php include('include/footer.php');?>		
		<?php include('include/setting.php');?>
	</div>
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
