<?php include 'components/menu.php';?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="food_search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php 
            //display active
            $sql = "SELECT * FROM food_items WHERE active='yes'";

            //EXECUTE
            $res = mysqli_query($conn, $sql);

            //count rows
            $count = mysqli_num_rows($res);

            //check if available
            if ($count>0) {
                // available
                while ($row=mysqli_fetch_assoc($res)) {
                    // get values 
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_path'];

                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            //check if image is available
                            if ($image_name=="") {
                                // not availble
                                echo "image not available";
                            }else{
                                //available
                                ?>
                                <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="<?php echo $title;?>" class="img-responsive img-curve" style="width:100px; height:100px;">

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
                //not available
                echo "<div class='error'>fppd not found</div>";
            }

            ?>

            

            


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

   <?php include 'components/footer.php';?>