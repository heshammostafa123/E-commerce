<?php 

	/*
		-manage comment pages
		-you can add /delete /approve comment from here
	*/
	session_start();
	$PageTitle="Orders";

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
								<td>Customer Name</td>
								<td>cost</td>
                                <td>City</td>
                                <td>Address</td>
                                <td>Phone</td>
								<td>Order_Date</td>
								<td>Control</td>
							</tr>
							<?php
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>".$row['Customer_Name']."</td>";
										echo "<td>".$row['Order_Cost']."</td>";
										echo "<td>".$row['Deliver_To']."</td>";
                                        echo "<td>".$row['Address']."</td>";
										echo "<td>".$row['Phone']."</td>";
										echo "<td>".$row['Order_Date']."</td>";
										echo "<td>
											<a href='orders.php?do=view&order_id=".$row['Order_Number']."' class='btn btn-info'><i class='fa fa-eye'></i>order items</a>";	
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
		}elseif ($do=="view") { //View Page

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
								<td>Item Name</td>
								<td>Item Des</td>
                                <td>Item Price</td>
								<td>Quantity</td>   
                                <td>Control</td>                             
							</tr>
							<?php
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>".$row['Name']."</td>";
										echo "<td>".$row['Describtion']."</td>";
										echo "<td>".$row['Price']."</td>";
										echo "<td>".$row['Quantity']."</td>";
                                        echo "<td>";
                                            echo "<a href='orders.php?do=Delete&item_id=".$row['Item_Id']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Remove</a>";
                                        echo "</td>";
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
					$themsg= "<div class='alert alert-succes'>This Order Not Exist</div>";
					redirectHome($themsg);
				echo "</div>";
			}
        }elseif ($do=='Delete') {
            //delete item from order
            echo "<h1 class='text-center'>Delete Item</h1>";
            echo "<div class='container'>";
                //check if get request value is numeric and get the integer value
                if(isset($_GET["item_id"]) && is_numeric($_GET['item_id'])){
                    $itemid= intval($_GET['item_id']);
                }else{
                    $itemid= 0;
                }
                //select all data depend on item id
                $stmt=$connect->prepare("select * from order_items where Item_Id=? and User_Id=? limit 1");
                $stmt->execute(array($itemid,$userid));
                $row=$stmt->fetch();
                $count=$stmt->rowCount();
                if($count>0) //to check item id exit or not 
                {
                    $item_quantity=$row['Quantity'];
					$order_id=$row['Order_Id'];
                    $res=$connect->prepare("select * from items where Item_Id=? limit 1");
                    $res->execute(array($itemid));
                    $item=$res->fetch();
                    $newquantity=$item['available_quantity']+$item_quantity;
					//update available quantity
					$stmt=$connect->prepare("update 
					                    items 
					                set 
					                    available_quantity=?	
					                where 
					                    Item_Id=? ");
					$stmt->execute(array($newquantity,$itemid));
                    $resl=$connect->prepare("select * from orders where Order_Number=? limit 1");
                    $resl->execute(array($order_id));
                    $order=$resl->fetch();
					$ordercost=$order['Order_Cost'];
                    $item_price=$item['Price'];//$65
                    $newordercost= substr_replace(
                        trim($ordercost,"$")
                        -($item_quantity*trim($item_price,"$"))
                    ,'$', 0, 0); //1*$65

					if(trim($newordercost,"$")>0){
							//update orders order cost
							$stmt=$connect->prepare("update 
							                    orders 
							                set 
							                    Order_Cost=?	
							                where 
							                    Order_Number=? 
											and 
												Customer_Id=?
											");
							$stmt->execute(array($newordercost,$order_id,$userid));
					}else{
						$stmt=$connect->prepare("delete from orders where Order_Number=? and Customer_Id=?");
						$stmt->execute(array($order_id,$userid));
					}
					//delete order item
					$order_item=$connect->prepare("delete from order_items where Order_Id=? and Item_Id=?");
					$order_item->execute(array($order_id,$itemid));

					$themsg= "<div class='alert alert-success'>Record Deleted</div>" ;
    				redirectHome($themsg,"back");
                }else{
					$themsg= "<div class='alert alert-danger'>This Item Id Is Not Exit</div>";
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