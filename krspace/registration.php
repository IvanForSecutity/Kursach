<?php

// TODO: Спрятать данные страницы от всех, кроме рута!

require_once('php_functions/functions.php');

// TODO: Ерроры надо выводить красиво, а не через жопу, как сейчас...
// TODO: И требования к логину/паролю - тоже

if(isset($_POST['btnSignUp']))
{
    // Removes spaces from the beginning and end of the line
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $password_again = trim($_POST['password_again']);

    // If the login fails the check, there will be an error message
    $error_login = checkLogin($login);
    $error_login === true ? '' : print $error_login;

    // If the password fails the check, there will be an error message
    $error_password = checkPassword($password);
    $error_password === true ? '' : print $error_password;

    // If the password is entered correctly, but the passwords are not identical, there will be an error message
    $error_password_again = ($password === $password_again);
    $error_password_again === true ? '' : print 'The passwords you entered do not match';

    // If there are no errors, we need to add information about user to DB
    if($error_login === true && $error_password === true && $error_password_again === true)
    {
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
            print $reg;
        }
    }
}
?>

<html>
<head>
	<title>Registration</title>
	 <link rel="stylesheet" href="style/my_style.css">
</head>
<body>
    <form action="" method="post">
	<div class="row">
            <label for="login">Enter login:</label>
            <input type="text" class="text" name="login" id="login" value="" />
            <div class="error" id="login-error"></div>
            <div class="instruction" id="login-instruction">В имени пользователя могут быть только символы латинского алфавита, цифры, символы '_', '-', '.'. Длина имени пользователя должна быть не короче 4 символов и не длиннее 16 символов</div>
	</div>
	<div class="row">
            <label for="password">Enter password:</label>
            <input type="password" class="text" name="password" id="password" value="" />
            <div class="error" id="password-error"></div>
            <div class="instruction" id="password-instruction">В пароле вы можете использовать только символы латинского алфавита, цифры, символы '_', '!', '(', ')'. Пароль должен быть не короче 6 символов и не длиннее 16 символов</div>
	</div>
	<div class="row">
            <label for="password_again">Confirm password:</label>
            <input type="password" class="text" name="password_again" id="password_again" value="" />
            <div class="error" id="password_again-error"></div>
            <div class="instruction" id="password_again-instruction">Повторите введенный ранее пароль</div>
	</div>
	<div class="row">
            <!-- Sending form data -->
            <input type="submit" name="btnSignUp" id="btn-submit" value="Sign Up" />
			
            <!-- Reset form fields to their original state -->
            <input type="reset" name="btnReset" id="btn-reset" value="Reset" />
	</div>
    </form>
</body>
</html>
