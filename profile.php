<?php
//include('../conn/conn.php');
include 'components/menu.php';
?>

<div class="profile-container">
  <div class="profile-wrapper">
    <h1 class="profile-title">My profile</h1>
    <br><br>

    <section class="user-info">
      <div class="user-details">

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

                <div class="user-data">
                  <p class="data-label">Username: <?php echo $username; ?></p>
                </div>

                <div class="user-data">
                  <p class="data-label">Firstname: <?php echo $firstname; ?></p>
                </div>
                <div class="user-data">
                  <p class="data-label">Email: <?php echo $email; ?></p>
                </div>
                <div class="user-data">
                  <p class="data-label">Phone number: <?php echo $phonenumber; ?></p>
                </div>

              <?php
              }
            } else {
              //no data
            }
          }
        }
        ?>

      </div>
      <a href="editdetails.php" class="edit-button">Edit Details</a>
    </section>
  </div>
</div>
<?php 
include('components/footer.php');
?>