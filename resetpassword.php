
<?php
    $connect = new PDO('mysql:host=localhost;dbname=sidetest', 'root', '');
    session_start();
    include_once 'userclass.php';
    require_once 'mailerclass.php';
    $mailer= new Mailerclass();
    $user = new User();
    $uid = $_SESSION['id'];
    //I named this qid to 'confuse confuse the endusers'
    //you can remate it but make sure you rename every instance. including where the email is sent
    // to the user
    if(isset($_GET['qid']))
    {
        //then selecting all from the database where the uniquid is similar to the unique id
        //that the user entered in the registration form. labelled :uniqueid
        //this is to prevent guessing
        $query = "SELECT id FROM users WHERE uniqueid = :uniqueid";
        $statement = $connect->prepare($query);
        $statement->execute(
             array(
                 ':uniqueid'	=>	$_GET['qid']
            )
        );
        $no_of_row = $statement->rowCount();
        
        if($no_of_row == 1)
        {   //if new password is selected
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                //get the email of the user
                $getmail = "SELECT email,username from users WHERE id = '".$row['id']."'";
                $resultmail= $connect->prepare($getmail);
                $resultmail->execute();

                    $mresult = $resultmail->fetchAll();
                    foreach ($mresult as $column) {
                        $em=trim($column['email']) ;
                        $na=trim($column['username']);
                
                        if (isset($_POST['submit'])) { 
                            extract($_POST);
                            //$usernamequery=   
                         
                                //this method resets the password
                                $user->resetpassword($newpassword,$na);
                                $subject='password reset';
                                $mailbody="
                                <p>Hi ".$na.",</p>
                                <p>Your password has been reset successfully</p>
                                <p>Open this link to login - http://localhost/phpprojects/final/login.php</p>
                                <p>Best Regards,<br />Your Webmaster hahaha</p>
                                ";
                                $nab='';
                                $mailer ->sendemail($subject,$em,$mailbody,$nab);
                                if($mailer){
                                    echo '<script type="text/javascript">alert("Password reset successfully")</script>';
                                    header("location:login.php");
                                    return true;
    
                                }
                                else{
                                    echo 'message could not be sent';
                                }
                            
                        }                  
                    }

                }
                
 
        }
            else{
                echo 'invalid link ';
                return false;
                
            }
    }
    else{
        echo 'that link is broken';
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>reset password</title>
		<link rel="stylesheet" type="text/css" href="test.css" />
    </head>
	<body style="background-image: url('images/estate.png');background-size: cover;">
        <div class="theform">
            <div class="header"> </div>
            <h1>Reset Password</h1>
        <div class="theform2">         
                 <form action="" method="post" name="login">
                        <span class="input input--keonss">
                            <input name="newpassword" class="input__field input__field--keonss" required type="password" id="input-3" />
                            <label class="input__label input__label--keonss" for="input-15">
                                <span class="input__label-content input__label-content--keonss" data-content="New Password">New Password</span>
                            </label>
                        </span>
                        <br>
                        <span class="input input--keonss">
                            <input name="confirmpassword" class="input__field input__field--keonss" required type="password" id="input-13" />
                            <label class="input__label input__label--keonss" for="input-13">
                                <span class="input__label-content input__label-content--keonss" data-content="Confirm Password">Confirm Password</span>
                            </label>
                        </span>
                        <br>
                        <div class="formgroup">
                            <input type="submit" name="submit" class="button" value="Confirm" onclick="submitpassword()">
                         </div>
                         
            </form>
            <div class="nav">
                <strong><a href="login.php"> Login Here</a></strong>
            </div>
        </div>
            
        </div>
    </body>
    <script src="main.js"></script>
    <script>
        (function() {
            // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
            if (!String.prototype.trim) {
                (function() {
                    // Make sure we trim BOM and NBSP
                    var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                    String.prototype.trim = function() {
                        return this.replace(rtrim, '');
                    };
                })();
            }
            [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
                // in case the input is already filled..
                if( inputEl.value.trim() !== '' ) {
                    classie.add( inputEl.parentNode, 'input--filled' );
                }
                // events:
                inputEl.addEventListener( 'focus', onInputFocus );
                inputEl.addEventListener( 'blur', onInputBlur );
            } );
            function onInputFocus( ev ) {
                classie.add( ev.target.parentNode, 'input--filled' );
            }
            function onInputBlur( ev ) {
                if( ev.target.value.trim() === '' ) {
                    classie.remove( ev.target.parentNode, 'input--filled' );
                }
            }
        })();
    </script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script> 
</html>