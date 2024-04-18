<?php
     include_once('hospital/include/config.php');
     if(isset($_POST['submit']))
     {
        $userName = $_POST['FullName'];
        $userEmail = $_POST['Email'];
        $userMobile = $_POST['Mobile'];
        $userDescription = $_POST['Description'];

        $addCon = mysqli_query($deal,"INSERT INTO contact(FullName, Email, Mobile, Decription)
                                           VALUE('$userName','$userEmail','$userMobile','$userDescript')");
        echo '<script>alert("your information successfully submited");</script>';
        echo '<script>widow.location.href ="index.php"</script>';
     }
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta name="viewport" content="">
    <title>Medical Management System</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css "/>
<body>
    <!-- header -->
    <header id="menu-mms">
        <div id="nav-head" class="header-nav">
             <div class="container">
                   <div class="row">
                         <div class="" style="">Medical
                               <a href="#menu"><i class=""></i></a>
                         </div>
                         <div id="menu" class="">
                               <ul>
                                    <li><a href="">Home</a></li>
                                    <li><a hef="#service">Service</a></li>
                                    <li><a href="#aboutUS">About Us</a></li>
                                    <li><a href="#gallery">Department</a></li>
                                    <li><a href="#contactUs">Contact</a></li>
                                    <li><a href="#logins">Logins</a></li>
                               </ul>
                         </div>
                         <div class="">
                               <a href="hospital/patient/userLogin.php" class="">Book an Appointment</a>
                         </div>
                   </div>
             </div>         
        </div>
    </header>
    <!-- end header -->
    <div class="slider-detail">
          <div id="carouselIndicator" class="" data-ride="">
                <ol class="carousel-indicator">
                     <li data-target="#carouselIndicator" data-slide-to ="0" class="active"></li>
                     <li data-target="#carouselIndicator" data-slide-to="1"></li>
                </ol>
                <!-- inner carousel -->
                <div class="carousel-inner">
                     <div class="carousel-item">
                          <img class="" src="" alt="second slide">
                          <div class="carousel-cover"></div>
                          <div class="">
                               <h5 class="">Medical Management system<h5>
                          </div>     
                     </div>
                     <!-- carousel - active -->
                     <div class="carousel-item active">
                           <img class="" src="" alt="Third slide">
                           <div class="carousel-cover"></div>
                           <div class="">
                                <h5 class="">Medical Management System</h5>
                           </div>
                     </div>
                </div>
                <a href="#carouselIndicator" role="button" class="" data-slide="prev">
                     <span class="" aria-hidden="true"></span>
                     <span class="">Previous</span>
                </a>
                <a href="#carouselIndicator" role="" class=""  data-slide="next">
                     <span class="" aria-hidden="true"></span>
                     <span class="">Next</span>
                </a>
          </div>
    </div>
    <!-- logins -->
    <section id="login" class="">
           <div class="container">
                 <div class="inner-title">
                      <h2>Login</h2>
                 </div>
                 <div class="col-sm-12 blog-cont">
                       <div class="row no-margin">
                             <div class="col-sm-4 blog-smk">
                                   <div class="blog-single">
                                         <img src="assets/images/patient.jpg" alt="">
                                         <div class="blog-single-det">
                                              <h6>Patient Login</h6>
                                              <a href="hospital/patient/userLogin.php" target="_blank">
                                                  <button class="btn btn-success btn-sm">Click Here</button>
                                              </a>
                                         </div>
                                   </div>
                             </div>
                             <div class="col-sm-4 blog-smk">
                                   <div class="blog-single">
                                         <img src="assets/images/doctor.jpg" alt="">
                                         <div class="blog-single-det">
                                               <h6>Doctors Login</h6>
                                               <a href="hospital/doctor" target="_blank">
                                                   <button class="btn btn-success btn-sm">Click Here</button>
                                               </a>
                                         </div>
                                   </div>
                             </div>
                             <div class="col-sm-4 blog-smk">
                                   <div class="blog-single">
                                        <img src="assets/images/admin.jpg" alt="">
                                        <div class="blog-single-det">
                                              <h6>Admin Login</h6>
                                              <a href="hospital/admin" target="_blank">
                                                  <button class="btn btn-success btn-sm">Click Here</button>
                                              </a>
                                        </div>
                                   </div>
                             </div>                             
                       </div>
                 </div>
           </div>
      </section>
      <!-- About Us -->
      <section id="aboutUs" class="">
            <div class="row no-margin">
                  <div class="col-sm-6 image-bg no-padding"></div>
                  <div class="col-sm-6 about-us">
                        <h3>About Our Hospital</h3>
                        <?php 
                              $qPage=mysqli_query($db_handle,"SELECT * FROM tblpage WHERE pageType = 'aboutus' ");
                              while($resultset=myqli_fetch_array($qPage))
                              {
                        ?>
                              <p><?php echo $resultset['PageDescription'];?>.</p>
                  <?php      } ?>
                  </div>                  
            </div>
      </section>
      <!-- end about us -->     
      <section id="contactUs" class="">
            <div class="row no-margin">
                  <div class="col-sm-12 cop-ck">
                        <form method="post">
                              <h2>Contact Form</h2>
                              <div class="row cf-ro">
                                    <div class="col-sm-3">
                                         <label>Enter Name:</label>
                                    </div>
                                    <div class="col-sm-8">
                                          <input name="FullName" type="text" class="" placeholder="Enter Name" required>
                                    </div>
                              </div>
                              <div class="row cf-ro">
                                    <div class="col-sm-3">
                                         <label>Email Address: </label>
                                    </div>
                                    <div class="col-sm-8">
                                         <input name="Email" type="text" class="" placeholder="Enter Email Address" required>
                                    </div>
                              </div>
                              <div class="row cf-ro">
                                    <div class="col-sm-3">
                                          <label>Mobile Nubmer:</label>
                                    </div>
                                    <div class="col-sm-8">
                                          <input name="Mobile" type="text" placeholder="Enter Mobile Number" class="" required>
                                    </div>
                              </div>
                              <div class="row cf-ro">
                                    <div class="col-sm-3"><label><label></div>
                                    <div class="col-sm-8">
                                          <button name="submit" type="submit" class="btn btn-success btn-sm"></button>
                                    </div>
                              </div>
                        </form>
                  </div>
            </div>
      </section>
      <!-- end section contact -->
      <footer class="footer">
            <div class="container">
                  <div class="row">
                        <div class="col-md-6 col-sm-12">
                              <h2>Useful Links</h2>
                              <ul class="list-unstyled link-list">
                                   <li><a href="#about" ui-sref="about">About us</a><i class="fa fa-angle-right"></i></li>
                                   <li><a href="#services" ui-sref="portfolio">Services</a><i class="fa fa-angle-right"></i></li>
                                   <li><a href="#logins" ui-sref="products">Logins</a><i class="fa fa-angle-right"></i></li>
                                   <li><a href="#gallery" ui-sref="gallery">Gallery</a><i class="fa fa-angle-right"></i></li>
                                   <li><a href="#contact" ui-sref="contact">Contact</a><i class="fa fa-angle-right"></i></li>
                              </ul>
                        </div>
                        <div class="col-md-6 col-sm-12 map-img">
                              <h2>Contact Us</h2>
                              <address class="md-margin-bottom-40">
                                    <?php 
                                         $qPage=mysqli_query($db_handle,"SELECT * FROM tblpage WHERE pageType='contactus' ");
                                         while($resultpage=mysqli_fetch_array($qPage))
                                         {
                                    ?>
                                         <?php echo $resultpage['pageDescription'];?><br>
                                              Phone: <?php echo $resultpage['mobileNumber'];?><br>
                                              Email:<a href="mailto:<?php echo $resultpage['Email'];?>" class="">
                                                                    <?php echo $resultpage['Email'];?></a><br>
                                              Timing: <?php echo $resultpage['openningTime'];?>                                         
                              </address>
                                    <?php } ?>
                        </div>
                  </div>
            </div>
      </footer>
      <!-- end footer -->
      <div class="copy">
            <div class="container">Midical Management System</div>
      </div>
</body>
<!-- javascript -->
<!-- custom javascript -->
     <script src="assets/js/script.js"></script>
</html>
