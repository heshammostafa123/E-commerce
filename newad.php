<?php

	session_start();//for the session in the navbar of the header

    $PageTitle="Create New Item";
    
	include "in.php";


	if(isset($_SESSION["userperson"])){

	if ($_SERVER["REQUEST_METHOD"]=='POST') {
		$name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
		$desc=filter_var($_POST['describtion'],FILTER_SANITIZE_STRING);
		$price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT); //will remove $ sign
		$country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
		$status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
		$category=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
		$available_quantity=filter_var($_POST['quantity'],FILTER_SANITIZE_NUMBER_INT);
		$tags=filter_var($_POST['tags'],FILTER_SANITIZE_STRING);


		$formerrors=array();

		if(empty($name)){
			$formerrors[]="Name can\'t be <strong>Empty</strong>";
		}
		if(empty($desc)){
			$formerrors[]="Describtion  can\'t be <strong>Empty</strong>";
		}
		if(empty($price)){
			$formerrors[]="Price  can\'t be <strong>String Or Empty</strong>";
		}
		if(empty($country)){
			$formerrors[]="Country can\'t be <strong>Empty</strong>";
		}
		if (empty($status)) {
			$formerrors[]="Item status Must Be Not Empty";
		}
		if (empty($category)) {
			$formerrors[]="Item Category Must Be Not Empty";
		}
		if (empty($available_quantity)) {
			$formerrors[]="Item Available quantity Must Be Not Empty";
		}
		$price="$".$price;
		//check if there is no error proceed the update opertion
		if (empty($formerrors)) {
			//insert the new item info in database
			$stmt=$connect->prepare("insert into
				items(Name,Describtion,Price,Country_Made,Status,Rating,Add_Date,Cat_id,Member_id,Tags,Available_Quantity)
				values(:zname, :zdescribtion,:zprice, :zcountry,:zstatus,0,now(),:zcategory_id,:zmember_id,:ztgs,:zquantity)");
			$stmt->execute(array(
				'zname' 		=> $name,
				'zdescribtion' 	=> $desc,
				'zprice'		=> $price,
 				'zcountry' 		=> $country,
 				'zstatus' 		=> $status,
 				'zcategory_id'  => $category,
				'zquantity'		=>$available_quantity,
 				'zmember_id' 	=> $_SESSION['userperson_id'],
 				'ztgs'			=>$tags
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
				$directory=mkdir(__DIR__."\admin\uploads\avatars\itemsavatars\\".$item_id);
				$to="itemsavatars\\".$item_id;
				$avatar=uploadImage($_FILES['avatar'],$to);	
				$first_thumbnail=uploadImage($_FILES['thum_first'],$to);	
				$second_thumbnail=uploadImage($_FILES['thum_second'],$to);	

				//insert avatar
				$db=$connect->prepare("update items set Avatar=?,first_thumbnail=?,second_thumbnail=? where Item_Id=?");
				$db->execute(array($avatar,$first_thumbnail,$second_thumbnail,$item_id));
			}
			//Echo success message
			if($stmt){
				$themsg='Item Success Added' ;
			}
			
			
			
		}
	}
?>
<h1 class="text-center"><?php echo $PageTitle ?></h1>
<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $PageTitle ?>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form class="form-horizontal main-form" action="<?php Echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
							<!--start name field-->
								<div class="form-group form-group-lg">
									<label class="col-md-2 control-label">Name</label>
									<div class="col-md-10">
										<input pattern=".{4,}" title="This Field require At Least 4 Characters" required type="text" name="name" class="form-control live" data-class=".live-title" autocomplete="off" required="required" placeholder="Name Of Item">
									</div>
								</div>
							<!--end name field-->
							<!--start describution field-->
								<div class="form-group form-group-lg">
									<label pattern=".{10,}" title="This Field require At Least 10 Characters" required class="col-md-2 control-label">Describtion</label>
									<div class="col-md-10">
										<input type="text" name="describtion" class="form-control live" data-class=".live-desc" autocomplete="off" required="required"  placeholder="Describtion Of Item">
									</div>
								</div>
							<!--end describution field-->
							<!--start price field-->
								<div class="form-group form-group-lg">
									<label class="col-md-2 control-label">Price</label>
									<div class="col-md-10">
										<input required type="text" name="price" class="form-control live" data-class=".live-price" autocomplete="off" required="required" placeholder="price Of Item">
									</div>
								</div>
							<!--end price field-->
							<!--start country made field-->
								<div class="form-group form-group-lg">
									<label class="col-md-2 control-label">Country</label>
									<div class="col-md-10">
										<input required type="text" name="country" class="form-control" autocomplete="off" required="required" placeholder="country made Of Item">
									</div>
								</div>
							<!--end country made  field-->
							<!--start status field-->
							<div class="form-group form-group-lg">
									<label class="col-md-2 control-label">Status</label>
									<div class="col-md-10">
										<select name="status" required>
											<option value="">....</option>
											<option value="1">New</option>
											<option value="2">Like New</option>
											<option value="3">Used</option>
											<option value="4">Old</option>
										</select>
									</div>
								</div>
							<!--end status field-->
							<!--start Categories field-->
							<div class="form-group form-group-lg" required>
									<label class="col-md-2 control-label">Category</label>
									<div class="col-md-10">
										<select name="category">
											<option value="">....</option>
											<?php
												$categories=GetAllFrom("*","categories","","","","id","");
												foreach ($categories as $categorie) {
													Echo "<option value='".$categorie['Id']."'>".$categorie["Name"]."</option>";
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
							<!--start tags field-->
								<div class="form-group form-group-lg">
									<label class="col-md-2 control-label">Tags</label>
									<div class="col-md-10">
										<input type="text" name="tags" class="form-control" placeholder="Seprate Tags With Comma (,)" />
									</div>
								</div>
							<!--end tags field-->
							<!--start item avatar field-->
								<div class="form-group form-group-lg">
									<label class="col-md-2 control-label">Item Avatar</label>
									<div class="col-md-10">
										<input type="file" name="avatar" class="form-control" required="required"/>
									</div>
								</div>
							<!--end item avatar field-->
							<!--start item thumbnail first field-->
							<div class="form-group form-group-lg">
									<label class="col-md-2 control-label">Item Thumbnail First</label>
									<div class="col-md-10">
										<input type="file" name="thum_first" class="form-control" required="required"/>
									</div>
								</div>
							<!--end item thumbnail first field-->
							<!--start item thumbnail second  field-->
							<div class="form-group form-group-lg">
									<label class="col-md-2 control-label">Item Thumbnail Second</label>
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
					<div class="col-md-4">
						<div class="thumbnail item-box live-preview">
							<span class="price-tag">
								<span class="live-price"></span>
							</span>
							<img class='img-responsive img-thumbnail center-block' style='max-height:250px; max-width:300px;' src='admin/uploads/avatars/itemsavatars/im.png' alt=''/>
							<div class="caption">
								<h3 class="live-title">title</h3>
								<p class="live-desc">Describtion</p>
							</div>
						</div>
					</div>
				</div>
				<!--start loop through Errors-->
				<?php
				if(!empty($formerrors)){
					foreach ($formerrors as $error) {
						Echo "<div class='alert alert-danger'>".$error."</div>";
					}
				}
				if (isset($themsg)) {
					$themsg= '<div class="alert alert-success">'.$themsg.'</div>';
					redirectHome($themsg,"back");
				}
				?>
				<!--end loop through Errors-->
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