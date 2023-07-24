<?php 
    include("partials-frontend/header.php");
    if(isset($_GET["search"])) {
        $search = $_GET["search"];
    }
?>

    <!--food-search -->
    <section class="food_search">
        <div class="container">
            <h2 class="text_center">
                Foods on Your Search
                <a href="#" class="text_white">"<?php echo $search; ?>"</a>
            </h2>
        </div>
    </section>


    <!-- Food Menu -->
    <section class="food_menu">
        <h2 class="text_center">Food Menu</h2>

        <div class="container">
            <div class="box_flex">
                <?php 
                    $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                    $db_select = mysqli_select_db($conn, DBNAME);
                    $sql = "SELECT * FROM tbl_food WHERE active='Yes' AND ( title LIKE '%$search%' OR description LIKE '%$search%' )";
                    $res = mysqli_query($conn, $sql);

                    if($res) {
                        $count_row = mysqli_num_rows($res);
                        if($count_row>0) {
                            // display category
                            while( $row = mysqli_fetch_array($res) ) {
                                $id= $row['id'];
                                $title = $row['title'];
                                $description = $row['description'];
                                $price = $row['price'];
                                $img_name = $row['image_name'];
                                
                                ?>
                                    <div class="food_menu_box">
                                        <div class="food_img ">
                                            <img src="./images/food/<?php echo $img_name ?>" alt="">
                                        </div>
                        
                                        <div class="food_descr">
                                            <h5><?php echo $title; ?></h5>
                                            <p class="food_price"><?php echo $price ?></p>
                                            <div class="food_detail"><?php echo $description ?></div>
                                            <a href="<?php echo SITEURL2; ?>order.php?id=<?php echo $id; ?>" class="hover_btn">Order Now</a>
                                        </div>
                                    </div>
                                <?php

                            }
                            
                        } else {
                            ?>
                                <div class="text_center">NO FOOD YET</div>
                            <?php
                        }
                    }
                ?>
    
        </div>
        <p class="text_center">
            <a href="">See All Foods</a>
        </p>
    </section>

<?php 
    include("partials-frontend/footer.php");
?>