<?php
	ob_start();
    session_start();
	$PageTitle="Reset";
	include 'in.php';

	if ($_SERVER["REQUEST_METHOD"]=='POST') {
		if(isset($_POST['reset'])){
			$email=$_POST['email'];;
            
			$check=checkitem("Email","users",$email);
            $formerrors = array();
            if($check==1){
                $_SESSION['email'] =$email;
                header("Location: reset_password.php");
                exit;
            }else{
                $formerrors[]= "This Email Not Exist";
            }
   		}
	}
?>

<div class="container reset-page">
    <h1 class="text-center">
        Reset Password
    </h1>
    <div class="reset">
        <p>
            Enter the email address associated with your account.
        </p>
        <!--start rest form-->
        <form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" >
            <div class="input-container">
                <label>Email</label>
                <input class="form-control" type="email" name="email" autocomplete="off" required placeholder="Email"/>
                <i class="fa fa-envelope fa-fw"></i>
            </div>
            <input class="btn-primary btn-block" name="reset" type="submit" value="Reset Password"/>
        </form>
    </div>
    <!--end rest form-->
    <!--start notifaction message of forget-->
    <div class="the-errors text-center">
        <?php
            if (!empty($formerrors)) {
                foreach ($formerrors as $error) {
                    Echo '<div class="msg error">'.$error.'</div>';
                }
            }
            if (isset($success_message)) {
                Echo '<div class="msg success">'.$success_message.'</div>';
            }
        ?>
    </div>
    <!--end notification message of forget-->
</div>
<?php
	include $tpl."footer.php";
	ob_end_flush();

?>