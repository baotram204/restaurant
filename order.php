<?php 
    include("partials-frontend/header.php");
    if(isset($_GET["id"])) {
        $id = $_GET["id"];

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $sql = "SELECT * FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $img_name = $row['image_name'];
        }
    }
?>

    <p class="error text_center">
        <?php 
            if(isset($_SESSION['order_failed'])) {
                echo $_SESSION['order_failed'];
                unset($_SESSION['order_failed']);
            }
        ?>
    </p>

    <!--food-order -->
    <section class="food_order">
        <div class="container">
            <h2 class="text_center text_white">Fill this form to confirm your order.</h2>

            <form action="" class="text_center" method="POST" >
                <div class="order">

                    <fieldset class="fieldset1">
                        <legend>Selected Food</legend>
    
                        <div class="food_order_box">
                            <div class="food_img">
                                <img src="./images/food/<?php echo $img_name; ?>" alt="">
                            </div>
            
                            <div class="food_descr">
                                <h1 class="text_red "><?php echo $title; ?></h1>
                                <p class="food_price"><?php echo $price; ?> $</p>
                                <h4>Quantity</h4>
                                <input type="number" name="qty" class="input_qtt" min="1" required>
                            </div>
                        </div>
                    </fieldset>
    
                    <fieldset class="fieldset2">
                        <legend>Delivery Details</legend>  

                        <div class="food_descr">
                            <div class="fix_row">
                                <h4>Full Name</h4>
                                <input type="text" name="customer_name" class="full_name" required>
                            </div>

                            <div class="fix_row">
                                <h4>Phone Number</h4>
                                <input type="number" name="customer_contact" class="phone" required>
                            </div>

                            <div class="fix_row">
                                <h4>Email</h4>
                                <input type="email" name="customer_email" class="email" required>
                            </div>

                            <div class="fix_row">
                                <h4>Address</h4>
                                <textarea name="customer_address" id="" required></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <input type="submit" name="submit" value="Confirm Order" class="submit_order">
            </form>
        </div>
        <?php 
            if(isset($_POST['submit'])) {
                $qty = $_POST['qty'];
                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address'];
                $total = $qty * $price;
                $order_date = date("Y-m-d H:i:s"); 
                $status = "Ordered"; // inclue: Ordered, On Delivery, Delivered, Cancelled.
        
                $sql2 = "INSERT INTO tbl_order SET
                        food = '$title',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                        ";
        
                $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                $db_select = mysqli_select_db($conn, DBNAME);
                $res = mysqli_query($conn, $sql2);
                if ($res) {
                    $_SESSION['order'] = "Order Successfully";
                    header('location:'.SITEURL2.'index.php');
                    exit();
                } else {
                    $_SESSION['order_failed'] = "Order Failed";
                    header('location:'.SITEURL2.'order.php?id='.$id);
                }
            }
        ?>
    </section>


<?php 
    include("partials-frontend/footer.php");
?>

