<?php 

    ob_start();
	session_start();
    if(isset($_SESSION["userperson"])){
		header("location: index.php");//redirect to index 
	}
    $PageTitle="reset_password";
    if(isset($_SESSION['email'])){
        $email =$_SESSION['email'];
        include "in.php";
        $do="";
        if(isset($_GET['do'])){
                $do=$_GET['do'];
        }else{
                $do='reset';
        }

        //start manage page
        if($do=="reset"){
            //this Email Exist
            $to_email =$email;
            $code=rand(0,1000000);
            $_SESSION['code']=$code;
            $subject = "Password assistance";
            $body = "<p>To authenticate, please use the following One Time Password(OTP)
                        <br/><h1>$code</h1><br/>
                        Do not share this OTP with anyone. Our customer service team will never ask you for your password
                        <br/>We hope to see you again soon
                    </p>";
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            if (mail($to_email, $subject, $body,$headers)) {
                header("Location:reset_password.php?do=OTP");                   
            } else {
                echo "Email sending failed...";
            }
        }elseif($do=="OTP"){
        ?>
            <div class="container reset-page">
                <h1 class="text-center">
                    Verification required
                </h1>
                <div class="reset">
                    <p>
                        To continue, complete this verification step. we've sent a code to your email.
                    </p>
                    <!--start rest form-->
                    <form action="reset_password.php?do=verfiy" method="POST" >
                        <div class="input-container">
                            <label>Enter OTP</label>
                            <input class="form-control" type="text" name="code" max-length="6" autocomplete="off" required placeholder="verification code"/>
                            <i class="fa fa-envelope fa-fw"></i>
                        </div>
                        <input class="btn-primary btn-block" type="submit" value="Continue"/>
                    </form>
                    <!--end rest form-->
                </div>
            </div>
        <?php
        }elseif($do=="verfiy"){
            $sendedcode= $_SESSION['code'];
            $receivedcode= $_POST['code'];
            $formerrors = array();
            if($sendedcode==$receivedcode){
                header("Location: reset_password.php?do=edit");
            }else{
            ?>
            <div class="container reset-page">
                <h1 class="text-center">
                    Verification required
                </h1>
                <div class="reset">
                    <p>
                        To continue, complete this verification step. we've sent a code to your email.
                    </p>
                    <!--start rest form-->
                    <form action="reset_password.php?do=verfiy" method="POST" >
                        <div class="input-container">
                            <label>Enter OTP</label>
                            <input class="form-control" type="text" name="code" max-length="6" autocomplete="off" required placeholder="verification code"/>
                            <i class="fa fa-envelope fa-fw"></i>
                        </div>
                        <input class="btn-primary btn-block" type="submit" value="Continue"/>
                    </form>
                    <!--end rest form-->
                </div>
            </div>
            <?php
                $formerrors[]= "Invalid OTP. Please check your Email and try again.";
            }
        }elseif($do=='edit'){
        ?>
            <div class="container reset-page">
                <h1 class="text-center">
                    Create new password
                </h1>
                <div class="reset">
                    <p>
                        We'll ask for this password whenever you sign in.
                    </p>
                    <!--start rest form-->
                    <form action="reset_password.php?do=update" method="POST" > 
                        <div class="input-container">
                            <label>Password</label>
                            <input minlength="4" class="password form-control" type="password" name="password" autocomplete="new-password" placeholder="Password" required />
                            <!--minlength attribute used to validate the input field in the front end minlength require the input field to be required-->
                            <i class="fa fa-lock fa-fw"></i>
			                <i class="show-pass fa fa-eye fa-lg"></i>
                        </div>
                        <div class="input-container">
                            <label>Confirm Password</label>
                            <input minlength="4" class="password form-control" type="password" name="password2" autocomplete="new-password" placeholder="Password again" required/>
                            <!--minlength attribute used to validate the input field in the front end minlength require the input field to be required-->
                            <i class="fa fa-lock fa-fw"></i>
			                <i class="show-pass fa fa-eye fa-lg"></i>
                        </div>
                        <input class="btn-primary btn-block" type="submit" value="Save changes and sign in"/>
                    </form>
                </div>
                <!--end rest form-->
            </div>
        <?php
        }elseif($do=="update"){
            //validate with back end for input field of signup form
   			$formerrors = array();
            if (isset($_POST['password']) &&isset($_POST['password2'])) {
                if (empty($_POST['password'])) {
                    $formerrors[]="Sorry Bassword Cant Be Empty";
                }
                $passwordone=sha1($_POST['password']);
                $passwordtwo=sha1($_POST['password2']);
                if ($passwordone!==$passwordtwo) {
                    $formerrors[]="Sorry Password IS Not Match";
                }
            }

            if (empty($formerrors)) {
				//check if item exit in database
				$check=checkitem("Email","users",$email);
				if($check==1){
                    $password=sha1($_POST['password']);
					$stmt=$connect->prepare("update users set Password=? where Email=?");
					$stmt->execute(array($password,$email));
                
                    $row=$connect->prepare("select UserId,UserName,Password from users where Password=? and Email=?");
                    $row->execute(array($password,$email));
                    $get=$row->fetch();
                    $_SESSION["userperson"]=$get['UserName'];//Register session name
                    $_SESSION["userperson_id"]=$get['UserId'];//Register session id to used in advertisement of the user
                    header("location:index.php");
                    exit();
                }
            }else{
            ?>
                <div class="container reset-page">
                    <h1 class="text-center">
                        Create new password
                    </h1>
                    <div class="reset">
                        <p>
                            We'll ask for this password whenever you sign in.
                        </p>
                        <!--start rest form-->
                        <form action="reset_password.php?do=update" method="POST" > 
                            <div class="input-container">
                                <label>Password</label>
                                <input minlength="4" class="password form-control" type="password" name="password" autocomplete="new-password" placeholder="Password" required />
                                <!--minlength attribute used to validate the input field in the front end minlength require the input field to be required-->
                                <i class="fa fa-lock fa-fw"></i>
			                    <i class="show-pass fa fa-eye fa-lg"></i>
                            </div>
                            <div class="input-container">
                                <label>Confirm Password</label>
                                <input minlength="4" class="password form-control" type="password" name="password2" autocomplete="new-password" placeholder="Password again" required/>
                                <!--minlength attribute used to validate the input field in the front end minlength require the input field to be required-->
                                <i class="fa fa-lock fa-fw"></i>
			                    <i class="show-pass fa fa-eye fa-lg"></i>
                            </div>
                            <input class="btn-primary btn-block" type="submit" value="Save changes and sign in"/>
                        </form>
                    </div>
                    <!--end rest form-->
                </div>
            <?php   
            }    
        }
        ?>
        <!--start notifaction message of forget-->
        <div class="the-errors text-center">
            <?php
                if (!empty($formerrors)) {
                    foreach ($formerrors as $error) {
                        Echo '<div class="msg error">'.$error.'</div>';
                    }
                }
            ?>
        </div>
        <!--end notification message of forget-->
        <?php
        include $tpl."footer.php";
    }else{
        header("location:forget_password.php");
		exit();
    }    
?>