<?php 
//require('../conn/conn.php');
include 'components/menu.php';
?>


<div class="main-content">
	<div class="wrapper">
	   <h1>Manage Food</h1>
	   <br><br>

		<a href="<?php echo SITEURL;?>admin/addtomenu.php" class="btn-primary">Add food</a>
		<br><br>

		<?php

		if (isset($_SESSION['add'])) {
		 	echo $_SESSION['add'];
		 	unset($_SESSION['add']);
		 } 

		if (isset($_SESSION['deleted'])) {
			// code...
			echo $_SESSION['deleted'];
			unset($_SESSION['deleted']);
		}

		?>

		<table class="tbl-full">
			<tr>
				<th>S.N</th>
				<th>Title</th>
				<th>Desctription</th>
				<th>Price</th>
				<th>Image</th>
				<th>Featured</th>
				<th>Active</th>
			</tr>
			<?php
            
			$sql = "SELECT * FROM food_items";

			//execute query
			$res = mysqli_query($conn, $sql);

			//count roews
			$count = mysqli_num_rows($res);

			$sn=1;

			//check if theres data
			if ($count>0) {
			 	//theres data
			 	//get data and display
			 	while ($row=mysqli_fetch_assoc($res)) {
			 		$id = $row['id'];
			 		$title = $row['title'];
			 		$description = $row['description'];
			 		$price = $row['price'];
			 		$image = $row['image_path'];
			 		$featured = $row['featured'];
			 		$active = $row['active'];

			 		?>

			<tr>
			        	<td><?php echo $sn++;?></td>
				        <td><?php echo $title;?></td>
				        <td><?php echo $description;?></td>
				        <td colspan="1"><?php echo $price;?></td>
				        <td>

				        	<?php
				        	//check if image name i available
				        	if ($image!="") {
				        		// display image
				        		?>
				        		<img src="<?php echo SITEURL;?>images/food/<?php echo $image;?>" width="100px">

				        		<?php
				        	}else{
				        		echo "<div class='error'>image not available</div>";
				        	}

				        	?>
				        		
				        </td>
				        <td><?php echo $featured;?></td>
				        <td><?php echo $active;?></td>
				        <td>
					        <a href="<?php echo SITEURL;?>admin/updatefood.php?id=<?php echo $id;?>" class="btn-secondary">Update food</a>
					        <a href="<?php echo SITEURL;?>admin/deletefood.php?id=<?php echo $id;?>" class="btn-danger">Delete food</a>
				        </td>
			        </tr>

			 		<?php
			 	}
			 }else{
			 	//no data
			 	//display message inside the table
			 	?>
			 	<tr>
			 		<td colspan="6"><div class="error">No food added</div></td>
			 	</tr>

			 	<?php

			 } 

			?>

			
		</table>

    </div>
</div>
