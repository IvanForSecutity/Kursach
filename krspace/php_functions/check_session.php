<?php
//
// Authorization verification script.
//

// TODO: Спрятать данные страницы от всех, кроме рута!

// Start the session, from which we will retrieve login and session hash of authorized users
session_start();

require_once('php_functions/functions.php');

// To determine whether the user is authorized,
// we need to check whether there are records in the database for his login and session hash.
// To do this, we use a user-defined function
// to verify the correctness of the data of the authorized user.
// If this function returns false, then there is no authorization.

// If where is no session data - we should check cookie.
// If cookies are correct - start new session.

// In the absence of authorization, we simply redirect the user to the authorization page.

// If the session contains data about both the login and the session hash, we check them
if(isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['session_hash']) && $_SESSION['session_hash'])
{
    // If validation of existing data fails
    if(!checkSession($_SESSION['login'], $_SESSION['session_hash']))
    {
        // Redirect user to the authorization page
        header('location: login.php');
        exit;
    }
}
else
{
    // Check cookie
    if (!empty($_COOKIE['login']) and !empty($_COOKIE['cookie_key']))
    {
        $login = $_COOKIE['login'];
        // If cookies are correct
        if(checkCookie($login, $_COOKIE['cookie_key']))
        {
            // Start new session
            $session_hash = randHash(32);
            // Connect to DB
            $link = connect();
            $sql = "UPDATE users SET session_hash='". $session_hash ."' WHERE `login`='".$login."'";
            mysqli_query($link, $sql);
            $_SESSION['login'] = $login;
            $_SESSION['session_hash'] = $session_hash;
            mysqli_close($link);
        }
        else
        {
            // Redirect user to the authorization page
            header('location: login.php');
            exit;
        }
    }
    else
    {
        // Redirect user to the authorization page
        header('location: login.php');
        exit;
    }
}
?>