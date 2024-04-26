<?php 
require_once("../define/config.php");

if(!empty($_POST["email"])) 
{
	$userEmail= $_POST["email"];
	$qUser =mysqli_query($deal,"SELECT email FROM users WHERE email='$userEmail'");
	$result=mysqli_num_rows($qUser);
	if($result>0)
	{
		echo "<span style='color:red'> Email already exists .</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
		} else{
			echo "<span style='color:green'> Email available for Registration .</span>";
		echo "<script>$('#submit').prop('disabled',false);</script>";
	}
}
?>
