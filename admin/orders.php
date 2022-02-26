<?php 

	/*
		-manage comment pages
		-you can add /delete /approve comment from here
	*/
	session_start();
	$PageTitle="Orders";
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
			//select all Orders
			$stmt=$connect->prepare("select * from orders where delivered=0 order by Order_Date desc");
			//Excute the statement
			$stmt->execute();
			//Assign to variable
			$rows=$stmt->fetchAll();
			if (! empty($rows)) {
?>
				<h1 class="text-center">Manage Orders</h1>
				<div class="container">
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>order_number</td>
								<td>customer_id</td>
								<td>Customer Name</td>
								<td>cost</td>
                                <td>City</td>
                                <td>Address</td>
								<td>Email</td>
                                <td>Phone</td>
								<td>Order_Date</td>
								<td>Control</td>
							</tr>
							<?php
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>".$row['Order_Number']."</td>";
										echo "<td>".$row['Customer_Id']."</td>";
										echo "<td>".$row['Customer_Name']."</td>";
										echo "<td>".$row['Order_Cost']."</td>";
										echo "<td>".$row['Deliver_To']."</td>";
                                        echo "<td>".$row['Address']."</td>";
										echo "<td>".$row['Email']."</td>";
										echo "<td>".$row['Phone']."</td>";
										echo "<td>".$row['Order_Date']."</td>";
										echo "<td>
											<a href='orders.php?do=view&order_id=".$row['Order_Number']."' class='btn btn-success'><i class='fa fa-eye'></i>order items</a>";
                                            if($row['delivered']==0){
                                                echo "<a href='orders.php?do=delivery&order_id=".$row['Order_Number']."' class='btn btn-info activate'><i class='fa fa-check'></i>delivery</a>";
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
					Echo '<div class="nice-message">There\'s No Orders To Show</div>';
				Echo"</div>";
			}
?>		

<?php
		}elseif ($do=="view") { //Edit Page

			if(isset($_GET["order_id"]) && is_numeric($_GET['order_id'])){ //check if get request value is numeric and get the integer value
				$order_id= intval($_GET['order_id']);
			}else{
				$order_id= 0;
			}
			//select all data depend on this id			
			$stmt=$connect->prepare("SELECT items.*,order_items.*
                from 
                    items
                INNER JOIN 
                    order_items
                on 
                    items.Item_Id=order_items.Item_Id
                where
                    order_items.Order_Id=?
            ");
	    	//Execute the data 
	    	$stmt->execute(array($order_id));
	    	//fetch the data
	    	$rows=$stmt->fetchAll();
	    	//the row count
	    	$count=$stmt->rowCount();
    		if($count>0)
    			{
?>
				<h1 class="text-center">Order Items</h1>
				<div class="container">
                    <div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Order_Id</td>
								<td>Item Id</td>
                                <td>Item Name</td>
								<td>Quantity</td>                                
							</tr>
							<?php
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>".$row['Order_Id']."</td>";
										echo "<td>".$row['Item_Id']."</td>";
										echo "<td>".$row['Name']."</td>";
										echo "<td>".$row['Quantity']."</td>";
									echo "</tr>";
								}
							?>
						</table>
					</div>
				</div>
<?php
			//if there is no such id show error message
			}
			else{
				echo "<div class='container'>";
					$themsg= "<div class='alert alert-succes'>there is not  such this id</div>";
					redirectHome($themsg);
				echo "</div>";
			}
        }elseif ($do=='delivery') {
            //mark item as deliverd 
            echo "<h1 class='text-center'> Delivery Item</h1>";
            echo "<div class='container'>";
                 //check if get request value is numeric and get the integer value
                if(isset($_GET["order_id"]) && is_numeric($_GET['order_id'])){
                    $order_num= intval($_GET['order_id']);
                }else{
                    $order_num= 0;
                }
                //select all data depend on this id
                $check=checkItem("Order_Number","orders",$order_num);
    
                if($check>0) //to check order id exit or not if exit show form else show message error
                {
                    $stmt=$connect->prepare("update orders set delivered=1 where Order_Number=?");
                    $stmt->execute(array($order_num));
                    $themsg= "<div class='alert alert-success'>".$stmt->rowCount()."Record deliverd</div>" ;
                    redirectHome($themsg,'back');
                }else{
                    $themsg= "<div class='alert alert-danger'>This Id Is Not Exit</div>";
                    redirectHome($themsg);
                }
            echo "</div>";
        }
        include $tpl."footer.php";
    
        }	 
    else{
		header("location:index.php");
		exit();
	}

?>