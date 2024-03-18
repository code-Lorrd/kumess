<?php 
include'../conn/conn.php';
include 'login_check.php';

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home page</title>
	<link rel="stylesheet" href="../css/admin.css">
</head>
<body>
	<div class="menu text-center">
		<div class="wrapper">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="manageadmin.php">Admin</a></li>
			<li><a href="managefood.php">Food</a></li>
			<li><a href="manageorder.php">Order</a></li>
			<li><a href="reports.php">Reports</a></li>
			<li><?php echo $_SESSION['user'];?></li>
			<li><a href="logout.php">Log out</a></li>
		</ul>
	    </div>
		
	</div>

</body>
</html>