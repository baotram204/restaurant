<?php
    include('partials/header.php');
?>

<!-- Dashboard -->
    <section class="dashboard">
        <h1>Manage Category</h1>

        <p class="success">
            <?php 
                if(isset($_SESSION["add_category"])) {
                    echo $_SESSION["add_category"];
                    unset($_SESSION["add_category"]);
                }

                if(isset($_SESSION["delete_category"])) {
                    echo $_SESSION["delete_category"];
                    unset($_SESSION["delete_category"]);
                }

                if(isset($_SESSION["update_category"])) {
                    echo $_SESSION["update_category"];
                    unset($_SESSION["update_category"]);
                }
            ?>
        </p>

        <p class="error">
            <?php 
                if(isset($_SESSION["delete_category_failed"])) {
                    echo $_SESSION["delete_category_failed"];
                    unset($_SESSION["delete_category_failed"]);
                }

                if(isset($_SESSION["error"])) {
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                }

                if(isset($_SESSION["category_not_found"])) {
                    echo $_SESSION["category_not_found"];
                    unset($_SESSION["category_not_found"]);
                }
            ?>
        </p>

        <br>
        <a href="<?php echo SITEURL; ?>add-category.php" class="btn_add">Add Category</a>

        <table class="tbl_full">
            <tr>
                <th>S.H</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                $db_select = mysqli_select_db($conn, DBNAME);
                $sql = "SELECT * FROM tbl_category";
                $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

                if($res == true) {
                    $cout_row = mysqli_num_rows($res);
                    $index = 1;

                    if($cout_row> 0) {
                        while($row = mysqli_fetch_array($res)) {
                            $id= $row['id'];
                            $title = $row['title'];
                            $img_name = $row['img_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?> 
                                <tr>
                                    <td><?php echo $index++.'. ' ?></td>
                                    <td><?php echo $title ?></td>
                                    <td>
                                        <?php 
                                            //check whether name_img valiable
                                            if ($img_name !='' ) {
                                                // display img

                                                ?>
                                                    <img src="<?php echo SITEURL2;?>images/category/<?php echo $img_name; ?>" alt="" width="100px">
                                                <?php
                                            } else {
                                                echo "<div class='error'> Image not Added. </div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured ?></td>
                                    <td><?php echo $active ?></td>

                                    <td>
                                        <a href="<?php echo SITEURL; ?>update-category.php?id=<?php echo $id; ?>" class="btn_update">Update Category</a>
                                        <a href="<?php echo SITEURL; ?>delete-category.php?id=<?php echo $id; ?>" class="btn_delete">Delete Category</a>
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