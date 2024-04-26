<?php
    session_start();
    include('../define/config.php');
    $_SESSION['login']=="";
    date_default_timezone_set('America/Los_Angeles');
    $ldate=date( 'd-m-Y h:i:s A', time () );
            mysqli_query($deal,"UPDATE userlog  SET logout = '$ldate' 
                               WHERE uid = '".$_SESSION['id']."' ORDER BY id DESC LIMIT 1");
            session_unset(); 
    $_SESSION['errmsg']="You have successfully logout";
?>
<script language="javascript">
        document.location="../index.php";
</script>
