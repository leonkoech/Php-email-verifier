<?php 
session_start();
require_once 'userclass.php';
$user = new User();
if (isset($_POST['submit'])) { 
		extract($_POST);   
	    $login = $user->check_loginadmin($admin, $adminpassword);
	    if ($login) {
            header("location:stats.php");   
	    } else {
	        // Registration Failed
	        echo 'Wrong username or password';
	    }
}
?>
<html>
    <title>
    </title>
        <link rel="stylesheet" href="style.css">
        <script src="main.js"></script>
<head>
</head>
    <body>

    <div class="theform">
        <div class="header"> <h1>Admin login</h1></div>
             <form action="" method="post" name="login">
                <div class="formfield ">
                    <p>username or email</p><input  name="admin" type="text">
                </div>
                <div class="formfield ">
                    <p>password</p><input name="adminpassword" type="password">
                </div>
                <div class="formgroup">
                <input class="button" type="submit" name="submit" value="login" onclick="return(submitadminlogin());">
            </div>
        </form>
    </div>
        
    </body>
</html>
