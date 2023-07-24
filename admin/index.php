<?php
    include('partials/header.php');
?>

    <!-- Dashboard -->
    <section class="dashboard">
        <h1>Dashboard</h1>

        <p class="success">
            <?php
                if(isset($_SESSION['login'])) {
                    echo $_SESSION["login"];
                    unset($_SESSION['login']);
                }
            ?>
        </p>

        <div class="displ_flex">
            <div class="box">
                <h1>
                    <?php 
                        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                        $sql = "SELECT * FROM tbl_category";
                        $db_select = mysqli_select_db($conn, DBNAME);
                        $res = mysqli_query($conn, $sql);
                        echo $count = mysqli_num_rows($res);
                    ?>
                </h1>
                <div class="text">Categories</div>
            </div>
    
            <div class="box">
                <h1>
                    <?php 
                        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                        $sql = "SELECT * FROM tbl_food";
                        $db_select = mysqli_select_db($conn, DBNAME);
                        $res = mysqli_query($conn, $sql);
                        echo $count = mysqli_num_rows($res);
                    ?>
                </h1>
                <div class="text">Foods</div>
            </div>
    
            <div class="box">
                <h1>
                    <?php 
                        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                        $sql = "SELECT * FROM tbl_order";
                        $db_select = mysqli_select_db($conn, DBNAME);
                        $res = mysqli_query($conn, $sql);
                        echo $count = mysqli_num_rows($res);
                    ?>
                </h1>
                <div class="text">Total Order</div>
            </div>
    
            <div class="box">
                <h1>
                    <?php 
                        $conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD) or die(mysqli_error($conn));
                        $sql = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Deliveried'";
                        $db_select = mysqli_select_db($conn, DBNAME);
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_fetch_assoc($res);
                        $total_revenue = $count['Total'];
                        if($total_revenue == '') $total_revenue = 0;
                        echo $total_revenue;
                    ?>
                </h1>
                <div class="text">Revenue</div>
            </div>
        </div>
    </section>

<?php 
    include('partials/footer.php');
?>