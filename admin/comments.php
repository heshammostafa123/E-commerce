<?php 

	/*
		-manage comment pages
		-you can add /delete /approve comment from here
	*/
	session_start();
	$PageTitle="Comment";
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
			//select all comments
			$stmt=$connect->prepare("select comments.*,items.Name AS Item_Name,users.UserName AS Member
					from
						 comments
					INNER JOIN
						items
					on
						items.Item_Id=comments.Item_Id
					INNER JOIN
						users
					on
						users.UserId=comments.User_Id
					order by 
						C_Id desc

					");
			//Excute the statement
			$stmt->execute();
			//Assign to variable
			$rows=$stmt->fetchAll();
			if (! empty($rows)) {
?>
				<h1 class="text-center">Manage Comments</h1>
				<div class="container">
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>Comments</td>
								<td>Item Name</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>
							<?php
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>".$row['C_Id']."</td>";
										echo "<td>".$row['Comment']."</td>";
										echo "<td>".$row['Item_Name']."</td>";
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
				</div>
<?php
			}else{
				Echo "<div class='container'>";
					Echo '<div class="nice-message">There\'s No Comments To Show</div>';
				Echo"</div>";
			}
?>		

<?php
		}elseif ($do=="Edit") { //Edit Page

			if(isset($_GET["comment_id"]) && is_numeric($_GET['comment_id'])){ //check if get request value is numeric and get the integer value
				$comment_id= intval($_GET['comment_id']);
			}else{
				$comment_id= 0;
			}
			//select all data depend on this id
			$stmt=$connect->prepare("select * from comments where C_Id=?");
	    	//Execute the data 
	    	$stmt->execute(array($comment_id));
	    	//fetch the data
	    	$row=$stmt->fetch();
	    	//the row count
	    	$count=$stmt->rowCount();
    		if($count>0) //to check user id exit or not if exit show form else show message error
    			{?> <!--to write html without-->
				<h1 class="text-center">Edit comment</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="comment_id" value="<?php echo $comment_id?>">
						<!--start comment field-->
							<div class="form-group form-group-lg">
								<label class="col-md-2 control-label">comment</label>
								<div class="col-md-10">
									<textarea class="form-control" name="comment"><?php echo $row['Comment']?></textarea>
								</div>
							</div>
						<!--end comment field-->
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
			}
			else{
				echo "<div class='container'>";
					$themsg= "<div class='alert alert-succes'>there is not  such this id</div>";
					redirectHome($themsg);
				echo "</div>";
			}
		 }elseif ($do=="Update") {//Update page
				if($_SERVER["REQUEST_METHOD"]=="POST"){
					echo "<h1 class='text-center'>Update Comment</h1>";
		 			echo "<div class='container'>";
					//get variables from form
					$com_id =$_POST["comment_id"];
					$comment   =$_POST["comment"];
					//Update the database with this info
					$stmt=$connect->prepare("update comments set comment=? where C_Id=?");
					$stmt->execute(array($comment,$com_id));	
					//notifiction  if data update using redirect function
					echo "<div class='container'>";
						$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Updated</div>" ;
					echo "</div>";
					redirectHome($themsg,"back");

				}
				else{
					echo "<div class='container'>";
						$themsg= "<div class='alert alert-danger'>sorry you cant Browse this page directly</div>";
					echo "</div>";
					redirectHome($themsg);
				}

			echo '</div>';

		}elseif ($do=='Delete') {
		 	//delete member drom database
			echo "<h1 class='text-center'>Delete Comment</h1>";
			echo "<div class='container'>";
				//check if get request value is numeric and get the integer value
				if(isset($_GET["comment_id"]) && is_numeric($_GET['comment_id'])){
					$commentid= intval($_GET['comment_id']);
				}else{
					$commentid= 0;
				}
				//select all data depend on this id
				$check=checkItem("C_Id","comments",$commentid);

	    		if($check>0) //to check user id exit or not if exit show form else show message error
	    		{
	    			$stmt=$connect->prepare("delete from comments where C_Id=:zcomment");
	    			//connect zcomment with comment id
	    			$stmt->bindParam(":zcomment",$commentid);
	    			$stmt->execute();
	    			$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>" ;
	    			redirectHome($themsg);
	    		}else{
	    			$themsg= "<div class='alert alert-danger'>This Id Is Not Exit</div>";
	    			redirectHome($themsg);
	    		}
    		echo "</div>";
		}elseif ($do=="Approve") {
			//Activate member drom database
			echo "<h1 class='text-center'>Approve Comment</h1>";
			echo "<div class='container'>";
		 		//check if get request value is numeric and get the integer value
				if(isset($_GET["comment_id"]) && is_numeric($_GET['comment_id'])){
					$comment_id= intval($_GET['comment_id']);
				}else{
					$comment_id= 0;
				}
				//select all data depend on this id
				$check=checkItem("C_Id","comments",$comment_id);

	    		if($check>0) //to check user id exit or not if exit show form else show message error
	    		{
	    			$stmt=$connect->prepare("update comments set Status=1 where C_Id=?");
	    			$stmt->execute(array($comment_id));
	    			$themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record Approved</div>" ;
	    			redirectHome($themsg);
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