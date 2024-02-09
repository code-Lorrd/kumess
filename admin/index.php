<?php include 'components/menu.php';?>
	<div class="main-content">
		<div class="wrapper">
		<h1>DASHBOARD</h1>
		<br><br>
		<?php
		   if (isset($_SESSION['login'])) {
			    //echo $_SESSION['login'];
			    unset($_SESSION['login']);
			
		   }
		?>
		<br><br>

		

		<div class="col-4 text-center">
			<?php 
			$sql2 = "SELECT * FROM food_items";

			//execute
			$res2 = mysqli_query($conn, $sql2);

			//count rows
			$count2 = mysqli_num_rows($res2);

			?>
			<h1><?php echo $count2;?></h1><br>
			Food
		</div>

		<div class="col-4 text-center">
			<?php 

			// Prepare the SQL query using prepared statements for security
			$sql3 = "SELECT COUNT(*) AS order_count FROM tbl_orders WHERE DATE(orderdate) = ?";
			$stmt = $conn->prepare($sql3);

			// Bind the current date parameter to the prepared statement
			$current_date = date("Y-m-d"); // Ensure format matches database column
			$stmt->bind_param("s", $current_date);

			// Execute the prepared statement
			$stmt->execute();

			// Bind the result to a variable
			$stmt->bind_result($count3);

			// Fetch the result
			$stmt->fetch();

			// Close the prepared statement
			$stmt->close();


			// $dateTime = new DateTime();

			// $currentDate = $dateTime->format('Y-m-d H:i:s');
			// $sql3 = "SELECT * FROM tbl_orders WHERE orderdate = '$currentDate';";
			// echo $sql3;
			// //execute
			// $res3 = mysqli_query($conn, $sql3);

			// //count rows
			// $count3 = mysqli_num_rows($res3);

			?>
			<h1><?php echo $count3;?></h1><br>
			Total orders
		</div>

		<div class="col-4 text-center">
			<?php

			//create sql
			//aggregate function
			$sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='ready'";

			//EXECUTE
			$res4 = mysqli_query($conn, $sql4);

			//get value
			$row4 = mysqli_fetch_assoc($res4);

			//get total rev
			$total_rev = $row4['Total'];

			?>
			<h1>Ksh.<?php echo $total_rev;?></h1><br>
			Earnings
		</div>

		<div class="clearfix"></div>
	    </div>
		
	</div>
	<?php include('components/footer.php') ?>