<?php 
    include('../config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $sql = "DELETE FROM tbl_admin WHERE id = $id";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if($res == true) {
            $_SESSION['delete_admin'] = "Admin deleted successfully";
            header('location:'.SITEURL.'manage-admin.php');
        } else {
            $_SESSION['delete_admin_failed'] = "failed to delete admin";
            header('location:'.SITEURL.'manage-admin.php');
        }
    } else {
        header('location:'.SITEURL.'manage-admin.php');
    }
?>