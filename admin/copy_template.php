<?php 

	/*
		-manage member pages
		-you can add /edit /delete member from here
	*/
	ob_start();
	session_start();
	$PageTitle="Members";
	if(isset($_SESSION['user'])){
		include "in.php";

		$do="";
		if(isset($_GET['do'])){
				$do=$_GET['do'];
		}else{
				$do='Manage';
		}
		//start manage page
		if($do=="Manage"){
			echo "welcome";
		}elseif ($do=='Add') {
			# code...
		}elseif ($do=='Insert') {
			# code...
		}elseif ($do=='Edit') {
			# code...
		}elseif ($do=='Update') {
			# code...
		}elseif ($do=='Delete') {
			# code...
		}elseif ($do=='Activate') {
			# code...
		}
	include $tpl."footer.php";

	}else{
		header("location:index.php");
		exit();
	}
	ob_end_flush();
?>