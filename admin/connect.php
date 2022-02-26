<?php 

	$dsn="mysql:host=localhost;dbname=shop";//data source name
	$user="root";
	$pass="";
	$option = array
    (
		'PDO::MYSQL_ATTR_INIT_COMMAND' =>
        "SET NAMES utf8",	
	);
    try {
    	$connect=new PDO($dsn,$user,$pass,$option);
    	$connect->SetAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //error exception
    } catch (PDOException $e) {
    	echo "failed too conect".$e->getmessage();
    }
 ?>