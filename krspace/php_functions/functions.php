<?php

// Generating random hash
function randHash($len=32)
{
    return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
}

// Generate random salt
function generateSalt()
{
    $salt = '';
    $salt_length = 8;
    for($i = 0; $i < $salt_length; $i++)
    {
        $salt .= chr(mt_rand(33, 126)); // ASCII-symbol
    }
    return $salt;
}

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
    $link = connect();

    $sql = "SELECT `id` FROM `users` WHERE `login`='" . $login . "'";
    // Execute query
    $query = mysqli_query($link, $sql);
    // We look at the number of users with this login, if there is at least one - return an error message
    if(mysqli_num_rows($query) > 0)
    {
        $error = 'User with the specified login is already registered';
        return $error;
    }

    // If there is no such user - register it

    // Generate salt
    $salt = generateSalt();
    $salted_password = password_hash($password.$salt, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `users`
            (`id`,`login`,`password`,`salt`) VALUES
            (NULL, '" . $login . "','" . $salted_password . "','" . $salt . "')";
    // Execute query
    $query = mysqli_query($link, $sql);

    mysqli_close($link);

    // Return the value true, indicating successful user registration
    return true;
}

// User authorization function
function authorization($login, $password, $remember)
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
    $link = connect();

    // We need to check whether there is such a user among registered
    $sql = "SELECT * FROM `users` WHERE login='".$login."'";
    // Execute query
    $result = mysqli_query($link, $sql);

    // If there is no user with such data, return an error message
    if(mysqli_num_rows($result) == 0)
    {
        $error = "User with the specified data is not registered";
        return $error;
    }

    // Check password
    $user = mysqli_fetch_assoc($result);
    $salt = $user['salt'];

    if (password_verify($password.$salt, $user['password']))
    {
        // Start new session
        // TODO: Время жизни сессии ограничить!
        session_start();
        $session_hash = randHash(32);
        $session_user_agent = hash('sha512', $_SERVER['HTTP_USER_AGENT']);
        $sql = "UPDATE users SET session_hash='". $session_hash ."', session_user_agent='". $session_user_agent ."' WHERE `login`='".$login."'";
        mysqli_query($link, $sql);
        $_SESSION['login'] = $login;
        $_SESSION['session_hash'] = $session_hash;
        // To prevent the ability to use a session from another browser (computer), you need to enter a validation of the HTTP-header field user-agent.
        $_SESSION['HTTP_USER_AGENT'] = $session_user_agent;

        // Check if button "Witness me" was pressed
        if ($remember == 1)
        {
            // Create cookie

            $cookie_key = randHash(32);
            $cookie_user_agent = hash('sha512', $_SERVER['HTTP_USER_AGENT']);
            $sql = "UPDATE users SET cookie='". $cookie_key ."', cookie_user_agent='". $cookie_user_agent ."' WHERE `login`='".$login."'";
            mysqli_query($link, $sql);
            // Life time is now + month
            setcookie('login', $login, time()+60*60*24*30, '/');
            setcookie('cookie_key', $cookie_key, time()+60*60*24*30, '/');
            setcookie('HTTP_USER_AGENT', $cookie_user_agent, time()+60*60*24*30, '/');
        }
    }
    else
    {
        $error = "Incorrect password!";
        return $error;
    }

    mysqli_close($link);

    // Return the value true, indicating successful user authorization
    return true;
}

function checkSession($login, $session_hash, $session_user_agent)
{
    // If strings are empty - return false
    if(!$login || !$session_hash)
    {
        return false;
    }

    // Check if the user is authorized
    // Connect to DB
    $link = connect();

    $sql = "SELECT `id` FROM `users` WHERE `login`='".$login."' AND `session_hash`='".$session_hash."' AND `session_user_agent`='".$session_user_agent."'";
    // Execute query
    $query = mysqli_query($link, $sql);

    // If there is no user with such data, return false
    if(mysqli_num_rows($query) == 0)
    {
        return false;
    }

    mysqli_close($link);

    // If all is OK - return true
    return true;
}

function checkCookie($login, $cookie_key, $cookie_user_agent)
{
    // If strings are empty - return false
    if(!$login || !$cookie_key)
    {
        return false;
    }

    // Check if the cookies are correct
    // Connect to DB
    $link = connect();

    $sql = "SELECT `id` FROM `users` WHERE `login`='".$login."' AND `cookie`='".$cookie_key."' AND `cookie_user_agent`='".$cookie_user_agent."'";
    // Execute query
    $query = mysqli_query($link, $sql);

    // If there is no user with such data, return false
    if(mysqli_num_rows($query) == 0)
    {
        return false;
    }

    mysqli_close($link);

    // If all is OK - return true
    return true;
}

function getUserRegDate($login)
{
    // If string is empty - return false
    if(!$login)
    {
        return false;
    }

    // Connect to DB
    $link = connect();

    $sql = "SELECT `reg_date` FROM `users` WHERE `login`='".$login."'";
    // Execute query
    $result = mysqli_query($link, $sql);
    $reg_date = mysqli_fetch_assoc($result);

    mysqli_close($link);

    return $reg_date;
}

// Delete user account.
function deleteUser($login)
{
    // Initialize a variable with a possible error message
    $error = '';
    
    // Connect to DB
    $link = connect();
    
    $sql = "SELECT `id` FROM `users` WHERE `login`='" . $login . "'";
    // Execute query
    $query = mysqli_query($link, $sql);
    // If there is no such user - return an error message
    if(mysqli_num_rows($query) == 0)
    {
        $error = 'No such user';
        return $error;
    }
    
    // If there is such user - delete it
    $sql = "DELETE FROM `users` WHERE `login`='" . $login . "'";
    // Execute query
    mysqli_query($link, $sql);
    
    // Delete user's ships
    $sql = "DELETE FROM `ships` WHERE `owner`='" . $login . "'";
    // Execute query
    mysqli_query($link, $sql);

    mysqli_close($link);
    
    // Return the value true, indicating successful user deletion
    return true;
}
?>
