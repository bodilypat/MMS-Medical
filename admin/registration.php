<?php
     include_once('../define/config.php');
     if(isset($_POST['SUBMIT']))
     {
        $userName=$_POST['fullname'];
        $userAdd=$_POST['address'];
        $userCity=$_POST['city'];
        $userGen=$_POST['gender'];
        $userPass=md5($_POST['password']);

        $aUser=mysqli_query("INSERT INTO users(fullname,address,city,genger,email,password)
                             VALUES('$userName','$userAdd','$userCity','$userGen','$userEmail','$userPass')");
        if($aUser)
        {
            echo "<script>alert('Successfully Registration. you can login now').</script>";
        }
     }
?>
<!-- javascript validation -->
	<script type="text/javascript">
		function valid() {
			if(document.registration.password.value != document.registration.cfpassword.value)
			{
				alert("Password and Confirm Password Field do not match !!");
				document.registration.cfpassword.focus();
				return false;
			}
			return turn;
		}
	</script>
<!-- register box -->
<body class="login">
      <div class="box-register">
            <form name="registration" id="registration" method="post">
                  <fieldset>
                        <legend>Sign Up</legend>
                        <p>Enter your data below: </p>
                        <div class="form-group">
                              <label>Full Name:</label>
                              <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" required>
                        </div>
                        <div class="form-group">
                              <label>Address:</labe>
                              <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                        </div>
                        <vid class="form-group">
                              <label>City:</label>
                              <input type="text" class="form-control" name="city" id="city" placeholder="City" required >
                        </div>
                        <div class="form-group">
                              <label>Gender:</label>
                              <div class="clip-radio radio-primary">
                                    <input type="radio" id="rg-female" name="gender" value="female" >
                                    <label for="rg-female">Female</label>                                    
                                    <input type="radio" id="rg-male" name="male" value="male">
                                    <label for="rg-male">Male</label>
                              </div>
                        </div>
                        <p>Enter your account </p>
                        <div class="form-group">
                            <span class="input-icon">
                                  <label>Email</label>
                                  <input type="email" class="form-group" name="email" id="email" onblur="userAvailability()" 
                                        placeholder="Email" required>
                                  <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                        <div class="form-group">
                             <label>Password</label>
                             <input type="password" class="form-control" name="email" id="email" placeholder="Password" required >
                             <i class="fa fa-lock"></i>
                        </div>
                        <div class="form-group">
                            <span class="input-icon">
                              <label>Confirm Password</label>
                              <input type="password" class="form-control" name="cfpassword" id="cfpassword" placeholder="Confirm Password" required >
                              <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="">
                              &copy;<span class="current-year"></span>
                              <span class="text-bold text-uppercase">MMS</span>
                              <span>All rights reserved</span>
                        </div>
                  </fielset>
            </form>
      </div>
      <!-- javascript -->
      <script src="../assign/js/main.js"></script>
      <script src="../assign/js/login.js"></script>
      <script>
            jQuery(document).ready(function(){
                Main.init();
                Login.init();
            });
        </script>
        <script>
            function userAvailability() {
                $('#loaderIcon').show();
                    jQuery.ajax({
                    url: "checkAvailability.php",
                    data: "email="+$('email').val(),
                    type: "POST",
                    success: function(data){
                        $('#user-availability-status').html(data);
                        $('#loaderIcon').hide();
                    },
                    error:function(){}
                });
            }
        </script>
</body>