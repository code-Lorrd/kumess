<?php
//include constants
include('conn/conn.php');
//destroy the session 

session_destroy();//unsets user session


// redirect to login page
header('location:'.SITEURL.'login.php');
?>