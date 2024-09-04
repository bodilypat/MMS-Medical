<?php
    session_start();
    include('../define/config.php');
    $_SESSION['dlogin'] = "";
    date_default_timezone_set('America/Monterrey');
    $lastDate = date('d-m-y h:i:s A', time() );
    $docID = $_SESSION['id'];
    mysqli_query($deal,"SELECT doctorlog SET logout = '$lastDate' WHERE userID = '$docID' ORDER BY id DESC LIMIT 1");
    session_unset();
    /* session_destroy */
    $_SESSION['errmsg'] = "You have successfully logout";
?>
<script language = "javascript">
    document.location = "../../index.php";
</script>