<?php
	/*Edit Profile Page*/
	session_start();
	$PageTitle="Edit Profile";

	include "in.php";

	if (isset($_SESSION['userperson'])) {
		$do="";
		if (isset($_GET['do'])) {
			$do=$_GET['do'];
		}else{
			$do='Edit';
		}
		if ($do=='Edit') {
			$stmt=$connect->prepare("select * from users where UserId=? limit 1");
			$stmt->execute(array($_SESSION["userperson_id"]));
			$row=$stmt->fetch();
			$count=$stmt->rowCount();
			if ($count>0) {
?>
			<h1 class="text-center">Edit Profile Info</h1>
			<div class="container">
				<form class="form-horizontal main-form" action="?do=Update" method="POST" enctype="multipart/form-data">
					<!--start Login Name field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Login Name</label>
						<div class="col-md-10">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="New Login Name" value="<?php Echo $row['UserName']?>">
						</div>
					</div>
					<!--end Login Name field-->
					<!--start Login password field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Password</label>
						<div class="col-md-10">
							<input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>">
							<input type="password" name="newpassword" class="password form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change">
							<i class="show-pass profile fa fa-eye fa-2x"></i>
						</div>
					</div>
					<!--end Login password field-->
					<!--start Email field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Email</label>
							<div class="col-md-10">
								<input type="email" name="email" class="form-control" required="required" value="<?php echo $row['Email']?>">
							</div>
						</div>
					<!--end Email field-->
					<!--start Full name field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Full Name</label>
							<div class="col-md-10">
								<input type="text" name="full" class="form-control" required="required" value="<?php echo $row['FullName']?>">
							</div>
						</div>
					<!--end Full name field-->
					<!--start user picture field -->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">User Picture</label>
							<div class="col-md-10">
								<input type="file" name="avatar" class="form-control">
								<input type="hidden" name="oldavatar" value="<?php echo $row['Avatar']?>">
							</div>
						</div>
					<!--end user picture field -->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="save" class="btn btn-primary btn-lg">
							</div>
						</div>
					<!--end button field-->
				</form>

			</div>
<?php
			}else{
			Echo "<div class='container'>";
				$themsg= "<div class='alert alert-succes'>This Is Not Login Person</div>";
				redirectHome($themsg);
			Echo "</div>";
			}
		}elseif ($do=='Update') {
			if ($_SERVER["REQUEST_METHOD"]=="POST") {
				Echo "<h1 class='text-center'>Update Memember</h1>";
				Echo "<div class=container>";
					$formerrors = array();
					$user  =$_POST["name"];
					$oldimage=$_POST['oldavatar'];
					//password trick if he push new value in form will other use the oldpassword
					$pass="";
					if(empty($_POST['newpassword'])){
						$pass=$_POST['oldpassword'];
					}else{
						$pass=sha1($_POST['newpassword']);
					}
					//edit image
					$avatar="";
					if(!empty($_FILES['avatar']['name'])){					
						$to="memberavatar\\".$_SESSION["userperson_id"];
						$avatar=uploadImage($_FILES['avatar'],$to,$oldimage);	
					}else{
						$avatar=$oldimage;
					}

					$email =$_POST["email"];
					$name  =$_POST["full"];


					
					//validate the form in the server side
					$formerrors = array();
					if(strlen($user)<4){
						$formerrors[]="username cant be less than <strong>4 characters</strong>";
					}
					if(strlen($user)>20){
						$formerrors[]="username cant be more than <strong>20 characters</strong>";
					}
					if(empty($user)){
						$formerrors[]="username cant be <strong>empty</strong>";
					}
					if(empty($name)){
						$formerrors[]="full name cant be <strong>empty</strong>";
					}
					if(empty($email)){
						$formerrors[]="email cant be <strong>empty</strong>";
					}
					
					//loop into errors array and echo it
					foreach ($formerrors as $error) {
						echo "<div class='alert alert-danger'>". $error."</div>" ;
					}
					if (empty($formerrors)) {
						//Update the database with this info

						$stmt2=$connect->prepare("update users set UserName=?,Password=?,Email=?,FullName=?,Avatar=? where UserId=? ");
						$stmt2->execute(array($user,$pass,$email,$name,$avatar,$_SESSION["userperson_id"]));

						//notifiction  if data update using redirect function
						echo "<div class='container'>";
							$themsg= "<div class='alert alert-success'>".$stmt2->rowCount()."Record Updated</div>" ;
						echo "</div>";
						redirectHome($themsg,"back");

					}

				Echo"</div>";
			}else{
				Echo "<div class=container>";
					$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
				Echo"</div>";
				redirectHome($themsg);
			}
		}
	include $tpl."footer.php";
	}else{
		header("location:index.php");
		exit();
	}
?>