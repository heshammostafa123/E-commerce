		<div class="container">
			<hr class="custom-hr"/>
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<div class="account">
						<h3>My Account</h3>
						<ul class="list-unstyled">
							<?php 
								if(isset($_SESSION["userperson"])){
									echo "<li><a href='profile.php'>Profile details</a></li>";
									echo "<li><a href='profile.php#my-ads'>My Items</a></li>";
								}else{
									echo "<li><a href='login.php'>Profile details</a></li>";
									echo "<li><a href='login.php'>My items</a></li>";
								}
							?>
						</ul>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="store">
						<h3>Company Store</h3>
						<ul class="list-unstyled">
							<li><a href='about-us.php'>About Us</a></li>
							<?php
							if(isset($_SESSION["userperson"])){
								echo "<li><a href='contact.php'>Contact US</a></li>";
							}else{
								echo "<li><a href='login.php'>Contact US</a></li>";
							}
							?>
							<li><a href='support.php'>Support</a></li>
						</ul>	
					</div>	
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="profit">
						<h3>Make Money With US</h3>
						<ul class="list-unstyled">
							<li>Sell Products On Site</li>
							<li>Sell Apps On Site</li>
							<li>Advertise Your Products</li>
						</ul>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contact-us">
						<h3>Contact Us</h3>
						<p>Assiut,No. 27 El Gomhoria Street, next to Cairo Bank</p>
						<ul class="list-unstyled">
							<li>Call US 19319</li>
							<li>Every Day 10:00Am - 10:00Pm</li>
							<li>Company12@gmail.com</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer text-center">
			<div class="container ">
				<div class="row">
					<div class="copyright col-xs-12 col-sm-6">Copyright to &copy; Electronics</div>
					<div class="design col-xs-12 col-sm-6">Designed by Hesham Mostafa</div>
				</div>
			</div>
		</div>
		<!--strat scroll to top-->
			<div id="scroll-top">
				<i class="fa fa-arrow-circle-up fa-3x" aria-hidden="true"></i>
			</div>
		<!--end scroll to top-->
      	<script type="text/javascript" src="<?php echo $js; ?>jquery.min.js"></script>
      	<script type="text/javascript" src="<?php echo $js; ?>bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $js; ?>front.js"></script>
		<script src="<?php echo $js; ?>jquery.elevatezoom.js" type="text/javascript"></script>
		<script>
			$("#img_01").elevateZoom({easing:true});
		</script>
		<script src="<?php echo $js; ?>zoom-image.js" type="text/javascript"></script>
		<script src="<?php echo $js; ?>zoom-main.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo $js; ?>jquery-ui.min.js"></script>
      	<script type="text/javascript" src="<?php echo $js; ?>jquery.selectBoxIt.min.js"></script>

    </body>
</html>