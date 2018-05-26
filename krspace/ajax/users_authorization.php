<?php

// Connect the file with the connection parameters to the DB
require_once('../php_functions/database.php');
require_once('../php_functions/functions.php');

// Registration
if (isset($_POST['reg']))
{
    $login = $_POST['login'];
    $hashed_password = $_POST['hashed_password'];

    // We need to add information about user to DB

    // Call the registration function
    $reg = registration($login, $hashed_password);

    // If the registration was successful, inform the user
    if($reg === true)
    {
        $message = '<p>You have successfully registered in the system. Now you will be redirected to the authorization page. If this does not happen, go to it <a href="login.php">directly</a>.</p>';
        print $message;
    }
    // Otherwise, we inform the user of an error
    else
    {
        print $reg;
    }
}

// Authentication
if (isset($_POST['auth']))
{
    $login = $_POST['login'];
    $hashed_password = $_POST['hashed_password'];
    $remember = $_POST['remember'];

    // Authorize the user
    $auth = authorization($login, $hashed_password, $remember);
	
    // If the authorization was successful, inform the user
    if($auth === true)
    {
        $message = '<p>You have been successfully authorized in the system. Now you will be redirected to the next page. If this does not happen, go to it <a href="hangar.php">directly</a>.</p>';
        print $message;
    }
    // Otherwise, we inform the user of an error
    else
    {
        print $auth;
    }
}
?>
