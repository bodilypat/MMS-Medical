<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION[0]=0)) {
        header('location: logout.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Manage Unread Enquiry | Admin</title>
        <!-- custom style -->
        <link rel="stylesheet" href="../assign/css/styles.css">
        <link rel="stylesheet" href="../assign/css/plugins.css">
        <link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
    </head>
<body>
    <div id="app">
        <?php include('../define/sidebar.php');?>
        <div class="app-content">
            <?php include('../define/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle"> Admin | Manage Unread Enquiry</h1></div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active">Unread Enquiry</li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <duv class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Manage<span class="text-bold">Unread Enquiry</span></h5>
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
                                        $qCon = mysqli_query($deal,"SELECT * tblcontactus WHERE isRead is null");
                                        $count =1;
                                        while($result=mysqli_fetch_array($qCon)) {
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
                                                       <a href="enquiryDetails.php?enqid=<?php echo $result['id'];?>" class="btn btn-transparent btn-lg"
                                                          title="View Details"><i class="fa fa-file"></i></a>
                                                  </div>
                                                  <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                       <div class="btn-group" dropdown is-open="status.isopen">
                                                            <button>
                                                                <i class="fa fa-cong"></i>&nbsp;;<span class="carent"></span>
                                                            </button>
                                                            <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                                <li><a hef="enquiryDetails.php">Edit</a></li>
                                                                <li><a href="readEnquiry.php">Show</a></li>
                                                                <li><a href="enquiryDetails.php">Remove</a></li>
                                                            </ul>
                                                       </div>
                                                  </div>
                                             </td>
                                        </tr>
                                        <?php $count=$count+1; } ?>
                                    </tbody>
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
    <!-- custom javascript -->
    <script src="../assign/js/main.js"></script>
    <script src="../assign/js/formElements.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php  } ?>