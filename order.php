<?php
include 'components/menu.php';

if (isset($_SESSION['user'])) {
    // cod
    $username = $_SESSION['user'];
    $sqlid = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $resid = mysqli_query($conn, $sqlid);

    $countid = mysqli_num_rows($resid);

    //check data vailable
    if ($countid == 1) {
        // we have data
        $rowid = mysqli_fetch_assoc($resid);
        $userid = $rowid['user_id'];
        //echo("$userID");
    }else{
        //not available
        //redirect
        echo "Username not available";
    }

    
}

if (isset($_GET['food_id'])) {
    // get fooed id and details of selected food
    $food_id = $_GET['food_id'];


    //get the details of selected food
    $sql = "SELECT * FROM food_items WHERE id='$food_id'";

    //execute
    $res = mysqli_query($conn, $sql);

    //count rows
    $count = mysqli_num_rows($res);

    //check data vailable
    if ($count>0) {
        // we have data
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_path'];
    }else{
        //not available
        //redirect
        header('location'.SITEURL);
    }
}else{
    //redirect to home
    header('location:'.SITEURL.'home.php');
}

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <!-- <section class="food-search"> -->
        <div class="container">
            
            <h2 class="text-center text-black">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php

                        //check if image is available
                        if ($image_name=="") {
                            // not available
                            echo "<div class='error'>image not available</div>";
                        }else{
                            //available
                            ?>

                            <img src="<?php SITEURL?>images/food/<?php echo $image_name;?>" alt="<?php echo $title;?>" class="img-responsive img-curve" style="width:100px; height:100px;">

                            <?php
                        }

                        ?>
                        
                    </div>
    
                    <!-- <div class="food-menu-desc"> -->
                        <h3><?php echo $title;?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">
                        <p class="food-price"><?php echo $price;?></p>
                        <input type="hidden" name="price" value="<?php echo $price;?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" value="1" required>
                        
                    <!-- </div> -->

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full_name" placeholder="E.g. Lewis Mutonyi">

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. o712435678" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@order.gmail.com" >

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="6" placeholder="E.g. Street, City, Country" ></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php 
            //check whether button iss clicked
            if (isset($_POST['submit'])) {
                // get all the data from form
                //$food = $_POST['food'];
                $price = $_POST['price'];
                $quantity = $_POST['qty'];

                $total = $price * $quantity;

                //$orderdate = date("Y-m-d h:i:sa");

                $status = "ordered";

                $customername = $_POST['full_name'];
                $customercontact = $_POST['contact'];
                $customeremail = $_POST['email'];
                $customeraddress = $_POST['address'];

                //save the order to db
                // sql

                $sql2 = "INSERT INTO tbl_orders SET
                food_id = '$food_id',
                user_id = '$userid',
                price = $price,
                quantity = $quantity,
                total = $total,
                status = '$status',
                customername = '$customername',
                customercontact = '$customercontact',
                customeremail = '$customeremail',
                customeraddress = '$customeraddress'
                ";

                //echo $sql2;// die();
               
                //execute query
                $result = mysqli_query($conn, $sql2);

                //check execution
                if ($result==true) {
                    // success
                    $_SESSION['ordered'] = "<div class='success'>order has been taken</div>";
                    header('location:'.SITEURL."orderhistory.php");
                }else{
                    //failed to save
                    $_SESSION['order_fail'] = "<div class='error'>order has not been taken</div>";
                    //header('location:'.SITEURL);
                }

            }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->


