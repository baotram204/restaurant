<?php 
    include('../config/constants.php');
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        
        // Retrieve the image name from the database before deleting the food entry
        $sql_select_image = "SELECT image_name FROM tbl_food WHERE id = $id";
        $res_select_image = mysqli_query($conn, $sql_select_image);
        if ($res_select_image) {
            $row_image = mysqli_fetch_assoc($res_select_image);
            $img_name = $row_image['image_name'];
            
            // Delete the image file from the folder
            $img_path = "../images/food/" . $img_name;
            if (file_exists($img_path)) {
                unlink($img_path);
            }
        }

        
        $sql = "DELETE FROM tbl_food WHERE id = $id";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if($res == true) {
            $_SESSION['delete_food'] = "food deleted successfully";
            header('location:'.SITEURL.'manage-foods.php');
        } else {
            $_SESSION['delete_food_failed'] = "failed to delete food";
            header('location:'.SITEURL.'manage-foods.php');
        }
    } else {
        header('location:'.SITEURL.'manage-foods.php');
    }
?>