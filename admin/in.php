<?php 


	include "connect.php";

	//rotes 

	$tpl='include/templates/'; //template directory
	$lang="include/languages/";  //template directory
	$func="include/functions/";  //template directory
	$css="layout/css/";	//css directory
	$js="layout/js/";	//js directory
	

	include $lang."english.php";
	include $func."functions.php";
	include $tpl."header.php";


	//include navbar on all page expect the one with $nonavbar variable
	if(!isset($nonavbar)){
   		include $tpl."navbar.php";
 	}

 	
 ?>