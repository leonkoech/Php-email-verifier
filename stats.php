
<?php 
session_start();
    include_once 'userclass.php';
    $user = new User();
    $uid = $_SESSION['id'];
    if (!$user->get_session()){
       header("location:@admin.php");
    }
    if (isset($_GET['q'])){
        $user->user_logout();
        header("location:@admin.php");
    }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Admin page</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  </head>

  <body>
    <div id="container" class="container">
      <div id="header">
        <a href="login.php?q=logout">LOGOUT</a>
      </div>
      <div id="main-body">
        <br/>
        <br/>
        <br/>
        <br/>
        <h1>Hello <?php $user->get_adminusername($uid); ?></h1>
        <div>
          <div>
          <table width="100%">
            <tr>
                <td class="wrapper" width="600" align="center">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="lcolumn" width="300">
                                <table>
                                    <tr>
                                        <td align="center">
                                          <h2>Inactive users</h2>
                                          <?php $user->inactiveusers(); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="rcolumn" width="300">
                                <table>
                                    <tr>
                                        <td align="center">
                                          <h2>active users</h2> 
                                          <?php $user->activeusers(); ?>  
                                      </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
          <div>
        </div>
      </div>
      <div id="footer"></div>
    </div>
  </body>

  </html>