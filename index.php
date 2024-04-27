<?php
    include_once('define/config.php');
    if(isset($_POST['submit']))
    {
        $userName = $_POST['fullname'];
        $userEmail = $_POST['email'];
        $userContact = $_POST['contactno'];
        $userDescript = $_POST['description'];
        $qCon=mysqli_query($dbcon,"INSERT INTO contact(fullName, email, contactno, message)
                                  VALUES('$username','$userEmail','$userContact','$userDescript')");
            echo '<script>alert(" Your information successfully submitted");</script>';
            echo '<script>window.location.href="index.php"</script>';
    }
?>
<!DOCTYPE html>
<html len="en">
    <head>
        <!-- custom css -->
        <link rel="stylesheet" type="text/css" href="assign/css/style.css" />
    </head>
<body>
    <header id="menu-mms">
        <div class="container">
              <div class="row">
                    <div>MMS</div>
                    <div id="menu" class="">
                          <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#Service">Service</a></li>
                                <li><a href="#aboutUs">About Us</a></li>
                                <li><a href="#gallery">Gallery</a></li>
                                <li><a href="#contactUs">Contact Us</a></li>
                                <li><a href="#logins">Logins</a></li>
                          </ul>
                    </div>
                    <div id="appointment" class="">
                         <a href="patient/userLog.php" class="btn btn-success">Book an Appointment</a>
                    </div>
              </div>
        </div>
    </header>
    <!-- slider start -->
    <div class="slider-detail">
          <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicator">
                     <li></li>
                     <li></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item">
                        <img src="" alt="Third slide">
                        <div class="carousel-cover">
                            <div class="carousel-caption">
                                <h5 class="">Medical Management System</h5>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active">
                        <img src="" class="" alt="">
                        <div class="carousel-cover"></div>
                        <div class="">
                            <h5 class="">Medical Management System</h5>
                        </div>
                    </div>
                </div>
                <a href="#carouselIndicators" class="" role="button" data-slide="prev">
                    <span class="" aria-hidden="true"></span>
                    <span class="">Previous</span>
                </a>  
                <a href="#carouselIndicators" role="button" data-slide="next">
                    <span class="" aria-hidden="true"></span>
                    <span class="">Next</span>
                </a>
          </div>
    </div>
    <!-- section: login -->
    <section id="logins" class="">
        <div class="container">
            <div class="inner-title">
                <h2>Logins</h2>
            </div>
            <div class="">
                  <div class="row no-margin">
                        <div class="col-sm-4 blog-smk">
                              <div class="blog-single">
                                    <img src="images/patient.jpg" alt="">
                                    <div class="">
                                          <h6>Patient Login</h6>
                                          <a href="patient/userLogin.php" target="_blank">
                                               <button class="">Click Here</button>
                                          </a>
                                    </div>
                              </div>
                        </div>
                        <div class="col-sm-4 blog-smk">
                              <div class="blog-single">
                                    <img src="images/doctor.jpg" alt="">
                                    <div class="blog-single-det">
                                          <a href="doctor" target="_blank">
                                               <button class="" >Click Here</button>
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
                                               <button clas="">Click Here</button>
                                          </a>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
        </div>
    </section>
    <!-- section: department  -->
    <section id="services" class="">
        <div class="container">
              <div class="inner-title">
                     <h2>Our Service</h2>
                     <p>Take a look at some of our Service</p>
              </div>
              <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-key">
                              <i class=""></i>
                              <h5>Cardiology</h5>
                        </div>
                    </div>              
                    <div class="col-lg-4 col-md-6">
                        <div class="single-key">
                              <i class=""></i>
                              <h5>Orthopaedic</h5>
                        </div>
                    </div>              
                    <div class="col-lg-4 col-md-6">
                          <div class="single-key">
                                <i class=""></i>
                                <h5>Neurologist</h5>
                          </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                          <div class="sigle-key">
                                <i class=""></i>
                                <h5>Pharma Pipeline</h5>
                          </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                          <div class="single-key">
                                <i class=""></i>
                                <h5>Pharma Team</h5>
                          </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                          <div class="single-key">
                                <i class=""></i>
                                <h5>High Quality treatment</h5>
                          </div>
                    </div>
              </div>
        </div>
    </section>
    <!-- section: about us -->
    <section id="about_us" class="about_us">
        <div class="row no-margin">
              <div class="col-sm-6 image-bg no-padding"></div>
              <div class="col-sm-6 about-us">
                    <h3>About Our Hospital</h3>
                    <?php
                        $qPage=mysqli_query($dbcon,"SELECT * FROM tblpage WHERE pageType='aboutus' ");
                        while($result=mysqli_fetch_array($qPage))
                        {
                    ?>
                    <p><?php echo $result['pageDescription'];?></p>
                    <?php  } ?>
              </div>
        </div>
    </section>
    <!-- section : Gallery  -->
    <section>
        <div id="gallery" class="gallery">
              <div class="container">
                    <div class="inner-title">
                          <h2>Gallery</h2>
                          <p>Our Gallery</p>
                    </div>
                    <div class="row">
                          <div class="">
                                <button></button>
                                <button></button>
                                <button></button>
                                <button></button>
                                <button></button>
                          </div>
                          </br>
                          <div class="">
                                <img src="" class="img-responsive">
                          </div>
                          <div class="">
                                <img src="" class="img-responsive">
                          </div>
                          <div class="">
                                <img src="" class="img-responsive">
                          </div>
                          <div class="">
                                <img src="" class="img-responsive">
                          </div>
                          <div class="">
                                <img src="" class="img-responsive">
                          </div>
                          <div class="">
                                <img src="" class="img-responsive">
                          </div>
                    </div>
              </div>
        </div>
    </section>
    <!-- section: contact us -->
    <section id="contact-us" class="">
         <div class="row no-margin">
               <div class="col-sm-12 cop-ck">
                     <form method="post">
                            <h2>Contact Form</h2>
                            <div class="row">
                                  <div class="col-sm-3"><label>Enter Name :</label></div>
                                  <div class="col-sm-8">
                                        <input name="fullname" type="text" class="form-control input-sm" placeholder="Name" require>
                                  </div>
                            </div>
                            <div class="row">
                                   <div class="col-sm-3"><label>Email Address :</label></div>
                                   <div class="col-sm-8">
                                         <input name="email" type="text" class="form-control input-sm" placeholder="Email Address" required>
                                   </div>
                            </div>
                            <div class="row">
                                   <div class="col-sm-3"><label>Mobile Number :</label></div>
                                   <div class="col-sm-8">
                                         <input name="contactno" type="text" class="form-control input-sm" placeholder="Mobile Number" required>
                                   </div>
                            </div>
                            <div class="row">
                                  <div class="col-sm-3"><label>Enter Message</label></div>
                                  <div class="col-sm-8">
                                        <textarea name="description" row="5" placeholder="Your Message" class="form-control input-sm" required></textarea>
                                  </div>
                            </div>
                            <div class="row cf-ro">
                                  <div class="col-sm-3"></div>
                                  <button name="submit" type="submit" class="btn btn-success btn-sm" >Send Message</button>
                            </div>
                     </form>
               </div>
         </div>
    </section>
    <!-- section: footer -->
    <footer class="footer">
            <div class="container">
				  <div class="row">
					    <div class="col-md-6 col-sm-12">
							  <h2>Useful links</h2>
							  <ul>
								   <li></li>
								   <li></li>
								   <li></li>
								   <li></li>
								   <li></li>
							  </ul>
						</div>
						<div class="col-md-6 col-sm-12 map-img">
							  <h2>Contact Us</h2>
							  <address class="md-margin-bottom-40">
									<?php 
									      $qCon=mysqli_query($dbcon,"SELECT * FROM tblpage WHERE pageType='contactus' ");
										  while ($result=mysqli_fetch_array($qCon))
										  {
									?>
										<?php echo $result['pageDescription']; ?><br>
											Phone : <?php echo $result['mobile'];?><br>
											Email: <a href="mailto:<?php echo $result['email'];?>" class=""><?php echo $result['email'];?></a><br>
											Timming: <?php echo $result['openingTime'];?>										  
							  </address>
							  <?php } ?>
						</div>
				  </div>
			</div>
    </footer>
</body>
</html>