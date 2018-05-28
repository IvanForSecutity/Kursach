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
                    <label for="login">Enter login:</label>
                    <input type="text" name="txtLogin" id="txtLogin" value="" />
                    <div class="error" id="divLoginError"> </div>
                    <div class="instruction" id="login-instruction">В имени пользователя могут быть только символы латинского алфавита, цифры, символы '_', '-', '.'. Длина имени пользователя должна быть не короче 4 символов и не длиннее 16 символов</div>
                </div>
                <div class="row">
                    <label for="password">Enter password:</label>
                    <input type="password"  name="txtPassword" id="txtPassword" value="" />
                    <div class="error" id="divPasswordError"> </div>
                    <div class="instruction" id="password-instruction">В пароле вы можете использовать только символы латинского алфавита, цифры, символы '_', '!', '(', ')'. Пароль должен быть не короче 6 символов и не длиннее 16 символов</div>
                </div>
                <div class="row">
                    <label for="password_again">Confirm password:</label>
                    <input type="password" class="text" name="txtPasswordAgain" id="txtPasswordAgain" value="" />
                    <div class="error" id="divPasswordAgainError"> </div>
                    <div class="instruction" id="password_again-instruction">Повторите введенный ранее пароль</div>
                </div>
                <div class="row">
                    <!-- Sending form data -->
                    <input type="submit" class="login_button" name="btnSignUp" id="btnSignUp" value="Sign Up"/>

                    <!-- Reset form fields to their original state -->
                    <input type="reset" class="login_button" name="btnReset" id="btnReset" value="Reset" />
                </div>
            </form>
        </div>
        <!-- Block for displaying messages -->
        <div style="align-content: center; text-align: center;">
            <div id="divRegResult" class="error"> </div>
        </div>
    </body>
</html>
