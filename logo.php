<?php
    				if(isset($_SESSION["userperson"])){
						?>
						<?php
						//select all users except admin
						$stmt=$connect->prepare("select * from users where UserName=?");
						//Excute the statement
						$stmt->execute(array($_SESSION["userperson"]));
						//Assign to variable
						$rows=$stmt->fetchAll();
						foreach ($rows as $row) {
							if (empty($row['Avatar'])) {
							Echo "<img class='my-img img-circle' src='admin/uploads/avatars/memberavatar/1.png' alt=''/>";
							}else{
								Echo "<img class='my-img img-circle' src='admin\uploads\avatars\memberavatar\\".$row['Avatar']."'alt=''/>";
							}
						}
						?>
						<a href="profile.php"><?php echo $_SESSION['userperson']?></a>
						<div class="pull-right btn-group">
							<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<?php echo $_SESSION['userperson']?>
								<span class="caret"></span>
							</span>
							<ul class="dropdown-menu">
								<li><a href="profile.php">My Profile</a></li>
								<li><a href="newad.php">New Item</a></li>
								<li><a href="profile.php#my-ads">My Items</a></li>
								<li><a href="logout.php">LogOut</a></li>
							</ul>
							<a href="shopping_cart.php">
								<i class="fa fa-shopping-cart fa-2x"></i>
								<span>
								<?php
									$userid=$_SESSION["userperson_id"];
									$count=countItem("User_Id","cart_items","where User_Id=$userid");
									if($count>0){
										echo $count;
									}else{
										echo "0";
									}
								?>
								</span>
								cart
							</a>
						</div>
						<?php
						$userstatus=checkuserstatus($sessionuser);
						if($userstatus==1){
							//user not Activiate By Admin";
						}
					}else{	
    			?>
    			<a href="login.php">
    				<span class="pull-right">Login/SignUp</span>
    			</a>
    			<?php } ?>