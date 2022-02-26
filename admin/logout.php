<?php 
	session_start(); //start session

	session_unset(); //unset the data

	session_destroy(); //destory the session

	header("location:index.php");

	exit();
?>