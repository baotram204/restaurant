<?php 
    include('../config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);

        // Retrieve the image name from the database before deleting the food entry
        $sql_select_image = "SELECT img_name FROM tbl_category WHERE id = $id";
        $res_select_image = mysqli_query($conn, $sql_select_image);
        if ($res_select_image) {
            $row_image = mysqli_fetch_assoc($res_select_image);
            $img_name = $row_image['img_name'];
            
            // Delete the image file from the folder
            $img_path = "../images/category/" . $img_name;
            if (file_exists($img_path)) {
                unlink($img_path);
            }
        }


        $sql = "DELETE FROM tbl_category WHERE id = $id";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if($res == true) {
            $_SESSION['delete_category'] = "Category deleted successfully";
            header('location:'.SITEURL.'manage-category.php');
        } else {
            $_SESSION['delete_category_failed'] = "failed to delete category";
            header('location:'.SITEURL.'manage-category.php');
        }
    } else {
        header('location:'.SITEURL.'manage-category.php');
    }
?>