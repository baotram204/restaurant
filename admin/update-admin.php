<?php
    include('./partials/header.php');

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $conn2 = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn2));
        $db_select = mysqli_select_db($conn2, DBNAME);
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";
        $res = mysqli_query($conn2, $sql);

        if($res) {
            $cout_row = mysqli_fetch_assoc($res);
            $username = $cout_row['username'];
            $full_name = $cout_row['full_name'];

            if($full_name == null) {
                $_SESSION["user_not_found"] = "User not found";
                header('location:'.SITEURL.'manage-admin.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Error. Check your connection and try again";
            header('location:'.SITEURL.'manage-admin.php');
        }
    }
?>
    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Update Admin</h1>

        <p class="error">
            <?php
                if(isset($_SESSION['update_admin_failed'])) {
                    echo $_SESSION["update_admin_failed"];
                    unset($_SESSION['update_admin_failed']);
                }
            ?>
        </p>
        
        <form action="" method="POST" class="tbl_add">
            <table>
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" required="required" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
    
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" required="required" value="<?php echo $username; ?>" >
                    </td>
                </tr>
    
    
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Update Admin">
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
        // $id = $_POST["id"];
        $full_name = $_POST["full_name"];
        $username = $_POST["username"];

        $sql2 = "UPDATE tbl_admin SET
                full_name = '$full_name',
                username = '$username'
                WHERE id = $id
                ";

        $conn2 = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn2));
        $db_select2 = mysqli_select_db($conn2, DBNAME);
        $res2 = mysqli_query($conn2, $sql2) or die(mysqli_error($conn2));

        if($res2 == true) {
            $_SESSION['update_admin'] = "Update Admin Successfully";

            header('location:'.SITEURL.'manage-admin.php');
        } else {
            $_SESSION['update_admin_failed'] = "Update Admin Failed";
            header('location:'.SITEURL.'update-admin.php?id='.$id);
        }
    };
?>