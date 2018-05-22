<?php

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');
require_once('php_functions/functions.php');

// TODO: Личный кабинет (смена пароля, аватарка и прочее)

// Initialize variables for possible errors
$errors = array();
$errors['full_error'] = '';

if(isset($_POST['btnLogIn']))
{
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $remember = !empty($_POST['cbxRemember']) ? 1 : 0;

    // Authorize the user
    $auth = authorization($login, $password, $remember);
	
    // If the authorization was successful, inform the user
    if($auth === true)
    {
        $message = '<p>You have been successfully authorized in the system. Now you will be redirected to the next page. If this does not happen, go to it <a href="hangar.php">directly</a>.</p>';
        print $message;
        header('Refresh: 5; URL = hangar.php');
    }
    // Otherwise, we inform the user of an error
    else
    {
        $errors['full_error'] = $auth;
    }
}
if(isset($_POST['btnReg']))
{
    header("Location: registration.php");
}
?>

<html>
    <head>
        <link rel="stylesheet" href="style/my_style.css">
        <title>Authorisation</title>
    </head>
    <body>
        <div style="align-content: center; text-align: center; margin-top: 10em">
            <em>Authorisation</em><br><br>
            <form action="" method="post" >
                <input type="text" name="login" placeholder="login" style="margin-top: 0.2em"><br>
                <input type="password" name="password" placeholder="password" style="margin-top: 0.2em"><br>
                <input type="checkbox" name="cbxRemember" value='1'> WITNESS ME!!!<br>
                <input type="submit" name="btnLogIn" value="Log In" style="margin-top: 0.2em" ><br>
                <input type="submit" name="btnReg" value="Registration" style="margin-top: 0.2em"><br>
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
