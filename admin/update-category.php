<?php
    include('./partials/header.php');

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $conn2 = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn2));
        $db_select = mysqli_select_db($conn2, DBNAME);
        $sql = "SELECT * FROM tbl_category WHERE id=$id";
        $res = mysqli_query($conn2, $sql);

        if($res) {
            $cout_row = mysqli_fetch_assoc($res);
            $curr_title = $cout_row['title'];
            $curr_img_name = $cout_row['img_name']; 
            $curr_featured = $cout_row['featured'];
            $curr_active = $cout_row['active'];

            if($curr_title == null) {
                $_SESSION["category_not_found"] = "Category not found";
                header('location:'.SITEURL.'manage-category.php');
                exit();
            }
        } else {
               $_SESSION['error'] = "Error. Check your connection and try again";
                header('location:'.SITEURL.'manage-category.php');
        }
    }
?>
    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Update Category</h1>

        <p class="error">
            <?php
                if(isset($_SESSION['update_category_failed'])) {
                    echo $_SESSION["update_category_failed"];
                    unset($_SESSION['update_category_failed']);
                }

                if(isset($_SESSION['upload_faild'])) {
                    echo $_SESSION["upload_faild"];
                    unset($_SESSION['upload_faild']);
                }
            ?>
        </p>
        
        <form action="" method="POST" class="tbl_add" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="<?php echo $curr_title; ?>">
                    </td>
                </tr>
    
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            //check whether name_img valiable
                            if ($curr_img_name !='' ) {
                                // display img
                                ?>
                                    <img src="<?php echo SITEURL2;?>images/category/<?php echo $curr_img_name; ?>" alt="" width="100px">
                                <?php
                            } else {
                                echo "<div class='error'> Image not Added. </div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="img" >
                    </td>
                </tr>
    
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if($curr_featured == 'Yes') echo 'checked'; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if($curr_featured == 'No') echo 'checked'; ?> > No
                    </td>
                </tr>

                <tr>
                    <td> Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($curr_active == 'Yes') echo 'checked'; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if($curr_active == 'No') echo 'checked'; ?> > No
                    </td>
                </tr>
    
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Update Category">
                    </td>
                </tr>
            </table>
        </form>
    </section>

<?php 
    include('partials/footer.php');

    //get values from form category and then save it to database

    // check submitted
    if(isset($_POST["submit"])) {
        // $id = $_POST["id"];
        $new_title = $_POST['title'];
        if ($new_title =='') $new_title = $curr_title;
        
        $new_featured = $_POST['featured'];
        $new_active = $_POST['active']; 

        // print_r($_FILES['img']);
        
        if(isset($_FILES['img']['name']) && $_FILES['img']['name'] !='') {
            // Start upload image
            // Create path
            $new_img_name = $_FILES['img']['name']; // name of the image

            //Aotu rename img
            $ext = end(explode('.', $new_img_name)); //get file extension 

            $new_img_name = "Food_Category_".rand(000, 999).'.'.$ext; 

            $cource_path = $_FILES['img']['tmp_name']; // path of image when uploaded in database
            //$destination_path = realpath(dirname(getcwd())).$img_name; 
            $destination_path = "../images/category/".$new_img_name; // path of image in folder

            //upload image 
            $upload = move_uploaded_file($cource_path, $destination_path);

            if ($upload == false) {
                // upload failed 
                $_SESSION['upload_faild'] = "Failed to upload image";
                header('location:'.SITEURL.'update-category.php');

                //Stop update all data in database
                die();
            }
        } else {
            //don't upload 
            $new_img_name = $curr_img_name;
        }

        $sql = "UPDATE tbl_category SET
                title = '$new_title',
                featured = '$new_featured',
                img_name = '$new_img_name',
                active = '$new_active'
                WHERE id = $id
                ";

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if($res == true) {
            $_SESSION['update_category'] = "Update category Successfully";

            header('location:'.SITEURL.'manage-category.php');
        } else {
            $_SESSION['update_category_failed'] = "Update category Failed";
            header('location:'.SITEURL.'update-category.php?id='.$id);
        }
    };
?>