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
            $password = $cout_row['password'];
            if($password == null) {
                $_SESSION["user_not_found"] = "User not found";
                header('location:'.SITEURL.'manage-admin.php');
                exit();
            }
        } else {
            header('location:'.SITEURL.'manage-admin.php');
        }
    }
?>
    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Change Password</h1>

        <p class="error">
            <?php
                if(isset($_SESSION['error_newPassword'])) {
                    echo $_SESSION["error_newPassword"];
                    unset($_SESSION['error_newPassword']);
                }

                if(isset($_SESSION['error_oldPassword'])) {
                    echo $_SESSION["error_oldPassword"];
                    unset($_SESSION['error_oldPassword']);
                }

                if(isset($_SESSION['error_changePassword'])) {
                    echo $_SESSION["error_changePassword"];
                    unset($_SESSION['error_changePassword']);
                }
            ?>
        </p>
        
        <form action="" method="POST" class="tbl_add">
            <table>
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="curr_password" required="required" placeholder="Old Password" >
                    </td>
                </tr>
    
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" required="required" placeholder="New Password">
                    </td>
                </tr>
    
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="con_password" required="required" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" name="submit" value="Change Password">
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
        $curr_password = $_POST["curr_password"];
        $new_password = $_POST["new_password"];
        $con_password = $_POST["con_password"];


        if ($new_password != $con_password) {
            // check confirm new password vs confirm password
            $_SESSION['error_newPassword'] = "Confirm that the new password doesn't match. Please try again.";
        } else {
            // check old password vs current password
            if ($curr_password != $password) {
                $_SESSION['error_oldPassword'] = "Old password failed. Please try again.";
            } else {
                if ($curr_password == $new_password) {
                    $_SESSION['error_changePassword'] = "The new password must be different from the old password. Please try again.";
                } else {
                    // update password in database
                    $sql = "UPDATE tbl_admin SET
                            password = '$new_password'
                            WHERE id = $id
                            ";
    
                    $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                    $db_select = mysqli_select_db($conn, DBNAME);
                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    if($res == true) {
                        $_SESSION['change'] = "Change Password Successfully";
                        header('location:'.SITEURL.'manage-admin.php');
                    } else {
                        $_SESSION['change_failed'] = "Change Password Failed";
                        header('location:'.SITEURL.'change-pasword.php?id='.$id);
                    }
                }
            }
        }

        
    };
?>