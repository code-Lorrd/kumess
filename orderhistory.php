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
        //echo("$userid");
    }else{
        //not available
        //redirect
        echo "Username not available";
    }

    
}


$sql2 = "SELECT * FROM tbl_orders WHERE userid='$userid'";
//echo($sql2);
$res2 = mysqli_query($conn, $sql2);
$count2 = mysqli_num_rows($res2);

if($count > 0){
    $rows2 = mysqli_fetch_assoc($res2);
    $foodid = $rows2['food_id'];
    $date = $rows2['orderdate'];
    $status = $rows2['status'];
    $quantity = $rows2['quantity'];
    $total = $rows2['total'];
}
?>