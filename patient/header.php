<?php error_reporting(0); ?>
<header>
    <!-- NAVBAR HEADER -->
    <div class="navbar-header">
        <a href="#" class="sidebar-mobile-togger pull-left hidden-md hidden-lg"
                    class="btn btn-navbar sidebar-toggle"
                    data-toggle-class="app-side-off"
                    data-toggle-click-outside="#sidebar">
            <i class="ti-align-justify"></i>
        </a>
        <a>
            <h2 style="padding-top:20%; color:#000 ">MMS</h2>
        </a>
        <a href="#" class="sidebar-toggler pull-right visible-lg" data-toggle-class="app-sidebar-close" data-toggle-target="#app">
            <i class="ti-align-justify"></i>
        </a>
        <a href=".navbar-collapse" id="menu-toggle" class="pull-right menu-toggler visible-xs-block"  data-toggle="collapse" >
            <span class="sr-only">Toggle Navigation"</span>
            <i class="ti-view-grid"></i>
        </a>
    </div>

    <!-- NAVBAR COLLAPSE -->
    <div class="navbar-collapse collapse">
        
        <ul class="nav navbar-right">
            <li style="padding-top:2%"><h2>Medical Management System</h2></li>
            <li class="dropdown current-user">
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <img src="assets/images/admin.jpg">
                    <span class="username">Admin<i class="ti-angle-down"></i></span>
                </a>
                <ul class="dropdown-menu dropdown-dark">
                    <li><a href="change-password.php">Change Password</a></li>
                    <li><a href="logout.php">Logout.php</a></li>
                </ul>
            </li>
        </ul>

        <div class="close-handle visible-xs-block menu-toggle" data-toggle="collapse" href=".navbar-collapse">
            <div class="arrow-left"></div>
            <div class="arrow-right"></div>
        </div>
    </div>
</header>