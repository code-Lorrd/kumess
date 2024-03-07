<?php include 'components/menu.php';?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 
            $search = $_POST['search'];

            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
           
            <h2 class="text-center">Food Menu</h2>
            <?php

            //sql query to get food based on search
            $sql = "SELECT * FROM food_items WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            //EXECUTE
            $res = mysqli_query($conn, $sql);

            //count rows
           // $count = mysqli_num_rows($res);
            $count = mysqli_num_rows($res);

            //check wheher food available
            if ($count>0) {
                // available
                while ($row=mysqli_fetch_assoc($res)) {
                    // get details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_path'];

                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                            //check whether image is available
                            if ($image_name=="") {
                                // not available
                                echo "<div class='error'>image not available</div>";
                            }else{
                                //available
                                ?>

                                 <img src="<?php echo SITEURL?>images/food/<?php echo $image_name;?>" alt="<?php echo $title;?>" class="img-responsive img-curve"style="height:100px;width:300px;">


                                <?php
                            }

                            ?>
                            
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title;?></h4>
                            <p class="food-price"><?php echo $price;?></p>
                            <p class="food-detail">
                                 <?php echo $description;?>
                            </p>
                    <br>

                            <a href="<?php echo SITEURL?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            }else{
                echo "<div class='error'>food not found</div>";
            }

            ?>

            


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

   <?php include 'components/footer.php';?>