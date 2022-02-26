<?php
	//page to show who we are
	session_start();

    $PageTitle="About Us";
    
	include "in.php";
?>
<div class="container">
    <h1 class="text-center">About Us</h1>
    <div class="about-us-avatar">
        <div class="overlay">
               <h2>WHO WE ARE?</h2>
               <div role='separator' class='divider'></div>
               <p><span>Electronics</span> is guided by four principles: customer obsession rather than competitor focus, passion for invention, commitment to operational excellence, and long-term thinking.</p>
               <p>we features a wide portfolio Of products that meet the needs of individuals and corporate By pursuing a study of the evolution of customer needs</p>
        </div>
    </div>
</div>
<div class="container container-about-us">
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="about-us">
                <img src="layout/images/about-us.jpg" alt="about-us-img" class="img-responsive">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="row">
                <div class="col-xs-12">
                    <i class="fa fa-rocket fa-lg" aria-hidden="true"></i>
                    <div class="text-info">
                        <h4>Our Mission</h4>
                        <p>We strive to offer our customers the lowest possible prices, the best available selection, and the utmost convenience.</p>
                    </div>
                </div>
                <div class="col-xs-12">
                    <i class="fa fa-eye fa-lg" aria-hidden="true"></i>
                    <div class="text-info">
                        <h4>Our Vission</h4>
                        <p>Our vision is to be earth's most customer centric company; to build a place where people can come to find and discover anything they might want to buy online.</p>
                    </div>
                </div>
                <div class="col-xs-12">
                    <i class="fa fa-bullseye fa-lg" aria-hidden="true"></i>
                    <div class="text-info">
                        <h4>Target</h4>
                        <p>We at company name are not only thinking about what we can offer to our customers at the moment, but we are thinking about developing and improving performance for the best for us an our customers by looking for the best technology solutions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include $tpl."footer.php";
?>