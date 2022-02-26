<?php

	session_start();//for the session in the navbar of the header

    $PageTitle="Checkout";
    if(isset($_SESSION["userperson"])){
        include "in.php";
        if ($_SERVER["REQUEST_METHOD"]=='POST') {
		
            $city=filter_var($_POST['city'],FILTER_SANITIZE_STRING);
            $phone=filter_var($_POST['phone'],FILTER_SANITIZE_NUMBER_INT);
            $adress=filter_var($_POST['adress'],FILTER_SANITIZE_STRING);
            $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);

            $formerrors=array();
    
            if(empty($city)){
                $formerrors[]="City can\'t be <strong>Empty</strong>";
            }
            if(empty($phone)){
                $formerrors[]="Phone can\'t be <strong>String Or Empty</strong>";
            }
            if(empty($adress)){
                $formerrors[]="Address  can\'t be <strong>Empty</strong>";
            }
            if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
                $phone=$phone;
            }else{
                $formerrors[]="Phone Must Match <strong>000-000-0000</strong>";
            }
            //check if there is no error proceed the update opertion
            if (empty($formerrors)) {
                $stmt=$connect->prepare("
                        select 
                            users.*,totalcost.Total
                        from users
                            INNER JOIN totalcost
                        on 
                            users.UserId=totalcost.User_Id
                        where
                            users.UserId=?
                        ");
                $stmt->execute(array($_SESSION["userperson_id"]));
                $row=$stmt->fetch();

                //insert the new order info in database
                $stmt=$connect->prepare("insert into
                    orders(Customer_Id,Customer_Name,Order_Cost,Deliver_To,Address,Email,Phone,Order_Date,Comment)
                    values(:zid, :zname,:ztotalcost,:zcity, :zaddress,:zemail,:zphone,now(),:zcomment)");
                $stmt->execute(array(
                    'zid' 		=> $row['UserId'],
                    'zname' 	=> $row['UserName'],
                    'ztotalcost'=> $row['Total'],
                    'zcity'		=> $city,
                    'zphone'  => $phone,
                    'zaddress' 		=> $adress,
                    'zcomment'		=>$comment,
                    'zemail' 		=> $row['Email']
                    
                ));
                 
                $stmt=$connect->prepare("                
                select orders.Order_Number from orders where Customer_Id=? 
                order by orders.Order_Number DESC LIMIT 1
                ");

                $stmt->execute(array($_SESSION["userperson_id"]));
                $result=$stmt->fetch();
                $order_num=($result[0]);

                $stmt=$connect->prepare("                
                select cart_items.* from cart_items where User_Id=? 
                ");

                $stmt->execute(array($_SESSION["userperson_id"]));
                $result=$stmt->fetchAll();
		        if (!empty($result)) {
                    foreach ($result as $res){
                        $stmt=$connect->prepare("insert into
                            order_items(Order_Id,Item_Id,Quantity,User_Id)
                         values(:zid,:zitemid,:zq,:zuser)");
                         $stmt->execute(array(
                            'zid' 		=> $order_num,
                            'zitemid' 	=> $res['Item_Id'],
                            'zq'=> $res['Required_Quantity'],
                            'zuser'=>$_SESSION["userperson_id"]
                         ));

                        // $ordernumber=$res['Order_Number'];
                        // $userid=$res['User_Id'];
                        // $itemid=$res['Item_Id'];
                        // $r_q=$res['Required_Quantity'];
                        
                        // $stmt=$connect->prepare("Update
                        //         order_items
                        //     set
                        //         Order_Id=?,
                        //         User_Id=?,
                        //         Item_Id=?,
                        //         Quantity=?
                        //     where
                        //         User_Id=?
                        // ");
                        //  $stmt->execute(array($ordernumber,$userid,$itemid,$r_q,$userid));
                        
                    }
                }
                $stmt=$connect->prepare("delete from cart_items where User_Id=:zid");
    			//connect zuser with userid
    			$stmt->bindParam(":zid",$row['UserId']);
    			$stmt->execute();
                $stmt=$connect->prepare("delete from totalcost where User_Id=:zid");
    			//connect zuser with userid
    			$stmt->bindParam(":zid",$row['UserId']);
    			$stmt->execute();
                //Echo success message
                if($stmt){
                    //Echo success message
                    echo "<div class='container'>";
                        $themsg= 
                            "<div class='alert alert-success'>".$stmt->rowCount()."order recorded</div>
                            <div class='alert alert-success'>The order will be delivered after 72 hours</div>" ;
                            redirectHome($themsg);
                    echo "</div>";
                    
                }
            }
        }
        ?>
        <h1 class="text-center"><?php echo $PageTitle ?></h1>
        <?php 
            $userid=$_SESSION["userperson_id"];
            $count=countItem("User_Id","cart_items","where User_Id=$userid");
            if($count>0){
        ?>
        <div class="create-ad block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo $PageTitle ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form class="form-horizontal main-form" action="<?php Echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <!--start City field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-md-2 control-label">City</label>
                                            <div class="col-md-10">
                                                <input pattern=".{4,}" type="text" name="city"  title="This Field require At Least 4 Characters"  class="form-control" autocomplete="off" required="required" placeholder="Name Of City">
                                            </div>
                                        </div>
                                    <!--end City field-->
                                    <!--start Phone Number field-->
                                        <div class="form-group form-group-lg">
                                            <label pattern=".{11,}" title="This Field require 11 Characters" required class="col-md-2 control-label">Phone Number</label>
                                            <div class="col-md-10">
                                                <input type="tel" name="phone" class="form-control" autocomplete="off" required="required"  placeholder="Phone Number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                                                <small>Format: 000-000-0000</small>
                                            </div>
                                        </div>
                                    <!--end Phone Number field-->
                                    <!--start Address field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-md-2 control-label">Address</label>
                                            <div class="col-md-10">
                                                <textarea name="adress" class="form-control" id="exampleFormControlTextarea1" rows="3"  required="required"   placeholder="Adress In Details"></textarea>
                                            </div>
                                        </div>
                                    <!--end Address field-->
                                    <!--start comment field-->
                                    <div class="form-group form-group-lg">
                                            <label class="col-md-2 control-label">Comment</label>
                                            <div class="col-md-10">
                                                <textarea name="comment" class="form-control" id="exampleFormControlTextarea2" rows="3"  placeholder="You can leave us a comment here"></textarea>
                                            </div>
                                        </div>
                                    <!--end comment field-->
                                    <!--start button field-->
                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-md-10">
                                                <input type="submit" value="Submit order" class="btn btn-primary btn-sm">
                                            </div>
                                        </div>
                                    <!--end button field-->
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="thumbnail item-box">
                                    <?php 
                                    $userid=$_SESSION["userperson_id"];
                                    //select total cost
                                    $stmt=$connect->prepare("select * from totalcost where User_Id=? limit 1");
                                    $stmt->execute(array($userid));
                                    $row=$stmt->fetch();
                                    $total=$row['Total'];
                                    
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
                                        foreach ($rows as $row) {
                                        Echo "<div class='row'>";
                                            echo "<div class='col-xs-4'>";
                                                echo "<div class='checkout-thumbnails'>";
                                                    if (empty($row['Avatar'])) {
                                                        Echo "<img class='img-responsive img-thumbnail center-block' src='admin/uploads/avatars/itemsavatars/im.png' alt=''/>";
                                                    }else{
                                                        Echo "<img class='img-responsive img-thumbnail center-block' src='admin\uploads\avatars\itemsavatars\\".$row['Item_Id']."\\".$row['Avatar']."'alt=''/>";
                                                    }
                                                echo "</div>";
                                            echo "</div>";
                                            echo "<div class='col-xs-8'>";
                                                echo "<div class='checkout-info'>";
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
                                        echo "</div>";
                                        echo "<div role='separator' class='divider'></div>";
                                        }
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="checkout-order">
                                                Order Total
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="checkout-cost">
                                                <?php 
                                                echo $total;
                                                ?>
                                            </div>
                                        </div>									
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
                            Echo '<div class="alert alert-success">'.$themsg.'</div>';
                        }
                        ?>
                        <!--end loop through Errors-->
                    </div>
                </div>
            </div>
        </div>
        <?php
        }else{
            echo "<div class='container'>";
               echo "<div class='empty-cart'>";
                echo "<h3>Your Cart Is Empty</h3>";
               echo "</div>";
            echo "</div>";
        }
        include $tpl."footer.php";
	}else{
		header("location:index.php");
		exit();
	}
?>
     
