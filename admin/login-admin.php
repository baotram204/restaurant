<?php
    include('../config/constants.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>ORDER FOOD</title>
</head>
<body>
    <section class="login_admin">
        <h1>Login</h1>
        <form action="" method="POST">

            <p class="error">
                <?php
                    if(isset($_SESSION['login_failed'])) {
                        echo $_SESSION["login_failed"];
                        unset($_SESSION['login_failed']);
                    }

                    if(isset($_SESSION['no_message'])) {
                        echo $_SESSION["no_message"];
                        unset($_SESSION['no_message']);
                    }
                ?>
            </p>

            <div class="marg">
                <input type="text" name="username" required="required" placeholder="Your username" >
            </div>

            <div class="marg">
                <input type="password" name="password" required="required" placeholder="Your password" >
            </div>

            <div class="marg">
                <input type="submit" name="submit" value="Login">
            </div>
            
        </form>
    </section>
</body>
</html>

<?php
    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
        $db_select = mysqli_select_db($conn, DBNAME);

        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res); //  check whether conditions true or false

        if($count == 1) {
            // condition true
            $_SESSION['login'] = "Login successful.";
            $_SESSION['user'] = $username; // check whether user login or not  and logout will unset it 

            header('location:'.SITEURL);
        } else {
            $_SESSION['login_failed'] = "Username or password  false!";
            header('location:'.SITEURL.'login-admin.php');
        }

    }
?>