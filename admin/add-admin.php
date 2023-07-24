<?php
    include('./partials/header.php');
?>
    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Add Admin</h1>

        <p class="error">
            <?php 
                if(isset($_SESSION["add_admin_failed"])) {
                    echo $_SESSION["add_admin_failed"];
                    unset($_SESSION["add_admin_failed"]);
                }
            ?>
        </p>
        

        <form action="" method="POST" class="tbl_add">
            <table>
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Your Name" required="required">
                    </td>
                </tr>
    
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your username" required="required">
                    </td>
                </tr>
    
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your password" required="required">
                    </td>
                </tr>
    
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Add Admin">
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
        $full_name = $_POST["full_name"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "INSERT INTO tbl_admin SET
                full_name = '$full_name',
                username = '$username',
                password = '$password'
                ";

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if($res == true) {
            $_SESSION['add_admin'] = "Add Admin Successfully";

            header('location:'.SITEURL.'manage-admin.php');
        } else {
            $_SESSION['add_admin_failed'] = "Add Admin Failed";
        }
    };
?>