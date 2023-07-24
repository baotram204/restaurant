<?php 
    include("./config/constants.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Restaurant</title>
</head>
<body>
    <!--Header -->
    <section class="header">
        <div class="container">
            <div class="box">
                <div class="logo">
                    <img src="./images/logo.png" alt="">
                </div>
    
                <ul>
                    <li>
                        <a href="<?php echo SITEURL2; ?>index.php">Home</a>
                    </li> 
                    <li>
                        <a href="<?php echo SITEURL2; ?>categories.php">Categories</a>
                    </li> 
                    <li>
                        <a href="<?php echo SITEURL2; ?>foods.php">Foods</a>
                    </li> 
                    <li>    
                        <a href="<?php echo SITEURL2; ?>#">Contact</a>
                    </li> 
                </ul>
            </div>
        </div>
    </section>