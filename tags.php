<?php

    $PageTitle="Tags";
	include "in.php";
?>


<div class="container">
	<div class="row">
		<?php 
			if(isset($_GET['name'])){//show tags depend on the tag name variable
				$tag=$_GET['name'];
			}else{
				$tag='';
			}
			echo "<h1 class='text-center'>".$tag."</h1>";
			$tagsitems=GetAllFrom("*","items","where Tags like '%$tag%'","And  Approve=1","Item_Id","");//depend on pageid to differntiate between categories
			foreach ($tagsitems as $item) {
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
						echo "<div>";
							echo '<h3><a href="items.php?item_id='.$item['Item_Id'].'">'.$item['Name']."</a></h3>";
							echo "<p>".$item['Describtion']."</p>";
							echo "<div class='date'>".$item['Add_Date']."</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>"; 
			}
		?>
	</div>
</div>


<?php
    include $tpl."footer.php";
?>