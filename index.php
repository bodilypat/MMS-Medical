<?php
	include_once('define/config.php');
	if(isset($_POST['submit']))
	{
			$userName=$_POST['fullname'];
			$userEmail=$_POST['emailid'];
			$userMobile=$_POST['mobileno'];
			$decription=$_POST['description'];
			
			$sql=mysqli_query($con,"INSERT INTO contactus(fullname,email,contactno,message) 
                                    values('$userName','$userEmail','$userMobile','$description')");
			echo "<script>alert('Your information succesfully submitted');</script>";
			echo "<script>window.location.href ='index.php'</script>";
} 
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Medical Management System </title>
 
    <link rel="stylesheet" type="text/css" href="describe/css/style.css" /> 
</head>
<body>
    <!-- header -->    
      <header id="menu-jk">
        <div id="nav-head" class="header-nav">
            <div class="container">
                <div class="row">
                    <div class="" style="">Hospital
                       <a href="#menu" data-toggle="collapse" data-target="#menu"  >
                            <i class="fas d-block d-md-none small-menu fa-bars"></i>
                        </a>
                    </div>
                    <div id="menu" class="">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#about_us">About Us</a></li>
                            <li><a href="#gallery">Department</a></li>
                            <li><a href="#contact_us">Contact Us</a></li>
                            <li><a href="#logins">Logins</a></li>  
                        </ul>
                    </div>
                    <div class="col-sm-2 d-none d-lg-block appoint">
                        <a class="btn btn-success" href="patient/user-login.php">Book an Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- slide -->
    <div class="slider-detail">
        <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselIndicators" data-slide-to="1"></li>
            </ol>
            <!-- carousel-inner -->
            <div class="carousel-inner">
                <div class="carousel-item ">
                    <img class="d-block w-100" src="images/slider/slider_2.jpg" alt="Second slide">
                    <div class="carousel-cover"></div>
                    <div class="carousel-caption vdg-cur d-none d-md-block">
                        <h5 class="animated bounceInDown">Medical Management System</h5>                   
                    </div>
                </div>
				<!-- carousel-active -->      
                <div class="carousel-item active">
                    <img class="d-block w-100" src="images/slider/slider_3.jpg" alt="Third slide">
                    <div class="carousel-cover"></div>
                    <div class="carousel-caption vdg-cur d-none d-md-block">
                        <h5 class="animated bounceInDown">Medical Management System</h5>                  
                    </div>            
                </div>         
            </div>
            <a href="#carouselIndicators" class="carousel-control-prev"  role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a href="#carouselIndicators" class="carousel-control-next"  role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
  <!-- section: Logins -->
    <section id="logins" class="our-blog container-fluid">
        <div class="container">
        <div class="inner-title">
                <h2>Logins</h2>
        </div>
            <div class="col-sm-12 blog-cont">
                <div class="row no-margin">
                    <div class="col-sm-4 blog-smk">
                        <div class="blog-single">
                                <img src="/images/patient.jpg" alt="">
                            <div class="blog-single-det">
                                <h6>Patient Login</h6>
                                <a href="patient/user-login.php" target="_blank">
                                    <button class="btn btn-success btn-sm">Click Here</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 blog-smk">
                        <div class="blog-single">
                                <img src="images/doctor.jpg" alt="">
                            <div class="blog-single-det">
                                <h6>Doctors login</h6>
                                <a href="doctor" target="_blank">
                                    <button class="btn btn-success btn-sm">Click Here</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 blog-smk">
                        <div class="blog-single">
                                <img src="images/admin.jpg" alt="">
                            <div class="blog-single-det">
                                <h6>Admin Login</h6>
                                <a href="admin" target="_blank">
                                    <button class="btn btn-success btn-sm">Click Here</button>
                                </a>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </section>  
    <!-- section:about us -->
    <section id="about_us" class="about-us">
        <div class="row no-margin">
            <div class="col-sm-6 image-bg no-padding"></div>
            <div class="col-sm-6 abut-yoiu">
                <h3>About Our Hospital</h3>
                    <?php
                        /* query page from DB */
                         $qPage=mysqli_query($deal,"SELECT * FROM tblpage WHERE PageType='aboutus' ");
                         while ($result=mysqli_fetch_array($qPage)) 
                         {
                    ?>

                 <p><?php  echo $result['PageDescription'];?>.</p>
                       <?php } ?>
            </div>
        </div>
    </section>    
    <!-- service -->                        
    <div id="gallery" class="gallery">    
        <div class="container">
            <div class="inner-title">
                <h2>Our Departments</h2>
                <p>View Departments</p>
            </div>
            <div class="row">
                <div class="gallery-filter d-none d-sm-block">
                    <button class="btn btn-default filter-button" data-filter="all">Radiology</button>
                    <button class="btn btn-default filter-button" data-filter="hdpe">Cardiolog</button>
                    <button class="btn btn-default filter-button" data-filter="sprinkle">Neurology</button>
                    <button class="btn btn-default filter-button" data-filter="spray">Pathology</button>
                    <button class="btn btn-default filter-button" data-filter="irrigation">Orthopedic</button>
                    <button class="btn btn-default filter-button" data-filter="irrigation">Anesthesiology</button>
                    <button class="btn btn-default filter-button" data-filter="irrigation">Intensive care medicine</button>
                    <button class="btn btn-default filter-button" data-filter="irrigation">Emergency medicine </button>
                </div>
                <br/>
                <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
                    <img src="assets/images/gallery/gallery_01.jpg" class="img-responsive">
                </div>

                <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter sprinkle">
                    <img src="assets/images/gallery/gallery_02.jpg" class="img-responsive">
                </div>

                <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe">
                    <img src="assets/images/gallery/gallery_03.jpg" class="img-responsive">
                </div>

                <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter irrigation">
                    <img src="assets/images/gallery/gallery_04.jpg" class="img-responsive">
                </div>

                <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray">
                    <img src="assets/images/gallery/gallery_05.jpg" class="img-responsive">
                </div>

                <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter spray">
                    <img src="assets/images/gallery/gallery_06.jpg" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
    <!-- section: contact us -->    
    <section id="contact_us" class="contact-us-single">
        <div class="row no-margin">
            <div  class="col-sm-12 cop-ck">
                <form method="post">
                    <h2 >Contact Form</h2>
                    <div class="row cf-ro">
                        <div  class="col-sm-3"><label>Enter Name :</label></div>
                        <div class="col-sm-8">
                            <input type="text" placeholder="Enter Name" name="fullname" class="form-control input-sm" required >
                        </div>
                    </div>
                    <div  class="row cf-ro">
                        <div  class="col-sm-3"><label>Email Address :</label></div>
                        <div class="col-sm-8">
                            <input type="text" name="emailid" placeholder="Enter Email Address" class="form-control input-sm"  required>
                        </div>
                    </div>
                     <div  class="row cf-ro">
                        <div  class="col-sm-3"><label>Mobile Number:</label></div>
                        <div class="col-sm-8">
                            <input type="text" name="mobileno" placeholder="Enter Mobile Number" class="form-control input-sm" required >
                        </div>
                    </div>
                     <div  class="row cf-ro">
                        <div  class="col-sm-3"><label>Enter  Message:</label></div>
                        <div class="col-sm-8">
                          <textarea name="description" rows="5" placeholder="Your Message" class="form-control input-sm"  required></textarea>
                        </div>
                    </div>
                     <div  class="row cf-ro">
                        <div class="col-sm-8">
                            <button name="submit" class="btn btn-success btn-sm" type="submit">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h2>Useful Links</h2>
                    <ul class="list-unstyled link-list">
                        <li><a ui-sref="about" href="#about">About us</a><i class="fa fa-angle-right"></i></li>
                        <li><a ui-sref="portfolio" href="#services">Services</a><i class="fa fa-angle-right"></i></li>
                        <li><a ui-sref="products" href="#logins">Logins</a><i class="fa fa-angle-right"></i></li>
                        <li><a ui-sref="gallery" href="#gallery">Gallery</a><i class="fa fa-angle-right"></i></li>
                        <li><a ui-sref="contact" href="#contact">Contact us</a><i class="fa fa-angle-right"></i></li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 map-img">
                    <h2>Contact Us</h2>
                    <address class="md-margin-bottom-40">

                        <?php
                            $qPage=mysqli_query($deal,"SELECT * FROM tblpage WHERE PageType='contactus' ");
                            while ($result=mysqli_fetch_array($qPage)) 
                        {
                        ?>
                             <?php  echo $result['PageDescription'];?> <br>
                              Phone: <?php  echo $result['MobileNumber'];?> <br>
                              Email: <a href="mailto:<?php  echo $result['Email'];?>" class="">
                                                     <?php  echo $result['Email'];?></a><br>
                              Timing: <?php  echo $result['OpenningTime'];?>
                    </address>
                        <?php } ?>
                </div>
            </div>
        </div>
    </footer>
    <div class="copy">
        <div class="container">Hospital Management System</div>
    </div>
</body>
<!-- javascript -->
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/plugins/scroll-nav/js/jquery.easing.min.js"></script>
<script src="assets/plugins/scroll-nav/js/scrolling-nav.js"></script>
<script src="assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js"></script>
<!-- custom:js -->
<script src="assets/js/script.js"></script>
</html>