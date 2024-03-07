<?php 
//include ('../conn/conn.php');
include 'components/menu.php'; ?>


<div class="main-content">
	<div class="wrapper">
		<h1>Add Admin</h1>
		<br><br>

		<?php
		if (isset($_SESSION['add'])) {
			echo $_SESSION['add'];
			unset($_SESSION['add']);
		}

		?>

		<form action="" method="POST">
			<table class="tbl-">
					<td>Username:</td>
					<td><input type="text" name="username" placeholder="set username" required=""></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" placeholder="password" required="true"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="add-admin" class="btn-primary">
					</td>
				</tr>
			</table>
			
		</form>
	</div>
</div>




<?php 
//process value from the form and save
//check if btn clicked


if (isset($_POST['submit'])) {
	// button clicked 
	
	//get data from form
	$username=$_POST['username'];
	$password=$_POST['password']; //password encrypt

	//SQL to save data to database

	$sql = "INSERT INTO tbl_admin SET 
	     username='$username',
	     password='$password'
	     ";
	    

	// execute the query and save to db

	$res = mysqli_query($conn, $sql) or die(mysqli_error());

	// check data in db 
	if ($res == true) {
		//create session variable
		$_SESSION['add'] = "admin added successfully";
		//redirect page
		header("location:".SITEURL.'admin/manageadmin.php');
	}
	else
	{
		//create session variable
		$_SESSION['add'] = "failed";
		//redirect page
		header("location:".SITEURL.'admin/addadmin.php');
	}


}


?>