<?php

	$nonavbar="";
	$PageTitle="Login";
	session_start();
		if(isset($_SESSION["user"])){
    		header("location: dashboard.php");//redirect to dashboard 
    	}

	include "in.php";

    //check if user coming from http post method
    if($_SERVER['REQUEST_METHOD']=="POST"){
    	$username=$_POST["user"];
    	$password=$_POST["pass"];
    	//Encryption of password
    	$hashedpass=sha1($password);
    	//Check if admin is exit in database
    	$stmt=$connect->prepare("select
    								UserId,UserName,Password 
    							from 
    								users
    							where
    								UserName=? 
    							and
    								Password=?
    							and 
    								GroupId=1
    							limit 1");
    	$stmt->execute(array($username, $hashedpass));
    	$row=$stmt->fetch();
    	$count=$stmt->rowCount();
    	//if couunt >0 this mean database contain record about this username
    	if($count>0){
    		$_SESSION["user"]=$username;//Register session name
    		$_SESSION["Id"]=$row['UserId'];//Register session id i will rely on edit
    		header("location: dashboard.php");//redirect to dashboard 
    		exit();
    	}
    }

?>

	<form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
        <i class="fa fa-user fa-fw"></i>
		<input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
        <i class="fa fa-lock fa-fw"></i>
		<input class="btn btn-primary btn-block" type="submit" value="login">
	</form>

<?php
    include $tpl."footer.php";
?>