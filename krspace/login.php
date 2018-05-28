<?php

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');
require_once('php_functions/functions.php');

if(isset($_POST['btnReg']))
{
    header("Location: registration.php");
}
?>

<html>
    <head>
        <link rel="stylesheet" href="style/login_style.css">
        <script type="text/javascript" src="js/sha512.js"></script>
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/js_login.js"></script>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <title>Authorisation</title>
    </head>
    <body class="login_body">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="pr-wrap">
            <div class="pass-reset">
              <label>
                            Enter the email you signed up with</label>
              <input type="email" placeholder="Email" />
              <input type="submit" value="Submit" class="pass-reset-submit btn btn-success btn-sm" />
            </div>
          </div>
          <div class="wrap">
            <p class="form-title">
              Sign In</p>
            <form class="login" action="" method="POST" id="frmLogin">
              <input type="text" name="txtLogin" id="txtLogin" placeholder="login" />
              <div class="error" id="divLoginError"> </div>
              <input type="password" id="txtPassword" placeholder="password" />
              <div class="error" id="divPasswordError"> </div>
              <input type="button" name="btnLogIn" id="btnLogIn" value="Log In" onclick="LogIn();" class="login_button" />
              <input type="button" name="btnReg" id="btnReg" value="Registration" onclick="window.location.href='registration.php'" class="login_button" />

              <div class="remember-forgot">
                <div class="row">
                  <div class="col-md-6">
                    <div class="checkbox" style="margin-left:7px">
                      <label>
                            <input type="checkbox" id="cbxRemember"  value='1'/>
                            Remember Me
                        </label>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div><!--
            <form action="" method="POST" id="frmLogin" >
                <input type="text" name="txtLogin" id="txtLogin" placeholder="login" style="margin-top: 0.2em"><br>
                <div class="error" id="divLoginError"> </div>
                <input type="password" id="txtPassword" placeholder="password" style="margin-top: 0.2em"><br>
                <div class="error" id="divPasswordError"> </div>
                <input type="checkbox" name="cbxRemember" id="cbxRemember" value='1'> Witness me!!!<br>
                <input type="button" name="btnLogIn" id="btnLogIn" value="Log In" style="margin-top: 0.2em" onclick="LogIn()"><br>
                <input type="submit" name="btnReg" id="btnReg" value="Registration" style="margin-top: 0.2em"><br>
            </form>
            -->
        <!-- Block for displaying messages -->
        <div style="align-content: center; text-align: center;">
            <div id="divLoginResult"> </div>
        </div>
    </body>
</html>
