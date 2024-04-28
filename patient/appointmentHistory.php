<?php
    session_start();
    error_start(0);
    include('../define/config.php');
    if(strlen($_SESSION['id']==0))
    {
        header('location:logout.php');
    } else {
        if(isset($_GET['cencel']))
        {
            mysqli_query($dbcon,"UPDATE appointment SET userStatus='0' WHERE id ='".$_GET['id']."'");
            $_SESSION['msg']="Your appointment canceled !!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>User | Appointment History</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/theme/theme-1.css" id="skin_color" />
    <head>
    <body>
        <div id="application">
            <div class="application-content">
                 <div class="main-content">
                      <div id ="container" class="wrap-content container">
                            <!-- section : page title -->
                            <section id="page-title">
                                 <div class="row">
                                       <div class="col-sm-8">
                                             <h1 class="mainTitle">User | Appointment History<h1></div>
                                       </div>
                                       <ol class="breadcrumb">
                                            <li><span>User</span></li>
                                            <li class="active"><span>Appointment History</span></li>
                                       </ol>
                                 </div>
                            </section>
                            <div class="container-fluid container-fullw bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                         <p style="color:red;">
                                             <?php echo htmlentities($_SESSION['msg']);?>
                                             <?php echo htmlentities($_SESSION['msg'])="";?>
                                        </p>
                                        <table id="app-table" class="table table-hover">
                                            <thead>
                                                <tr>
                                                     <th class="center">#</th>
                                                     <th class="hidden-xs">Doctor Name</th>
                                                     <th>Specialization</th>
                                                     <th>Consultancy Fee</th>
                                                     <th>Appointment Date / Time</th>
                                                     <th>Current Status</th>
                                                     <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php                                                 
                                                    $qDoc=mysqli_query($dbcon,"SELECT doctors.doctorName as docname, appointment.*
                                                                               FROM appointment JOIN doctors ON doctor.id=appointment.doctorId
                                                                               WHERE appointment.userId='".$_SESSION['id']."'");
                                                    $count=1;
                                                    while($result=mqli_fetch_array($qDoc))
                                                    {
                                                ?>
                                                <tr>
                                                     <td class="center"<?php echo $count;?>.</td>
                                                     <td class="hidden-xs"><?php echo $result['docname'];?></td>
                                                     <td><?php echo $result['doctorSpecial'];?></td>
                                                     <td><?php echo $result['consultFees'];?></td>
                                                     <td><?php echp $result['appointmentDate'];?> / <?php echo $result['appointmentTime'];?></td>
                                                     <td><?php echo $result['postDate'];?></td>
                                                     <td>
                                                         <?php if(($result['userStatus']==1) && ($result['doctorStatus']==1))
                                                         {
                                                            echo "Active";
                                                         }
                                                         if(($result['userStatus']==0) && ($result['doctorStatus']==1))
                                                         {
                                                            echo "Cancel by You?";
                                                         }
                                                         if(($result['userStatus']==1) && ($result['doctorStatus']==0))
                                                         {
                                                            echo "Cancel by Doctor";
                                                         } ?>
                                                    </td>
                                                     <td>
                                                         <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                              <?php if($result['userStatus']==1 && ($result['doctorStatus']==1))
															  	    { ?>
																<a href="appointmentHistory.php?id=<?php echo $result['id'];?>&cancel=update"
																   onClick="return confirm('Are you sure you want to cancel this Appointment ?')"
																   class="btn btn-transparent btn-xs tooltips"
																   title="Cancel Appointment" tooltip-placement="top"
																   tooltip="Remove">Cancel
																</a>
																<?php } else {
																	echo "Canceled"
																} ?>
                                                         </div>
                                                     </td>
                                                </tr>
                                                <?php  } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                      </div>
                 </div>
            </div>
			<!-- FOOTER -->
			<?php include('../define/footer.php');?>
			<?php include('../define/setting.php');?>
        </div>
		<!-- javascript -->
		<script src="../assign/js/main.js"></script>
		<script src="../assign/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function(){
				Main.init();
				FormElements.init();
			});
		</script>
    </body>
</html>
