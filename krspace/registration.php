<?php

// TODO: Не передавать пароли на сервер в открытом виде.

require_once('php_functions/database.php');
require_once('php_functions/functions.php');

// Initialize variables for possible errors
$errors = array();
$errors['full_error'] = '';

if(isset($_POST['btnSignUp']))
{
    // Removes spaces from the beginning and end of the line
    $login = trim($_POST['txtLogin']);
    $password = trim($_POST['txtPassword']);
    $password_again = trim($_POST['txtPasswordAgain']);

    // We need to add information about user to DB

    // Call the registration function
    $reg = registration($login, $password);

    // If the registration was successful, inform the user
    if($reg === true)
    {
        $message = '<p>You have successfully registered in the system. Now you will be redirected to the authorization page. If this does not happen, go to it <a href="login.php">directly</a>.</p>';
        print $message;
        header('Refresh: 5; URL = login.php');
    }
    // Otherwise, we inform the user of an error
    else
    {
        $errors['full_error'] = $reg;
    }
}
?>

<html>
    <head>
        <title>Registration</title>
        <link rel="stylesheet" href="style/page_style.css">
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/js_checks.js"></script>
    </head>
    <body>
        <div style="align-content: center; text-align: center; margin-top: 10em">
            <em>Registration</em><br><br>
            <form action="" method="post" id="frmRegistration">
                <div class="row">
                    <label for="login">Enter login:</label>
                    <input type="text" class="text" name="txtLogin" id="txtLogin" value="" />
                    <div class="error" id="divLoginError"> </div>
                    <div class="instruction" id="login-instruction">В имени пользователя могут быть только символы латинского алфавита, цифры, символы '_', '-', '.'. Длина имени пользователя должна быть не короче 4 символов и не длиннее 16 символов</div>
                </div>
                <div class="row">
                    <label for="password">Enter password:</label>
                    <input type="password" class="text" name="txtPassword" id="txtPassword" value="" />
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
                    <input type="submit" name="btnSignUp" id="btnSignUp" value="Sign Up"/>

                    <!-- Reset form fields to their original state -->
                    <input type="reset" name="btnReset" id="btnReset" value="Reset" />
                </div>
            </form>
        </div>
        <!-- Block for displaying error messages -->
        <div style="align-content: center; text-align: center;">
            <div id="full_error" class="error" style="display: <?php echo $errors['full_error'] ? 'inline-block' : 'none'; ?>;">
                <?php echo $errors['full_error'] ? $errors['full_error'] : ''; ?>
            </div>
        </div>
    </body>
</html>
