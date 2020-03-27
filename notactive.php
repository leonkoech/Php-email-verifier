<?php
$connect = new PDO('mysql:host=localhost;dbname=sidetest', 'root', '');
require_once 'userclass.php';
$user = new User();
if(isset($_GET['uniqueuserid']))
{
    //then selecting all from the database where the uniquid is similar to the unique id
    //that the user entered in the registration form. labelled :uniqueid
	$query = "SELECT * FROM users WHERE uniqueid = :uniqueid";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':uniqueid'	=>	$_GET['uniqueuserid']
		)
	);
	$no_of_row = $statement->rowCount();
	
	if($no_of_row > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if($row['active'] == 0)
			{        if (isset($_POST['submit'])) {
                    //get the email of the user
					$getmail = "SELECT email from users WHERE id = '".$row['id']."'";
					$resultmail= $connect->prepare($getmail);
					$resultmail->execute();
					$mmailresult = $resultmail->fetchAll();
					foreach ($mmailresult as $mailresult) {
						//get username
						$getname = "SELECT username from users WHERE id = '".$row['id']."'";
						$resultname= $connect->prepare($getname);
						$resultname->execute();
						$nnameresult = $resultname->fetchAll();
						foreach ($nnameresult as $nameresult) {
                            //echo '<script type="text/javascript">alert("Your Email Address Successfully Verified")</script>';
                           
                                $uname=$nameresult['username'];
                                $uemail=$mailresult['email'];
                                $unique_key= $uname;
                                $unique_key=md5($unique_key);

                                $mailbody = "
                                <p>Hi ".$uname.",</p>
                                <p>Thanks for Registration. Your email is ".$uemail.", Your password will work only after your email verification.</p>
                                <p>Please Open this link to verify your email address - http://localhost/phpprojects/final/emailver.php?uniqueuserid=".$unique_key."
                                <p>Best Regards,<br />Your Webmaster hahaha</p>
                                ";
                                $companyname='van der keons';
                                $subject='Confirm your '.$companyname.' email';
                                $mailer= new Mailerclass();
								$mailer->sendemail($subject,$uemail,$mailbody,'');
								if ($mailer) {
									# code...
									echo '<script type="text/javascript">alert("Email sent successfully. \n Check your email to verify")</script>';
									header('location:login.php');
								}
                            }
							//$message = '<label class="text-success">Your Email Address Successfully Verified <br />You can login here - <a href="login.php">Login</a></label>';
							//calling the mailer function and hopefully it sends an email to the following 
						}

					}

			}
			else
			{   echo '<script type="text/javascript">alert("Your Email Address is ALREADY Verified")</script>';
				//$message = '<label class="text-info">Your Email Address Already Verified</label>';
			}
		}
	}
	else
	{   echo '<script type="text/javascript">alert("Invalid Link")</script>';
		//$message = '<label class="text-danger">Invalid Link</label>';
	}
}

?>
<!DOCTYPE html>
<html lang="en" >
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Error</title>
		<link rel="stylesheet" type="text/css" href="test.css" />
	</head>
    <body style="background:#3f7fd9;
  " >
        <div style="width:520px; height:auto;position: absolute;
        text-align: center; background:#2f6abd;
  ">
		<img src="images/gatherz.jpg" alt="error 500" style="
		height:430px;
		width:auto;
	position: absolute;
  top: 50%;
  left: 80%;
  -ms-transform: translate(60% ,25%);
  transform: translate(60%, 25%);

  ">
        </div>
        <div class="container2">
		<P>oops</P>
			<label class="text-danger">
			
				<span>Your email has not been verified.<br>
					check your email for the link or<br>
					click here to resend code</span>
					<strong></strong>
					<div><form action="" method="post" name="forgotpassword">
					<div class="formgroup">
					<input class="button" type="submit" name="submit" value="resend code">
					</div>
			</label>
		</div>
</body>
<script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script> 
</html>