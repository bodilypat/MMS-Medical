<?php
    include('../define/config.php');
    if(!empty($_POST['specialized']))
    {
        $qDoc=mysqli_query($dbcon,"SELECT doctorName, id From doctors WHERE special='".$_POST['specialized']."'");?>
        <option selected="selected">Select Doctor</option>
        <?php 
            while($result=mysqli_fetch_array($qDoc))
            {
        ?>
        <option value="<?php echo htmlentities($result['id']);?>"><?php echo htmlentities($result['doctorName']);?></option>
        <?php  }
    }
    if(!empty($_POST['doctor']))
    {
        $qDoc=mysqli_query($dbcon,"SELECT docFees FROM doctors WHERE id='".$_POST['doctor']."'");
        while($result=mysqli_fetch_array($qDoc))
        {
    ?>
        <option value="<?php echo htmlentities($result['docFees']); ?>"><?php echo htmlentities($result['docFees']);?></option>
        <?php
        }
    }
?>