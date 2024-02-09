<?php 
include'conn/conn.php';
include 'components/login_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/registration.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/loggo.jpg" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="foods.php">Foods</a>
                    </li>
                    <li>
                        <a href="orderhistory.php">Your Orders</a>
                    </li>
                    <li><?php echo $_SESSION['user'];?></li>
                    <li>
                        <a href="logout.php">Log out</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>