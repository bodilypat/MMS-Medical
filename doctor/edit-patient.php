<?php
    session_start();
    error_reporting(0);
    include('../config/dbconnect.php');
    if(strlen($_SESSION['id'])){
        header('location:logout.php')
    } else {
        
        if(isset($_POST['submit'])) {
            $eid = $_GET['editid'];
            $patName = $_POST['patientname'];
            $patContact = $_POST['contactno']
            $patEmail = $_POST['email'];
            $patAddress = $_POST['address'];
            $patGender = $_POST['gender'];
            $patAge = $_POST['age'];
            $medhis = $_POST['medhis'];

            $ePat = mysqli_query($deal,"UPDATE patients 
                                        SET name='$patName',
                                            contactno='$patContact',
                                            email='$patEmail',
                                            gender='$patGender',
                                            address = '$patAddress',
                                            age = '$patAge',
                                            medhis = '$medhis',
                                        WHERE id='$eid' ");
            if($ePat){
                echo "<script>alert('Patient info updated successfully');</script>";
                header('location:manage-patients.php');
            }
        }
?>

<!DOCTYPE html>
<head>
    <title>Doctor | Edit Patients</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../asset/css/styles.css">
</head>

<body>
    <div id="app">
        <!-- Outline : Navbar -->
         <?php include('../layouts/sidebar.php');?>
        <div class="app-content">
            <!-- Outline : Header -->
             <?php include('../layouts/header.php');?>
            <div class="main-content">
                <div id="container" class="wrap-content container">
                    <!-- PAGE TITILE -->
                    <select id="page-title">
                        <div class="row">
                            <div class="col-sm-8"><h1 class="mainTitle">Patients | Edit Patient</h1></div>
                            <ol>
                                 <li><span>Patient</span></li>
                                 <li><span>Edit Patient</li>
                            </ol>
                        </div>
                    </select>
                    <!-- Content -->
                    <div class="contriner-fluid container-full bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-lg-8 col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading"><h5 class="panel-title">Edit Patient</h5></div>
                                        <div class="panel-body">
                                            <form role="patient-form" name="patientForm" method="post">
                                                <?php
                                                    $eid = $_GET['editid'];
                                                    $qPat = mysqli_query($deal,"SELECT * FROM patients WHERE id='$eid' ");
                                                    while($result=mysqli_fetch_array($qPat))
                                                    {
                                                ?>
                                                <div class="form-group">
                                                    <label for="DoctorName">Patient Name</label>
                                                    <input type="text" name="patientname" class="form-control" 
                                                           value="<?php $result[name];?>" required="true">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Contactno">Contactno</label>
                                                    <input type="text" name="contactno" class="form-control" 
                                                           value="<?php echo $result['contactn'];?>" maxlength="10" pattern="[0-9]+">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Email">Email</label>
                                                    <input type="email" name="email" id="email" class="form-control" 
                                                           value="<?php echo $result['email'];?>" readonly='true'>
                                                    <span id="email-availability-status"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Gender:</label>
                                                    <?php if($result['Gender']=="Female") { ?> 
                                                        <input type="radio" name="gender" id="gender" value="Female" checked="true">Female
                                                        <input type="radio" name="gender" id="gender" value="male">male
                                                        <?php } else { ?>
                                                    <label>
                                                        <input type="radio" name="gender" id="gender" value="Male" checked="true">male
                                                        <input type="radio" name="gender" id="gender" value="Female">Female
                                                    </label>
                                                    <?php } ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="DoctorID">Doctor Name</label>
                                                    <select name="doctor_id" class="form-control" required="required">
                                                        <option value="<?php echo htmlentities($result['doctor_id']);?>">
                                                                <?php echo htmlentities($result['doctor_id']);?>
                                                        </option>
                                                        <?php 
                                                            $qDoc = mysqli_query($deal,"SELECT * FROM doctors");
                                                            while($row=mysqli_fetch_array($qDoc))
                                                            {
                                                        ?>
                                                        <option value="<?php echo htmlentities($row['doctor_id']);?>">
                                                               <?php echo htmlentities($row['name']);?>
                                                        </option>
                                                        <?php    } ?>
                                                    </select>
                                                </div>
                                                <?php  } ?>
                                                <button type="submit" name="submit" class="btn btn-o  btn-primary">Update</button>
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
    <!-- Outline: Footer -->
    <?php include('../layouts/footer.php');?>
    <?php include('../layouts/setting.php');?>
    <script src="../asset/js/main.js"></script>
    <script src="../asset/js/form-elements.js"></script>
    <!-- Custom CSS -->
    <script>
        jQuery(document).ready(function(){
            Main.init();
            Form-element.init();
        });
    </script>
</body>
<?php
    } 
?>