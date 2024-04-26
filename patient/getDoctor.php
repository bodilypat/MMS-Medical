<?php
include('../define/config.php');
if(!empty($_POST["specilizationid"])) 
{
	$qDoc=mysqli_query($deal,"SELECT doctorName,id 
							 FROM  doctors 
							 WHERE specilization='".$_POST['specilizationid']."'");
	?>								
	<option selected="selected">Select Doctor </option>
	<?php
		 while($result=mysqli_fetch_array($qDoc))
		{
		?>
			<option value="<?php echo htmlentities($result['id']); ?>">
			               <?php echo htmlentities($result['doctorName']); ?>
			</option>
		<?php
		 }
}

		if(!empty($_POST["doctor"])) 
		{

			 $qdf=mysqli_query($deal,"SELECT docFees FROM doctors WHERE id='".$_POST['doctor']."'");
			 while($record=mysqli_fetch_array($qdf))
			{
			?>
				<option value="<?php echo htmlentities($record['docFees']); ?>">
				               <?php echo htmlentities($record['docFees']); ?>
			    </option>
				<?php
			}
		}
?>

