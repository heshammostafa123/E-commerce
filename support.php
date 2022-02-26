<?php
	session_start();//for the session in the navbar of the header
    $PageTitle="Support";
	include "in.php";
?>
<div class="container support">
	<h2 class="text-center supportheader">
        STEPS TO COMMUNICATE WITH TECHNICAL SUPPORT TO SOLVE THE PROBLEM ONLINE
	</h2>
    <h3 class="text-center supportdan">
        PLEASE READ CAREFULLY
    </h3>
    <ul>
        <li>Contact the technical support department (19319) to make an appointment.</li>
        <li>After make an appointment.please click on the link to Downlaod teamviewer program </li>
        <li>After entering the download page, TeamViewer for Windows is selected .</li>
        <li>After the download is completed, the program is run .</li>
        <li>When the time comes, please send ( ID and Password ) .</li>
    </ul>
</div>


<?php
    include $tpl."footer.php";
?>