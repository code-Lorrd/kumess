<?php require('conn/conn.php');?>
<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<style>
    .login {
    background-image: url("images/kumess.jpeg");
    background-size: cover; /* Or your desired size/positioning */
    background-repeat: no-repeat; /* Or your desired repeat behavior */
    height: 100vh; /* Or your desired height */
}

</style>
<link rel="stylesheet" href="css/registration.css">
</head>
<body>
<script>
	const passwordInput = document.getElementById('password');
	const eyeIcon = document.getElementById('eye');

	eyeIcon.addEventListener('click', () => {
	if (passwordInput.type === 'password') {
		passwordInput.type = 'text';
		eyeIcon.classList.add('active'); // Add active class for styling (optional)
	} else {
		passwordInput.type = 'password';
		eyeIcon.classList.remove('active'); // Remove active class for styling (optional)
	}
	});

</script>
<div class="login">
<img src="images/logo.png" alt="KU Logo" class="img-responsive" style="width:80px; height:80px; padding-top:30px;">
<h2 style="margin-top:0px;">Login</h2>
<form action="" method="POST">
  <label for="Username">Username</label><br>
  <input type="text" name="username" id="username" required><br><br>
  <label for="password">Password</label><br>
  <div class="password-container">
    <input type="password" name="password" id="password" required>
    <i id="eye" class="fas fa-eye"></i> 
  </div><br><br>
  <input type="submit" name="submit" value="Login">
  <a href="<?php echo SITEURL;?>registration.php" class="btn-secondary">Register</a>
</form>
<a href="<?php echo SITEURL;?>admin/adminlogin.php" class="btn-primary">Are you an admin</a>
		<br><br>
</div>
</body>
</html>



<?php 
//check if submit clicked
if (isset($_POST['submit'])) {
	// processs login
	//get data from form

  $username = $_POST['username'];
	$password = $_POST['password']; 
	$password=md5($password);

	//sql to check whether usernam and pass exist
	$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";

	//execute query
	$res = mysqli_query($conn, $sql);

	// count rows to check if user exists or not 
	$count = mysqli_num_rows($res);

	if ($count==1) {
		// user available and login success
		$_SESSION['login'] = $username;
		$_SESSION['user'] = $username;
		//redirect to index page 
		header('location:'.SITEURL.'home.php');
	}else{
		//user not available
		$_SESSION['login'] = "username and pass dont match";
		//redirect to index page 
		header('location:'.SITEURL.'login.php');
	}

}

?>