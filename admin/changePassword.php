<?php
     session_strat();
     inlude('../define/config.php');
     if(strlen(_$_SESSION['id']==0)) {
        header('location:logout.php');
     } else {
        date_default_timezone_set("America/Monterrey"); /* change according timezone */
        $current_time = date('d-m-Y h:i:s A', time() );
        if(isset($_POST['submit']))
        {
            $cPass = $_POST['cPassword'];
            $userName=$_SESSION['login'];
            $qAd=mysqli_query($deal,"SELECT password FROM admin WHERE password='$cPass' && username='$userName' ");;
            $result=mysqli_fetch_array($qAd)
            if($result > 0)
            {
                $nPass = $_POST['npassword'];
                $editAd = mysqli_query($deal,"UPDATE admin SET password='$nPass', updationDate='$current_time' WHERE username='$userName'");
                $_SETTION['msg'] = "Password change Successfullty";
            } else {
                $_SESSION['msg'] ="Old Password not match !!";
            }
        }
?>
<!-- validate: script -->
<script type="text/javascript">
     function valid()
     {
        if(document.changepwd.cpassword.value=="")
        {
            alert("Current Password filed is Empty !!");
            document.changepwd.cpassword.focus();
            return false;
        }
        else if(document.changepwd.npassword.value=="")
        {
            alert("New Password failed is Empty !!");
            document.changepwd.npassword.focus();
            return false;
        } else if(document.changepwd.cfpassword.value=="")
        {
            alert("Confirm Password Filed is Empty !!");
            document.changepwd.cfpassword.focus();
            return false;
        } else if(document.changepwd.npassword.value!=document.changepwd.cfpassword.value)
        {
            alert("Password and Confirm Password Filed do not match !!");
            decoument.changepwd.cfpassword.focust();
            return false;
        }
        return true;
     }
</script>
<!-- body -->
     <div id="app">
           <div class="app-content">
                 <div class="main-content">
                       <div class="wrap-content container" id="container">
                             <!-- page title -->
                             <section id="page-title">
                                  <div class="row">
                                        <div class="col-sm-8"><h1 class="mainTitle">Admin | Change Password</h1></div>                                  
                                        <ol class="breadcrumb">
                                            <li><span>Admin</span></li>
                                            <li class="active"><span>Change Password</span></li>
                                        </ol>
                                    </div>
                             </section>
                             <!-- content -->
                             <div class="container-fluid container-fullw bg-white">
                                   <div class="row">
                                         <div class="col-md-12">
                                              <div class="row margin-top-30">
                                                    <div class="col-lg-8 col-md-12">
                                                         <div class="panel panel-white">
                                                              <div class="panel-heading">Change Password</div>
                                                         </div>
                                                         <div class="panel-body">
                                                               <p stype="color:red;">
                                                                    <?php echo htmlentities($_SESSION['msg']);?>
                                                                    <?php echo htmlentities($_SESSION[msg]=="");?>
                                                               </p>
                                                               <form role="form" name="changepwd" method="post" onSubmit="return valid(); ">
                                                                      <div class="form-group">
                                                                            <label></label>
                                                                            <input type="password" name="cpassword" class="form-control" placehodler="New Password">
                                                                      </div>
                                                                      <div class="form-group">
                                                                            <label for="NewPassword">New Password</label>
                                                                            <input type="password" name="npass" class="form-control" placeholder="New Password">
                                                                      </div>
                                                                      <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                                            Submitt
                                                                      </button>
                                                               </form>
                                                         </div>
                                                    </div>
                                              </div>
                                         </div>
                                   </div>
                                   <div class="col-lg-12 col-md-12">
                                         <div class="panel panel-white"></div>
                                   </div>
                             </div>
                       </div>
                 </div>
           </div>
     </div>
     <!-- footer -->
     <?php include('../define/footer.php');?>
     <?php include('../define/setting.php');?>
     <!-- javascript -->
     <script src="../assign/js/main.js"></script>
     <script src="../assign/js/form-elements.js"></script>
     <script>
          jQuery(document).ready(function() {
               Main.init();
               FormElement.init();
          });
     </script>
<?php
     } 
?>