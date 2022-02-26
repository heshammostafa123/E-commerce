<?php 

	/*
		-categories pages
		-you can add /edit /delete categorie from here
	*/
	session_start();
	$PageTitle="Categories";
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
			$sort='ASC';
			$sort_array= array('ASC','DESC');
			if (isset($_GET['sort'])&&in_array($_GET['sort'],$sort_array)) {
				$sort=	$_GET['sort'];		
			}
			$rows=GetAllFrom("*","categories","where parent=0","","Ordering","$sort");
			if (!empty($rows)) {
?>
			<h1 class="text-center">Manage Categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i>Manage Categories
						<div class="option pull-right">
							<i class="fa fa-sort"></i>Ordering:[
							<a class="<?php if($sort=='ASC'){echo 'active'; } ?>" href="categories.php?sort=ASC">ASC</a> |
							<a class="<?php if($sort=='DESC'){echo 'active'; } ?>" href="categories.php?sort=DESC">DESC</a>]
							<i class="fa fa-eye"></i>View:[
							<span class="active" data-view="full">Full</span> |
							<span data-view="classic">Classic</span>]
						</div>
					</div>
					<div class="panel-body">
						<?php
							foreach ($rows as $row) {
								echo "<div class='cat'>";
									echo "<div class='hidden-buttons'>";
										echo "<a href='categories.php?do=Edit&catid=".$row['Id']."' class='btn btn-primary'><i class='fa fa-edit'></i>Edit</a>";
										echo "<a href='categories.php?do=Delete&catid=".$row['Id']."' class='confirm btn btn-danger'><i class='fa fa-close'></i>Delete</a>";
									echo "</div>";
									echo "<h3>".$row['Name']."</h3>";
									echo "<div class='full-view'>";
										echo "<p>";if ($row['Describtion']=='') {echo "This Categorie Has No Describtion";} else {echo $row['Describtion'];}echo"</p>";
										if ($row['Visibility']==1){echo "<span class='visibility'><i class='fa fa-eye'></i>Hidden</span>";}
										if ($row['Allow_Comment']==1){echo "<span class='commenting'><i class='fa fa-close'></i>Comment Disabled</span>";}
										if ($row['Allow_Ads']==1){echo "<span class='adverties'><i class='fa fa-close'></i>Ads Disabled</span>";}
									echo "</div>";

									$getchildcats=GetAllFrom("*","categories","where Parent={$row['Id']}","","Id","ASC");
									if(!empty($getchildcats)){
										Echo "<h4 class='child-head'>Child Categories</h4>";
										Echo "<ul class='list-unstyled child-cats'>";
											foreach ($getchildcats as $child) {
												echo"<li class='child-link'>
														<a href='categories.php?do=Edit&catid=".$child['Id']."'>".$child['Name']."</a>
														<a href='categories.php?do=Delete&catid=".$child['Id']."' class='confirm show-delete'>Delete</a>
													</li>";
											}
										Echo "</ul>";
									}
									echo "</div>";
								
								echo "<hr/>";
							}
						?>
					</div>
				</div>
				<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Category</a>
			</div>
<?php
		}else{
			Echo "<div class='container'>";
				Echo '<div class="nice-message">There\'s No  Categorie To Show</div>';
				Echo"<a href='categories.php?do=Add' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i>";
					Echo "New Categorie";
				Echo"</a>";
			Echo"</div>";
		}
?>



