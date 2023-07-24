<?php
    include('./partials/header.php');

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $sql = "SELECT * FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res) {
            $cout_row = mysqli_fetch_assoc($res);
            $curr_title = $cout_row['title'];
            $curr_description = $cout_row['description'];
            $curr_price = $cout_row['price'];
            $curr_img_name = $cout_row['image_name']; 
            $curr_category_id = $cout_row['category_id'];
            $curr_featured = $cout_row['featured'];
            $curr_active = $cout_row['active'];

            if($curr_title == null) {
                $_SESSION["food_not_found"] = "food not found";
                // header('location:'.SITEURL.'manage-foods.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Error. Check your connection and try again";
            // header('location:'.SITEURL.'manage-foods.php');
        }
    }
?>
    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Update Food</h1>

        <p class="error">
            <?php
                if(isset($_SESSION['update_food_failed'])) {
                    echo $_SESSION["update_food_failed"];
                    unset($_SESSION['update_food_failed']);
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
                    <td>Description: </td>
                    <td>
                        <textarea type="text" name="description"  cols="22" rows="5"><?php echo $curr_description; ?> </textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" step="any" placeholder="<?php echo $curr_price; ?>">
                    </td>
                </tr>
    
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            //check whether name_img valiable
                            if ($curr_img_name !='' ) {
                                ?>
                                    <img src="<?php echo SITEURL2;?>images/food/<?php echo $curr_img_name; ?>" alt="" width="50px">
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
                    <td>Category: </td>
                    <td>
                        <select name="category" id="">
                            <?php
                                $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                                $db_select = mysqli_select_db($conn, DBNAME);
                                $sql = "SELECT * FROM tbl_category WHERE active ='Yes'";
                                $res = mysqli_query($conn, $sql);
                                
                                if(!$res ) {
                                    die("Error");
                                }

                                $count = mysqli_num_rows($res);
                                
                                //display options of category
                                if($count >0 ) {
                                    while($row = mysqli_fetch_assoc($res)) {
                                        $cur_id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                            <option value="<?php echo $cur_id;?>" <?php if($cur_id == $curr_category_id) echo "selected" ?>> <?php echo $title; ?> </option>                           
                                        <?php
                                    }
                                } else {
                                    ?>
                                        <option value="0">No Category Found</option>                           
                                    <?php
                                }

                                //display on dropdown 

                            ?>
                                                   
                        </select>
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
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($curr_active == 'Yes') echo 'checked'; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if($curr_active == 'No') echo 'checked'; ?> > No
                    </td>
                </tr>
    
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Update food">
                    </td>
                </tr>
            </table>
        </form>
    </section>

<?php 
    // include('partials/footer.php');
    
    //get values from form food and then save it to database
    // check submitted
    if(isset($_POST["submit"])) {
        $new_title = $_POST['title'];
            if ($new_title =='') $new_title = $curr_title;
        $new_description = $_POST['description'];
            if ($new_description =='') $new_description = $curr_description;
        $new_price = $_POST['price'];
            if ($new_price =='') $new_price = $curr_price;
        $new_category_id = $_POST['category'];
        $new_featured = $_POST['featured'];
        $new_active = $_POST['active']; 

        // print_r($_FILES['img']);
        
        if(isset($_FILES['img']['name']) && $_FILES['img']['name'] !='') {
            // Start upload image
            // Create path
            $new_img_name = $_FILES['img']['name']; // name of the image

            //Aotu rename img
            $ext = end(explode('.', $new_img_name)); //get file extension 

            $new_img_name = "Food_Name_".rand(000, 999).'.'.$ext; 

            $cource_path = $_FILES['img']['tmp_name']; // path of image when uploaded in database
            //$destination_path = realpath(dirname(getcwd())).$img_name; 
            $destination_path = "../images/food/".$new_img_name; // path of image in folder

            //upload image 
            $upload = move_uploaded_file($cource_path, $destination_path);

            if ($upload == false) {
                // upload failed 
                $_SESSION['upload_faild'] = "Failed to upload image";
                // header('location:'.SITEURL.'update-food.php');

                //Stop update all data in database
                die();
            }
        } else {
            //don't upload 
            $new_img_name = $curr_img_name;
        }
        
        $sql = "UPDATE tbl_food SET
                title = '$new_title',
                description = '$new_description',
                price = $new_price,
                image_name = '$new_img_name',
                category_id = $new_category_id,
                featured = '$new_featured',
                active = '$new_active'
                WHERE id = $id
                ";

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if($res == true) {
            $_SESSION['update_food'] = "Update food Successfully";
            header('location:'.SITEURL.'manage-foods.php');
        } else {
            $_SESSION['update_food_failed'] = "Update food Failed";
            header('location:'.SITEURL.'update-food.php?id='.$id);
        }
    };
?>