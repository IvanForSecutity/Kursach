<?php

// TODO: Спрятать данные страницы от всех, кроме рута!

// Ship registration function.
function registerNewShip($ship_name, $owner, $hull, $hull_2, $hull_3)
{
    // Initialize a variable with a possible error message
    $error = '';
    
    // Connect to DB
    connect();
    
    $sql = "SELECT `id` FROM `ships` WHERE `ship_name`='" . $ship_name . "'";
    // Execute query
    $query = mysql_query($sql);
    // We look at the number of ships with this name, if there is at least one - return an error message
    if(mysql_num_rows($query) > 0)
    {
        $error = 'Ship with the specified name is already registered';
        return $error;
    }
    
    // If there is no such ship - register it
    $sql = "INSERT INTO ships
            (ship_name, owner, hull, hull_2, hull_3) VALUES
            ('". $ship_name ."', '". $owner ."', '". $hull ."', '". $hull_2 ."', '". $hull_3 ."');";

    // Execute query
    mysql_query($sql);

    mysql_close();
    
    // Return the value true, indicating successful ship registration
    return true;
}

// Load user ships.
function loadUserShips($login)
{
    // Connect to DB
    connect();
    $sql = "SELECT `ship_name` FROM `ships` WHERE `owner`='".$login."'";
    $result = mysql_query($sql);
    $ships = array();
    while ($cur_ship = mysql_fetch_assoc($result))
    {
        $ships[] = $cur_ship;
    }

    mysql_close();
    
    return $ships;
}

// Get our ship.
function loadCurrentShip($ship_name)
{
    // Connect to DB
    connect();

    // Hull
    $sql = "SELECT hull, hull_2, hull_3 FROM `ships` WHERE `ship_name`='".$ship_name."'";
    $result = mysql_query($sql);
    $hull = mysql_fetch_assoc($result);

    mysql_close();
    
    return $hull;
}
?>
