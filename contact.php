<?php
	//page to show who we are
	session_start();

    $PageTitle="Contact Us";
    
	include "in.php";
?>
<div class="container contact">
    <h1 class="text-center">Contact Us</h1>
    <h2 class="text-center contactheader">
        WAYS TO COMMUNICATE with TECHNICAL SUPPORT TO SOLVE THE PROBLEM
	</h2>
    <div class="contact-us">
        <p>Assiut,No. 27 El Gomhoria Street, next to Cairo Bank</p>
        <ul class="list-unstyled">
            <li>Call US 19319</li>
            <li>Every Day 10:00Am - 10:00Pm</li>
            <li>Company12@gmail.com</li>
        </ul>
    </div>
</div>
<?php
    include $tpl."footer.php";
?>