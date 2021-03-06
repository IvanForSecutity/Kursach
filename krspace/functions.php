<?php

// TODO: Спрятать данные страницы от всех, кроме рута!

// Generating random hash
function randHash($len=32)
{
    return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
}

// Connect the file with the connection parameters to the DB
require_once('database.php');

// Check user login
function checkLogin($str)
{
    // Initialize a variable with a possible error message
    $error = '';

    // If login string is empty, return an error message
    if(!$str)
    {
        $error = 'You did not enter a login';
        return $error;
    }

    // The login must be at least 4, not longer than 16 characters
    $pattern = '/^[-_.a-z\d]{4,16}$/i';	
    $result = preg_match($pattern, $str);

    // If the check fails, return an error message
    if(!$result)
    {
        $error = 'Invalid characters in login or login is too short (long)';
        return $error;
    }

    // If all is OK - return true
    return true;
}

// Check user password
function checkPassword($str)
{
    // Initialize a variable with a possible error message
    $error = '';

    // If password string is empty, return an error message
    if(!$str)
    {
        $error = 'You did not enter a password';
        return $error;
    }

    // The password must be at least 6, not longer than 16 characters
    $pattern = '/^[_!)(.a-z\d]{6,16}$/i';	
    $result = preg_match($pattern, $str);

    // If the check fails, return an error message
    if(!$result)
    {
        $error = 'Invalid characters in password or password is too short (long)';
        return $error;
    }

    // If all is OK - return true
    return true;
}

// User registration function
function registration($login, $password)
{
    // Initialize a variable with a possible error message
    $error = '';

    // If strings are empty, return an error message
    if(!$login)
    {
        $error = 'You did not enter a login';
        return $error;
    } 
    elseif(!$password)
    {
        $error = 'You did not enter a password';
        return $error;
    }

    // Check if the user is already registered
    // Connect to DB
    connect();

    $sql = "SELECT `id` FROM `users` WHERE `login`='" . $login . "'";
    // Execute query
    $query = mysql_query($sql);
    // We look at the number of users with this login, if there is at least one - return an error message
    if(mysql_num_rows($query) > 0)
    {
        $error = 'User with the specified login is already registered';
        return $error;
    }

    // If there is no such user - register it
    $sql = "INSERT INTO `users` 
            (`id`,`login`,`password`) VALUES 
            (NULL, '" . $login . "','" . $password . "')";
    // Execute query
    $query = mysql_query($sql);

    mysql_close();

    // Return the value true, indicating successful user registration
    return true;
}

// User authorization function
function authorization($login, $password)
{
    // Initialize a variable with a possible error message
    $error = '';

    // If strings are empty, return an error message
    if(!$login)
    {
        $error = 'You did not enter a login';
        return $error;
    } 
    elseif(!$password)
    {
        $error = 'You did not enter a password';
        return $error;
    }

    // Check if the user is already registered
    // Connect to DB
    connect();

    // We need to check whether there is such a user among registered
    $sql = "SELECT `id` FROM `users` WHERE `login`='".$login."' AND `password`='".$password."'";
    // Execute query
    $query = mysql_query($sql);

    // If there is no user with such data, return an error message
    if(mysql_num_rows($query) == 0)
    {
        $error = 'User with the specified data is not registered';
        return $error;
    }

    // TODO: куки! А не только сессии..
 
    // Start new session
    session_start();
    $session_hash = randHash(32);
    $sql = "UPDATE users SET session_hash='". $session_hash ."' WHERE `login`='".$login."'";
    mysql_query($sql);
    $_SESSION['login'] = $login;
    $_SESSION['session_hash'] = $session_hash;

    mysql_close();

    // Return the value true, indicating successful user authorization
    return true;
}

function checkSession($login, $session_hash)
{
    // If strings are empty - return false
    if(!$login || !$session_hash)
    {
        return false;
    }
	
    // Check if the user is authorized
    // Connect to DB
    connect();
	
    $sql = "SELECT `id` FROM `users` WHERE `login`='".$login."' AND `session_hash`='".$session_hash."'";
    // Execute query
    $query = mysql_query($sql);

    // If there is no user with such data, return false
    if(mysql_num_rows($query) == 0)
    {
        return false;
    }

    mysql_close();	

    // If all is OK - return true
    return true;
}
?>
