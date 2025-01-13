<?php
    include_once('medical/include/config.php');
    if(isset($_POST['submit']))
    {
        $userName = $_POST['fullname'];
        $userEmail = $_POST['emailid'];
        $userMobile = $_POST['mobileno'];
        $userDescription = $_POST['description']; 

        /* Using prepared statement to prevent SQL injection  */
        $stmt = $deal->prepare("INSERT INTO tblcontactus (fullname, email, contactno, message) VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("ssss", $username, $userEmail, $userMobile, $userDescription);

        if($state->execute()) {
            /* Success , redirect to homepage */
            echo "<script>alert('Your information was successful submitted');<script>";
            echo "<script>Window.location.href ='index.php';</script>";
        } else {
            /* Error in execution */
            echo "<script>alert('There was an error submitting your information.');<script>";
        }
        $stmt->close();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    </head>
    <body>
        <header id="menu-mms">
            <div id="nav-head" class="nav-header">
                <div class="row">
                    <div>
                         Medical
                         <a data-toggle="collapse" data-target="#menu" href="#menu">
                            <i class="d-block d-md-none small-menu fa-bars"></i>
                         </a>
                    </div>
                    <div id="menu" class="d-none d-md-block nav-item">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#clinics">Clinics</a></li>
                            <li><a href="#about_us">Abount Us</a></li>
                            <li><a href="#contact_us">Contact Us</a></li>
                            <li><a href="#logins">Logins</a></li>
                        </ul>
                        <div class="appointment">
                            <a class="btn btn-success" href="medical/userLogin.php">Book an Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- slider starts  -->
        <div class="slider-detail">
            <div id="carouselndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicator">
                    <li data-target="#carouselIndicator" data-slide-to="0"></li>
                    <li data-target="#carouselIndicator" data-slide-to="1"></li>
                </ol>
                <!-- carousel inner -->
                <div class="carousel-inner">
                    <div class="carousel-item">
                        <img class="d-block w-100" src="assets/images/slider/sldier_2.jpg" alt="second slide">
                        <div class="carousel-cover"></div>
                        <div class="carousel-caption vdg-cur d-none d-md-block">
                            <h5 class="animated bounceInDown">Medical Manament System</h5>
                        </div>
                    </div>
                    <!-- carousel active -->
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="assets/images/slider/slider_3.jpg" alt="Third slide">
                        <div class="carousel-cover"></div>
                        <div class="carousel-caption vdg-cur d-none d-md-block"><h5 class="animated bounceInDown">Medical Management System</h5></div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="carouselIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <!-- Login -->
        <section id="logins" class="out-blog container">
            <div class="container">
                <div class="inner-title"><h2>Logins</h2></div>
                <div class="col-sm-12 blog-cont">
                    <div class="col-sm-4 blog-smk" >
                        <div class="blog-single">
                            <img src="assets/images/patient.jpg" alt="">
                            <div class="blog-single-det">
                                <h6>Patient Login</h6>
                                <a href="medical/patient/userLogin.php" target="_blank">
                                    <button class="btn btn-success btn-sm">Click Here</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 blog-smk">
                        <div class="blog-single">
                            <img src="assets/images/doctor.jpg" alt="">
                            <div class="blog-single-det">
                                <h6>Doctor login</h6>
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
                                <a href="medical/admin" target="_blank">
                                    <button class="btn btn-success btn-sm">Click Here</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Us -->
        <section id="aboutUs" class="about-us">
            <div class="row no-margin">
                <div class="col-sm-6 image-bg no-padding"></div>
                <div class="col-sm-6 about-us">
                    <h3>About Medical</h3>
                    <?php
                        $result = mysqli_query($deal,"SELECT * FROM tblpage WHERE pageType='aboutus' ");
                        while ($resultset = mysqli_fetch_array($result)) {
                    ?>
                        <p><?php echo $resultset['pageDescription'];?>.</p>
                    <?php  } ?>
                </div>
            </div>
        </section>
        <!-- Department -->
        <div id="Clinics" class="clinics-md">
            <div class="clinics-container">
                <div class="inner-title">
                    <h2>Our Clinics</h2>
                    <p>View Clinics</p>
                </div>
                <div class="row">
                    <div class="clinics-filer d-none d-sm-block">
                        <button class="btn btn-default filter-button" data-filter="all">Radiology</button>
                        <button class="btn btn-default filter-button" data-filter="hop">Cardiolog</button>
                        <button class="btn btn-default filter-button" data-filter="sprinkle">Neurolog</button>
                        <button class="btn btn-default filter-button" data-filter="spray">Pathology</button>
                        <button class="btn btn-default filter-button" data-filter="irrigation">Orthopedic</button>
                        <button class="btn btn-default filter-button" data-filter="hop">Anesthesiology</button>
                        <button class="btn btn-default filter-button" data-fitler="sprinkle">Intensive care medicine</button>
                        <button class="btn btn-default filter-button" data-filter="sprinkle">Emergency medicine</button>
                    </div>
                    <br/>
                    <div><img src="assets/images/clinics/clinic_01.jpg" class="img-responsive"></div>
                    <div><img src="assets/images/clinics/clinic_02.jpg" class="img-responsive"></div>
                    <div><img src="assets/images/clinics/clinic_03.jpg" class="img-responsive"></div>
                    <div><img src="assets/images/clinics/clinic_04.jpg" class="img-responsive"></div>
                    <div><img src="assets/images/clinics/clinic_05.jpg" class="img-responsive"></div>
                    <div><img src="assets/images/clinics/clinic_06.jpg" class="img-responsive"></div>
                </div>
            </div>
        </div>
        <!-- Contact Us -->
        <select id="contactUs" class="contact-us-single">
            <div class="row no-margin">
                <div class="col-sm-12 cop-ck">
                    <form method="post">
                        <h2>Contact Form</h2>
                        <div class="row">
                            <div class="col-sm-3"><label for="FullName"></label></div>
                            <div class="col-sm-8">
                                <input type="text" name="fullname" placeholder="Enter Name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label for="Email">Email Address :</label></div>
                            <div class="col-sm-8">
                                <input type="text" name="emailid"  placeholder="Enter Email Address" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label for="Phone">Phone Number: </label></div>
                            <div class="col-sm-8">
                                <input type="text" name="mobileno" placeholder="Enter Mobile Number" class="form-control" required >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label for="Message">Message: </label></div>
                            <div class="col-sm-8"><textarea row="rows" name="description" class="form-control" placeholder="Enter Your Message" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-8">
                                <button type="submit" name="submit" class="btn btn-success btn-sm">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </select>
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-ms-6 col-sm-12">
                        <h2>Useful Links</h2>
                        <ul class="link-list">
                            <li><a href="#about">About us</a><i class="angle-right"></i></li>
                            <li><a href="#clinics">Clinics</a><i class="angle-right"></i></li>
                            <li><a href="#logins">Logins</a><i class="angle-right"></i></li>
                            <li><a href="#Service">Gallery</a><i class="angle-right"></i></li>
                            <li><a href="#Contact">Contact Us</a><i class="angle-right"></i></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-12 map-img">
                        <h2>Contact Us</h2>
                        <address>
                            <?php
                                $result = mysqli_query($deal,"SELECT * FROM tblpage WHERE pageType='contact' ");
                                while ($resultset = mysqli_fetch_array($result)) {
                            ?>
                            <?php echo $resultset['pageDescription']; ?><br>
                                    Phone: <?php echo $resultset['mobileno']; ?><br>
                                    Email: <a href="mailto:<?php echo $resultset['email'];?>" class=""><?php echo $resultset['email'];?></a><br>
                                    Timing: <?php echo $resultset['openningTime']; ?>
                        </address>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end footer -->
    <div class="copy">
         <div class="container">Medical Management System</div>
    </div>
    </body>
    <script src="assets/js/script.js"></script>
</html>