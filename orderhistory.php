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

$count2 = 0;


if($count2 > 0){
    $rows2 = mysqli_fetch_assoc($res2);
    $foodid = $rows2['food_id'];
    $date = $rows2['orderdate'];
    $status = $rows2['status'];
    $quantity = $rows2['quantity'];
    $total = $rows2['total'];
}

$sql2 = "SELECT * FROM tbl_orders WHERE user_id='$userid' ORDER BY id DESC";
//echo $sql2;
$res2 = mysqli_query($conn, $sql2);

if ($res2 && mysqli_num_rows($res2) > 0) {
    // Display orders if there are results
    echo '<table class="table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Food</th>';
    echo '<th>Date</th>';
    echo '<th>Status</th>';
    echo '<th>Quantity</th>';
    echo '<th>Total</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($res2)) {
        echo '<tr>';
        echo '<td>' . $row['food_id'] . '</td>';
        echo '<td>' . $row['orderdate'] . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['total'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No orders found in your history.</p>';
}


?>