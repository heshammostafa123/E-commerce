<?php 

/*
	-shopping page pages
	-you can add /edit /delete item from here
*/
    session_start();//for the session in the navbar of the header

    $PageTitle="Show Items";
if(isset($_SESSION["userperson"])){
	include "in.php";
	$userid=$_SESSION["userperson_id"];
	$do="";
	if(isset($_GET['do'])){
			$do=$_GET['do'];
	}else{
			$do='Manage';
	}
	//start manage page
	if($do=="Manage"){
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
		if (!empty($rows)) {
?>
	<h1 class="text-center">cart items</h1>
    <div class="container">
	<?php
		foreach ($rows as $row) {
	?>
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
							<i class="fa fa-money fa-fw"></i>
							<span>Price</span>: <?php echo $row['Price']?>
						</li>
						<li>
							<i class="fa fa-building fa-fw"></i>
							<span>Made In</span>: <?php echo $row['Country_Made']?>
						</li>
						<li>
							<i class="fa fa-edit fa-fw"></i>
							<span>Edit quantity</span>:
							<form class="form-inline" action="?do=Update" method="POST" style="display: inline;">
								<input type="hidden" name="itemid" value="<?php echo $row["Item_Id"]?>">
								<div class="form-group mx-sm-3 mb-2">
									<select name="r_q">
										<?php
											$stmt=$connect->prepare("select * from items where Item_Id=?");
											$stmt->execute(array($row['Item_Id']));
											$item=$stmt->fetch();
											$avaliable_q=$item["available_quantity"]+$row['Required_Quantity'];
											for ($i=1; $i <=$avaliable_q ; $i++) { 
												Echo "<option value='".$i."'";
													if($row['Required_Quantity']==$i) echo 'selected';
												echo ">".$i."</option>";
											}
										?>
									</select>
								</div>
								<button type="Update" class="btn btn-success mb-2">Update</button>
							</form>
						</li>
						<li>
							<i class='fa fa-close'></i>
							<span>Delete</span>:
							<?php echo "<a href='shopping_cart.php?do=Delete&item_id=".$row['Item_Id']."' class='btn btn-danger'>Delete</a>";?>
						</li>
					</ul>
				</div>
			</div>
		<hr class="custom-hr"/>
		<?php } ?>
		<?php 
			if(isset($_SESSION["userperson"])){ 
			$check=checkItem("User_Id","totalcost",$userid);
			if($check>0){
				echo "<div class='row'>";
					echo "<div class='total-cost col-sm-offset-4'>";
							//user id exist in total coast
							$stmt=$connect->prepare("select * from totalcost where User_Id=? limit 1");
							$stmt->execute(array($userid));
							$row=$stmt->fetch();
							$total=$row['Total'];
						echo "<h3>Total coast</h3>";
						echo "<div>$total</div>";
					echo "</div>";
				echo "</div>";
			}else{
				echo "<div class='row'>";
					echo "<div class='col-sm-offset-4'>";
						echo "<h3>Total coast</h3>";
						echo "<div>0</div>";
					echo "</div>";
				echo "</div>";
			}	
			}else{
				Echo "<div class='alert alert-danger text-center'><a href='login.php'>Login</a> Or <a href='login.php'>Register</a> To Add Comment</div>";
			}?>
		<!--start total coast-->	
	</div>

<?php	
	//result when row count<=0
	}else{
			Echo "<div class='container'>";
				$themsg= "<div class='alert alert-danger'>There Is Not Items IN cart To Show</div>";
				redirectHome($themsg);
			Echo "</div>";
	}
?>
<?php
}elseif ($do=='insert') {
		//insert new cart Item in database
        echo "<h1 class='text-center'>Item Added To Cart</h1>";
 		echo "<div class='container'>";
            if(isset($_GET["item_id"])&&is_numeric($_GET["item_id"])){//check if get request value is numeric and get the integer value
                $item_id=intval($_GET["item_id"]);
            }else{
                $item_id=0;
            }
			//check item exist in cart or not
			$stmt=$connect->prepare("select * from cart_items where Item_Id=? and User_Id=?");
			$stmt->execute(array($item_id,$_SESSION["userperson_id"]));
			$counter=$stmt->rowCount();
			if($counter >0){
				Echo "<div class='container'>";
					$themsg= "<div class='alert alert-succes'>This item is already in the cart</div>";
					redirectHome($themsg,"back");
				Echo "</div>";
			}else{
				//select all item data depend on item id
				$stmt=$connect->prepare("select * from items where Item_Id=? limit 1");
				$stmt->execute(array($item_id));
				$row=$stmt->fetch();
				$count=$stmt->rowCount();
				if($count>0){
				$item_price=$row['Price'];
				$userid=$_SESSION["userperson_id"];
				//echo $item_price;
				//insert the new item info in cart_items table
					$stmt=$connect->prepare("insert into
					cart_items(User_Id,Item_Id,Required_Quantity,Price)
					values(:zuserid, :zitemid,:zrequiredquantity,:zprice)");
					$stmt->execute(array(
						'zuserid' 		=>$userid,
						'zitemid'	=> $item_id,
						'zrequiredquantity' 		=> 1,
						'zprice'		=> $item_price
					));
					//update item available quantity in items table
					$new_available_quantity=$row['available_quantity']-1;
					$stmt=$connect->prepare("update 
											items 
										set 
											available_quantity=? 
										where 
											Item_Id=? ");
					$stmt->execute(array($new_available_quantity,$item_id));
					//before insert into total person check this person exist or not
					$check=checkItem("User_Id","totalcost",$userid);
					if($check>0){
						//user id exist in total coast
						$stmt=$connect->prepare("select * from totalcost where User_Id=? limit 1");
						$stmt->execute(array($userid));
						$row=$stmt->fetch();
						$total=substr_replace(trim($row['Total'],"$")+trim($item_price,"$"), '$', 0, 0);
						$stmt=$connect->prepare("update 
												totalcost 
											set 
												Total=? 
											where 
												User_Id=? ");
						$stmt->execute(array($total,$userid));
						//Echo success message
						$themsg= "<div class='alert alert-success'>".$stmt->rowCount()." item added to cart</div>" ;
						redirectHome($themsg,"back");
					}else{
						$stmt=$connect->prepare("insert into
						totalcost(User_Id,Total)
						values(:zuserid,:zprice)");
						$stmt->execute(array(
							'zuserid' 		=>$userid,
							'zprice'		=> $item_price
						));
						//Echo success message
						$themsg= "<div class='alert alert-success'>".$stmt->rowCount()." item added to cart</div>" ;
						redirectHome($themsg,"back");
					}
				}else{
					Echo "<div class='container'>";
						$themsg= "<div class='alert alert-succes'>There Is Not  Such This Item Id</div>";
						redirectHome($themsg);
					Echo "</div>";
				}
			}
		echo '</div>';
	}elseif ($do=='Update') {
		//Update page
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Update Cart</h1>";
 			echo "<div class='container'>";
			 //get variables from form
			$userid    		=$_SESSION["userperson_id"];
			$item_id 	    =$_POST["itemid"];
			$new_required_q 	=$_POST["r_q"];

			$stmt=$connect->prepare("select * from cart_items where Item_Id=? limit 1");
			$stmt->execute(array($item_id));
			$row=$stmt->fetch();
			$item_price=$row["Price"];
			$old_required_q=$row["Required_Quantity"];
			$totalcost=substr_replace($new_required_q*trim($item_price,"$"), '$', 0, 0);
			//validate the form in the server side
			$formerrors = array();
			if(empty($new_required_q)){
				$formerrors[]="required quantity can\'t be <strong>Empty</strong>";
			}
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}
			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//Update the database with this info
				$stmt=$connect->prepare("update 
											cart_items 
										set 
											User_Id=? ,
											Required_Quantity=?,
											Price=?
										 where 
										 	Item_Id=? ");
				$stmt->execute(array($userid,$new_required_q,$item_price,$item_id));
				//update item available quantity in items table
				//select all data depend on item id
				$stmt=$connect->prepare("select * from items where Item_Id=? limit 1");
				$stmt->execute(array($item_id));
				$row=$stmt->fetch();
				$available_quantity=$row['available_quantity'];
				if($new_required_q > $old_required_q){
					$difference=$new_required_q-$old_required_q;
					$new_available_quantity=$available_quantity-$difference;
					$stmt=$connect->prepare("update 
										items 
									set 
										available_quantity=? 
									where 
										Item_Id=? ");
					$stmt->execute(array($new_available_quantity,$item_id));
				}else{
					$difference=$old_required_q-$new_required_q;
					$new_available_quantity=$available_quantity+$difference;
					$stmt=$connect->prepare("update 
										items 
									set 
										available_quantity=? 
									where 
										Item_Id=? ");
					$stmt->execute(array($new_available_quantity,$item_id));
				}
				$row=$connect->prepare("select * from totalcost where User_Id=? limit 1");
				$row->execute(array($userid));
				$result=$row->fetch();
				$total=substr_replace(
					(
						(trim($result['Total'],"$")
					-$old_required_q*trim($item_price,"$"))
					+$new_required_q*trim($item_price,"$")
				),'$', 0, 0);
				$stmt=$connect->prepare("update 
											totalcost 
										set 
											total=?	
										 where 
										 	User_Id=? ");
				$stmt->execute(array($total,$userid));
				//notifiction  if data update using redirect function
				echo "<div class='container'>";
					$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>" ;
				echo "</div>";
				redirectHome($themsg,"back");

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
		//delete item from database
		echo "<h1 class='text-center'>Delete Item</h1>";
		echo "<div class='container'>";
			//check if get request value is numeric and get the integer value
			if(isset($_GET["item_id"]) && is_numeric($_GET['item_id'])){
				$itemid= intval($_GET['item_id']);
			}else{
				$itemid= 0;
			}
			//select all data depend on item id
			$stmt=$connect->prepare("select * from cart_items where Item_Id=? limit 1");
			$stmt->execute(array($itemid));
			$row=$stmt->fetch();
			$count=$stmt->rowCount();
    		if($count>0) //to check item id exit or not 
    		{
				$itemprice=$row['Price'];
				$required_q=$row['Required_Quantity'];
				$res=$connect->prepare("select * from totalcost where User_Id=? limit 1");
				$res->execute(array($userid));
				$result=$res->fetch();
				$newtotal=substr_replace(
					(
						trim($result['Total'],"$")
					- ($required_q*trim($itemprice,"$"))
					),'$', 0, 0);
				$stmt=$connect->prepare("update 
											totalcost 
										set 
											total=?	
										 where 
										 	User_Id=? ");
				$stmt->execute(array($newtotal,$userid));
				//select all data depend on item id
				$stmt=$connect->prepare("select * from items where Item_Id=? limit 1");
				$stmt->execute(array($itemid));
				$res=$stmt->fetch();
				//update item available quantity in items table
				$new_available_quantity=$res['available_quantity']+$row['Required_Quantity'];
				$stmt=$connect->prepare("update 
										items 
									set 
										available_quantity=? 
									where 
										Item_Id=? ");
				$stmt->execute(array($new_available_quantity,$itemid));
    			$stmtatment=$connect->prepare("delete from cart_items where Item_Id=:zitemid and User_Id=:zuser");
    			//connect zuser with userid zitem with itemid
				$stmtatment->bindParam(":zitemid",$itemid);
				$stmtatment->bindParam(":zuser",$userid);
				$stmtatment->execute();
    			$themsg= "<div class='alert alert-success'>".$stmtatment->rowCount()."Record Deleted</div>" ;
    			redirectHome($themsg,'back');
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