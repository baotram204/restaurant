<?php
    include('partials/header.php');
?>

<!-- Dashboard -->
    <section class="dashboard">
        <h1>Manage Foods</h1>
        
        <p class="success">
            <?php 
                if(isset($_SESSION["add_food"])) {
                    echo $_SESSION["add_food"];
                    unset($_SESSION["add_food"]);
                }

                if(isset($_SESSION["delete_food"])) {
                    echo $_SESSION["delete_food"];
                    unset($_SESSION["delete_food"]);
                }

                if(isset($_SESSION["update_food"])) {
                    echo $_SESSION["update_food"];
                    unset($_SESSION["update_food"]);
                }
            ?>
        </p>

        <p class="error">
            <?php 
                if(isset($_SESSION["delete_food_failed"])) {
                    echo $_SESSION["delete_food_failed"];
                    unset($_SESSION["delete_food_failed"]);
                }
            ?>
        </p>

        <br>
        <a href="<?php echo SITEURL; ?>add-food.php" class="btn_add">Add Food</a>

        <table class="tbl_full">
            <tr>
                <th>S.H</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                $db_select = mysqli_select_db($conn, DBNAME);
                $sql = "SELECT * FROM tbl_food";
                $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

                if($res == true) {
                    $cout_row = mysqli_num_rows($res);
                    $index = 1;

                    if($cout_row> 0) {
                        while($row = mysqli_fetch_array($res)) {
                            $id= $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $img_name = $row['image_name'];
                            $category_id = $row['category_id'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?> 
                                <tr>
                                    <td><?php echo $index++.'. ' ?></td>
                                    <td><?php echo $title ?></td>
                                    <td><?php echo $price ?>$</td>
                                    <td>
                                        <?php 
                                            //check whether name_img valiable
                                            if ($img_name !='' ) {
                                                // display img

                                                ?>
                                                    <img src="<?php echo SITEURL2;?>images/food/<?php echo $img_name; ?>" alt="" width="50px">
                                                <?php
                                            } else {
                                                echo "<div class='error'> Image not Added. </div>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $conn2 = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn2));
                                            $db_select2 = mysqli_select_db($conn2, DBNAME);
                                            $sql2 = "SELECT * FROM tbl_category WHERE id=$category_id";
                                            $res2 = mysqli_query($conn2, $sql2);
                                            if ($res2) {
                                                $row = mysqli_fetch_assoc($res2);
                                                $category_title = $row['title'];
                                                echo $category_title;
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>

                                    <td>
                                        <a href="<?php echo SITEURL; ?>update-food.php?id=<?php echo $id; ?>" class="btn_update">Update food</a>
                                        <a href="<?php echo SITEURL; ?>delete-food.php?id=<?php echo $id; ?>" class="btn_delete">Delete food</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    } else {
                        ?>
                            <tr>
                                <td colspan="3">No Categoty Added Yet.</td>
                            </tr>
                        <?php
                    }
                }
            ?>

        </table>
    </section>

<?php 
    include('partials/footer.php');
?>