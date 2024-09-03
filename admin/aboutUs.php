<?php
    session_start();
    error_reporting(0);
    include('../define/config.php');
    if(strlen($_SESSION[id]==0)){
        header('location:logout.php');
    } else {
        /* code for Update the Content */
        if(isset($_POST['submit']))
        {
            $pageTitle=$_POST['pageitle'];
            $pageDes=$deal->real_escape_string($_POST['pagedes']);

            $editPage=mysqli_query($deal,"UPDATE tblpage
                                          SET PageTitle='$pageTitle', PageDescription='$pageDes' 
                                          WHERE PageType='aboutus' ");
            if($editPage)
            {
                echo '<script>alert("About Us has been updated.")</script.';
            } else {
                echo '<script>alert("something Went Wrong. Please try again.")</script>';
            }
        }
?>
<!-- body page -->
 <body>
       <div id="app">
             <?php include('../define/sidebar.php');?>
             <div class="app-content">
                   <?php include('..define/header.php'); ?>
                   <div class="main-content">
                         <div class="wrap-content container" id="container">
                            <!-- start: PAGE TITLE -->
                               <select id="page-title">
                                     <div class="row">
                                           <div class="col-sm-8">
                                                 <h1 class="mainTitle">Admin | Update the About us Content</h1>
                                           </div>
                                           <ol class="breadcrumb">
                                                <li><span>Admin</span></li>
                                                <li><span>Update the About us Content</span></li>
                                           </ol>
                                     </div>
                               </select>
                               <div class="container-fluid container-fullw bg-white">
                                     <div class="row">
                                          <div class="col-md-12">
                                                <form class="form-aboutus" method="post">
                                                    <?php
                                                        $qPage=mysqli_query($deal,"SELECT * FROM tblpage WHERE PageType='aboutus' ");
                                                        $count=1;
                                                        while($result=mysqli_fetch_array($qPage))
                                                        {
                                                    ?>
                                                            <div class="form-group">
                                                                 <label for="Username">Page Title</label>
                                                                 <input id="pagetitle" name="pagetitle" type="text" class="form-control" required="true"
                                                                        value="<?php echo $result['PageTitle'];?>">
                                                            </div>
                                                            <div class="form-group">
                                                                  <label for="Email">Page Description</label>
                                                                  <textarea class="form-control" name="pagedes" row="12">
                                                                        <?php echo $result['PageDescription'];?>
                                                                  </textarea>
                                                            </div>
                                                  <?php  } ?>
                                                </form>
                                          </div>
                                     </div>
                               </div>
                         </div>
                   </div>
             </div>
       </div>
       <!-- javascript -->
        <script src="../assign/js/main.js"></script>
        <script src="../assign/js/formElements.js"></script>
        <script>
              jQuery(document).ready(function() {
                Main.init();
                formElements.init();
              });
        </script>
 </body>
<?php
    }
?>