<?php

// TODO: Спрятать данные страницы от всех, кроме рута!

// Ship registration function.
function registerNewShip($ship_name, $owner, $hull, $engine)
{
    // Initialize a variable with a possible error message
    $error = '';
    
    // Connect to DB
    $link = connect();
    
    $sql = "SELECT `id` FROM `ships` WHERE `ship_name`='" . $ship_name . "'";
    // Execute query
    $query = mysqli_query($link, $sql);
    // We look at the number of ships with this name, if there is at least one - return an error message
    if(mysqli_num_rows($query) > 0)
    {
        $error = 'Ship with the specified name is already registered';
        return $error;
    }
    
    // If there is no such ship - register it
    $sql = "INSERT INTO ships
            (ship_name, owner, hull, engine) VALUES
            ('". $ship_name ."', '". $owner ."', '". $hull ."', '". $engine ."');";

    // Execute query
    mysqli_query($link, $sql);

    mysqli_close($link);
    
    // Return the value true, indicating successful ship registration
    return true;
}

// Load user ships.
function loadUserShips($login)
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT `ship_name` FROM `ships` WHERE `owner`='".$login."'";
    $result = mysqli_query($link, $sql);
    $ships = array();
    while ($cur_ship = mysqli_fetch_assoc($result))
    {
        $ships[] = $cur_ship;
    }

    mysqli_close($link);
    
    return $ships;
}

// Get our ship.
function loadCurrentShip($ship_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `ships` WHERE `ship_name`='".$ship_name."'";
    $result = mysqli_query($link, $sql);
    $ship = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $ship;
}

// Get ship hull.
function loadShipHull($hull_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `hulls` WHERE `name`='".$hull_name."'";
    $result = mysqli_query($link, $sql);
    $hull = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $hull;
}

// Get ship engine.
function loadShipEngine($engine_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `engines` WHERE `name`='".$engine_name."'";
    $result = mysqli_query($link, $sql);
    $engine = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $engine;
}
?>
