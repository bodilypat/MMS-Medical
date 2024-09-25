<?php
    session_start();
    include('../config/dbconnect.php');
    
    if(strlen($_SESSION['id']==0)){
        header('Location:login.php');
    } else {

        $did = intval($_GET['id']) /* get doct id */
        if(isset($_POST['submit']))
        {
            $docname = $_POST['name'];
            $specailty = $_POST['specialty'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            $eDoc = mysqli_query($deal,"UPDATE doctors SET name='$docname', specialty='$specialty', phone='$phone', email='$email' 
                                        WHERE id='$did' ");
            header('Location:manage-doctors.php');
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Edit Doctor</title>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../asset/css/styles.css">
    </head>
</html>
<body>
    <div id="app">
        <!-- Outline : Navber -->
        <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <!-- Outline : Header -->
            <?php include('../layouts/header.php');?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                     <!-- PAGE TITLE -->
                    <section id="pate-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Admin | Edit Doctor</h1></div>
                            <ol>
                                 <li><span>Admin</span></li>
                                 <li class="active"><span>Edit Doctor</span></li>
                            </ol>
                        </div>
                    </select>
                    <!-- BODY -->
                    <div class="container-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 style="color: green; font-size:18px; "><?php if($msg) { echo htmlentities($msg);} ?></h5>
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading"><h5 class="panel-title">Edit Doctor</h5></div>
                                            <div class="panel-body">
                                                <?php
                                                    $qDoc = mysqli_query($deal,"SELECT * FROM doctors WHERE id='$did'");
                                                    while($result=mysqli_fetch_array($qDoc))
                                                    {
                                                ?>
                                                <form name="addDoctor" method="post" >
                                                    <div class="form-group">
                                                        <label for="Name">Name</label>
                                                        <input type="text" name="name" id="name" class="form-control"
                                                               value="<?php echo $result['name'];?>" required >
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Specialty">Specialty</label>
                                                        <input type="text" name="specialty" id="specialty" class="form-control"
                                                               value="<?php echo $result['specialty'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Phone">Phone</label>
                                                        <input type="text" name="phone" id="phone" class="form-control"
                                                               value="<?php echo $result['phone'];?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Email">Email</label>
                                                        <input type="text" name="email" id="email" class="form-control"
                                                               value="<?php echo $result['email'];?>" required>
                                                    </div>
                                                    <?php } ?>
                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    } ?>