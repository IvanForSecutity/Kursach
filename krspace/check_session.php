<?php
//
// Authorization verification script.
//

// TODO: Спрятать данные страницы от всех, кроме рута!

// Start the session, from which we will retrieve login and session hash of authorized users
session_start();

require_once('functions.php');

// To determine whether the user is authorized,
// we need to check whether there are records in the database for his login and session hash.
// To do this, we use a user-defined function
// to verify the correctness of the data of the authorized user.
// If this function returns false, then there is no authorization.
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
	// Redirect user to the authorization page
        header('location: login.php');
	exit;
}
?>