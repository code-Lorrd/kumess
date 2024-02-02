<?php 
include '../conn/conn.php';

//getid of food to be deleted
$id = $_GET['id'];

//sql statement
$sql = "DELETE FROM food_items WHERE id='$id'";

//EXECUTE THE STATEMENT
$res = mysqli_query($conn, $sql);

//check query execution
if ($res==true) {
	$_SESSION['deleted'] = "<div class='success'>food deleted successfully</div>";
	header('location:'.SITEURL.'admin/managefood.php');
}else{
	$_SESSION['deleted'] = "<div class='eeror'>failed to delete food</div>";
	header('location:'.SITEURL.'admin/managefood.php');
}
?>