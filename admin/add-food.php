<?php
    include('./partials/header.php');
?>
    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Add Food</h1>

        <p class="error">
            <?php 
                if(isset($_SESSION["add_food_failed"])) {
                    echo $_SESSION["add_food_failed"];
                    unset($_SESSION["add_food_failed"]);
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
                        <input type="text" name="title" placeholder="Food title" required="required">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" id="" cols="22" rows="5"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" step="any" placeholder="Food Price " required="required">
                    </td>
                </tr>
    
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="img" required="required">
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
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>                           
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
        $description = $_POST["description"];
        $price = $_POST["price"];
            if ($price < 0) $price = 0;
        $featured = $_POST["featured"];
        $active = $_POST["active"];
        $category = $_POST["category"];

        // print_r($_FILES['img']);

        if(isset($_FILES['img']['name'])) {
            // Start upload image

            

            // Create path
            $img_name = $_FILES['img']['name']; // name of the image

            //Aotu rename img
            $ext = end(explode('.', $img_name)); //get file extension 

            $img_name = "Food_Name".rand(000, 999).'.'.$ext; 

            $cource_path = $_FILES['img']['tmp_name']; // path of image when uploaded in database
            //$destination_path = realpath(dirname(getcwd())).$img_name; 
            $destination_path = "../images/food/".$img_name; // path of image in folder

            //upload image 
            $upload = move_uploaded_file($cource_path, $destination_path);

            if ($upload == false) {
                // upload failed 
                $_SESSION['upload_faild'] = "Failed to upload image";
                header('location:'.SITEURL.'add-food.php');

                //Stop update all data in database
                die();
            }
        } else {
            //don't upload 
            $img_name ="";
        }

        $conn2 = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn2));
        $db_select2 = mysqli_select_db($conn2, DBNAME);
        $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$img_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                ";

        $res2 = mysqli_query($conn2, $sql2);

        if($res2) {
            $_SESSION['add_food'] = "Add food Successfully";

            header('location:'.SITEURL.'manage-foods.php');
        } else {
            $_SESSION['add_food_failed'] = "Add food Failed";
        }
    };
?>