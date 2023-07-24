<?php
    include('./partials/header.php');
?>
    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Add Category</h1>

        <p class="error">
            <?php 
                if(isset($_SESSION["add_category_failed"])) {
                    echo $_SESSION["add_category_failed"];
                    unset($_SESSION["add_category_failed"]);
                }

                if(isset($_SESSION["upload_faild"])) {
                    echo $_SESSION["upload_faild"];
                    unset($_SESSION["upload_faild"]);
                }
            ?>
        </p>
        

        <form action="" method="POST" class="tbl_add" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category title" required="required">
                    </td>
                </tr>
    
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="img" required="required">
                    </td>
                </tr>
    
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"  required="required"> Yes
                        <input type="radio" name="featured" value="No"  required="required"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"  required="required"> Yes
                        <input type="radio" name="active" value="No"  required="required"> No
                    </td>
                </tr>
    
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Add Admin">
                    </td>
                </tr>
            </table>
        </form>
    </section>

<?php 
    include('partials/footer.php');

    //get values from form admin and then save it to database

    // check submitted
    if(isset($_POST["submit"])) {
        $title = $_POST["title"];
        $featured = $_POST["featured"];
        $active = $_POST["active"];

        // print_r($_FILES['img']);

        if(isset($_FILES['img']['name'])) {
            // Start upload image

            

            // Create path
            $img_name = $_FILES['img']['name']; // name of the image

            //Aotu rename img
            $ext = end(explode('.', $img_name)); //get file extension 

            $img_name = "Food_Category_".rand(000, 999).'.'.$ext; 

            $cource_path = $_FILES['img']['tmp_name']; // path of image when uploaded in database
            //$destination_path = realpath(dirname(getcwd())).$img_name; 
            $destination_path = "../images/category/".$img_name; // path of image in folder

            //upload image 
            $upload = move_uploaded_file($cource_path, $destination_path);

            if ($upload == false) {
                // upload failed 
                $_SESSION['upload_faild'] = "Failed to upload image";
                header('location:'.SITEURL.'add-category.php');

                //Stop update all data in database
                die();
            }
        } else {
            //don't upload 
            $img_name ="";
        }

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $sql = "INSERT INTO tbl_category SET
                title = '$title',
                img_name = '$img_name',
                featured = '$featured',
                active = '$active'
                ";

        $res = mysqli_query($conn, $sql);
        if($res) {
            $_SESSION['add_category'] = "Add Category Successfully";

            header('location:'.SITEURL.'manage-category.php');
        } else {
            $_SESSION['add_category_failed'] = "Add Category Failed";
        }
    };
?>