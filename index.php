<?php

	session_start();

    $PageTitle="HomePage";
    
	include "in.php";
?>

	<?php 
		$do="";
		if(isset($_GET['do'])){
				$do=$_GET['do'];
		}else{
				$do='Allitems';
		}
		if($do=="Allitems"){
			?>
			<!--start carousel-->
			<div id="myslide" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#myslide" data-slide-to="0" class="active"></li>
					<li data-target="#myslide" data-slide-to="1"></li>
					<li data-target="#myslide" data-slide-to="2"></li>
					<li data-target="#myslide" data-slide-to="3"></li>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<img src="layout\images\minimal-simple-home-appliances-background-2435326.jpg" alt="picture1">
						<div class="carousel-caption">
							<h1>Home Appliances</h1>
							<P class="lead">
								Home appliances are among the most important inventions that help in life and make it easier and faster, as they are used in all the things we need, for example, washing dishes, the traditional method is tiring, which takes great time and effort, so the dishwasher was invented that washes dishes and others with ease
							</P>
						</div>
					</div>
					<div class="item">
						<img src="layout\images\flagship-smartphones-2018.jpg" alt="picture2">
						<div class="carousel-caption">
							<h1>Mobile phones</h1>
							<P class="lead">
							Mobile phones are one of the most important ways of communication and instant communication between people all over the world, and the process of communicating using a mobile phone takes place through different methods,[1] where there are many social networking applications such as Facebook, Twitter
							</P>
						</div>
					</div>
					<div class="item">
						<img src="layout\images\o6bdsbw9paa51.jpg" alt="picture3">
						<div class="carousel-caption">
							<h1>Computers&labptops</h1>
							<P class="lead">
							Computers have become an important role in our daily life nowadays. Its use has also increased greatly over the last decade. The computer is currently used in every office / institution, whether private or governmental. Computers are also used in areas such as design, machinery manufacturing.
							</P>
						</div>
					</div>
					<div class="item">
						<img src="layout\images\biz24_wally-main_rh_06-24-2009_T5GDDVN.jpg" alt="picture4">
						<div class="carousel-caption">
							<h1>TVs</h1>
							<P class="lead">					
								The invention of television was a revolution in the world of technology; Through it, people began to follow the news of nations and peoples in various regions of the world, wars became documented, and people began to follow the news of natural disasters and the tragedies of other countries while they were in their homes with ease and ease.
							</P>
						</div>
					</div>
					</div>

				<!-- Controls -->
				<a class="left carousel-control" href="#myslide" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myslide" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			<!--end carousel-->
			<!--start search form visisble in xs screen-->
			<div class="container">
				<div class="form visible-xs">
					<form class="navbar-form row search-form" role="search" method="POST" action="index.php?do=search">
							<div class="form-group col-xs-8">
								<input type="text" class="form-control search" placeholder="Search" autocomplete="off" name="search">
							</div>
							<div class="form-group col-xs-4">
								<button type="submit" class="btn btn-default search-btn">Search</button>
							</div>
					</form>	
				</div>
			</div>
			<!--end search form visisble in xs screen-->
<div class="container">
	<?php
			$sort='ASC';
			$sort_array= array('ASC','DESC');
			if (isset($_GET['sort'])&&in_array($_GET['sort'],$sort_array)) {
				$sort=	$_GET['sort'];		
			}
			$allitems=GetAllFrom("*","items","where Item_Id","And  Approve=1 And available_quantity>0","Item_Id","DESC");
			foreach ($allitems as $item) {
				//if($item['Member_id']!=$_SESSION["userperson_id"]){
					echo "<div class='col-sm-6 col-md-3'>";
						echo "<div class='thumbnail item-box'>";
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
							if(isset($_SESSION["userperson"])){
									Echo "<div class='cart'>";
										Echo"<a href='shopping_cart.php?do=insert&item_id=".$item['Item_Id']."' class='btn btn-sm btn-primary'>";
											Echo "Add To Cart";
										Echo"</a>";
									Echo"</div>";
							}
							echo "<div>";
								echo '<h3><a href="items.php?item_id='.$item['Item_Id'].'">'.$item['Name']."</a></h3>";
								echo "<p>".$item['Describtion']."</p>";
								echo "<div class='date'>".$item['Add_Date']."</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>"; 
				//}
			}
		}elseif ($do=="search") {
			if ($_SERVER["REQUEST_METHOD"]=='POST') {
				if (isset($_POST['search'])) {
					$searchitem=$_POST['search'];
					$stmt=$connect->prepare("select
			    								*
			    							from 
			    								items
			    							where
			    								Name=?
			    							And 
			    								Approve=1
			    							");
			    	$stmt->execute(array($searchitem));
			    	$searchitem=$stmt->fetchAll();
			    	$counter=$stmt->rowCount();
					echo "<div class='container'>";
						echo "<h1 class='text-center'>";
							echo "Search Items";
						echo "</h1>";
						echo "<div class='row'>";
			    	//if couunt >0 this mean database contain record about this username
			    	if($counter>0){
			    		foreach ($searchitem as $item) {
							echo "<div class='col-sm-6 col-md-3'>";
								echo "<div class='thumbnail item-box'>";
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
									if(isset($_SESSION["userperson"])){
											Echo "<div class='cart'>";
												Echo"<a href='shopping_cart.php?do=insert&item_id=".$item['Item_Id']."' class='btn btn-sm btn-primary'>";
													Echo "Add To Cart";
												Echo"</a>";
											Echo"</div>";
									}
									echo "<div>";
										echo '<h3><a href="items.php?item_id='.$item['Item_Id'].'">'.$item['Name']."</a></h3>";
										echo "<p>".$item['Describtion']."</p>";
										echo "<div class='date'>".$item['Add_Date']."</div>";
									echo "</div>";
								echo "</div>";
							echo "</div>"; 
						}
			    	}else{
						echo '<div class="nice-message">This Item May Not Exist</div>';
			    	}
						echo "</div>";
					echo "</div>";
				}
			}
		}
	?>
</div>
<?php
    include $tpl."footer.php";
?>