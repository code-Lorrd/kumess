<!DOCTYPE html>
<html>
<head>
<title>Add Menu Item</title>
</head>
<body>
<h2>Add Menu Item</h2>
<form action="add_menu_item_process.php" method="post" enctype="multipart/form-data">
  <label for="name">Name:</label><br>
  <input type="text" name="name" id="name" required><br><br>
  <label for="price">Price:</label><br>
  <input type="number" name="price" id="price" step="0.01" required><br><br>
  <label for="image">Image:</label><br>
  <input type="file" name="image" id="image" required><br><br>
  <input type="submit" value="Add Item">
</form>
</body>
</html>
