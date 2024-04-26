<?php
    session_start();
    include('../define/config.php');
    $_SESSION['dlogin']=="";
    date_default_timezone_set('America/Los_Angeles');
    $ldate=date( 'd-m-Y h:i:s A', time () );
    $docid=$_SESSION['id'];
    mysqli_query($deal,"UPDATE doctorslog  SET logout = '$ldate' WHERE uid = '$docid' ORDER BY id DESC LIMIT 1");
    session_unset();
    //session_destroy();
    $_SESSION['errmsg']="You have successfully logout";
?>
<script language="javascript">
do  cument.location="../index.php";
</script>
