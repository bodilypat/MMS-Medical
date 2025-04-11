<?php 
    error_reporting(E_ALL); /* enable error reporting for development */
    include('../include/dbconnect.php'); /* Include the DB connection */

    /* Fetch user data securely */
    $qUser = mysqli_prepare($deal,"SELECT fullName FROM users WHERE = ? ");
    mysqli_stmt_bind_param($qUser,'i', $_SESSION['id']) /* bind parameter */
    mysqli_stmt_execute($qUser);
    mysqli_stmt_bind_result($qUser, $fullName);
    mysqli_stmt_fetch($qUser);
    mysqli_stmt_close($qUser);

    /* Default name if no fullName is found */
    if(!$fullName) {
        $fullName = "Guest"; /* fallback to "Guest, if no user fund */
    }
?>
<header class="navbar navbar-default navbar-static-top">
    <!-- NAVBAR HEADER -->
    <div class="navbar-header">
        <a href="#" class="sidebar-mobile-togger pull-left hidden-md hidden-lg"
                    data-toggle-class="app-slide-off"
                    data-toggle-target="#app"
                    data-toggle-click-outside="#sidebar">
            <i class="ti-align-justify"></i>
        </a>

        <!-- MMS Branding -->
        <a class="navbar-brand" href="#">
            <h2 class="mms-brand-title">MMS</h2>
        </a>

        <!-- Desktop Sidebar Toggle -->
        <a href="#" class="sidebar-toggler pull-right visible-lg" data-toggle-class="app-sidebar-close" data-toggle-target="#app">
            <i class="ti-align-justify"></i>
        </a>

        <!-- Mobile Menu Toggle -->
        <a href="#navbar-collapse" id="menu-toggle" class="pull-right menu-toggler visible-xs-block"  data-toggle="collapse" >
            <span class="sr-only">Toggle Navigation"</span>
            <i class="ti-view-grid"></i>
        </a>
    </div>

    <!-- Nabar collapse -->
    <div class="navbar-collapse" id="navbar_collapse">
        
        <ul class="nav navbar-right">
            <li class="navbar-text" style="padding-top:2%">
                <h2>Medical Management System</h2>
            </li>

            <!-- User Dropdown -->
            <li class="dropdown current-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expand="false">
                    <img src="assets/images/admin.jpg" alt="Admin Profile" class="user-img">
                    <span class="username"><?php echo htmlspecialchars($fullName); ?><i class="ti-angle-down"></i></span>
                </a>
                <ul class="dropdown-menu dropdown-dark">
                    <li><a href="editProfile.php">My Profile</a></li>
                    <li><a href="changePassword.php">Change Password</a></li>
                    <li><a href="logout.php">Logout.php</a></li>
                </ul>
            </li>
        </ul>

        <!-- Mobile Navigation Close Handle -->
        <div class="close-handle visible-xs-block menu-toggle" data-toggle="collapse" href="#navbar-collapse" aria-label="Close Menu">
            <div class="arrow-left"></div>
            <div class="arrow-right"></div>
        </div>
    </div>
</header>
<style>
<!-- Additional styles for better spacing and readability -->
.mms-bran-title {
    font-size: 24px;
    font-weight: bold;
}   
.mms-navbar-text {
    font-size: 18px;
}
.user-img {
    border-radius: 50%;
    width: 30px;
}
.navbar-text h2 {
    margin: 0;
}
</style>