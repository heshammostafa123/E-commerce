<?php 
	

	$do="";
	if(isset($_GET['do'])){
		$do=$_GET['do'];
	}else{
		$do='Manage';
	}
	
	//if the page is main page

	if($do=='Manage'){
		echo "Welcomre you are in manage catogory page";
		echo "<a href='page.php?do=Add'>Add New Category</a>";
	}elseif($do=='Add'){
		echo "wlcome you are in add page";
	}
	elseif($do=='Insert'){
		echo "wlcome you are in insert page";
	}elseif($do=='Edit'){
		echo "wlcome you are in insert page";
	}else{
		echo "error";
	}
?>