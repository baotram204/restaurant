<?php
    include('../config/constants.php');
    include('login-check.php');
?>

<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Restaurant - Amin</title>
</head>
<body>
    <!-- Header -->
    <section class="header">
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li> 
            <li>
                <a href="manage-admin.php">Admin</a>
            </li> 
            <li>
                <a href="manage-category.php">Category</a>
            </li> 
            <li>
                <a href="manage-foods.php">Foods</a>
            </li> 
            <li>    
                <a href="manage-order.php">Order</a>
            </li>
            <li>    
                <a href="Logout-admin.php">Logout</a>
            </li>
        </ul>
    </section>