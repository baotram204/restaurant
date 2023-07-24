<?php 
    include("partials-frontend/header.php");
?>

    <!-- categories -->
    <section class="categories">
        <div class="container">
            <h2 class="text_center">Explore Foods</h2>

            <div class="box_flex">
                <?php 
                    $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                    $db_select = mysqli_select_db($conn, DBNAME);
                    $sql = "SELECT * FROM tbl_category  WHERE active='Yes'";
                    $res = mysqli_query($conn, $sql);

                    if($res) {
                        $count_row = mysqli_num_rows($res);
                        if($count_row>0) {
                            // display category
                            while( $row = mysqli_fetch_array($res) ) {
                                $id = $row['id'];
                                $img_name = $row['img_name'];
                                $title = $row['title'];
                                ?>
                                    <a href="<?php echo SITEURL2; ?>category-foods.php?id=<?php echo $id; ?>">
                                        <div class="box3 hover_img">
                                            <img src="./images/category/<?php echo $img_name; ?>" alt="">
                                            <div class="content"><?php echo $title; ?></div>
                                        </div>
                                    </a>
                                <?php

                            }
                            
                        } else {
                            ?>
                                <div class="text_center">NO CATEGORY YET</div>
                            <?php
                        }
                    }
                ?>
            </div>

        </div>
    </section>

<?php 
    include("partials-frontend/footer.php");
?>