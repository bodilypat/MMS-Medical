<?php
    session_start();
    error_reporting(0);
    include('..deffine/confif.php');
    if(strlen($_SESSION['id']==0)) {
        header('location:logoout');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Enquiry | Admin Manage </title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/themes-1.css" id="skin_color">
    </head>
<body>
    <div id="app">
        <?php include('../define/sideber.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- page title -->
                     <section id="page-title">
                          <div class="row">
                               <div class="col-sm-8"><h1 class="mainTitle">Amind | Manage Enquiry</h1></div>
                               <ol class="breadcrumb">
                                    <li><span>Admin</span></li>
                                    <li><span>Manage Enquiry</span></li>
                               </ol>
                          </div>
                     </section>
                    <div class="container-fluid contanier-fullw bg-white">
                        <div class="col-md-12">
                            <h5 class="over-title margin-bottom-15">Manage<span class="text-bold">Read Enquiry</span>
                        </div>
                        <table class="table table-hover" id="enquiries-table">
                            <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>Name</th>
                                    <th class="hidden-xs">Email</th>
                                    <th>Contact No.</th>
                                    <th>Enquiry Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $qCon = mysqli_query($deal,"SELECT * FROM tblcontactus WHERE isRead is not null");
                                $count = 1;
                                while($result=mysqli_fetch_array($qCon)){
                            ?>
                                
                                <tr>
                                    <td class="center"><?php echo $count;?>.</td>
                                    <td class="hidden-xs"><?php echo $result['fullname'];?></td>
                                    <td><?php echo $result['email'];?></td>
                                    <td><?php echo $result['contactno'];?></td>
                                    <td><?php echo $result['message'];?></td>
                                    <td><?php echo $result['postingDate'];?></td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="enquiryDetails.php?enqid=<?php echo $result['id'];?>" class="btn btn-transparent bg-lg" 
                                               title="view details"> <i class="fa fa-file"></i>
                                            </a>
                                        </div>
                                        <div class="visible-xs visible-sm hidden-md hidden-xs">
                                            <div class="btn-group" dropdown is-pen="status.isopen">
                                                <button type="button" class="btn btn-primary btn-0 btn-sm dropdown-toggle" dropdown-toggle>
                                                    <i class="fa fa-cog"></i>$nbsp;<span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu pull-right dropdown-ligh" role="menu">
                                                    <li><a href="enquiryDetails.php">Edit</a></li>
                                                    <li><a href="readEnquiry.php">Show</li>
                                                    <li><a href="enquiryDetails.php">Remove</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <?php include('../define/footer.php');?>
        <?php include('../define/setting.php');?>
    </div>
    <!-- custom javascript -->
    <script src="../assign/js/main.js"></script>
    <script src="../assign/js/formElements.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php    } ?>