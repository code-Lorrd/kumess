<?php 
include 'components/menu.php';
?>

<div class="main-content">
	<div class="wrapper">
		<h1>add food</h1>
		<br><br>

		<?php 
		if (isset($_SESSION['upload'])) {
			echo $_SESSION['upload'];
			unset($_SESSION['upload']);
		}

		?>

		<form action="" method="POST" enctype="multipart/form-data">
			
			<table class="tbl-30">
				<tr>
					<td>title</td>
					<td>
						<input type="text" name="title" placeholder="title of food">
					</td>
				</tr>
				<tr>
					<td>Description:</td>
					<td>
						<textarea name="description" cols="30" rows="r" placeholder="food description"></textarea>
					</td>
				</tr>
				<tr>
					<td>Price</td>
					<td>
						<input type="num" name="price">
					</td>
				</tr>
				<tr>
					<td>Select image</td>
					<td>
						<input type="file" name="image">
					</td>
  </tr>
				<tr>
					<td>Featured</td>
					<td>
						<input type="radio" name="featured" value="yes">Yes
						<input type="radio" name="featured" value="no">No
					</td>
				</tr>
				<tr>
					<td>Active</td>
					<td>
						<input type="radio" name="active" value="yes">Yes
						<input type="radio" name="active" value="no">No
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="Add food" class="btn-primary">
					</td>
				</tr>
				
			</table>
		</form>

		<?php

		//check if buttonis clicked 
		if (isset($_POST['submit'])) {
			// add food to db
			//echo "clicked";

			//get data from the form
			$title = $_POST['title'];
			$description = $_POST['description'];
			$price = $_POST['price'];

			//check whetherv radio active
			if (isset($_POST['featured'])) {
				$featured = $_POST['featured'];
			}else{
				$featured = "no";
			}
			if (isset($_POST['active'])) {
				$active = $_POST['active'];
			}else{
				$active = "no";//default value
			}


			//upload the image
			//check whether select image
			if (isset($_FILES['image']['name'])) {
				// get the details of image
				$image_name = $_FILES['image']['name'];
				//checkif image is selected or not 
				if($image_name != ""){
					//image is selected
					//rename image
					//fet extension of selected image
					$ext = end(explode('.', $image_name));

					///create new name for image
					$image_name = "food_name_".rand(0000,9999).".".$ext;

					//upload the image
					//get the src and destination
					$src = $_FILES['image']['tmp_name'];

					//destination path
					$dst = "../images/food/".$image_name;

					//upload
					$upload = move_uploaded_file($src, $dst);

					//check if uploade 
					if ($upload==false) {
						// failed to upload
						//redirect with message
						$_SESSION['upload'] = "failed to upload";
						header('location:'.SITEURL.'admin/addfood.php');
						//stop
						die();
					}

				}

			}else{
				$image_name = "";//default is blank
			}


			//insert to the db

			//create sqlquery to add food
			$sql2 = "INSERT INTO food_items SET 
			title = '$title',
			description = '$description',
			price = $price,
			image_path = '$image_name',
			featured = '$featured',
			active = '$active' 
			";

			//execute query
			$res2 = mysqli_query($conn, $sql2);

			//check if executed
			//redirect with a message
			if ($res2 == true) {
				// data inserted successfully
				$_SESSION['add'] = "<div class='success'>added successfully</div>";
				header('location:'.SITEURL.'admin/managefood.php');
			}else{
				$_SESSION['add'] = "<div class='error'>error adding food</div>";
				header('location:'.SITEURL.'admin/addtomenu.php');
			}

			//redirect with a message

		}

		?>
		
	</div>
	
</div>

