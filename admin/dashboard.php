<?php 

	session_start();
	if(isset($_SESSION['user'])){
		$PageTitle="Dashboard";
		include "in.php";
		/*start Dashboard page*/

		$numusers=5;//number of latest users
		$latestusers=getlatest("*","users","UserId","$numusers"); //latest users array

		$numitems=6;//number of latest item
		$latestitems=getlatest("*","items","Item_Id","$numitems");

		$numcomments=4;//number of comments
?>
	<!--start stats-->
	<div class="container home-stats text-center">
		<h1>Dashboard</h1>
		<div class="row">
			 <div class="col-md-3 col-sm-6">
			 	<div class="stat members">
			 		<i class="fa fa-users"></i>
			 		<div class="info">
			 			Total Members
			 			<span><a href="members.php"><?php echo countItem('UserId','users')?></a></span>
			 		</div>			 		
			 	</div>
			 </div>
			 <div class="col-md-3 col-sm-6">
			 	<div class="stat pending">
			 		<i class="fa fa-user-plus"></i>
			 		<div class="info">
				 		Panding Members
				 		<span><a href="members.php?do=Manage&page=Panding"><?php echo checkitem("Regstatus","users","0");?></a></span>
			 		</div>	
			 	</div>
			 </div>
			 <div class="col-md-3 col-sm-6">
			 	<div class="stat items">
			 		<i class="fa fa-tag"></i>
			 		<div class="info">
				 		Total Items
				 		<span><a href="items.php"><?php echo countItem('item_id','items')?></a></span>
			 		</div>	
			 	</div>
			 </div>
			 <div class="col-md-3 col-sm-6">
			 	<div class="stat comments">
			 		<i class="fa fa-comments"></i>
			 		<div class="info">
				 		Total Comments
				 		<span><a href="comments.php"><?php echo countItem('C_Id','comments')?></a></span>
			 		</div>	
			 	</div>
			 </div>
		</div>
	</div>
	<!--end stats-->


	
	<div class="container latest">
		<!--start latest [regiter users/comments-->
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-users"></i>Latest <?php echo $numusers?> Registerd Users
						<span class="toggle-info pull-right"><i class="fa fa-plus"></i></span>
					</div>
					<div class="panel-body">
						<ul class="list-unstyled latest-users">
						<!--get latest register users-->
						<?php	
							if(! empty($latestusers)){				
								foreach ($latestusers as $user) {
									echo "<li>";
										echo $user['UserName'];
										echo '<a href="members.php?do=Edit&UserId='.$user['UserId'].'">';
											echo "<span class='btn btn-success pull-right'>";
												echo "<i class='fa fa-edit'></i>Edit";
												if($user['Regstatus']==0){
													echo "<a href='members.php?do=Activate&UserId=".$user['UserId']."' class='btn btn-info activate pull-right '>";
															echo "<i class='fa fa-close'></i>Activate";
													echo "</a>";
												}
											echo "</span>";
										echo '</a>';
									echo "</li>";
								}
							}else{
								echo 'There\'s No Members To Show';
							}
						?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-tag"></i>Latest <?php echo $numitems?> Items
						<span class="toggle-info pull-right"><i class="fa fa-plus"></i></span>
					</div>
					<div class="panel-body">
						<ul class="list-unstyled latest-users">
						<!--get latest register users-->
						<?php	
							if(! empty($latestitems)){				
								foreach ($latestitems as $item) {
									echo "<li>";
										echo $item['Name'];
										echo '<a href="items.php?do=Edit&item_id='.$item['Item_Id'].'">';
											echo "<span class='btn btn-success pull-right'>";
												echo "<i class='fa fa-edit'></i>Edit";
												if($item['Approve']==0){
													echo "<a href='items.php?do=Approve&item_id=".$item['Item_Id']."' class='btn btn-info activate pull-right '>
															<i class='fa fa-close'></i>Approve
														</a>";
												}
											echo "</span>";
										echo '</a>';
									echo "</li>";
								}
							}else{
								echo 'There\'s No Items To Show';
							}
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--end latest [regiter users/comments-->
		<!--start latest comment-->
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-comments-o"></i>Latest <?php echo $numcomments?> Comments
						<span class="toggle-info pull-right"><i class="fa fa-plus"></i></span>
					</div>
					<div class="panel-body">
<?php
					$stmt=$connect->prepare("select comments.*,users.UserName AS Member
						from
							 comments
						INNER JOIN
							users
						on
							users.UserId=comments.User_Id
							order by C_Id
							desc
						limit 
							$numcomments

					"); 
					//Excute the statement
					$stmt->execute();
					//Assign to variable
					$comments=$stmt->fetchAll();
					if (!empty($comments)) {
						foreach ($comments as $comment) {
						echo "<div class='comment-box'>";
							echo "<span class='member-n'>".$comment['Member']."</span>";
							echo "<p class='member-c'>".$comment['Comment']."</p>";
						echo "</div>";
						}
					}else{
						echo 'There\'s No commets To Show';
					}
					
?>
					</div>
				</div>
			</div>
		</div>
		<!--end latest comment-->
	</div>

<?php
		/*end Dashboard page*/
		include $tpl."footer.php";
	}else{
		header("location:index.php");
		exit();
	}

?>