<?php 
	

	/*
		title function print the page title un case the page has the variable $getTitle and echo default tilte for other pages v1.0
	*/


	function getTitle(){

		global $PageTitle;

		if(isset($PageTitle)){
			echo $PageTitle;
		}else{
			echo "Default";
		}
	}

	
	/*
		get latest recods function v1.0
		function to get latest items from database [users,items,comments]

	*/

	function getlatest($select,$table,$order,$limit){
		global $connect;
		$statment=$connect->prepare("select $select from $table order by $order desc limit $limit");
		$statment->execute();
		$rows=$statment->fetchAll();
		return $rows;
	}

		//count number of items v1.0
	//$item=the item to count [users/comments/items]
	//$table=the table to choose from

	function countItem($item,$table){
		global $connect;
		$statment=$connect->prepare("select count($item) from $table");
		$statment->execute();
		return $statment->fetchColumn();
	}
	

	//function to check item exit in database or not v1.0
	function checkitem($select,$table,$value){
		global $connect;
		$statement=$connect->prepare("select $select from $table where $select=?");
		$statement->execute(array($value));
		$cont=$statement->rowCount();
		return $cont;
	}
	

	//function redirct function v2.0
	//$themsg =echo the message [error /succes /warning]
	//$url=the link you want to redirect to
	//$seconds=seconds before redirecting
	
	function redirectHome($themsg,$url=null,$seconds=3){
		if ($url===null) {
			$url="index.php";
			$link="Home page";
		}else{
			//redirect to referer if it found or back to index.php if not found
			if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!==''){
				$url=$_SERVER['HTTP_REFERER'];
				$link="Previous page";
			}else{
				$url='index.php';
				$link="Home page";
			}
		}
		echo $themsg;
		echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds seconds.</div>";
		header("refresh:$seconds;url=$url");
		exit();
	
	}



	/***
		get All function
		function to get All Fileds form database table
	***/
	function GetAllFrom($field,$table,$where=null,$and=null,$orderby,$ordering='DESC'){
		global $connect;
		$GetAll=$connect->prepare("SELECT $field FROM $table  $where $and order by $orderby $ordering");
		$GetAll->execute();
		$All=$GetAll->fetchAll();
		return $All;
	}
	function uploadImage($avatar,$folder_name,$oldavatar=null){
		global $Avatar;
		$AvatarName=$avatar['name'];
		$AvatarSize=$avatar['size'];
		$AvatarTmp=$avatar['tmp_name'];
		$AvatarType=$avatar['type'];

		$AvatarAllowedExtension=array('jpg','jpeg','gif','png');

		$arr=explode('.',$AvatarName);
		$AvatarExtension=strtolower(end($arr));

		$formerrors=array();
		if (!empty($AvatarName)&&!in_array($AvatarExtension,$AvatarAllowedExtension)) {
			$formerrors[]="This Extention Is Not <strong>Allowed</strong>";
		}
		if($AvatarSize>4194304){
			$formerrors[]="Avatar Cant Be Larger Than <strong>4MB</strong>";
		}

		foreach ($formerrors as $error) {
			echo "<div class='alert alert-danger'>". $error."</div>" ;
		}
		if (empty($formerrors)) {
			$Avatar=rand(0,1000000)."_".$AvatarName;
			move_uploaded_file($AvatarTmp,"uploads\avatars\\".$folder_name."\\".$Avatar);
			return $Avatar;
		}else{
			//when update
			return $oldavatar;
		}
	}

?>