<?php 

	/*
		-manage member pages
		-you can add /edit /delete member from here
	*/
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
			$query='';
			if(isset($_GET['page']) && $_GET['page']=='Panding'){
				$query="AND Regstatus =0";
			}
			//select all users except admin
			$stmt=$connect->prepare("select * from users where GroupId!=1 $query order by UserId DESC");
			//Excute the statement
			$stmt->execute();
			//Assign to variable
			$rows=$stmt->fetchAll();
			if(!empty($rows)){

?>
				<h1 class="text-center">Manage Members</h1>
				<div class="container">
					<div class="table-responsive">
						<table class="main-table manage-avatar text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>Avatar</td>
								<td>Username</td>
								<td>Email</td>
								<td>Full Name</td>
								<td>Registerd Date</td>
								<td>Control</td>
							</tr>
							<?php
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>".$row['UserId']."</td>";
										echo "<td>";
											if (empty($row['Avatar'])) {
												Echo "<img src='uploads/avatars/memberavatar/1.png' alt=''/>";
											}else{
												Echo "<img src='uploads\avatars\memberavatar\\".$row['UserId']."\\".$row['Avatar']."'alt=''/>";
											}
										Echo"</td>";
										echo "<td>".$row['UserName']."</td>";
										echo "<td>".$row['Email']."</td>";
										echo "<td>".$row['FullName']."</td>";
										echo "<td>".$row['Date']."</td>";
										echo "<td>
											<a href='members.php?do=Edit&UserId=".$row['UserId']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
											<a href='members.php?do=Delete&UserId=".$row['UserId']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
											if($row['Regstatus']==0){
												echo "<a href='members.php?do=Activate&UserId=".$row['UserId']."' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";
											}
										echo " </td>";
									echo "</tr>";
								}

							?>
						</table>
					</div>
					<a href='members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i>New member</a>
				</div>
<?php
			}else{
				Echo "<div class='container'>";
					Echo '<div class="nice-message">There\'s No Members To Show</div>';
					Echo"<a href='members.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i>";
						Echo "New member";
					Echo"</a>";
				Echo"</div>";
			}
?>

