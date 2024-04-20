  <?php
  session_start();
  error_reporting(0);
  include('include/config.php');
  if(strlen($_SESSION['id']==0)) {
      header('location:logout.php');
    } else{
      if(isset($_POST['submit']))
      {        
          $patID=$_GET['infoid'];
          $bloodpress=$_POST['bloodpressure'];
          $bloodSu=$_POST['bloodsurgeer'];
          $weight=$_POST['weight'];
          $temp=$_POST['temperature'];
          $mddpress=$_POST['pressure'];  
          $addMdh=mysqli_query($deal, "INSERT INTO  medicalhistory(PatientID,BloodPressure,BloodSugar,Weight,Temperature,MedicalPres)
                                       VALUES('$patID','$bloodPress','$bloodSu','$weight','$temp','$medPress')");
      if ($addMdh) {
      echo '<script>alert("Medicle history has been added.")</script>';
      echo "<script>window.location.href ='managePatient.php'</script>";
    }
    else
      {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
      }    
  }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
      <title>Doctor | Manage Patients</title>
      <!-- CSS -->
      <link rel="stylesheet" href="assign/css/styles.css">
      <link rel="stylesheet" href="assign/css/plugins.css">
      <link rel="stylesheet" href="assign/css/themes/theme-1.css" id="skin_color" />
	</head>
<body>
		<div id="app">		
        <?php include('include/sidebar.php');?>
        <div class="app-content">
            <?php include('include/header.php');?>
            <div class="main-content" >
                <div class="wrap-content container" id="container">
						        <!-- section: PAGE TITLE -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Doctor | Manage Patients</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Doctor</span></li>
                                <li class="active"><span>Manage Patients</span></li>
                            </ol>
                        </div>
                    </section>
                    <!-- section:CONTENT -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Patients</span></h5>
                                <?php
                                     $patID=$_GET['infoid'];
                                     $qPat=mysqli_query($deal,"SELECT * FROM patient WHERE ID='$patID'");
                                     $count=1;
                                     while ($resultset=mysqli_fetch_array($qPat)) {
                                ?>
                                <table border="1" class="table table-bordered">
                                    <tr align="center">
                                        <td colspan="4" style="font-size:20px;color:blue">Patient Details</td>
                                    </tr>
                                    <tr>
                                        <th scope>Patient Name</th>
                                          <td><?php  echo $resultst['PatientName'];?></td>
                                        <th scope>Patient Email</th>
                                        <td><?php  echo $resultset['PatientEmail'];?></td>
                                    </tr>
                                    <tr>
                                        <th scope>Patient Mobile Number</th>
                                            <td><?php  echo $resultset['PatientContno'];?></td>
                                        <th>Patient Address</th>
                                        <td><?php  echo $resultset['PatientAdd'];?></td>
                                    </tr>
                                    <tr>
                                        <th>Patient Gender</th>
                                          <td><?php  echo $resultset['PatientGender'];?></td>
                                        <th>Patient Age</th>
                                        <td><?php  echo $resultset['PatientAge'];?></td>
                                    </tr>
                                    <tr>                                    
                                        <th>Patient Medical History(if any)</th>
                                        <td><?php  echo $resultset['PatientMedhis'];?></td>
                                        <th>Patient Reg Date</th>
                                        <td><?php  echo $resultset['CreationDate'];?></td>
                                    </tr>                                
                                    <?php }?>
                                </table>
                                  <?php  
                                       $qmdh=mysqli_query($deal,"SELECT * FROM medicalhistory  WHERE PatientID='$patID'");
                                  ?>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                       <tr align="center">
                                            <th colspan="8" >Medical History</th> 
                                       </tr>
                                       <tr>
                                            <th>#</th>
                                            <th>Blood Pressure</th>
                                            <th>Weight</th>
                                            <th>Blood Sugar</th>
                                            <th>Body Temprature</th>
                                            <th>Medical Prescription</th>
                                            <th>Visit Date</th>
                                        </tr>
                                            <?php  
                                                while ($resultmdh=mysqli_fetch_array($ret)) { 
                                            ?>
                                        <tr>
                                            <td><?php echo $count;?></td>
                                            <td><?php  echo $resultmdh['BloodPressure'];?></td>
                                            <td><?php  echo $resultmdh['Weight'];?></td>
                                            <td><?php  echo $resultmdh['BloodSugar'];?></td> 
                                            <td><?php  echo $resultmdh['Temperature'];?></td>
                                            <td><?php  echo $resultmdh['MedicalPres'];?></td>
                                            <td><?php  echo $resultmdh['CreationDate'];?></td> 
                                        </tr>
                                          <?php $count=$count+1;} ?>
                                  </table>
                                  <p align="center">                            
                                      <button class="btn btn-primary waves-effect waves-light w-lg" 
                                              data-toggle="modal" data-target="#myModal">Add Medical History
                                      </button>
                                  </p>  
                                  <?php  ?>
                                  <div id="myModal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                 <div class="modal-header">
                                                     <h5 id="medicalhistory" class="modal-title" >Add Medical History</h5>
                                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-hover data-tables">
                                                        <form name="submit" method="post" >
                                                            <tr>
                                                                <th>Blood Pressure :</th>
                                                                <td>
                                                                    <input name="bloodpressure" placeholder="Blood Pressure" 
                                                                        class="form-control wd-450" required="true">
                                                                </td>
                                                            </tr>                          
                                                            <tr>
                                                                <th>Blood Sugar :</th>
                                                                <td>
                                                                    <input name="bloodsuger" placeholder="Blood Sugar" 
                                                                         class="form-control wd-450" required="true">
                                                                </td>
                                                            </tr> 
                                                            <tr>
                                                                <th>Weight :</th>
                                                                <td>
                                                                    <input name="weight" placeholder="Weight" class="form-control wd-450" 
                                                                           required="true">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Body Temprature :</th>
                                                                <td>
                                                                    <input name="temperature" placeholder="Blood Sugar" 
                                                                       class="form-control wd-450" required="true">
                                                                </td>
                                                            </tr>                                                                        
                                                            <tr>
                                                                <th>Prescription :</th>
                                                                <td>
                                                                    <textarea name="pressure" placeholder="Medical Prescription" 
                                                                          rows="12" cols="14" class="form-control wd-450" 
                                                                          required="true">
                                                                    </textarea>
                                                                </td>
                                                            </tr>                                                    
                                                    </table>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button name="submit" type="submit"  class="btn btn-primary">Submit</button>                                                  
                                                   </form>
                                              </div>
                                        </div>
                                  </div>
                            </div>
                      </div>
                </div>
          </div>
    </div>
	<!--  FOOTER -->
	<?php include('include/footer.php');?>			
	<?php include('include/setting.php');?>
	<!-- JAVASCRIPT -->	
	<script src="assign/js/main.js"></script>	
	<script src="assign/js/form-elements.js"></script>
	<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>	
	</body>
</html>
<?php }  ?>
