<?php
    include('partials/header.php');

?>

<!-- Dashboard -->
    <section class="dashboard">
        <h1>Manage Order</h1>

        <p class="success">
            <?php
                if(isset($_SESSION['update_order'])) {
                    echo $_SESSION["update_order"];
                    unset($_SESSION['update_order']);
                }

            ?>
        </p>
        
        <table class="tbl_full">
            <tr>
                <th>S.H</th>
                <th>Food</th>
                <th>Qty</th>
                <th>Total</th>
                <!-- <th>Order Date</th> -->
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
                $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                $db_select = mysqli_select_db($conn, DBNAME);
                $sql = "SELECT * FROM tbl_order";
                $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

                if($res) {
                    $cout_row = mysqli_num_rows($res);
                    $index = 1;
                    if ($cout_row >0) {
                        while($row = mysqli_fetch_array($res)) {
                            $id = $row['id'];
                            $food = $row['food'];
                            $name = $row['customer_name'];
                            $contact = $row['customer_contact'];
                            $email = $row['customer_email'];
                            $address = $row['customer_address'];
                            $status = $row['status'];
                            $qty = $row['qty'];
                            $total = $row['total'];
                            // $date = $row['order_date'];
    
                            ?>
                                <tr>
                                    <td><?php echo $index++ ?></td>
                                    <td><?php echo $food;?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td><?php echo $total ?></td>
                                    <!-- <td><?php echo $date; ?> $</td> -->
                                    <td>
                                        <?php 
                                            if($status == 'Ordered') echo "<div style='color:#00A803'>$status</div>";
                                            if($status == 'On delivery') echo "<div style='color:#0055A8'>$status</div>";
                                            if($status == 'Deliveried') echo "<div style='color:#ed00c3'>$status</div>";
                                            if($status == 'Cancelled') echo "<div style='color:#A80010'>$status</div>";
                                        ?>
                                    </td>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $contact; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $address; ?></td>

                                    <td>
                                        <a href="<?php echo SITEURL; ?>update-order.php?id=<?php echo $id; ?>" class="btn_update">Update order</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                }
            ?>
        </table>
    </section>

<?php 
    include('partials/footer.php');
?>