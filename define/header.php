<?php error_reporting(0);?>
	<header class="navbar navbar-default navbar-static-top">
		<!-- start: NAVBAR HEADER -->
		<div class="navbar-header">
			<a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" 
			            class="btn btn-navbar sidebar-toggle" 
						data-toggle-class="app-slide-off" 
						data-toggle-target="#app" 
						data-toggle-click-outside="#sidebar">
				<i class="ti-align-justify"></i>
			</a>
			<a href="#" class="navbar-brand" >
				<h2 style="padding-top:20% ">MMS</h2>
			</a>
			<a href="#" class="sidebar-toggler pull-right visible-md visible-lg" 
			            data-toggle-class="app-sidebar-closed" 
						data-toggle-target="#app">
				<i class="ti-align-justify"></i>
			</a>
			<a href=".navbar-collapse" id="menu-toggler" 
			            class="pull-right menu-toggler visible-xs-block"  
						data-toggle="collapse" >
				<span class="sr-only">Toggle navigation</span>
				<i class="ti-view-grid"></i>
			</a>
		</div>
		<!-- start: NAVBAR COLLAPSE -->
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-right">
			<!-- start: MESSAGES DROPDOWN -->
				<li  style="padding-top:2% "><h2>Hospital Management System</h2></li>						
				<li class="dropdown current-user">
					<a href class="dropdown-toggle" data-toggle="dropdown">
						<img src="../image/images.jpg"> 
						<span class="username">
								<!-- query users -->
							<?php $qUser=mysqli_query($deal,"SELECT fullName FROM users WHERE id='".$_SESSION['id']."'");
								  while($result=mysqli_fetch_array($qUser))
							      {
									  echo $result['fullName'];
								  }
							?> 
							<i class="ti-angle-down"></i>
						</span>
					</a>
					<ul class="dropdown-menu dropdown-dark">
						<li><a href="editProfile.php">My Profile</a></li>								
						<li><a href="changePassword.php">Change Password</a></li>
						<li><a href="logout.php">Log Out</a></li>
					</ul>
				</li>
				<!-- end: USER OPTIONS DROPDOWN -->
			</ul>
				<!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
			<div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
				<div class="arrow-left"></div>
				<div class="arrow-right"></div>
			</div>
		</div>							
	</header>
