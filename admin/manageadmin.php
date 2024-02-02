<?php include('../conn/conn.php')?>
	<div class="main-content">
		<div class="wrapper">
		<h1>Manage admin</h1>
		<br><br>

		<?php 

		if (isset($_SESSION['add'])) {
			echo $_SESSION['add'];//session message
			unset($_SESSION['add']);//remove session message
		}
		echo "<br>";
		if (isset($_SESSION['delete'])) {
			echo $_SESSION['delete'];
			unset($_SESSION['delete']);
		}

		if (isset($_SESSION['update'])) {
			echo $_SESSION['update'];
			unset($_SESSION['update']);
		}
		if (isset($_SESSION['user-not-found'])) {
			echo $_SESSION['user-not-found'];
			unset($_SESSION['user-not-found']);
		}

		if (isset($_SESSION['passwords-dont-match'])) {
			echo $_SESSION['passwords-dont-match'];//session message
			unset($_SESSION['passwords-dont-match']);//remove session message
		}
		if (isset($_SESSION['passwords_change'])) {
			echo $_SESSION['passwords_change'];
			unset($_SESSION['passwords_change']);
		}

		?>
		<br><br><br>

		<a href="addadmin.php" class="btn-primary">Add admin</a>
		<br><br>
        <a href="managefood.php" class="btn-primary">Manage food</a>
		<br><br>

		<table class="tbl-full">
			<tr>
				<th>S.N</th>
				<th>Username</th>
				<th>Actions</th>
			</tr>

			<?php
			//get data from admin
			$sql = "SELECT * FROM tbl_admin";
			//execute
			$res = mysqli_query($conn, $sql);

			//check query execution
			if ($res==true) {
			 	//count rows to check for data 

			 	$count = mysqli_num_rows($res);
			 	$sn=1;

			 	//check num rows 
			 	if ($count>0) {
			 		//theres data in base
			 		while ($rows=mysqli_fetch_assoc($res)) {
			 			// get all data
			 			$id=$rows['id'];
			 			$username=$rows['username'];
			 			//display data in table
			 			?>
			 			  <tr>
				            <td><?php echo $sn++; ?></td>
				            <td><?php echo $username; ?></td>
				            <td>
				              <!-- <a href="<?php echo SITEURL; ?>admin/updatepassword.php?id=<?php echo $id;?>" class="btn-primary">change password</a>
					          <a href="<?php echo SITEURL;?>admin/updateadmin.php?id=<?php echo $id; ?>" class="btn-secondary">Update admin</a> -->
					          <a href="<?php echo SITEURL;?>admin/deleteadmin.php?id=<?php echo $id;?> " class="btn-danger">Delete admin</a>
				            </td>
			               </tr>





			 			<?php
			 		}

			 	}
			 	else{
			 		//no data
			 	}
			 } 
			 ?>

			
		</table>

	    </div>
		
	</div>