<?php
		}elseif ($do=='Add') {
?>
			<h1 class="text-center">Add New categorie</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST">
						<!--start name field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Name</label>
								<div class="col-md-10">
									<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of Categories">
								</div>
							</div>
						<!--end name field-->
						<!--start Describtion field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Describtion</label>
								<div class="col-md-10">
									<input type="text" name="describtion" class="form-control" placeholder="Describe Of Categorie">
								</div>
							</div>
						<!--end Describtion field-->
						<!--start Ordering field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Ordering</label>
								<div class="col-md-10">
									<input type="text" name="ordering" class="form-control" autocomplete="off" placeholder="Number To arange The Categorie">
								</div>
							</div>
						<!--end Ordering field-->
						<!--start Add category type-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Parent?</label>
								<select name='parent' class="col-md-10">
									<option value="0">None</option>
									<?php
										$getparentcat=GetAllFrom("*","categories","where parent=0","","Id","");
										foreach ($getparentcat as $cat) {
											Echo "<option value='".$cat['Id']."'>".$cat['Name']."</option>";
										}
									?>
								</select>
							</div>
						<!--end Add category type-->
						<!--start Visibility field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Visible</label>
								<div class="col-md-10">
									<div>
										<input id="vis-yes" type="radio" name="visibility" value="0" checked><!--zero mean that yes active-->
										<label for="vis-yes">Yes</label><!--for to check if click in text-->
									</div>
									<div>
										<input id="vis-no" type="radio" name="visibility" value="1"><!--one mean that no not active-->
										<label for="vis-no">no</label><!--for to check if click in text-->
									</div>
								</div>
							</div>
						<!--end Visibility field-->
						<!--start Allow-Comment field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Allow Comment</label>
								<div class="col-md-10">
									<div>
										<input id="com-yes" type="radio" name="Comment" value="0" checked><!--zero mean that yes active-->
										<label for="com-yes">Yes</label><!--for to check if click in text-->
									</div>
									<div>
										<input id="com-no" type="radio" name="Comment" value="1"><!--one mean that no not active-->
										<label for="com-no">no</label><!--for to check if click in text-->
									</div>
								</div>
							</div>
						<!--end Allow-Comment field-->
						<!--start Allow_Ads field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Allow_Ads</label>
								<div class="col-md-10">
									<div>
										<input id="ads-yes" type="radio" name="ads" value="0" checked><!--zero mean that yes active-->
										<label for="ads-yes">Yes</label><!--for to check if click in text-->
									</div>
									<div>
										<input id="ads-no" type="radio" name="ads" value="1"><!--one mean that no not active-->
										<label for="ads-no">no</label><!--for to check if click in text-->
									</div>
								</div>
							</div>
						<!--end Allow_Ads field-->
						<!--start button field-->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-10">
									<input type="submit" value="Add Categorie" class="btn btn-primary btn-lg">
								</div>
							</div>
						<!--end button field-->
					</form>
				</div>

		<?php
		}elseif ($do=='Insert') {
			echo "<h1 class='text-center'>Insert Categorie</h1>";
		 	echo "<div class='container'>";
			if($_SERVER["REQUEST_METHOD"]=='POST'){
	
					//get variables from form
					$name=$_POST['name'];
					$describtion=$_POST['describtion'];
					$parent=$_POST['parent'];
					$ordering=$_POST['ordering'];
					$visibility=$_POST['visibility'];
					$comment=$_POST['Comment'];
					$ads=$_POST['ads'];

					//validate the form in the server side
					$formerrors = array();
					if(empty($name)){
						$formerrors[]="name cant be <strong>empty</strong>";
					}
					//loop into errors array and echo it
					foreach ($formerrors as $error) {
						echo "<div class='alert alert-danger'>". $error."</div>" ;
					}
					if (empty($formerrors)) {
						//check if item exit in database
						$check=checkitem("Name","categories",$name);
						if($check==1){
							$themsg= "<div class='alert alert-danger'> sorry This categorie Is Exit In Database</div>";
							redirectHome($themsg,"back");
						}else{
							//insert the new Categorie info in database
							$stmt=$connect->prepare("insert into
								categories(Name,Describtion,Parent,Ordering,Visibility,Allow_Comment,Allow_Ads)
								values(:zname, :zdes,:zparent,:zorder,:zvisible,:zComment,:zads)");
							$stmt->execute(array(
								'zname'          => $name,
								'zdes'        	 => $describtion,
								'zparent'		 => $parent,
								'zorder'	     => $ordering,
					 			'zvisible' 	     => $visibility,
				 				'zComment' 	   	 => $comment,
				 				'zads'     		 => $ads
							));
							//Echo success message
							$themsg= "<div class='alert alert-success'>".$stmt->rowCount()." Record Insert</div>" ;
							redirectHome($themsg,"back");
						}
					}
			}
			else{
				$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
				redirectHome($themsg,"back");
			}
			echo "</div>";
		}


		elseif ($do=='Edit') {//Edit Page
			//check if get request catid is numeric &get its integer variable
			if(isset($_GET["catid"]) && is_numeric($_GET['catid'])){
				$catid= intval($_GET['catid']);
			}else{
				$catid= 0;
			}
			//select all data depend on this id
			$stmt=$connect->prepare("select * from categories where Id=? ");
	    	//Execute the data 
	    	$stmt->execute(array($catid));
	    	//fetch the data
	    	$cat=$stmt->fetch();
	    	//the row count
	    	$count=$stmt->rowCount();
    		if($count>0) //to check user id exit or not if exit show form else show message error
    		{?> <!--to write html without-->
				<h1 class="text-center">Edit categorie</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="catid" value="<?php echo $catid?>">
						<!--start name field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Name</label>
								<div class="col-md-10">
									<input type="text" name="name" class="form-control" required="required" placeholder="Name Of Categories" value="<?php echo $cat['Name']?>">
								</div>
							</div>
						<!--end name field-->
						<!--start Describtion field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Describtion</label>
								<div class="col-md-10">
									<input type="text" name="describtion" class="form-control" placeholder="Describe Of Categorie"  value="<?php echo $cat['Describtion']?>">
								</div>
							</div>
						<!--end Describtion field-->
						<!--start Ordering field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Ordering</label>
								<div class="col-md-10">
									<input type="text" name="ordering" class="form-control" placeholder="Number To orange The Categorie"  value="<?php echo $cat['Ordering']?>">
								</div>
							</div>
						<!--end Ordering field-->
						<!--start Add category type-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Parent?</label>
								<select name='parent' class="col-md-10">
									<option value="0">None</option>
									<?php
										$getparentcat=GetAllFrom("*","categories","where parent=0","","Id","");
										foreach ($getparentcat as $categ) {
											Echo "<option value='".$categ['Id']."'";
												if ($cat['Parent']==$categ['Id']) {
													Echo 'selected';
												}
											Echo ">".$categ['Name']."</option>";
										}
									?>
								</select>
							</div>
						<!--end Add category type-->
						<!--start Visibility field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Visible</label>
								<div class="col-md-10">
									<div>
										<input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility']==0){Echo 'checked';} ?> /><!--zero mean that yes active-->
										<label for="vis-yes">Yes</label><!--for to check if click in text-->
									</div>
									<div>
										<input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility']==1){Echo 'checked';} ?>><!--one mean that no not active-->
										<label for="vis-no">no</label><!--for to check if click in text-->
									</div>
								</div>
							</div>
						<!--end Visibility field-->
						<!--start Allow-Comment field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Allow Comment</label>
								<div class="col-md-10">
									<div>
										<input id="com-yes" type="radio" name="comment" value="0" <?php if ($cat['Allow_Comment']==0){Echo 'checked';} ?>><!--zero mean that yes active-->
										<label for="com-yes">Yes</label><!--for to check if click in text-->
									</div>
									<div>
										<input id="com-no" type="radio" name="comment" value="1" <?php if ($cat['Allow_Comment']==1){Echo 'checked';} ?>><!--one mean that no not active-->
										<label for="com-no">no</label><!--for to check if click in text-->
									</div>
								</div>
							</div>
						<!--end Allow-Comment field-->
						<!--start Allow_Ads field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">Allow_Ads</label>
								<div class="col-md-10">
									<div>
										<input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads']==0){Echo 'checked';} ?>><!--zero mean that yes active-->
										<label for="ads-yes">Yes</label><!--for to check if click in text-->
									</div>
									<div>
										<input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads']==1){Echo 'checked';} ?>><!--one mean that no not active-->
										<label for="ads-no">no</label><!--for to check if click in text-->
									</div>
								</div>
							</div>
						<!--end Allow_Ads field-->
						<!--start button field-->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-10">
									<input type="submit" value="Save" class="btn btn-primary btn-lg">
								</div>
							</div>
						<!--end button field-->
					</form>
				</div>
					
				
			<?php
			//if there is no shuch id show error message
			}else{
				echo "<div class='container'>";
					$themsg= "<div class='alert alert-succes'>there is not  such this id</div>";
					redirectHome($themsg);
				echo "</div>";
			}
		}elseif ($do=='Update') {
			echo "<h1 class='text-center'>Update Categorie</h1>";
		 	echo "<div class='container'>";
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				
				//get variables from form
				$id           =$_POST['catid'];
				$name         =$_POST['name'];
				$describtion  =$_POST['describtion'];
				$parent  	  =$_POST['parent'];
				$ordering     =$_POST['ordering'];
				$visibility   =$_POST['visibility'];
				$allow_Comment=$_POST['comment'];
				$allow_Ads    =$_POST['ads'];

				//validate the form in the server side
				$formerrors=array();
				if (strlen($name)<4) {
					$formerrors[]="Name Cant Be Less Than <strong>4 Characters</strong>";
				}
				if (strlen($name)>20) {
					$formerrors[]='Name Cant more Than <strong>20 Characters</strong>';
				}
				if (empty($name)) {
					$formerrors[]='Name Field Cant Be Empty';
				}
				if (empty($formerrors)) {
					//Update the database with this info
					$stmt=$connect->prepare("update categories set Name=? ,Describtion=?,Parent=?,Ordering=?,Visibility=?,Allow_Comment=?,Allow_Ads=? where Id=? ");
					$stmt->execute(array($name,$describtion,$parent,$ordering,$visibility,$allow_Comment,$allow_Ads,$id));	
					
					//notifiction  if data update using redirect function
					echo "<div class='container'>";
						$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>" ;
					echo "</div>";
					redirectHome($themsg,"back");
				}

			} else {
				$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
				redirectHome($themsg);
			}
			echo "</div>";
			
		}elseif ($do=='Delete') {
			//delete category drom database
			echo "<h1 class='text-center'>Delete Category</h1>";
			echo "<div class='container'>";
					//check if get request value is numeric and get the integer value
				if(isset($_GET["catid"]) && is_numeric($_GET['catid'])){
					$catid= intval($_GET['catid']);
				}else{
					$catid= 0;
				}
				//select all data depend on this id
				$check=checkItem("Id","categories",$catid);

	    		if($check>0) //to check user id exit or not if exit show form else show message error
	    		{
	    			$stmt=$connect->prepare("delete from categories where Id=:zid");
	    			//connect zuser with userid
	    			$stmt->bindParam(":zid",$catid);
	    			$stmt->execute();
	    			$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>" ;
	    			redirectHome($themsg);
	    		}else{
					$themsg="<div class='alert alert-danger'>This Id Is Not Exit</div>";
					redirectHome($themsg);
				}
			Echo "</div>";
		}
		include $tpl."footer.php";

		}else{
			header("location:index.php");
			exit();
		}
?>