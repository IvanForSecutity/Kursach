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
        <link rel="stylesheet" href="style/page_style.css">
        <script type="text/javascript" src="js/sha512.js"></script>
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/js_login.js"></script>
        <title>Authorisation</title>
    </head>
    <body>
        <div style="align-content: center; text-align: center; margin-top: 10em">
            <em>Authorisation</em><br><br>
            <form action="" method="POST" id="frmLogin">
                <input type="text" name="txtLogin" id="txtLogin" placeholder="login" style="margin-top: 0.2em"><br>
                <div class="error" id="divLoginError"> </div>
                <input type="password" id="txtPassword" placeholder="password" style="margin-top: 0.2em"><br>
                <div class="error" id="divPasswordError"> </div>
                <input type="checkbox" name="cbxRemember" id="cbxRemember" value='1'> Witness me!!!<br>
                <input type="button" name="btnLogIn" id="btnLogIn" value="Log In" style="margin-top: 0.2em" onclick="LogIn()"><br>
                <input type="submit" name="btnReg" id="btnReg" value="Registration" style="margin-top: 0.2em"><br>
            </form>
        </div>
        <!-- Block for displaying messages -->
        <div style="align-content: center; text-align: center;">
            <div id="divLoginResult"> </div>
        </div>
    </body>
</html>
