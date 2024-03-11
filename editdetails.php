<?php include('components/menu.php'); ?>


    
    <div class="main-content">
                    <div class="wrapper">
                        <h1>Update your Profile</h1>
                        <br><br>
                        <?php
        if (isset($_SESSION['user'])) {
          //get data from admin
          $username = $_SESSION['user'];
          $sql = "SELECT * FROM users WHERE username='$username'";
          //execute
          $res = mysqli_query($conn, $sql);

          //check query execution
          if ($res == true) {
            //count rows to check for data 

            $count = mysqli_num_rows($res);


            //check num rows 
            if ($count > 0) {
              //theres data in base
              while ($rows = mysqli_fetch_assoc($res)) {
                // get all data
                $id = $rows['user_id'];
                $username = $rows['username'];
                $firstname = $rows['firstname'];
                $email =  $rows['email'];
                $phonenumber = $rows['phonenumber'];
                //display data in table
                ?>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <label for="username">Username:</label><br>
                            <input type="text" name="username" id="username" value="<?php echo $username; ?>" required><br><br>
                            <label for="firstname">Firstname:</label><br>
                            <input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" required><br><br>
                            <label for="email">Email:</label><br>
                            <input type="email" name="email" id="email" value="<?php echo $email; ?>" required><br><br>
                            <label for="phonenumber">Phone number:</label><br>
                            <input type="number" name="phonenumber" id="phonenumber" value="<?php echo $phonenumber; ?>" placeholder="Don't start with 0 or +254" required><br><br>
                            <!-- <label for="password">Password:</label><br>
                            <input type="password" name="password" id="password" required><br><br>
                            <label for="confirm_password">Confirm Password:</label><br>
                            <input type="password" name="confirm_password" id="confirm_password" required><br><br> -->
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Profile" class="btn-secondary">                   
                        </form>

        <?php

                }
            }

        }
        

    }
    else
    {
        //Redirect to Manage Food
        header('location:'.SITEURL.'/profile.php');
    }
?>




        <?php 
        
            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";

                //1. Get all the details from the form
                $id = $_POST['id'];
                $username = $_POST['username'];
                $firstname = $_POST['firstname'];
                $email = $_POST['email'];
                $phonenumber = $_POST['phonenumber'];

                

                //2. Update the Food in Database
                $sql3 = "UPDATE users SET 
                    username = '$username',
                    firstname = '$firstname',
                    email = '$email',
                    phonenumber = '$phonenumber'
                    WHERE user_id=$id
                ";

                //echo $sql3;

                //Execute the SQL Query
                $res3 = mysqli_query($conn, $sql3);

                //CHeck whether the query is executed or not 
                if($res3==true)
                {
                    //Query Exectued and Food Updated
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'profile.php');
                }
                else
                {
                    //Failed to Update Food
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                    header('location:'.SITEURL.'editdetails.php');
                }

                
            }
        
        ?>

    </div>
</div>

<?php include('components/footer.php'); ?>