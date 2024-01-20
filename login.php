<?php
// Connect to your database (replace with your credentials):
require 'conn/conn.php';


// Check connection:
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Get username and password from form:
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Hash password using a secure algorithm (e.g., bcrypt):
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query the database to check for matching credentials:
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hashed_password'";
$result = mysqli_query($conn, $sql);

// Check query results:
if (mysqli_num_rows($result) == 1) {
  // User found, start a session:
  session_start();
  $_SESSION['username'] = $username;
  header("location:".SITEURL."home.html");  // Redirect to a welcome page
} else {
  // Incorrect credentials:
  echo "Invalid username or password.";
}

mysqli_close($conn);
?>
