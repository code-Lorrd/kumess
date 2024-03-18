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

		
		<a href="reports/foodReports.php" style="cursor:pointer;" rel="noopener noreferrer" target="blank">
		<div class="col-4 text-center">
			<?php 
			$sql2 = "SELECT * FROM food_items";

			//execute
			$res2 = mysqli_query($conn, $sql2);

			//count rows
			$count2 = mysqli_num_rows($res2);

			?>
			<h1><?php echo $count2;?></h1><br>
			Foods on menu
		</div>
		</a>

		 
		<a href="reports/orderReports.php" style="cursor:pointer;" rel="noopener noreferrer" target="blank">
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

			?>
			<h1><?php echo $count3;?></h1><br>
			Total orders
		</div>
		</a>

		<a href="reports/salesReports.php" style="cursor:pointer;" rel="noopener noreferrer" target="blank">
		<div class="col-4 text-center">
			<?php

			//create sql
			//aggregate function
			//$sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='ready'";
			$sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='ordered'";

			//EXECUTE
			$res4 = mysqli_query($conn, $sql4);

			//get value
			$row4 = mysqli_fetch_assoc($res4);

			//get total rev
			$total_rev = $row4['Total'];

			?>
			<h1>Ksh.<?php echo $total_rev;?></h1><br>
			Total Earnings
		</div>
		</a>

		<a href="reports/forecastReport.php" style="cursor:pointer;" rel="noopener noreferrer" target="blank">
		<div class="col-4 text-center">
			<?php

			//create sql
			//aggregate function
			//$sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='ready'";
			$sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='ordered'";

			//EXECUTE
			$res4 = mysqli_query($conn, $sql4);

			//get value
			$row4 = mysqli_fetch_assoc($res4);

			//get total rev
			$total_rev = $row4['Total'];

			?>
			<h1>Ksh.<?php echo $total_rev+1000;?></h1><br>
			Projected Earnings
		</div>
		</a>

		<a href="reports/dailyReport.php" rel="noopener noreferrer" target="blank" style="cursor:pointer;">
		<div class="col-4 text-center">
			<?php

			//create sql
			//aggregate function

			$now = new DateTime();

            // Format the timestamp as a string in the desired format
			$startDate = "2023-03-18 18:56:59";
			$endDate = $now->format('Y-m-d H:i:s');
			//echo $endDate;


			$sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE orderdate BETWEEN '$startDate' AND '$endDate'";
			//$sql4 = "SELECT SUM(total) AS Total FROM tbl_orders WHERE status='ordered'";

			//EXECUTE
			$res4 = mysqli_query($conn, $sql4);

			//get value
			$row4 = mysqli_fetch_assoc($res4);

			//get total rev
			$total_rev = $row4['Total'];

			?>
			<h1>Ksh.<?php echo $total_rev;?></h1><br>
			Daily Earnings
		</div>
		</a>

		<div class="clearfix"></div>
	    </div>
		
	</div>
	<?php include('components/footer.php') ?>