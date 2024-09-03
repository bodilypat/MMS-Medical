<?php
    include_once('../define/config.php');
    if(isset($_POST['submit']))
    {
        $userName=$_POST['fullname'];
        $userAddress=$_POST['address'];
        $userCity=$_POST['city'];
        $userGender=$_POST['gender'];
        $userEmail=$_POST['email'];
        $userPass=$_POST['password'];

        $addUser=mysqli_query("INSERT INTO users(fullname, address, city, gender, email, password)
                               VALUES('$userName','$userAddress','$userCity','$userGender','$userEmail','$userPass')");
        if($addUser) {
            echo "<script>alert('Successfully Registered. you can login now');</script>";
        }
    }
?>
<!-- body: login -->
<body class="login">
     <div class="row">
            <div class="logo"><img src="assign/images/logo.png" alt="clip-two" /></div>
            <!-- register box -->
            <div class="box-register">
                  <form name="registration" id="registration" method="post">
                         <fieldset>
                                 <legend>Sign Up</legend>
                                 <p>Enter your personal details below: </p>
                                 <div class="form-group">
                                       <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
                                 </div>
                                 <div class="form-group">
                                       <input type="text" class="form-control" name="address" placeholder="Address" required>
                                 </div>
                                 <div class="form-group">
                                       <input type="text" class="form-control" name="city" placeholder="City" requried>
                                 </div>
                                 <div class="form-control">
                                       <label class="block">Gender</label>
                                       <div class="clip-radio radio-primary">
                                             <input type="radio" id="rg-female" name="gender" value="female">
                                             <label for="rg-female">Female</label>

                                             <input type="radio" id="rg-male" name="gender" value="male">
                                             <label for="rg-male">Male</label>
                                       </div>
                                 </div>
                                 <p>Enter your account details :</p>
                                 <div class="form-group">
                                       <span class="input-icon">
                                              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                              <i class="fa fa-lock"></i>
                                       </span>
                                 </div>
                                 <div class="form-group">
                                       <div class="checkbox clip-check check-primary">
                                             <input type="checkbox" id="agree" value="agree">
                                             <label for ="agree">I agree</label>
                                       </div>
                                 </div>
                                 <div class="form-actions">
                                       <p>Already have an account?
                                            <a href="userLogin.php">Log-in</a>
                                       </p>
                                       <button type="submit" class="btn btn-primary pull-right" id="submit" name="submit">
                                             Submit<i class="fa fa-arrow-circle-right"></i>
                                       </button>
                                 </div>
                         </fieldset>
                  </form>
                  <div class="">
                        <span class="current-year"></span>
                        <span class="text-bold text-uppercase">Medical Management System</span>
                  </div>
            </div>
     </div>
    <script src="../assign/js/main.js"></script>
    <script src="../assing/js/login.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            Login.init();
        });
    </script>
    <script>
        function userAvailability()
        {
            $('#loaderIcon').show();
            jQuery.ajax({
                url : 'checkAvailability.php',
                date: 'email='+("#email").val(),
                type : "POST",
                success: function(data){
                    $("#user-availability-status").html(data);
                    $('#loaderIcon').hide();
                },
                error:function () {}
            });
        }
    </script>
</body>