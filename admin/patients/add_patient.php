<?php
    session_start();
    include('config/dbconnect.php');
    if(isset($_POST['submit']))
    {
        $name = $_POST['name'];
        $dob = $_POST['age'];
        $contactno = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address']
        $gender = $_POST['gender'];
        $mdh = $_POST['medical_historty'];

        $addStmt = mysqli_query($deal,"INSERT INTO patients(name, dob,phone,email, gender,) VALUES ('$name','$dob','$contactno','$email','$gender') ");
        if($addStmt->execute())
        {
            echo "new patient record created successfully";
        } else {
            echo "Error:" . $addStmt->error;
        }
        $addStmt->close();
    }
?>
<form method="POST" action="">
    <div class="form-group">
        <label for="Name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required></br>
    </div>
    <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" id="contactno" name="contactno" class="form-control" required></br>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" required></br>
    </div>
    <div class="form-group">
        <label for="Address">Address:</label>
        <textarea name="Address" id="address" class="form-control" required></br>
    </div>
    <input type="submit" value="Submit">
</form>
