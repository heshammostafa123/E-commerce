<?php
	session_start();//for the session in the navbar of the header
    $PageTitle="Items";
	include "in.php";
?>


<div class="container">
	<div class="row">
		<div class="col-md-3">
			test
		</div>
		<div class="col-md-9">
			<div class="row">
			<h1 class="text-center">
				Category Items
			</h1>
			<?php 
		if(isset($_GET["pageid"])&&is_numeric($_GET["pageid"])){//check if get request value is numeric and get the integer value
			$Category=intval($_GET["pageid"]);
		}else{
			$Category=0;
		}
		$allitems=GetAllFrom("*","items","where Cat_id=$Category","And  Approve=1 And available_quantity>0 ","Item_Id","ASC");//depend on pageid to differntiate between categories
		foreach ($allitems as $item) {
			//if($item['Member_id']!=isset($_SESSION["userperson_id"])){
				echo "<div class='col-xs-12 col-sm-6 col-md-3'>";
					echo "<div class='thumbnail item-box'>";
						echo "<span class='price-tag'>".$item['Price']."</span>";
						if (empty($item['Avatar'])) {
							Echo"<div class='img'>";
								Echo "<img class='img-responsive img-thumbnail center-block'  src='admin/uploads/avatars/itemsavatars/im.png' alt=''/>";
							Echo "</div>";
						}else{
							Echo"<div class='img'>";
								Echo "<img class='img-responsive img-thumbnail center-block' src='admin\uploads\avatars\itemsavatars\\".$item['Item_Id']."\\".$item['Avatar']."'alt=''/>";
							Echo "</div>";
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
	?>

		</div>
	</div>

	</div>


</div>


<?php
    include $tpl."footer.php";
?>