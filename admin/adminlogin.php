<?php 
require('../conn/conn.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<h2>Login</h2>
<form action="" method="POST">
  <label for="Username">Username:</label><br>
  <input type="text" name="username" id="username" required><br><br>
  <label for="password">Password:</label><br>
  <input type="password" name="password" id="password" required><br><br>
  <input type="submit" name="submit" value="Login">
</form>
<a href="<?php echo SITEURL;?>login.php" class="btn-primary">Back to user login</a>
		<br><br>
</body>
</html>



<?php 
//check if submit clicked
if (isset($_POST['submit'])) {
	// processs login
	//get data from form

    $username = $_POST['username'];
	$password = $_POST['password']; 
	$password = md5($password);

	//sql to check whether usernam and pass exist
	$sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password' LIMIT 1";

	//execute query
	$res = mysqli_query($conn, $sql);

	// count rows to check if user exists or not 
	$count = mysqli_num_rows($res);

	if ($count==1) {
		// user available and login success
		$_SESSION['login'] = $username;
		$_SESSION['user'] = $username;
		//redirect to index page 
		header('location:'.SITEURL.'admin/index.php');
	}else{
		//user not available
		$_SESSION['login'] = "username and pass dont match";
		//redirect to index page 
		header('location:'.SITEURL.'login.php');
	}

}

?>