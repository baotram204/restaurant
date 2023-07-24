<?php
    //Authorization and Access control
    
    //check  whether the user is logged in or not 
    if(!isset($_SESSION['user'])) {
        //user is not logged in
        $_SESSION['no_message'] = 'Please login to access Control Panel';
        header('Location:'.SITEURL.'login-admin.php');
    }
?>