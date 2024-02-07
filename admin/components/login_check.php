<?php 
//access control
//check if user i slogged in or not 
if (!isset($_SESSION['user'])) //iff user isnt logged in
{
	// redirect to login
	$_SESSION['no-login-message'] = "<div class='error text-center'> please login to access.</div>";
	header('location:'.SITEURL.'/admin/adminlogin.php');
}
?>