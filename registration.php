<?php require('conn/conn.php'); ?>

<!DOCTYPE html>
<html>
<head>
<title>Registration Page</title>
<link rel="stylesheet" href="css/registration.css">
</head>
<body>
<script>
  const username = document.getElementById('username');
  const usernameError = document.getElementById('username-error');

  username.addEventListener('input', function(event) {
    // Check if username is at least 6 characters long
    if (username.value.length < 6) {
      usernameError.textContent = "Username must be at least 6 characters long.";
      username.classList.add('error'); // Add styling for error state
    } else {
      usernameError.textContent = "";
      username.classList.remove('error');
    }
  });

  // Similar validation logic for password and confirm password fields with separate error messages and styling

  // Password validation
  const password = document.getElementById('password');
  const passwordError = document.getElementById('password-error');

  password.addEventListener('input', function(event) {
    // Check if password is at least 8 characters long, has at least one uppercase letter, one lowercase letter, one number, and one special character
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
    if (!regex.test(password.value)) {
      passwordError.textContent = "Password must be at least 8 characters long with at least one uppercase letter, one lowercase letter, one number, and one special character.";
      password.classList.add('error');
    } else {
      passwordError.textContent = "";
      password.classList.remove('error');
    }
  });

  // Confirm password validation
  const confirmPassword = document.getElementById('confirm_password');
  const confirmPasswordError = document.getElementById('confirm-password-error');

  confirmPassword.addEventListener('input', function(event) {
    if (confirmPassword.value !== password.value) {
      confirmPasswordError.textContent = "Password and confirm password do not match.";
      confirmPassword.classList.add('error');
    } else {
      confirmPasswordError.textContent = "";
      confirmPassword.classList.remove('error');
    }
  });

  // Prevent form submission if there are errors
  const form = document.getElementById('registration-form');
  form.addEventListener('submit', function(event) {
    const errors = document.querySelectorAll('.error');
    if (errors.length > 0) {
      event.preventDefault(); // Prevent form submission
      alert("Please fix the errors before submitting the form.");
    }
  });

  // Style the error class elements
  const errorElements = document.querySelectorAll('.error');
  errorElements.forEach(element => {
    element.style.border = '1px solid red';
    element.style.backgroundColor = '#f5ebeb';
  });

  const errorSpans = document.querySelectorAll('.error span');
  errorSpans.forEach(span => {
    span.style.color = 'red';
    span.style.fontWeight = 'bold';
  });
</script>
<h2>Register</h2>
<?php
if(isset($_SESSION['add'])){
 echo $_SESSION['add']; 
unset( $_SESSION['add'] );} ?>

<form action="" method="POST" id="registration-form">
  
  <label for="username">Username:</label><br>
  <input type="text" name="username" id="username" required><br><br>
  <label for="firstname">Firstname:</label><br>
  <input type="text" name="firstname" id="firstname" required><br><br>
  <label for="email">email:</label><br>
  <input type="email" name="email" id="email" required><br><br>
  <label for="phonenumber">Phone number:</label><br>
  <input type="number" name="phonenumber" id="phonenumber" placeholder="Don't start with 0 or +254" required><br><br>
  <label for="password">Password:</label><br>
  <input type="password" name="password" id="password" required><br><br>
  <label for="confirm_password">Confirm Password:</label><br>
  <input type="password" name="confirm_password" id="confirm_password" required><br><br>
  <input type="submit" name="submit" value="Register">
  <a href="<?php echo SITEURL;?>login.php" class="btn-secondary">Login</a>
</form>
</body>


</html>



<?php

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $email = strtolower($_POST['email']);
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password']; // Encrypt password before saving
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords first
    if ($confirm_password !== $password) {
        $_SESSION['add'] = "Passwords don't match";
        header("location: " . SITEURL . 'registration.php');
        exit;
    }

    // Check for existing username
    $sql_check = "SELECT COUNT(*) FROM users WHERE username='$username'";
    $res_check = mysqli_query($conn, $sql_check) or die(mysqli_error($conn));

    // Extract the count value directly from the fetched row
    $existing_username = mysqli_fetch_row($res_check)[0];

    if ($existing_username > 0) {
        $_SESSION['add'] = "Username already exists";
        header("location: " . SITEURL . 'registration.php');
        exit;
    }

    // Encrypt password securely before saving
    $password = md5($password);

    // Insert user data
    $sql = "INSERT INTO users SET username='$username', firstname='$firstname', email='$email', phonenumber='$phonenumber', password='$password' ";
    //echo $sql;
   $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    if ($res === true) {
        $_SESSION['add'] = "User added successfully";
       header("location: " . SITEURL . 'login.php');
    } else {
        $_SESSION['add'] = "Failed to add user";
        header("location: " . SITEURL . 'registration.php');
    }
}
?>
