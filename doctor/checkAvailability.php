<?php 
	require_once("include/config.php");
	if(!empty($_POST["email"])) {
	$email= $_POST["email"];
	$qPat=mysqli_query($deal,"SELECT PatientEmail FROM tblpatient WHERE PatientEmail='$email'");
	$result=mysqli_num_rows($qPat);
	if($result > 0)
	{
		echo "<span style='color:red'> Email already exists .</span>";
 		echo "<script>$('#submit').prop('disabled',true);</script>";
	} else{	
		echo "<span style='color:green'> Email available for Registration .</span>";
 		echo "<script>$('#submit').prop('disabled',false);</script>";
	}
}
?>
