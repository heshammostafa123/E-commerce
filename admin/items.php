<?php 

/*
	-items pages
	-you can add /edit /delete member from here
*/
session_start();
$PageTitle="Items";
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
		//select all items
		$stmt=$connect->prepare("SELECT items.*,categories.Name as category_name ,users.UserName
								from items
								INNER JOIN categories
								on categories.Id=items.Cat_id
								INNER JOIN users 
								ON users.UserId =items.Member_id
								order by 
									Item_Id desc

								");
		//Excute the statement
		$stmt->execute();
		//Assign to variable
		$items=$stmt->fetchAll();
		if (!empty($items)) {
?>
			<h1 class="text-center">Manage Items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered manage-avatar">
						<tr>
							<td>#ID</td>
							<td>Avater</td>
							<td>Name</td>
							<td>Describtion</td>
							<td>Price</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Control</td>
						</tr>
						<?php
							foreach ($items as $item) {
								echo "<tr>";
									echo "<td>".$item['Item_Id']."</td>";
									Echo "<td>";
										if (empty($item['Avatar'])) {
												Echo "<img src='uploads/avatars/itemsavatars/im.png' alt=''/>";
										}else{
												Echo "<img src='uploads\avatars\itemsavatars\\".$item['Item_Id']."\\".$item['Avatar']."'alt=''/>";
										}
									Echo "</td>";
									echo "<td>".$item['Name']."</td>";
									echo "<td>".$item['Describtion']."</td>";
									echo "<td>".$item['Price']."</td>";
									echo "<td>".$item['Add_Date']."</td>";
									echo "<td>".$item['category_name']."</td>";
									echo "<td>".$item['UserName']."</td>";
									echo "<td>
										<a href='items.php?do=Edit&item_id=".$item['Item_Id']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='items.php?do=Delete&item_id=".$item['Item_Id']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
										if($item['Approve']==0){
													echo "<a href='items.php?do=Approve&item_id=".$item['Item_Id']."' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";
												}
									echo " </td>";
								echo "</tr>";
							}

						?>
					</table>
				</div>
				<a href='items.php?do=Add' class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>New Item</a>
			</div>
<?php
		}else{
			Echo "<div class='container'>";
				Echo '<div class="nice-message">There\'s No items To Show</div>';
				Echo"<a href='items.php?do=Add' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i>";
					Echo "New Item";
				Echo"</a>";
			Echo"</div>";
		}
?>		

<?php
	}elseif ($do=='Add') {?>
		<h1 class="text-center">Add New Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!--start name field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Name</label>
							<div class="col-md-10">
								<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of Item">
							</div>
						</div>
					<!--end name field-->
					<!--start describution field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Describtion</label>
							<div class="col-md-10">
								<input type="text" name="describtion" class="form-control" autocomplete="off" required="required"  placeholder="Describtion Of Item">
							</div>
						</div>
					<!--end describution field-->
					<!--start price field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Price</label>
							<div class="col-md-10">
								<input type="text" name="price" class="form-control" autocomplete="off" required="required" placeholder="price Of Item">
							</div>
						</div>
					<!--end price field-->
					<!--start country made field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Country</label>
							<div class="col-md-10">
								<input type="text" name="country" class="form-control" autocomplete="off" required="required" placeholder="country made Of Item">
							</div>
						</div>
					<!--end country made  field-->
					<!--start status field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Status</label>
							<div class="col-md-10">
								<select name="status">
									<option value="0">....</option>
									<option value="1">New</option>
									<option value="2">Like New</option>
									<option value="3">Used</option>
									<option value="4">Old</option>
								</select>
							</div>
						</div>
					<!--end status field-->
					<!--start members field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Members</label>
							<div class="col-md-10">
								<select name="member">
									<option value="0">....</option>
									<?php
										$getallusers=GetAllFrom("*","users","","","UserId","");						
										foreach ($getallusers as $user) {
											Echo "<option value='".$user['UserId']."'>".$user["UserName"]."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!--end members field-->
					<!--start Categories field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Category</label>
							<div class="col-md-10">
								<select name="category">
									<option value="0">....</option>
									<?php
										$categories=GetAllFrom("*","categories","where Parent=0","","Id","");	
										foreach ($categories as $categorie) {
											Echo "<option value='".$categorie['Id']."'>".$categorie["Name"]."</option>";
											$childcategories=GetAllFrom("*","categories","where Parent={$categorie['Id']}","","Id","");
											foreach ($childcategories as $child) {
													Echo "<option value='".$child['Id']."'>---".$child['Name']."</option>";//display child items
												}
										}
									?>
								</select>
							</div>
						</div>
					<!--end Categories field-->
					<!--start item 	available_quantity field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">quantity</label>
							<div class="col-md-10">
								<input type="number" name="quantity" min="1" class="form-control" autocomplete="off" placeholder="Quantity Available Of Item">
							</div>
						</div>
					<!--end item available_quantity field-->
					<!--start Tags field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Tags</label>
							<div class="col-md-10">
								<input type="text" name="tags" class="form-control" placeholder="Seprate Tags With Comma (,)"/>
							</div>
						</div>
					<!--end Tags  field-->
					<!--start upload picture field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Add Avatar</label>
							<div class="col-md-10">
								<input type="file" name="avatar" class="form-control" required="required" >
							</div>
						</div>
					<!--end upload picture  field-->
					<!--start item thumbnail first field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Item First Thumbnail</label>
							<div class="col-md-10">
								<input type="file" name="thum_first" class="form-control" required="required"/>
							</div>
						</div>
					<!--end item thumbnail first field-->
					<!--start item thumbnail second  field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Item Second Thumbnail</label>
							<div class="col-md-10">
								<input type="file" name="thum_second" class="form-control" required="required"/>
							</div>
						</div>
					<!--end item thumbnail second field-->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="Add Item" class="btn btn-primary btn-sm">
							</div>
						</div>
					<!--end button field-->
				</form>
			</div>

	<?php
	
	}elseif ($do=='Insert') {
		//insert new Item in database
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Insert Item</h1>";
 			echo "<div class='container'>";

			//validate the form in the server side
			$name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
			$describtion=filter_var($_POST['describtion'],FILTER_SANITIZE_STRING);
			$price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT); //will remove $ sign
			$country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
			$status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
			$member_id=filter_var($_POST['member'],FILTER_SANITIZE_NUMBER_INT);
			$category=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
			$available_quantity=filter_var($_POST['quantity'],FILTER_SANITIZE_NUMBER_INT);
			$tags=filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
	
		
			$formerrors = array();
			if(empty($name)){
				$formerrors[]="Name can\'t be <strong>Empty</strong>";
			}
			if(empty($describtion)){
				$formerrors[]="Describtion  can\'t be <strong>Empty</strong>";
			}
			if(empty($price)){
				$formerrors[]="Price  can\'t be <strong>String Or Empty</strong>";
			}
			if(empty($country)){
				$formerrors[]="Country can\'t be <strong>Empty</strong>";
			}
			if($status==0){
				$formerrors[]="You Must Choose The <strong>Status</strong>";
			}
			if($member_id==0){
				$formerrors[]="You Must Choose The <strong>Member</strong>";
			}
			if($category_id==0){
				$formerrors[]="You Must Choose The <strong>Category</strong>";
			}
			if (empty($available_quantity)) {
				$formerrors[]="Item Available quantity Must Be Not Empty";
			}
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}
			$price="$".$price;
			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//insert the new member info in database
				$stmt=$connect->prepare("insert into
					items(Name,Describtion,Price,Country_Made,Status,Add_Date,Cat_id,Member_id,Tags,Available_Quantity)
					values(:zname, :zdescribtion,:zprice, :zcountry,:zstatus,now(),:zcategory_id,:zmember_id,:Ztags,:zquantity)");
				$stmt->execute(array(
					'zname' 		=> $name,
					'zdescribtion'	=> $describtion,
					'zprice'		=> $price,
					'zcountry' 		=> $country,
					'zstatus' 		=> $status,
					'zcategory_id' 	=> $category_id,
					'zquantity'		=>$available_quantity,
					'zmember_id' 	=> $member_id,
					'Ztags'			=>$tags
				));
				//select last item
				$stmt=$connect->prepare("SELECT Item_Id FROM `items` ORDER BY Item_Id DESC LIMIT 1");
				//Excute the statement
				$stmt->execute();
				//Assign to variable
				$row=$stmt->fetch();
				$item_id=$row['Item_Id'];

				$avatar="";
				$first_thumbnail="";
				$second_thumbnail="";
				if(!empty($_FILES['avatar']['name']) && !empty($_FILES['thum_first']['name']) && !empty($_FILES['thum_second']['name'])){
					$directory=mkdir(__DIR__."\uploads\avatars\itemsavatars\\".$item_id);
					$to="itemsavatars\\".$item_id;
					$avatar=uploadImage($_FILES['avatar'],$to);	
					$first_thumbnail=uploadImage($_FILES['thum_first'],$to);	
					$second_thumbnail=uploadImage($_FILES['thum_second'],$to);	

					//update avater
					$db=$connect->prepare("update items set Avatar=?,first_thumbnail=?,second_thumbnail=? where Item_Id=?");
					$db->execute(array($avatar,$first_thumbnail,$second_thumbnail,$item_id));
				}
				//Echo success message
				$themsg= "<div class='alert alert-success'>".$stmt->rowCount()." Record Insert</div>" ;
			
				redirectHome($themsg,"back");
				
			}
			
		}
		else{
			echo "<div class='container'>";
			$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
			redirectHome($themsg);
			echo "</div>";
		}

		echo '</div>';
	}elseif ($do=='Edit') {
		//Edit Page
		if(isset($_GET["item_id"])&&is_numeric($_GET["item_id"])){//check if get request value is numeric and get the integer value
			$item_id=intval($_GET["item_id"]);
		}else{
			$item_id=0;
		}
		//select all data depend on item id
		$stmt=$connect->prepare("select * from items where Item_Id=? limit 1");
		$stmt->execute(array($item_id));
		$row=$stmt->fetch();
		$count=$stmt->rowCount();
		if ($count>0) { 
?>
			<h1 class="text-center">Edit item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="POST">
					<input type="hidden" name="itemid" value="<?php echo $item_id?>">
					<!--start item name field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Item Name</label>
						<div class="col-md-10">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The New Item" value="<?php Echo $row['Name']?>">						
						</div>
					</div>
					<!--end item name field-->
					<!--start item describtion field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Describtion</label>
						<div class="col-md-10">
							<input type="text" name="describtion" class="form-control" autocomplete="off" required="required" placeholder="Describtion Of The New Item" value="<?php Echo $row['Describtion']?>">
						</div>
					</div>
					<!--end item describtion field-->
					<!--start item name field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Item Price</label>
						<div class="col-md-10">
							<input type="text" name="price" class="form-control" autocomplete="off" required="required" placeholder="Price Of The New Item" value="<?php Echo $row['Price']?>">						
						</div>
					</div>
					<!--end item name field-->
					<!--start item describtion field-->
					<div class="form-group form-group-lg">
						<label class="col-md-2 control-label">Country Made</label>
						<div class="col-md-10">
							<input type="text" name="country" class="form-control" autocomplete="off" required="required" placeholder="Country Made Of The New Item" value="<?php Echo $row['Country_Made']?>">
						</div>
					</div>
					<!--end item describtion field-->

					<!--start status field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Status</label>
							<div class="col-md-10">
								<select name="status">
									<option value="0">....</option>
									<option value="1" <?php if($row['status']==1) echo 'selected'; ?>>New</option>
									<option value="2" <?php if($row['status']==2) echo 'selected'; ?>>Like New</option>
									<option value="3" <?php if($row['status']==3) echo 'selected'; ?>>Used</option>
									<option value="4" <?php if($row['status']==4) echo 'selected'; ?>>Old</option>
								</select>
							</div>
						</div>
					<!--end status field-->
					<!--start Categories field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Category</label>
							<div class="col-md-10">
								<select name="category">
									<option value="0">....</option>
									<?php
										$stmt=$connect->prepare("select *from categories");
										$stmt->execute();
										$categories=$stmt->fetchall();
										foreach ($categories as $categorie) {
											Echo "<option value='".$categorie['Id']."'";
											if($row['Cat_id']==$categorie['Id']) echo 'selected';
											Echo">".$categorie["Name"]."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!--end Categories field-->
					<!--start members field-->
					<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Members</label>
							<div class="col-md-10">
								<select name="member">
									<option value="0">....</option>
									<?php
										$stmt=$connect->prepare("select *from users");
										$stmt->execute();
										$users=$stmt->fetchall();
										foreach ($users as $user) {
											Echo "<option value='".$user['UserId']."'";
											if($row['Member_id']==$user['UserId']) echo 'selected';
											 Echo">".$user["UserName"]."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!--end members field-->
					<!--start item 	available_quantity field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">quantity</label>
							<div class="col-md-10">
								<input type="number" name="quantity" min="1" class="form-control" autocomplete="off" placeholder="Quantity Available Of Item" value="<?php Echo $row['available_quantity']?>">
							</div>
						</div>
					<!--end item available_quantity field-->
					<!--start tags field-->
						<div class="form-group form-group-lg">
							<label class="col-md-2 control-label">Tags</label>
							<div class="col-md-10">
								<input type="text" name="tags" class="form-control" placeholder="Seprate Tags With Comma (,)" value="<?php Echo $row['Tags']?>" />
							</div>
						</div>
					<!--end tags field-->
					<!--start button field-->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<input type="submit" value="save item" class="btn btn-primary btn-lg">
							</div>
						</div>
					<!--end button field-->

				</form>
<?php
				//select  comments where Item_Id==
				$stmt=$connect->prepare("select comments.*,users.UserName AS Member
					from
						 comments
					INNER JOIN
						users
					on
						users.UserId=comments.User_Id
					where
						Item_Id=?

						");
				//Excute the statement
				$stmt->execute(array($item_id));
				//Assign to variable
				$rows=$stmt->fetchAll();
				if (! empty($rows)) {
?>
				<h1 class="text-center">Manage [<?php Echo $row['Name']?>] Comments</h1>
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>Comments</td>
							<td>User Name</td>
							<td>Added Date</td>
							<td>Control</td>
						</tr>
						<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>".$row['Comment']."</td>";									
									echo "<td>".$row['Member']."</td>";
									echo "<td>".$row['Comment_Date']."</td>";
									echo "<td>
										<a href='comments.php?do=Edit&comment_id=".$row['C_Id']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='comments.php?do=Delete&comment_id=".$row['C_Id']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
										if($row['Status']==0){
											echo "<a href='comments.php?do=Approve&comment_id=".$row['C_Id']."' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";
										}
									echo " </td>";
								echo "</tr>";
							}

						?>
					</table>
				</div>
<?php
				 }
?>
			</div>
<?php
		//if there is no shuch id show error message
		}else{
			Echo "<div class='container'>";
				$themsg= "<div class='alert alert-succes'>There Is Not  Such This Item Id</div>";
				redirectHome($themsg);
			Echo "</div>";
		}
	}elseif ($do=='Update') {
		//Update page
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			echo "<h1 class='text-center'>Update Item</h1>";
 			echo "<div class='container'>";
			//get variables from form
			//validate the form in the server side
			$id =$_POST["itemid"];
			$name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
			$describtion=filter_var($_POST['describtion'],FILTER_SANITIZE_STRING);
			$price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT); //will remove $ sign
			$country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
			$status_id=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
			$member_id=filter_var($_POST['member'],FILTER_SANITIZE_NUMBER_INT);
			$category_id=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
			$available_quantity=filter_var($_POST['quantity'],FILTER_SANITIZE_NUMBER_INT);
			$tags=filter_var($_POST['tags'],FILTER_SANITIZE_STRING);

			//validate the form in the server side
			$formerrors = array();
			if(empty($name)){
				$formerrors[]="Name can\'t be <strong>Empty</strong>";
			}
			if(empty($describtion)){
				$formerrors[]="Describtion  can\'t be <strong>Empty</strong>";
			}
			if(empty($price)){
				$formerrors[]="Price  can\'t be <strong>Empty</strong>";
			}
			if(empty($country)){
				$formerrors[]="Country can\'t be <strong>Empty</strong>";
			}
			if($status_id==0){
				$formerrors[]="You Must Choose The <strong>Status</strong>";
			}
			if($category_id==0){
				$formerrors[]="You Must Choose The <strong>Category</strong>";
			}
			if($member_id==0){
				$formerrors[]="You Must Choose The <strong>member</strong>";
			}
			if (empty($available_quantity)) {
				$formerrors[]="Item Available quantity Must Be Not Empty";
			}
			//loop into errors array and echo it
			foreach ($formerrors as $error) {
				echo "<div class='alert alert-danger'>". $error."</div>" ;
			}
			$price="$".$price;
			//check if there is no error proceed the update opertion
			if (empty($formerrors)) {
				//Update the database with this info
				$stmt=$connect->prepare("update 
											items 
										set 
											Name=? ,
											Describtion=?,
											Price=?,
											Country_Made=?,
											Status=?,
											Cat_id=?,
											Member_id=?,
											Available_Quantity=?,
											Tags=?
										 where 
										 	Item_Id=? ");
				$stmt->execute(array($name,$describtion,$price,$country,$status_id,$category_id,$member_id,$available_quantity,$tags,$id));	
				
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
		//delete item drom database
		echo "<h1 class='text-center'>Delete Item</h1>";
		echo "<div class='container'>";
			//check if get request value is numeric and get the integer value
			if(isset($_GET["item_id"]) && is_numeric($_GET['item_id'])){
				$itemid= intval($_GET['item_id']);
			}else{
				$itemid= 0;
			}
			//select item data
			$stmt=$connect->prepare("select * from items where Item_Id=?");
			//Excute the statement
			$stmt->execute(array($itemid));
			//Assign to variable
			$row=$stmt->fetch();
			//select all data depend on this id
			$check=checkItem("Item_Id","items",$itemid);

    		if($check>0) //to check user id exit or not if exit show form else show message error
    		{
				//delete image from items folder
				$image=__DIR__."\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['Avatar'];
				$first_thum=__DIR__."\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['first_thumbnail'];
				$second_thum=__DIR__."\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['second_thumbnail'];
				$directory=__DIR__."\uploads\avatars\itemsavatars\\".$row['Item_Id'];
				unlink($image);
				unlink($first_thum);
				unlink($second_thum);
				rmdir($directory);
				//delete item 
    			$stmt=$connect->prepare("delete from items where Item_Id=:zitem");
    			//connect zuser with userid
    			$stmt->bindParam(":zitem",$itemid);
    			$stmt->execute();
    			$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>" ;
    			redirectHome($themsg,'back');
    		}else{
    			$themsg= "<div class='alert alert-danger'>This Id Is Not Exit</div>";
    			redirectHome($themsg);
    		}
		echo "</div>";
	}elseif ($do=='Approve') {
		//Approve item from database
		echo "<h1 class='text-center'> Approve Item</h1>";
		echo "<div class='container'>";
	 		//check if get request value is numeric and get the integer value
			if(isset($_GET["item_id"]) && is_numeric($_GET['item_id'])){
				$item_id= intval($_GET['item_id']);
			}else{
				$item_id= 0;
			}
			//select all data depend on this id
			$check=checkItem("Item_Id","items",$item_id);

    		if($check>0) //to check item id exit or not if exit show form else show message error
    		{
    			$stmt=$connect->prepare("update items set Approve=1 where Item_Id=?");
    			$stmt->execute(array($item_id));
    			$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Activated</div>" ;
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