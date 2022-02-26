<?php
	ob_start();
	$PageTitle="Login";
	session_start();
	if(isset($_SESSION["userperson"])){
		header("location: index.php");//redirect to index 
	}
	include 'in.php';
	if ($_SERVER["REQUEST_METHOD"]=='POST') {
		if(isset($_POST['login'])){
			$email=$_POST['email'];
			$password=$_POST['password'];

			//Encryption of password
	    	$hashedpass=sha1($password);
			
	    	//check if person is exit in database
	    	$stmt=$connect->prepare("select
	    								UserId,UserName,Password 
	    							from 
	    								users
	    							where
										Email=? 
	    							and
	    								Password=?
	    							");
	    	$stmt->execute(array($email,$hashedpass));
	    	$get=$stmt->fetch();
	    	$count=$stmt->rowCount();
	    	//if couunt >0 this mean database contain record about this username
	    	if($count>0){
	    		$_SESSION["userperson"]=$get['UserName'];//Register session name
	    		$_SESSION["userperson_id"]=$get['UserId'];//Register session id to used in advertisement of the user
	    		header("location:index.php");
	    		exit();
	    	}
   		}else{
   			//validate with back end for input field of signup form
   			$formerrors = array();
   			if (isset($_POST['username'])) {
   				$filteruser=filter_var($_POST['username'],FILTER_SANITIZE_STRING);
   				if (strlen($filteruser)<4) {
   					$formerrors[]= "Name Must Be Greater Than Four Characters";
   				}
   			}
   			if (isset($_POST['password']) &&isset($_POST['password2'])) {
   				if (empty($_POST['password'])) {
   					$formerrors[]="Sorry Bassword Cant Be Empty";
   				}
   				$passwordone=sha1($_POST['password']);
   				$passwordtwo=sha1($_POST['password2']);
   				if ($passwordone!==$passwordtwo) {
   					$formerrors[]="Sorry Password IS Not Match";
   				}
   			}
   			if (isset($_POST['email'])) {
   				$filteremail=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
   				if (filter_var($filteremail,FILTER_VALIDATE_EMAIL)!=true) {
   					$formerrors[]= "This Email Is Not Valid";
   				}
   			}
			//check if there is no error proceed the user add
			if (empty($formerrors)) {
				//check if item exit in database
				$check=checkitem("UserName","users",$_POST['username']);
				if($check==1){
					$formerrors[]="Sorry This User Is Exit";
				}else{
					$email=$_POST['email'];
					$name=$_POST['username'];
					$password=sha1($_POST['password']);
					//insert the new member info in database
					$stmt=$connect->prepare("insert into
						users(UserName,Password,Email,FullName,Avatar,Regstatus,Date)
						values(:zuser, :zpass,:zmail,'','',0,now())");
					$stmt->execute(array(
						'zuser' =>$name,
						'zpass' =>$password,
						'zmail' =>$email,
    
					 ));
					 $row=$connect->prepare("select UserId,UserName,Password from users where Password=? and Email=?");
					 $row->execute(array($password,$email));
					 $get=$row->fetch();
					 $count=$row->rowCount();
					 //if couunt >0 this mean database contain record about this username
					if($count>0){
						$_SESSION["userperson"]=$get['UserName'];//Register session name
						$_SESSION["userperson_id"]=$get['UserId'];//Register session id to used in advertisement of the user
						header("location:index.php");
						exit();
					}
				}
			}   			
   		}
	}
?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">login</span>
		 | <span data-class="signup">SignUp</span>
	</h1>
	<!--start login form-->
	<form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" >
		<div class="input-container">
			<label>Email</label>
			<input class="form-control" type="email" name="email" autocomplete="off" required placeholder="Email"/>
			<i class="fa fa-envelope fa-fw"></i>
		</div>
		<div class="input-container">
			<label>Password</label>
			<span class="rest-pass"><a href="forget_password.php">Forgot your password?</a></span>
			<input class="password form-control" type="password" name="password" autocomplete="new-password" required placeholder="Password"/>
			<i class="fa fa-lock fa-fw"></i>
			<i class="show-pass fa fa-eye fa-lg"></i>
		</div>
		<input class="btn-primary btn-block" name="login" type="submit" value="login"/>
	</form>
	<!--end login form-->
	<!--start signup form-->
	<form class="signup" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
		<div class="input-container">
			<label>Username</label>
			<input pattern=".{4,}" title="UserName Must Be Greater Than 4 Characters" class="form-control" type="text" name="username" autocomplete="off" placeholder="UserName" required />
			<!--pattern used to validate the input field in the front end paterrn require the input field to be required-->
			<i class="fa fa-user fa-fw"></i>
		</div>
		<div class="input-container">
			<label>Password</label>
			<input minlength="4" class="password form-control" type="password" name="password" autocomplete="new-password" placeholder="Password" required />
			<!--minlength attribute used to validate the input field in the front end minlength require the input field to be required-->
			<i class="fa fa-lock fa-fw"></i>
			<i class="show-pass fa fa-eye fa-lg"></i>
		</div>
		<div class="input-container">
			<label>Confirm Password</label>
			<input minlength="4" class="password form-control" type="password" name="password2" autocomplete="new-password" placeholder="Password again" required/>
			<!--minlength attribute used to validate the input field in the front end minlength require the input field to be required-->
			<i class="fa fa-lock fa-fw"></i>
			<i class="show-pass fa fa-eye fa-lg"></i>
		</div>
		<div class="input-container">
			<label>Email</label>
			<input class="form-control" type="email" name="email" placeholder="Email" required/>
			<i class="fa fa-envelope fa-fw"></i>
		</div>
        
		<input class="btn-success btn-block" name='signup' type="submit" value="SignUp"/>
	</form>
	<!--end signup form-->
	<!--start error message of signup-->
	<div class="the-errors text-center">
		<?php
			if (!empty($formerrors)) {
				foreach ($formerrors as $error) {
					Echo '<div class="msg error">'.$error.'</div>';
				}
			}
			if (isset($success_message)) {
				Echo '<div class="msg success">'.$success_message.'</div>';
			}
		?>
	</div>
	<!--end error message of signup-->


</div>


<?php
	include $tpl."footer.php";
	ob_end_flush();

?>