<?php
     session_start();
     error_repoting();
     include('../include/config.php');
     if(strlen($_SESSION['id']==0))
     {
         header('location:logout.php');
     } else {
                $docID=intval($_GET['id']);
                if(isset($_POST['submit']))
                {
                    $dSpecial=$_POST['docSepecial'];
                    $dName=$_POST['docName'];
                    $dAddress=$_POST['docAddress'];
                    $dFees=$_POST['docConsult'];
                    $dContact=$_POST['docContact'];
                    $dEmail=$_POST['docEmail'];
                    $editDoc=mysqli_query($deal,"UPDATE doctors
                                                 SET specialization='$dSpecial',
                                                     doctorName='$dName',
                                                     docAddress='$dAddress',
                                                     docFees='$dFees',
                                                     docContact='$dContact',
                                                     docEmail='$docEmail',
                                                     WHERE id='$docID' ");
                    if($editDoc)
                    {

                    }
                }
?>
<!DOCTYPE html>
<htmln lang="en">
    <head>
          <title>Admin | Edit Doctor Details</title>
          <link rel="stylesheet" type="text/css" href="">
          <!-- css -->
          <!-- css custom -->
          <!-- css media -->
    </head>
<body>
      <div id="application">
            <?php include('../include/sidebar.php');?>
            <div class="application-content">
                  <?php include('../include/header.php');?>
                  <div class="main-content">
                       <div id="container" class="wrap-content container">
                             <!-- page title -->
                             <section id="page-title">
                                     <div class="row">
                                           <div class="col-sm-8">
                                                 <h1 class="mainTitle">Admin | Edit Doctor Details</h1>
                                           </div>
                                           <ol class="breadcrumb">
                                                 <li><span>Admin</span></li>
                                                 <li class="active"><span>Edit Doctor Details</span></li>
                                           </ol>
                                     </div>
                             </section>
                             <!-- content -->
                             <div class="container-fluid container-fullw bg-white">
                                  <div class="row">
                                       <div class="col-md-12">
                                            <h5 style="color:green; font-size:18px; ">
                                                 <?php if(msg) { echo htmlentities($msg); } ?></h5>
                                                 <div class="row margin-top-30">
                                                       <div class="col-lg-8 col-md-12">
                                                             <div class="panel panel-white">
                                                                  <div class="panel-heading">
                                                                       <h5 class="panel-title">Edit Doctor info</h5>
                                                                  </div>
                                                                  <div class="panel-body">
                                                                    <?php 
                                                                         $qDoc=mysqli_query($deal,"SELECT * FROM doctors WHERE id='$docID'");
                                                                         while($infoset=mysqli_fetch_array($qDoc))
                                                                         {
                                                                    ?>
                                                                        <h4><?php echo htmlentities($infoset['docName']);?>'s Profile</h4>
                                                                        <p><b>Profile Reg. Date: </b>
                                                                              <?php echo htmlentities($infoset['creationDate']);?>
                                                                        </p>
                                                                              <?php echo htmlentities($infoset['creationDate']); { ?> 
                                                                        <p><b>Profile Last Updation Date: </b>
                                                                              <?php echo htmlentities($infoset['updationDate']);?>
                                                                        </p>
                                                                  <?php  } ?>
                                                                  <hr />
                                                                       <form name="addDoc" method="post" role="form" onSubmit="refurn valid(); ">
                                                                             <div class="form-group">
                                                                                  <label for="DoctorSpecial">Doctor Specialization</label>
                                                                                  <select name="docSpecial" class="form-control" required="required">
                                                                                        <option value="<?php echo htmlentities($infoset['specialization']);?>">
                                                                                            <?php echo htmlentities($inforset['specialization']);?>
                                                                                        </option>
                                                                                            <?php $qDocs=mysqli_query($deal,"SELECT * FROM dSpecialization");
                                                                                                while($recordDs=mysqli_query($qDocs))
                                                                                                {
                                                                                            ?>
                                                                                          <option value="<?php echo htmlentities($recordDs['specialization']);?>">
                                                                                                <?php echo htmlentities($recordDs['specialization']);?>
                                                                                          </option>
                                                                                        <?php
                                                                                                } ?>
                                                                                   </select>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                  <label for="doctorName">Doctpr Name</label>
                                                                                  <input name="docName" type="text" class="form-control"
                                                                                         value="<?php echo htmlentities($_infoset['docName']);?>">
                                                                             </div>
                                                                             <div class="form-grou">
                                                                                  <label for="ClinicAddress">Clinic Address</label>
                                                                                  <textarea name="docAddress" class="form-control">
                                                                                         <?php echo htmlentities($infoset['docAddress']);?>
                                                                                  </textarea>
                                                                             </div>
                                                                             <div class="form-group">
                                                                                   <label for="ConsualtFees">Consultancy Fees</label>
                                                                                   <input name="docFees" type="text" class="form-control" required="requried"
                                                                                          value="<?php echo htmlentities($infoset['docFees']);?>">
                                                                             </div>
                                                                             <div class="form-group">
                                                                                   <label for="EmailDoctor">Email Address:</label>
                                                                                   <input name="docEmail" type="email" class="form-control" readonly="readonly"
                                                                                          value="<?php echo htmlentities($infoset['docEmail']);?>">
                                                                             </div>
                                                                             <?php } ?>
                                                                             <button name="submit" type="submit" class="btn btn-o btn-primary">
                                                                                  Update 
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
            <?php include('../include/footer.php');?>
            <?php include('../include/setting.php');?>
      </div>
      <!-- javascript -->
      <script src="../compose/js/jquery.min.js"></script>
      <script src="../compose/js/bootstrap.min.js"></script>
      <script src="../compose/js/modernizr.js"></script>
      <script src="../compose/js/jquery.cookie.js"></script>
      <script src="../compose/js/perfect-scrollbar.js"></script>
      <script src="../compose/js/switchery.min.js"></script>
      <script src="../compose/js/jquery.maskedinput.min.js"></script>
      <script src="../compsoe/js/jquery.bootstrap-touchspin.min.js"></script>
      <script src="../compose/js/autosize.min.js"></script>
      <script src="../compose/js/classie.js"></script>
      <script src="../compose/js/selectFx.js"></script>
      <script src="../compose/js/select2.min.js"></script>
      <script src="../compose/js/bootstrap-datepicker.min.js"></script>
      <script src="../compose/js/bootstrap-tiempicter.min.js"></script>
      <!-- js custom -->
      <Script src="../compose/js/main.js"></script>
      <script src="../compose/js/form-elements.js"></script>
      <script>
             jQuery(document).ready(funtion() {
                 Main.init();
                 FormElements.init();
             });
      </script>
</body>
</html>
<?php
    }
?>