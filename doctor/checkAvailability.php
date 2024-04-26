<?php 
	require_once("../define/config.php");
	if(!empty($_POST["email"])) {
	$email= $_POST["email"];
	$qPat=mysqli_query($deal,"SELECT PatientEmail FROM patient WHERE PatientEmail='$email'");
	$countRow=mysqli_num_rows($qPat);
	if($countRow > 0)
	{
		echo "<span style='color:red'> Email already exists .</span>";
 		echo "<script>$('#submit').prop('disabled',true);</script>";
	} else{	
		echo "<span style='color:green'> Email available for Registration .</span>";
 		echo "<script>$('#submit').prop('disabled',false);</script>";
	}
}
?>
