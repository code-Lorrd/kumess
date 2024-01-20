<?php

require 'conn/conn.php';


// Check connection:
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get name and password from form:
$name = mysqli_real_escape_string($conn, $_POST['name']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

if($password != $confirm_password){
    echo "Passwords are not same";
    header("location:".SITEURL."registration.html");
}else{

$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
// Insert user into database:
$sql = "INSERT INTO users (name, username,  password) VALUES ('$name', '$username', '$hashedpassword')";
if (mysqli_query($conn, $sql)) {
  echo "Registration successful!";
  header("location:".SITEURL."login.html");
} else {
  echo "Error: " . mysqli_error($conn);
}


mysqli_close($conn);
}
?>
