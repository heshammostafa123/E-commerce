<?php 

	//Error Reporting
	ini_set("display_errors", "on");
	error_reporting(E_ALL);
	include "admin/connect.php";

	$sessionuser='';
	if(isset($_SESSION["userperson"]))
		$sessionuser=$_SESSION['userperson'];


	//rotes 

	$tpl='include/templates/'; //template directory
	$lang="include/languages/";  //template directory
	$func="include/functions/";  //template directory
	$css="layout/css/";	//css directory
	$js="layout/js/";	//js directory
	

	include $lang."english.php";
	include $func."functions.php";
	include $tpl."header.php";

 	
 ?>