<?php
    session_start();
    include('../config/dbconnect.php');
    
    if(strlen($_SESSION['id']==0)){
        header('Location:login.php');
    } else {

        $pid = intval($_GET['editid']) /* get doct id */

        if(isset($_POST['submit']))
        {
            $docname = $_POST['name'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address']

            $eDoc = mysqli_query($deal,"UPDATE patients SET name='$name', dob='$dob', gender='$gender', phone='$phone', email='$email', address='$address' 
                                        WHERE id='$pid' ");
            header('Location:manage-patients.php');
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
                            <div class="col-sm-8"><h1 class="mainTitle">Admin | Edit Patient</h1></div>
                            <ol>
                                 <li><span>Admin</span></li>
                                 <li class="active"><span>Edit Patient</span></li>
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
                                            <div class="panel-heading"><h5 class="panel-title">Edit Patient</h5></div>
                                            <div class="panel-body">
                                                <?php
                                                    $qPat = mysqli_query($deal,"SELECT * FROM patients WHERE id='$pid'");
                                                    while($result=mysqli_fetch_array($qPat))
                                                    {
                                                ?>
                                                <form name="addPatient" method="post" >
                                                    <div class="form-group">
                                                        <label for="Name">Name</label>
                                                        <input type="text" name="name" id="name" class="form-control"
                                                               value="<?php echo $result['name'];?>" required >
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="DOB">Date of Birth</label>
                                                        <input type="text" name="dob" id="dob" class="form-control"
                                                               value="<?php echo $result['dob'];?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="gender">Gender</label>
                                                        <select class="form-control" id="gender" name="gender" require >
                                                            <option value="male"<?php echo $result['gender']=='male' ? 'selected' :'';?>>Male</option>
                                                            <option value="female"<?php echo $result['gender']=='female' ? 'selected':'';?>>Female</option>
                                                            <option value="other"<?php echo $result['gender']=='other' ? 'selected':'';?>>Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Phone">Phone</label>
                                                        <input type="text" name="phone" id="phone" class="form-control"
                                                               value="<?php echo $result['phone'];?>" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Email">Email</label>
                                                        <input type="email" name="email" id="email" class="form-control"
                                                               value="<?php echo $result['email'];?>" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Address">Address</label>
                                                        <textarea  name="address" id="address" class="form-control"
                                                               value="<?php echo $result['address'];?>" required>
                                                        </textarea>
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