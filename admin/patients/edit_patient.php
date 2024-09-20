<?php
    session_start();
    include('config/dbconnect.php');
    include('define/checklogin.php')
    if(isset($_POST['submit']))
    {
        $fullname = $_POST['fullname'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $contactno = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address']
        $city = $_POST['city'];

        $editStmt = mysqli_query($deal,"UPDATE patients SET fullName = '$fullname',
                                                            date_of_birth = '$dob',
                                                            gender = '$gender',
                                                            contact_number = '$phone',
                                                            email = '$email',
                                                            address = '$address',
                                                            city ='$city',
                                                        WHERE id = '" .SESSION['id']."'");
        if($editStmt)
        {
            echo "new patient record created successfully";
        } 
    }
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h5 style="color:green"><?php if($msg) { echo htmlentities($msg) ; }?></h5>
            <div class="panel white-panel" >
                <div class="panel-heading"><h5 class="panel-title">Edit Patient</h5></div>
                <div class="panel-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="Name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" 
                                   value="<?php echo htmlentities($result['name']);?>" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" id="dob" value="<?php echo htmlentities($result['dob']);?>" required>
                        </div> 
                        <div class="form-group">
                            <label for="gender"></label>
                            <select name="gender" class="form-control" required> 
                                <option value="<?php htmlentities($result['gender']);?>"><?php echo htmlentities(['gender']);?></option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </section>
                        </div>
                        <div class="form-group">
                            <label for="ContactNumber">Phone:</label>
                            <input type="text" id="phone" name="phone" class="form-control" 
                                   value="<?php echo htmlentities($result['phone']);?>" required></br>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required ="readonly"
                                    value="<?php echo htmlentities($result['email']);?>">
                                    <a href="change-email.php">Update your email id</a>
                        </div>
                        <div class="form-group">
                            <label for="Address">Address:</label>
                            <textarea name="Address" id="address" class="form-control" 
                                    value="<?php echo html($result['address']);?>" required>
                        </div>
                        <div class="form-group">
                            <label for="City">City:</label>
                            <input type="text" id="city" name="city" class="form-control" 
                                   value="<?php echo htmlentities($result['city']);?>" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-o btn-primary">Update</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>