<?php
    include('./partials/header.php');
?>
    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Manage Admin</h1>

        <br>
        <a href="<?php echo SITEURL; ?>add-admin.php" class="btn_add">Add Admin</a>
        
        <p class="success">
            <?php 
                if(isset($_SESSION["add_admin"])) {
                    echo $_SESSION["add_admin"];
                    unset($_SESSION["add_admin"]);
                }

                if(isset($_SESSION["update_admin"])) {
                    echo $_SESSION["update_admin"];
                    unset($_SESSION["update_admin"]);
                }

                if(isset($_SESSION["delete_admin"])) {
                    echo $_SESSION["delete_admin"];
                    unset($_SESSION["delete_admin"]);
                }

                if(isset($_SESSION["change"])) {
                    echo $_SESSION["change"];
                    unset($_SESSION["change"]);
                }
            ?>
        </p>

        <p class="error">
            <?php
                if(isset($_SESSION["change_failed"])) {
                    echo $_SESSION["change_failed"];
                    unset($_SESSION["change_failed"]);
                } 
                
                if(isset($_SESSION["delete_admin_failed"])) {
                    echo $_SESSION["delete_admin_failed"];
                    unset($_SESSION["delete_admin_failed"]);
                }

                if(isset($_SESSION["user_not_found"])) {
                    echo $_SESSION["user_not_found"];
                    unset($_SESSION["user_not_found"]);
                }

                if(isset($_SESSION["error"])) {
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                }
            ?>
        </p>

        <table class="tbl_full">
            <tr>
                <th>S.H</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
                $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                $db_select = mysqli_select_db($conn, DBNAME);
                $sql = "SELECT * FROM tbl_admin";
                $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

                if($res == true) {
                    $cout_row = mysqli_num_rows($res);
                    $index = 1;

                    if($cout_row> 0) {
                        while($row = mysqli_fetch_array($res)) {
                            $id= $row['id'];
                            $full_name = $row['full_name'];
                            $username = $row['username'];

                            ?> 
                                <tr>
                                    <td><?php echo $index++.'. ' ?></td>
                                    <td><?php echo $full_name ?></td>
                                    <td><?php echo $username ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>update-admin.php?id=<?php echo $id; ?>" class="btn_update">Update Admin</a>
                                        <a href="<?php echo SITEURL; ?>delete-admin.php?id=<?php echo $id; ?>" class="btn_delete">Delete Admin</a>
                                        <a href="<?php echo SITEURL; ?>change-password.php?id=<?php echo $id; ?>" class="btn_changePassword">Change Password</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    } else {
                        ?>
                            <tr>
                                <td colspan="3">No Addmin Added Yet.</td>
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

