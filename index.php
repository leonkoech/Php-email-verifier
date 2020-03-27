<?php 
require_once 'userclass.php';
$user = new User();
// Checking for user logged in or not
    /*if (!$user->get_session())
    {
       header("location:index.php");
    }*/
if (isset($_POST['submit'])){
        extract($_POST);
        $register = $user->reg_user($firstname,$lastname, $username, $userpassword, $email);
        if ($register) {
            // Registration Success
            echo '<script type="text/javascript">alert("Registration successful open your email to verify")</script>';

            // $alert=new phpAlert();
			// $alert->phpAlert('Registration successful open your email to verify');
         // echo "<div style='text-align:center'></div>";
            // echo '<script  type="text/javascript">',
            // 'alert(registration sucessful. check your \n email for link);',
            // '</script>';
            //created by Leonkoech
        } else {
            // Registration Failed
            echo '<script type="text/javascript">alert("Registration failed. Email or Username already exits please try again.")</script>';

            // $alert=new phpAlert();
			// $alert->phpAlert('');
            ///echo "<div style='text-align:center'></div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>sign up</title>
		<link rel="stylesheet" type="text/css" href="test.css" />
	</head>
	<body  style="background-image: url('images/estate.png');background-size: cover;">
        <div class="theform">
            <div class="header"> </div>
            <h1>Create an account</h1>
        <div class="theform2">         
                 <form action="" method="post" name="reg">
                        <span class="input input--keonss">
                            <input name="firstname" class="input__field input__field--keonss" required type="text" id="input-1" />
                            <label class="input__label input__label--keonss" for="input-13">
                                <span class="input__label-content input__label-content--keonss" data-content="First Name">First Name</span>
                            </label>
                        </span>
                        <br>
                        <span class="input input--keonss">
                            <input name="lastname" class="input__field input__field--keonss" required type="text" id="input-2" />
                            <label class="input__label input__label--keonss" for="input-14">
                                <span class="input__label-content input__label-content--keonss" data-content="Last name">Last Name</span>
                            </label>
                        </span>
                        <br>
                        <span class="input input--keonss">
                            <input name="username" class="input__field input__field--keonss" required type="text" id="input-3" />
                            <label class="input__label input__label--keonss" for="input-15">
                                <span class="input__label-content input__label-content--keonss" data-content="Username">Username</span>
                            </label>
                        </span>
                        <br>
                        <span class="input input--keonss">
                            <input name="userpassword" class="input__field input__field--keonss" required type="password" id="input-13" />
                            <label class="input__label input__label--keonss" for="input-13">
                                <span class="input__label-content input__label-content--keonss" data-content="Password">Password</span>
                            </label>
                        </span>
                        <br>
                        <span class="input input--keonss">
                            <input name="confirm_password" class="input__field input__field--keonss" required type="password" id="input-14" />
                            <label class="input__label input__label--keonss" for="input-14">
                                <span class="input__label-content input__label-content--keonss" data-content="Confirm Password">Confirm Password</span>
                            </label>
                        </span>
                       <br>
                        <span class="input input--keonss">
                            <input name="email" class="input__field input__field--keonss" type="text" required id="input-15" />
                            <label class="input__label input__label--keonss" for="input-15">
                                <span class="input__label-content input__label-content--keonss" data-content="Email">Email</span>
                            </label>
                        </span>
                        <br>
                        <div class="formgroup">
                            <input type="submit" name="submit" class="button" value="Sign up" >
                         </div>
                         
            </form>
            <div class="nav">
                <strong>Already Have an Account?<a href="login.php"> Login Here</a></strong>
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