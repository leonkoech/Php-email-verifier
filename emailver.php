<?php

//I used  PDO because it was more convinient
$connect = new PDO('mysql:host=localhost;dbname=sidetest', 'root', '');
session_start();
//importing the mailer class for sending emails
include_once 'mailerclass.php';
//importing user class to fetch user details(for the email to be sent to the company)
//for notification of user confirmation of registration
include_once 'userclass.php';
$mailer = new Mailerclass();
$user= new User();
//$uid = $_SESSION['id'];
//this 'uniqueuserid' is the argument i put inside the link to the verification
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
			{
				$update_query = "UPDATE users SET active = 1 WHERE id = '".$row['id']."'";
				$statement = $connect->prepare($update_query);
				$statement->execute();
				$sub_result = $statement->fetchAll();
				//if updated
				if(isset($sub_result))
				{	//get the email of the user
					$getmail = "SELECT email from users WHERE id = '".$row['id']."'";
					$resultmail= $connect->prepare($update_query);
					$resultmail->execute();
					$mmailresult = $resultmail->fetchAll();
					foreach ($mmailresult as $mailresult) {
						//get username
						$getname = "SELECT username from users WHERE id = '".$row['id']."'";
						$resultname= $connect->prepare($update_query);
						$resultname->execute();
						$nameresult = $resultname->fetchAll();
						foreach ($nnameresult as $nameresult) {
                            echo '<script type="text/javascript">alert("Your Email Address Successfully Verified")</script>';

							//$message = '<label class="text-success">Your Email Address Successfully Verified <br />You can login here - <a href="login.php">Login</a></label>';
							//calling the mailer function and hopefully it sends an email to the following 
							$address='companyjunk@mailinator.com';
							$subject='User Registration';
							$mailbody= '
							<p>Another user has confirmed registration.</p>
							<p>username </p>'.$nameresult['username'].'
							<p>and</p>
							<p>email</P'.$mailresult['email'].'
							<p>Open this link to log in as admin - http://localhost/phpprojects/final/@admin.php</P>
							<p>Best Regards,<br/>Leon Koech<br/>System Administrator</p>
							';
							$name='';
							$mailer->sendemail($subject,$address,$mailbody,$name);
						}

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
<html>
	<head>
		<title>Registration status</title>		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		
		<div class="container">
			<h1 align="center">Email Verification</h1>
            <h3 align="center"><a href="login.php">click here to login</a></h3>
			
		</div>
	
	</body>
	
</html>
