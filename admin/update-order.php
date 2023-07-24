<?php
    include('partials/header.php');
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $sql = "SELECT * FROM tbl_order WHERE id=$id";
        $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

        if($res) {
            $row = mysqli_fetch_assoc($res);
            $food = $row['food'];
            $name = $row['customer_name'];
            $contact = $row['customer_contact'];
            $email = $row['customer_email'];
            $address = $row['customer_address'];
            $status = $row['status'];
            $qty = $row['qty'];
            $total = $row['total'];
            $price = $row['price'];
        }
    }
?>

<!-- Dashboard -->
    <section class="dashboard">
        <h1>Manage Order</h1>

        <p class="error">
            <?php
                if(isset($_SESSION['update_order_failed'])) {
                    echo $_SESSION["update_order_failed"];
                    unset($_SESSION['update_order_failed']);
                }

            ?>
        </p>
        
        <form action="" method="POST" class="tbl_add">
            <table>
                <tr>
                    <td><?php echo $food; ?> </td>
                </tr>

                <tr>
                    <td>Quatity </td>
                    <td>
                        <input type="number" name="qty" placeholder="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status: </td>
                    <td>
                        <select name="status" id="">
                            <option value="Ordered" <?php if($status == "Ordered") echo 'selected'; ?>>Ordered</option>
                            <option value="On delivery" <?php if($status == "On delivery") echo 'selected'; ?>>On Delivery</option>
                            <option value="Deliveried" <?php if($status == "Deliveried") echo 'selected'; ?>>Deliveried</option>
                            <option value="Cancelled" <?php if($status == "Cancelled") echo 'selected'; ?>>Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name: </td>
                    <td>
                        <input type="text" name="customer_name" placeholder="<?php echo $name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" placeholder="<?php echo $contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email: </td>
                    <td>
                        <input type="email" name="customer_email" placeholder="<?php echo $email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <input type="text" name="customer_address" placeholder="<?php echo $address; ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" name="submit" value="Update order">
                    </td>
                </tr>
            </table>
        </form>
    </section>

<?php 
    include('partials/footer.php');

    if(isset($_POST['submit'])) {
        $new_qty = $_POST['qty'];
            if($new_qty=='' or $new_qty<0) $new_qty = $qty;
        $new_status = $_POST['status'];
            if($new_status =='') $custumer_status = $status;
        $customer_name = $_POST['customer_name']; 
            if($customer_name=='') $customer_name =$name;
        $customer_contact = $_POST['customer_contact'];
            if($customer_contact=='') $customer_contact =$contact;
        $customer_email = $_POST['customer_email'];
            if($customer_email=='') $customer_email =$email;
        $customer_address = $_POST['customer_address'];
            if($custom_address=='') $custom_address= $address;
        $new_total = $price * $new_qty;

        $sql = "UPDATE tbl_order SET
                qty = $new_qty,
                total = $new_total,
                status = '$new_status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_address = '$custom_address'
                WHERE id=$id
                ";

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if($res == true) {
            $_SESSION['update_order'] = "Update Order Successfully";
            header('location:'.SITEURL.'manage-order.php');
        } else {
            $_SESSION['update_order_failed'] = "Update order Failed";
            header('location:'.SITEURL.'update-order.php?id='.$id);
        }
    }
?>