<?php
    session_start();
    include('../define/config.php');
    if(strlen($_SESSION['id']==0)){
        header('location:logout.php');
    } else {
        date_default_timezone_set('America/Lost_Angeles'); /* change according timezone */
        $currentTime = date('d-m-Y h:i:s A', time() );
        if(isset($_POST['submit']))
        { 
            $currentPass = $_POST['cpass'];
            $userName=$_SESSION['login'];
            /* get password */
            $qAdmin=mysqli_query($deal,"SELECT password FROM admi  WHERE password='$userPass' && username='$userName' ");
            $result=msyqli_fetch_array($qAdmin);
            if($result > 0)
            {
                $newPass=$_POST['newPassword'];
                $eAdmin=mysqli_query($deal,"UPDATE admin SET password='$newPass', updatingDate='$currentTime' WHERE username='$userName' ");
                $SESSION['msg']="Password changed Successfully !!";
            } else {
                $_SESSION['msg']="Old Password not match  !! ";
            }
        }
?>

    <script type="text/javascript">
         function valid()
         {
            if(document.changpwd.cpass.value=="")
            {
                alert("Current Password Filed is Empty !! ");
                document.changpwd.cpass.focus();
                return false;
            }
            else if(document.changpwd.npass.value=="")
            {
                alert("New Password filed is Empty !! ");
                document.changpwd.npass.focus();
                return false;
            }
            else if(document.changpwd.cfpass.value=="")
            {
                alert("Confirm Password Filed is Empty !! ");
                document.changpwd.cfpass.focus();
                return false;
            } else if(document.changpwd.npass.value!=document.changpwd.cfpass.value)
            {
                alert("Password and Confirm Password Field do not match !! ");
                document.changpwd.cfpass.focus();
                return false;
            }
            return true;
         }
    </script>
    <!-- box change password -->
<body>
    <div id="app">
          <div class="panel panel-white">
                <div class="panel-heading"><h5 class="panel-title">Change Password</h5></div>
                <div class="panel-body">
                      <p stype="color:red;">
                          <?php echo htmlentities($_SESSION['msg']); ?>
                          <?php echo htmlentities($_SESSION['msg']); ?>
                      </p>
                      <form name="changpwd" role="form" method="post" onSubmit="return valid(); ">
                            <div class="form-group">
                                 <label for="CurrentPassword">Current Password</label>
                                 <input name="cpass" type="password" class="form-contrl" placeholder="Current Password">
                            </div>
                            <div class="form-group">
                                  <label for="NewPassword">New Password</label>
                                  <input name="npass" type="password" class="form-control" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                  <label for="ConfirmPassword">Confirm Password</label>
                                  <input name="cfpass" type="password" class="form-control" placeholder="Confirm Password">
                            </div>
                            <button name="submit" type="submit" class="btn btn-o btn-primary">
                                Submit
                            </button>
                      </form>
                </div>
          </div>
    </div>
    <script src="../assign/js/main.js"></script>
    <script src="../assign/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>
</body>
<?php
    }
?>