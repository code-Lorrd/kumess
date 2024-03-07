<?php

include '../conn/conn.php';
//get id of admin to be deleted

$id = $_GET['id'];
//sql statement

$sql = "DELETE FROM tbl_admin WHERE id=$id";
echo $sql;

//execute

$res = mysqli_query($conn, $sql);

//check query execution
if ($res==true) {
	//admin deleted successfully
	//echo "admin deleted successfully";
	//create session to display message
	$_SESSION['delete']="<div class='success'>admin deleted successfully</div>";
	//redirect
	header('location:'.SITEURL.'admin/manageadmin.php');

}
else{
	//failed
	//echo "failed to delete";
	$_SESSION['delete'] = "<div class='error'>failed to delete admin.try again later</div>";
	header('location:'.SITEURL.'admin/manageadmin.php');

}
//redirect to mange admin(success or errors)
?>