<?php

	session_start();//for the session in the navbar of the header

    $PageTitle="Profile";
    
	include "in.php";


	if(isset($_SESSION["userperson"])){
		$getuser=$connect->prepare("select * from users where UserName=?");
		$getuser->execute(array($sessionuser));
		$info=$getuser->fetch();
		
?>
<h1 class="text-center"><?php echo $_SESSION['userperson'];?> Profile</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My Information
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>
						<span>Login Name</span>:<?php echo $info["UserName"]?>
					</li>
					<li>
						<i class="fa fa-envelope-o fa-fw"></i>
						<span>Email</span>:<?php echo $info["Email"]?>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Full Name</span>:<?php echo $info["FullName"]?>
					</li>
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Register Date</span>:<?php echo $info["Date"]?>
					</li>				
				</ul>
				<a href="editprofile.php?do=Edit" class="btn btn-default my-button">Edit Information</a>		
			</div>
		</div>
	</div>
</div>

<div id="my-ads" class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				My Items
			</div>
			<div class="panel-body">
					<?php 
					$getitems=GetAllFrom("*","items","where Member_Id={$info['UserId']}","","Item_Id","");
					if(!empty($getitems)){
						echo "<div class='row'>";
							foreach ($getitems as $item) {
								echo "<div class='col-lg-3 col-sm-6 col-xs-12'>";
									echo "<div class='thumbnail item-box'>";
										if($item['Approve']==0){
											echo "<span class='approve-status'>Wating Approve</span>";
										}
										echo "<span class='price-tag'>".$item['Price']."</span>";
										if (empty($item['Avatar'])) {
											Echo"<div class='img'>";
												Echo "<img class='img-responsive img-thumbnail center-block'  src='admin/uploads/avatars/itemsavatars/im.png' alt=''/>";
											Echo "</div>";
										}else{
											Echo"<div class='img'>";
												Echo "<img class='img-responsive img-thumbnail center-block' src='admin\uploads\avatars\itemsavatars\\".$item['Item_Id']."\\".$item['Avatar']."'alt=''/>";
											Echo"</div>";
										}
										echo "<div>";
											echo '<h3><a href="items.php?item_id='.$item['Item_Id'].'">'.$item['Name'].'</a></h3>';
											echo "<p>".$item['Describtion']."</p>";
											echo "<div class='date'>".$item['Add_Date']."</div>";
										echo "</div>";
									echo "</div>";
								echo "</div>"; 
						}
						echo "</div>";
					}else{
						echo 'There \'s No Advertisement To Show,Create <a href="newad.php">New Adv</a>';
					}
					?>
			</div>
		</div>
	</div>
</div>

<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Lateast-Comments
			</div>
			<div class="panel-body">
			<?php
				$allcomments=GetAllFrom("Comment","comments","where User_Id={$info['UserId']}","","C_Id","");
				if(!empty($allcomments)){
					foreach ($allcomments as $row) {
						echo "<p>".$row["Comment"]."</p>";
					}
				}else{
					echo 'There \'s No Comment To Show';
				}
			?>
			</div>
		</div>
	</div>
</div>

<?php
}else {
	header('location:login.php'); //to redirect unlogin person to the the login page
	exit();
}
    include $tpl."footer.php";
?>