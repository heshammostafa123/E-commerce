<?php
	//page to show details of each item
	session_start();//for the session in the navbar of the header

    $PageTitle="Show Items";
    
	include "in.php";
	//Edit Page
	if(isset($_GET["item_id"])&&is_numeric($_GET["item_id"])){//check if get request value is numeric and get the integer value
		$item_id=intval($_GET["item_id"]);
	}else{
		$item_id=0;
	}
	//select all data depend on item id
	$stmt=$connect->prepare("select items.*,categories.Name as category_name,users.UserName 
							 from 
							 	items 
							 INNER JOIN
							 	categories
							 on
							 	categories.Id=items.Cat_id
							 INNER JOIN
							 	users
							 on
							 	users.UserId=items.Member_id
							 where
							 	Item_Id=?
							 and 
							 	Approve=1
							 limit 1");
	$stmt->execute(array($item_id));
	if($stmt->rowCount()>0){
	$row=$stmt->fetch();
?>
	<h1 class="text-center"><?php echo $row['Name']?></h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-xs-12">
				<div class="row">
					<div class="col-xs-8 master-img">
					<?php
						if (empty($row['Avatar'])) {
							Echo "<div class='show' href='admin/uploads/avatars/itemsavatars/im.png'>";
								Echo "<img id='zoom_01' data-zoom-image='large/image1.jpg' class='img-responsive img-thumbnail center-block' style='max-height:250px; max-width:300px;' src='admin/uploads/avatars/itemsavatars/im.png' alt=''/>";
							Echo "</div>";	
						}else{
							Echo "<div class='show' href='admin\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['Avatar']."'>";
								Echo "<img class='img-responsive img-thumbnail center-block' style='max-height:250px;max-width:300px;' src='admin\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['Avatar']."'alt=''/>";
							Echo "</div>";
						}
					?>
					</div>
					<div class="col-xs-4">
						<div class="thumbnails">
						<?php
							if (empty($row['Avatar'])) {
								Echo "<img class='img-responsive img-thumbnail' src='admin\uploads\avatars\itemsavatars\im.png' alt=''/>";
							}else{
								Echo "<img class='img-responsive img-thumbnail' src='admin\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['Avatar']."'alt=''/>";
							}
						?>
						</div>
						<div class="thumbnails">
						<?php
							if (empty($row['first_thumbnail'])) {
								Echo "<img class='img-responsive img-thumbnail' src='admin\uploads\avatars\itemsavatars\im.png' alt=''/>";
							}else{
								Echo "<img class='img-responsive img-thumbnail' src='admin\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['first_thumbnail']."'alt=''/>";
							}
						?>
						</div>
						<div class="thumbnails">
						<?php
							if (empty($row['second_thumbnail'])) {
								Echo "<img class='img-responsive img-thumbnail' src='admin\uploads\avatars\itemsavatars\im.png' alt=''/>";
							}else{
								Echo "<img class='img-responsive img-thumbnail' src='admin\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['second_thumbnail']."'alt=''/>";
							}
						?>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-lg-8 col-xs-12 item-info" >
				<h2><?php echo $row['Name']?></h2>
				<h2><?php echo $row['Describtion']?></h2>
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Add Date</span>: <?php echo $row['Add_Date']?>
					</li>
					<li>
						<i class="fa fa-money fa-fw"></i>
						<span>Price</span>: <?php echo $row['Price']?>
					</li>
					<li>
						<i class="fa fa-building fa-fw"></i>
						<span>Made In</span>: <?php echo $row['Country_Made']?>
					</li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						<span>Category</span>:<a href="categories.php?pageid=<?php Echo $row['Cat_id']?>"><?php echo $row['category_name']?></a> 
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Added By</span>: <?php echo $row['UserName']?>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Tags</span>:
						<?php
							$alltags=explode(",",$row['Tags']);
							foreach ($alltags as $tag) {
								$lowertag=strtolower(str_replace(' ','',$tag));
								if(!empty($tag)){
									Echo "<a href='tags.php?name={$lowertag}'>".$tag.'</a>';
								}
							}
						?>
					</li>
				</ul>
			</div>
		</div>
		<hr class="custom-hr"/>
		<?php 
		if(isset($_SESSION["userperson"])){
			if($row['Member_id']!=$_SESSION["userperson_id"]){
		 ?>
		<!--start add comment-->	 
			<div class="row">
				<div class="col-sm-offset-4">
					<div class="add-comment">
						<h3>Add Your Comment</h3>
						<form action="<?php Echo $_SERVER['PHP_SELF'].'?item_id='.$row['Item_Id']?>" method="POST">
							<textarea name="comment" required></textarea>
							<input class="btn btn-primary" type="submit" name="Add Comment">
						</form>
						<?php
							if($_SERVER['REQUEST_METHOD']=='POST'){
								$comment =filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
								$itemid=$row['Item_Id'];
								$userid=$_SESSION["userperson_id"];


								if(!empty($comment)){
									$stmt=$connect->prepare("insert into  
										Comments(Comment,Status,Comment_Date,Item_Id,User_Id)
										VALUES(:Zcomm, 0 ,NOW(),:zitemid,:zuserid)");
									$stmt->execute(array(':Zcomm'=>$comment,
														 ':zitemid'=>$itemid,
														 ':zuserid'=>$userid
														));

								}else{
									Echo '<div class="alert alert-danger">You Must Enter Comment</div>';
								}
								if($stmt){
									$themsg= '<div class="alert alert-success">Comment Added </div>';
									redirectHome($themsg,'back');
								}
							}
						?>
					</div>
				</div>
			</div>
		<?php
			echo "<hr class='custom-hr'/>";
			}else{
				Echo "<div class='alert alert-danger text-center'>Sorry You Can Not Add Comment</div>";
			}
		}else{
			Echo "<div class='alert alert-danger text-center'><a href='login.php'>Login</a> Or <a href='login.php'>Register</a> To Add Comment</div>";
			Echo "<hr class='custom-hr'/>";
		}?>
		<!--end add comment-->	 
<?php
            //select all comments
			$stmt=$connect->prepare("select comments.*,users.*
					from
						 comments
					INNER JOIN
						users
					on
						users.UserId=comments.User_Id
					where 
						Item_Id=?
					and
						Status=1
					order by 
						C_Id desc

					");
			//Excute the statement
			$stmt->execute(array($row['Item_Id']));
			//Assign to variable
			$comments=$stmt->fetchAll();

		foreach ($comments as $com) {
			Echo '<div class="comment-box">';
			Echo '<div class="row">';
				Echo '<div class="col-sm-4 text-center">';
				if (empty($com['Avatar'])) {
							Echo "<img class='my-img img-circle center-block' src='admin/uploads/avatars/memberavatar/1.png' alt=''/>";
							Echo $com['UserName'];
							}else{
								Echo "<img class='my-img img-circle center-block' src='admin\uploads\avatars\memberavatar\\".$com['Item_Id']."\\".$com['Avatar']."'alt=''/>";
								Echo $com['UserName'];
							}
				Echo '</div>';
				Echo '<div class="col-sm-8"><p class="lead">'.$com['Comment'].'</p></div>';
				//Echo $com['Comment_Date']."<br/>";
				//Echo $com['User_Id']."<br/>";
			Echo '</div>';
			Echo '</div>';
			
		}

?>

	</div>

<?php	
	//result when row count<=0
	}else{
			Echo "<div class='container'>";
				$themsg= "<div class='alert alert-danger'>There Is Not  Such This Item Id Or Item Waiting Approval</div>";
				redirectHome($themsg);
			Echo "</div>";
	}


    include $tpl."footer.php";
?>