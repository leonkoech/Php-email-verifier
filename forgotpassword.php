<?php 
session_start();
require_once 'userclass.php';
$user = new User();
if (isset($_POST['submit'])) { 
		extract($_POST);   
	    $sendresetlink=$user->resetpasswordlink($emailusername);
        if($sendresetlink){
            echo 'reset link sent';
        }
        else{
            echo 'reset link cannot be sent';
        }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Forgot password</title>
		<link rel="stylesheet" type="text/css" href="test.css" />
    </head>
	<body style="background-image: url('images/estate.png');background-size: cover;">
        <div class="theform">
            <div class="header"> </div>
            <h1>Reset Password</h1>
        <div class="theform2">         
                 <form action="" method="post" name="forgotpassword">
                        <span class="input input--keonss">
                            <input name="emailusername" class="input__field input__field--keonss" required type="text" id="input-3" />
                            <label class="input__label input__label--keonss" for="input-15">
                                <span class="input__label-content input__label-content--keonss" data-content="Username or email">Username or email</span>
                            </label>
                        </span>
                        <br><p></p>
                        <div class="formgroup">
                            <input type="submit" name="submit" class="button" value="Send Reset Email" onclick="submitlogin()">
                         </div>
                         
            </form>
            <div class="nav">
                <strong>Don't have an account?<a href="index.php"> Sign Up</a></strong>
                <p></P>
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
