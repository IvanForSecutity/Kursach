<?php

require_once('php_functions/database.php');
require_once('php_functions/functions.php');
?>

<html>
    <head>
        <title>Registration</title>
        <link rel="stylesheet" href="style/login_style.css">
        <script type="text/javascript" src="js/sha512.js"></script>
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/js_registration.js"></script>
    </head>
    <body>
        <div style="text-align: left; padding-left: 50px; padding-top: 10px;">
            <button id="login_button" class="login_button_up" onclick="window.location.href='login.php'" ><span>Back to Log In</span></button>

        </div>

        <div style="align-content: center; text-align: center; margin-top: 2em">
          <p class="form-title">
            registration</p>
            <form class="login"  action="" method="POST" id="frmRegistration">
                <div class="row">
                    <label for="login" style="font-size: 1.1vw;">Enter login:</label>
                    <input type="text" name="txtLogin" id="txtLogin" value="" />
                    <div class="error" id="divLoginError"> </div>
                    <div class="instruction" id="login-instruction" style="font-size: 0.7vw;">The username can only contain Latin characters, numbers, symbols '_', '-', '.'. The length of the username must be at least 4 characters and not longer than 16 characters</div>
                </div>
                <div class="row">
                    <label for="password" style="font-size: 1.1vw;">Enter password:</label>
                    <input type="password"  name="txtPassword" id="txtPassword" value="" />
                    <div class="error" id="divPasswordError"> </div>
                    <div class="instruction" id="password-instruction" style="font-size: 0.7vw;">In the password you can use only Latin characters, numbers, symbols '_', '!', '(', ')'. The password must be at least 6 characters long and not longer than 16 characters</div>
                </div>
                <div class="row">
                    <label for="password_again" style="font-size: 1.1vw;">Confirm password:</label>
                    <input type="password" class="text" name="txtPasswordAgain" id="txtPasswordAgain" value="" />
                    <div class="error" id="divPasswordAgainError"> </div>
                    <div class="instruction" id="password_again-instruction" style="font-size: 0.7vw;">Repeat the password you entered previously</div>
                </div>
                <div class="row" style="width:20vw">
                    <!-- Sending form data -->
                    <input type="submit" class="login_button" name="btnSignUp" id="btnSignUp" value="Sign Up" style="width:100%;font-size:1.2vw;"/>

                    <!-- Reset form fields to their original state -->
                    <input type="reset" class="login_button" name="btnReset" id="btnReset" value="Reset" style="width:100%;font-size:1.2vw;"/>
                </div>
            </form>
        </div>
        <!-- Block for displaying messages -->
        <div style="align-content: center; text-align: center;">
            <div id="divRegResult" class="error"> </div>
        </div>
    </body>
</html>
