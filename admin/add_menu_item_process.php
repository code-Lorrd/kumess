<?php
// Connect to your database:
$db = mysqli_connect("localhost", "root", "", "ku_mess");

// Check connection:
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get form data:
$name = mysqli_real_escape_string($db, $_POST['name']);
$price = mysqli_real_escape_string($db, $_POST['price']);

// Image handling:
$target_dir = "images";  // Target directory for uploaded images
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is an actual image:
$check = getimagesize($_FILES["image"]["tmp_name"]);
if($check !== false) {
  $uploadOk = 1;
} else {
  echo "File is not an image.";
  $uploadOk = 0;
}

// Check if file already exists:
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size:
if ($_FILES["image"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats:
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// If everything is OK, try to upload file:
if ($uploadOk == 1) {
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    // Insert item into database, including image path:
    $sql = "INSERT INTO menu (name, price, image_path) VALUES ('$name', '$price', '$target_file')";
    if (mysqli_query($db, $sql)) {
      echo "New menu item added successfully!";
    } else {
      echo "Error: " . mysqli_error($db);
    }
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

mysqli_close($db);
?>
