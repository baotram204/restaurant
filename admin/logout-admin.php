<?php 
    include('../config/constants.php');

    //destroy session
    session_destroy();

    header('location:'.SITEURL.'login-admin.php');
    
    
?>
