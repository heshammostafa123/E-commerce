<?php ob_start();?>
<html>
    <header>
        <meta charset="utf-8">
        <title><?php echo getTitle() ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>zoom-main.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery.selectBoxIt.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>front.css">
    </header>
    <body>
    	<div class="upper-bar">
    		<div class="container">
				<div class="row">
					<div class="col-xs-4 col-sm-2">
						<div class="logo-img">
							<img src="layout/images/project_logo.png" class="img-responsive" alt="Logo Image">
						</div>
					</div>
					<div class="col-sm-4 hidden-xs">
						<div class="row">
							<div class="form">
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
					</div>
					<div class="col-sm-2 hidden-xs">
						<div class="callus-img">
							<img src="layout\images\call_us.png" class="img-responsive" alt="call us Image">
						</div>
					</div>
					<div class="col-xs-4 col-sm-2">
						<div class="shopping-cart">
							<?php
							if(isset($_SESSION["userperson"])){
								$userid=$_SESSION["userperson_id"];
								$count=countItem("User_Id","cart_items","where User_Id=$userid");
									if($count>0){
										Echo "<span class='btn btn-default dropdown-toggle' data-toggle='dropdown'>";
											Echo "<img class='my-img img-circle' src='layout/images/shopping-cart.png' alt=''/>";
											Echo"<span class='count'>$count</span>";
											Echo "<span class='cart'>";
												Echo  "CART";
											Echo"</span>";
											Echo "<span class='caret'></span>";
										Echo "</span>";
										//select all cart items
										$stmt=$connect->prepare("SELECT items.*,cart_items.*
											from items
											INNER JOIN cart_items
											on items.Item_Id=cart_items.Item_Id
											where
												cart_items.User_Id=?
											order by 
												cart_items.Id desc
										");
										//Excute the statement
										$stmt->execute(array($userid));
										//Assign to variable
										$rows=$stmt->fetchAll();
										?>
										<div class="dropdown-menu cart-dropdown">
											<?php
											if (!empty($rows)) {
												foreach ($rows as $row) {
													echo "<div class='container-fluid'>";
														Echo "<div class='row'>";
															echo "<div class='col-xs-4'>";
																echo "<div class='cart-thumbnails'>";
																	if (empty($row['Avatar'])) {
																		Echo "<img class='img-responsive img-thumbnail center-block' style='max-height:250px; max-width:300px;' src='admin/uploads/avatars/itemsavatars/im.png' alt=''/>";
																	}else{
																		Echo "<img class='img-responsive img-thumbnail center-block' style='max-height:250px;max-width:300px;' src='admin\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['Avatar']."'alt=''/>";
																	}
																echo "</div>";
															echo "</div>";
															echo "<div class='col-xs-8'>";
																echo "<div>";
																	echo $row['Name'];
																echo "</div>";
																echo "<div>";
																	echo "<span>";
																		echo $row['Required_Quantity'];
																	echo "</span>"; 
																	echo "<span> * </span>";
																	echo $row['Price'];
																echo "</div>";
															echo "</div>";
														echo "</div>";
														echo "<div role='separator' class='divider'></div>";
													echo "</div>";
												}
											}
											?>
											<div class='container-fluid'>
												<div class="row">
													<div class="col-xs-6">
														<div class="cart-button">
														<a href='shopping_cart.php' class='btn btn-success'>View Cart</a>
														</div>
													</div>
													<div class="col-xs-6 pull-right">
														<div class="cart-button">
															<a href='checkout.php' class='btn btn-primary'><i class='fa fa-check'></i>Checkout</a>
														</div>
													</div>									
												</div>
											</div>
										</div>
										<?php
										$userstatus=checkuserstatus($sessionuser);
										if($userstatus==1){
											//user not Activiate By Admin";
										}
									}else{
										Echo "<span class='btn btn-default dropdown-toggle' data-toggle='dropdown'>";
											Echo "<img class='my-img img-circle' src='layout/images/shopping-cart.png' alt=''/>";
											Echo"<span class='count'>0</span>";	
											Echo "<span class='cart'>";
												Echo  "CART";
											Echo"</span>";
											Echo "<span class='caret'></span>";
										Echo "</span>";
										echo "<ul class='dropdown-menu cart-dropdown' aria-labelledby='dropdownMenuLink'>";
											echo "<li class='text-center'>Cart Is Empty</li>";
										echo "</ul>";
									}
							}else{	
								Echo "<span class='btn btn-default dropdown-toggle' data-toggle='dropdown'>";
									Echo "<img class='my-img img-circle' src='layout/images/shopping-cart.png' alt=''/>";
									Echo"<span class='count'>0</span>";
									Echo "<span class='cart'>";
										Echo  "CART";
									Echo"</span>";
									Echo "<span class='caret'></span>";
								Echo "</span>";
								?>
								<ul class="dropdown-menu cart-dropdown" aria-labelledby="dropdownMenuLink">
									<li class="text-center">Cart Is Empty</li>
								</ul>
					<?php   } ?>
						</div>
						
					</div>
					<div class="col-xs-4 col-sm-2">
						<div class="account">
							<?php
							if(isset($_SESSION["userperson"])){
								$stmt=$connect->prepare("select * from users where UserName=?");
								//Excute the statement
								$stmt->execute(array($_SESSION["userperson"]));
								//Assign to variable
								$rows=$stmt->fetchAll();

								foreach ($rows as $row) {
									if (empty($row['Avatar'])) {
										Echo "<span class='btn btn-default dropdown-toggle' data-toggle='dropdown'>";
											Echo "<img class='my-img img-circle' src='admin/uploads/avatars/memberavatar/1.png' alt=''/>";
												Echo "<span class='vissible-name'>";
													Echo  $_SESSION['userperson'];
												Echo"</span>";
											Echo "<span class='caret'></span>";
										Echo "</span>";
									}else{
										Echo "<span class='btn btn-default dropdown-toggle' data-toggle='dropdown'>";
											Echo "<img class='my-img img-circle' src='admin\uploads\avatars\memberavatar\\".$row['UserId']."\\".$row['Avatar']."'alt=''/>";
												Echo "<span class='vissible-name'>";
													Echo  $_SESSION['userperson'];
												Echo"</span>";
											Echo "<span class='caret'></span>";
										Echo "</span>";
									}
								}
								?>
								<ul class="dropdown-menu">
									<li><a href="profile.php">My Profile</a></li>
									<li><a href="profile.php#my-ads">My Items</a></li>
									<li><a href="orders.php">Orders</a></li>
									<li><a href="newad.php">New Item</a></li>
									<li><a href="logout.php">LogOut</a></li>
								</ul>
								<?php
								$userstatus=checkuserstatus($sessionuser);
								if($userstatus==1){
									//user not Activiate By Admin";
								}
							}else{	
								Echo "<span class='btn btn-default dropdown-toggle' data-toggle='dropdown'>";
									Echo "<img class='my-img img-circle' src='admin/uploads/avatars/memberavatar/1.png' alt=''/>";
										Echo "<span class='vissible-name'>";
											Echo  "ACCOUNT";
										Echo"</span>";
									Echo "<span class='caret'></span>";
								Echo "</span>";
								?>
								<ul class="dropdown-menu">
									<li><a href="login.php">Login/SignUp</a></li>
								</ul>
						<?php } ?>
						</div>
					</div>
				</div>
    		</div>
    	</div>
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="true">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php">Home <span>Page</span></a>
		    </div>
		    <div class="collapse navbar-collapse" id="app-nav">
		      <ul class="nav navbar-nav mr-auto">
<?php
				$categories=GetAllFrom("*","categories","where Parent=0","","Id","ASC") ;
			    foreach ($categories as $cat) {
					echo '<li><a href="categories.php?pageid='.$cat['Id'].'">'.$cat['Name'].'</a></li>';
			    }
?>
		      </ul>
			  <ul class="nav navbar-nav navbar-right mr-auto">
				  <li><a href="about-us.php"><i class="fa fa-users fa-fw"></i>About Us</a></li>
				  <li><a href="support.php"><i class="fa fa-volume-control-phone fa-fw"></i>Support</a></li>
			  </ul>
		    </div>
		  </div>
		</nav>