<?php
    include_once('../define/config.php');
    if(isset($_POST['submit'])){
        $userName = $_POST['fullname'];
        $userAdd = $_POST['address'];
        $userCity = $_POST['city'];
        $userGen = $_POST['gender'];
        $userEmail = $_POST['email'];
        $userPass = $_POST['password'];

        $qUser = myqli_query($deal,"INSERT INTO users(fullname, address, city, gender, email, password)
                                    VALUES('$userName','$userAdd','$userCity','$userGen','$userEmail','$userPass') ");
        if($qUser){
            echo "<script>alert('successfully registered. you can login now');</script>";
        }
    }
?>
<script type="text/javascript">
    function valid()
    {
        if(document.registration.password.value != document.registration.cfpassword.value)
        {
            alert('Password and confirm filed do not match !! ');
            document.registration.cfpassword.focus();
            return false;
        }
        return true;
    }
</script>
<!-- registration box -->
<body class="login">
     <div class="row">
           <div class="main-login">
                 <div class="logo margin-top-30"><a href="../index.php"></h2>MMS | Patient Registration</h2></a></div>
           </div>
           <!-- start: register box -->
           <div class="box-register">
                 <form mame="registration" id="registration" method="post" onSubmit="return valid(); ">
                       <fieldset>
                             <legend>Sign Up</legend>
                             <p>Enter Password</p>
                             <div class="form-group">
                                  <input name="fullname" type="text" class="form-control" placeholder="Full Name" required>
                             </div>
                             <div class="form-group">
                                   <input name="address" type="text" class="form-control" placeholder="Address" required>
                             </div>
                             <div class="form-group">
                                   <input name="city" type="text" class="form-control" placeholder="ciry" required>
                             </div>
                             <div class="form-group">
                                   <label class="block">Gendor</label>
                                   <div class="clip-radio radio-primary">
                                         <input name="gender" id="female" type="text" value="female">
                                         <label for="Female">Female</label>
                                         <input name="gender" id="male" type="radio" value="male">
                                         <label for="Male"></label>
                                   </div>
                             </div>
                             <p>Enter your account detail below:</p>
                             <div class="form-group">
                                   <span class="input-icon">
                                         <input name="email" id="email" type="email" class="form-control" onBlur="userAvailability()" placeholder="Email" required>
                                         <i  class="fa fa-envelope"></i>
                                   </span>
                                   <span id="user-availability-status" style="font-size:12px;"></span>
                             </div>
                             <div class="form-group">
                                  <span class="form-group">
                                        <input name="password" id="password" type="password" class="form-control"
                                               placeholder="Password" required>
                                  </span>
                             </div>
                             <div class="form-group">
                                   <span class="input-icon">
                                         <input name="cfpassword" id="cfpassword" type="password" placeholder="Confirm Password" required>
                                         <i class="fa fa-lock"></i>
                                   </span>
                             </div>
                             <div class="form-group">
                                   <div class="checkbox clip-check check-primary">
                                         <input id="agree" value="agree" checked="true" type="password" placeholder="Password Again" required>
                                         <label for="Agree">I agree</label>
                                   </div>
                             </div>
                             <div class="form-actions">
                                   <p>Already have an account?<a href="userLogin.php">Log-in</a></p>
                                   <button name="submit" id="submit" type="submit" class="btn btn-primary pull-right">
                                          Submit<i class="fa fa-arrow-circle-right"></i>
                                   </button>
                             </div>
                       </fieldset>
                 </form>
                 <div class="">
                       $copy;<span class="current-year"></span>
                       <span class="text-bold text-uppercase">MMS</span>
                       <span>All right reserved</span>
                 </div>
           </div>
     </div>
     <!-- customer javascript  -->
     <script src="../assign/js/main.js"></script>
     <script src="../assign/js/login.js"></script>
     <script>
           jQuery(document).ready(function(){
                Main.init();
                Login.init();
           });
     </script>
     <script>
            function userAvailability(){
                  $('#loaderIcon').show();
                  jQuery.ajax({
                        url: "checkAvailability.php",
                        data: 'email=' +('#email').val(),
                        type: 'POST',
                        success: function(data){
                              $('#user-availability-status').html(data);
                              $('#loaderIcon').hide();
                        },
                        error:function(){}
                  });
            }
     </script>
</body>