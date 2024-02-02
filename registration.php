<!DOCTYPE html>
<html>
<head>
<title>Registration Page</title>
<link rel="stylesheet" href="css/registration.css">
</head>
<body>
<h2>Register</h2>
<form action="" method="POST">
  
  <label for="username">Username:</label><br>
  <input type="text" name="username" id="username" required><br><br>
  <label for="password">Password:</label><br>
  <input type="password" name="password" id="password" required><br><br>
  <label for="confirm_password">Confirm Password:</label><br>
  <input type="password" name="confirm_password" id="confirm_password" required><br><br>
  <input type="submit" name="submit" value="Register">
</form>
</body>
</html>



<?php 
//process value from the form and save
//check if btn clicked
require('conn/conn.php');

if (isset($_POST['submit'])) {
	// button clicked 
	
	//get data from form
	$username=$_POST['username'];
	$password=$_POST['password']; //password encrypt
  $confirm_password = $_POST['confirm_password'];

  if($confirm_password =! $password){
    echo "Passwords don't match";
    header("location:".SITEURL.'registration.php');
  }else{

	//SQL to save data to database

	$sql = "INSERT INTO users SET 
	     username='$username',
	     password='$password'
	     ";
	    

	// execute the query and save to db

	$res = mysqli_query($conn, $sql) or die(mysqli_error());

	// check data in db 
	if ($res == true) {
		//create session variable
		$_SESSION['add'] = "added successfully";
		//redirect page
		header("location:".SITEURL.'login.php');
	}
	else
	{
		//create session variable
		$_SESSION['add'] = "failed";
		//redirect page
		header("location:".SITEURL.'registration.php');
	}


}
}


?>