<?php
		}elseif ($do=="Add") {//Add New member
?>
				
				<h1 class="text-center">Add Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data"><!--enctype encrption to file input-->
						<!--start user name field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Username</label>
								<div class="col-md-10">
									<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="UserName To Login Into Shop">
								</div>
							</div>
						<!--end user name field-->
						<!--start Password field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Password</label>
								<div class="col-md-10">
									<input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Password Must Be Hard $ Complx" required="required">
									<i class="show-pass fa fa-eye fa-2x"></i>
								</div>
							</div>
						<!--end Password field-->
						<!--start Email field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Email</label>
								<div class="col-md-10">
									<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid">
								</div>
							</div>
						<!--end Email field-->
						<!--start Full name field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Full Name</label>
								<div class="col-md-10">
									<input type="text" name="full" class="form-control" required="required" placeholder="Full Name Upper In Your Profile Page">
								</div>
							</div>
						<!--end Full name field-->
						<!--start USer Picture field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">User Picture</label>
								<div class="col-md-10">
									<input type="file" name="avatar" class="form-control" required="required">
								</div>
							</div>
						<!--end USer Picture field-->
						<!--start button field-->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-10">
									<input type="submit" value="Add Member" class="btn btn-primary btn-lg">
								</div>
							</div>
						<!--end button field-->
					</form>
				</div>
<?php
		}elseif ($do=='Insert') {//insert new member in database
				if($_SERVER["REQUEST_METHOD"]=="POST"){
					echo "<h1 class='text-center'>Insert Member</h1>";
		 			echo "<div class='container'>";
		 			
					//get variables from form
					$user  =$_POST["username"];
					$pass  =$_POST["password"];
					$email =$_POST["email"];
					$name  =$_POST["full"];

					//to insure that the pass not empty
					$hashpass=sha1($_POST["password"]);

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
					if(empty($pass)){
						$formerrors[]="password cant be <strong>empty</strong>";
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

					//check if there is no error proceed the update opertion
					if (empty($formerrors)) {
						//check if user exit in database
						
						$check=checkitem("UserName","users",$user);
						if($check==1){
							$themsg= "<div class='alert alert-danger'> sorry This User Is Exit In Database</div>";
							redirectHome($themsg,"back");
						}else{
							//insert the new member info in database
							$stmt=$connect->prepare("insert into
								users(UserName,Password,Email,FullName,Regstatus,Date)
								values(:zuser, :zpass,:zmail, :zname,1,now())");
							$stmt->execute(array(
								'zuser' => $user,
								'zpass' => $hashpass,
								'zmail' => $email,
				 				'zname' => $name
							 ));
							//select last user
							$stmt=$connect->prepare("SELECT UserId FROM `users` ORDER BY UserId DESC LIMIT 1");
							//Excute the statement
							$stmt->execute();
							//Assign to variable
							$row=$stmt->fetch();
							$user_id=$row['UserId'];

							$avatar="";
							if(!empty($_FILES['avatar']['name'])){
								$directory=mkdir(__DIR__."\uploads\avatars\memberavatar\\".$user_id);
								$to="memberavatar\\".$user_id;
								$avatar=uploadImage($_FILES['avatar'],$to);	
								//insert avatar
								$db=$connect->prepare("update users set Avatar=? where UserId=?");
								$db->execute(array($avatar,$user_id));
							}

							//Echo success message
							$themsg= "<div class='alert alert-success'>".$stmt->rowCount()." Record Insert</div>" ;
							redirectHome($themsg,"back");
						}
						
					}
				}
				else{
					echo "<div class='container'>";
					$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
					redirectHome($themsg);
					echo "</div>";
				}

			echo '</div>';



		}elseif ($do=="Edit") { //Edit Page

			if(isset($_GET["UserId"]) && is_numeric($_GET['UserId'])){ //check if get request value is numeric and get the integer value
				$UserId= intval($_GET['UserId']);
			}else{
				$UserId= 0;
			}
			//select all data depend on this id
			$stmt=$connect->prepare("select * from users where UserId=? limit 1");
	    	//Execute the data 
	    	$stmt->execute(array($UserId));
	    	//fetch the data
	    	$row=$stmt->fetch();
	    	//the row count
	    	$count=$stmt->rowCount();
    		if($count>0) //to check user id exit or not if exit show form else show message error
    			{?> <!--to write html without-->
				<h1 class="text-center">Edit Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="userid" value="<?php echo $UserId?>">
						<!--start user name field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Username</label>
								<div class="col-md-10">
									<input type="text" name="username" class="form-control" autocomplete="off" required="required" value="<?php echo $row['UserName']?>">
								</div>
							</div>
						<!--end user name field-->
						<!--start Password field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Password</label>
								<div class="col-md-10">
									<input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>">
									<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change">
								</div>
							</div>
						<!--end Password field-->
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
			//if there is no shuch id show error message
			}
			else{
				echo "<div class='container'>";
					$themsg= "<div class='alert alert-danger'>there is not  such this id</div>";
					redirectHome($themsg);
				echo "</div>";
			}
		 }elseif ($do=="Update") {//Update page
				if($_SERVER["REQUEST_METHOD"]=="POST"){
					echo "<h1 class='text-center'>Update Member</h1>";
		 			echo "<div class='container'>";
					//get variables from form
					$id    =$_POST["userid"];
					$user  =$_POST["username"];
					$email =$_POST["email"];
					$name  =$_POST["full"];
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
						//delete old image from member folder
						$image=__DIR__."\uploads\avatars\memberavatar\\".$id."\\".$oldimage;
						unlink($image);

						$to="memberavatar\\".$id;
						$avatar=uploadImage($_FILES['avatar'],$to,$_POST['oldavatar']);	
					}else{
						$avatar=$oldimage;
					}

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
					//check if there is no error proceed the update opertion
					if (empty($formerrors)) {
						$stmt1=$connect->prepare("select * from users where UserName = ? and UserId != ?");
						$stmt1->execute(array($user,$id));
						$count=$stmt1->rowCount();
						if($count==1){
							$themsg= "<div class='alert alert-danger'> sorry this user is exist</div>";
							redirectHome($themsg,"back");
						}else{
							//Update the database with this info
							$stmt2=$connect->prepare("update users set UserName=? ,Email=?,FullName=?,Password=?,Avatar=? where UserId=? ");
							$stmt2->execute(array($user,$email,$name,$pass,$avatar,$id));	
							
							//notifiction  if data update using redirect function
							echo "<div class='container'>";
								$themsg= "<div class='alert alert-success'>".$stmt2->rowCount()."Record Updated</div>" ;
							echo "</div>";
							redirectHome($themsg,"back");
						}		

					}
				}
				else{
					echo "<div class='container'>";
						$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
					echo "</div>";
					redirectHome($themsg);
				}

				echo '</div>';

		}elseif ($do=='Delete') {
		 	//delete member drom database
			echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";
					//check if get request value is numeric and get the integer value
				if(isset($_GET["UserId"]) && is_numeric($_GET['UserId'])){
					$UserId= intval($_GET['UserId']);
				}else{
					$UserId= 0;
				}
				//select user data
				$stmt=$connect->prepare("select * from users where UserId=?");
				//Excute the statement
				$stmt->execute(array($UserId));
				//Assign to variable
				$row=$stmt->fetch();

	
				//select all data depend on this id
				$check=checkItem("UserId","users",$UserId);
				
	    		if($check>0) //to check user id exit or not if exit show form else show message error
	    		{
					//delete image from member folder
					$image=__DIR__."\uploads\avatars\memberavatar\\".$row['UserId']."\\".$row['Avatar'];
					$directory=__DIR__."\uploads\avatars\memberavatar\\".$row['UserId'];
					unlink($image);
					rmdir($directory);

	    			$stmt=$connect->prepare("delete from users where UserId=:zuser");
	    			//connect zuser with userid
	    			$stmt->bindParam(":zuser",$UserId);
	    			$stmt->execute();
	    			$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>" ;
	    			redirectHome($themsg);
	    		}else{
	    			$themsg= "<div class='alert alert-danger'>This Id Is Not Exit</div>";
	    			redirectHome($themsg,"back");
	    		}
    		echo "</div>";
		}elseif ($do=="Activate") {
			//Activate member drom database
			echo "<h1 class='text-center'>Activate Member</h1>";
			echo "<div class='container'>";
		 		//check if get request value is numeric and get the integer value
				if(isset($_GET["UserId"]) && is_numeric($_GET['UserId'])){
					$UserId= intval($_GET['UserId']);
				}else{
					$UserId= 0;
				}
				//select all data depend on this id
				$check=checkItem("UserId","users",$UserId);

	    		if($check>0) //to check user id exit or not if exit show form else show message error
	    		{
	    			$stmt=$connect->prepare("update users set Regstatus=1 where UserId=?");
	    			$stmt->execute(array($UserId));
	    			$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Activated</div>" ;
	    			redirectHome($themsg);
	    		}else{
	    			$themsg= "<div class='alert alert-danger'>This Id Is Not Exit</div>";
	    			redirectHome($themsg);
	    		}
    		echo "</div>";
		}
		include $tpl."footer.php";

	}else{
		header("location:index.php");
		exit();
	}

?>