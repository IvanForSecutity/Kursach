<?php

// Ship registration function.
function registerNewShip($ship_name, $owner, $hull, $engine, $fuel_tank, $secondary_engine, $radar, $repair_droid, $magnetic_grip, $weapon_1, $weapon_2, $weapon_3, $weapon_4, $weapon_5)
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
            (ship_name, owner, hull, engine, fuel_tank, secondary_engine, radar, repair_droid, magnetic_grip, weapon_1, weapon_2, weapon_3, weapon_4, weapon_5) VALUES
            ('". $ship_name ."', '". $owner ."', '". $hull ."', '". $engine ."', '". $fuel_tank ."', '". $secondary_engine ."', '". $radar ."', '". $repair_droid ."', '". $magnetic_grip ."', '". $weapon_1 ."', '". $weapon_2 ."', '". $weapon_3 ."', '". $weapon_4 ."', '". $weapon_5 ."');";

    // Execute query
    mysqli_query($link, $sql);

    mysqli_close($link);
    
    // Return the value true, indicating successful ship registration
    return true;
}

// Delete ship.
function deleteShip($ship_name)
{
    // Initialize a variable with a possible error message
    $error = '';
    
    // Connect to DB
    $link = connect();
    
    $sql = "SELECT `id` FROM `ships` WHERE `ship_name`='" . $ship_name . "'";
    // Execute query
    $query = mysqli_query($link, $sql);
    // If there is no such ship - return an error message
    if(mysqli_num_rows($query) == 0)
    {
        $error = 'No such ship';
        return $error;
    }
    
    // If there is such ship - delete it
    $sql = "DELETE FROM `ships` WHERE `ship_name`='" . $ship_name . "'";
    // Execute query
    mysqli_query($link, $sql);

    mysqli_close($link);
    
    // Return the value true, indicating successful ship deletion
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

// Load all hulls.
function loadHulls()
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT * FROM `hulls`";
    $result = mysqli_query($link, $sql);
    $hulls = array();
    while ($cur_hull = mysqli_fetch_assoc($result))
    {
        $hulls[] = $cur_hull;
    }

    mysqli_close($link);
    
    return $hulls;
}

// Load all engines.
function loadEngines()
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT * FROM `engines`";
    $result = mysqli_query($link, $sql);
    $engines = array();
    while ($cur_engine = mysqli_fetch_assoc($result))
    {
        $engines[] = $cur_engine;
    }

    mysqli_close($link);
    
    return $engines;
}

// Load all fuel tanks.
function loadFuelTanks()
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT * FROM `fuel_tanks`";
    $result = mysqli_query($link, $sql);
    $fuel_tanks = array();
    while ($cur_fuel_tank = mysqli_fetch_assoc($result))
    {
        $fuel_tanks[] = $cur_fuel_tank;
    }

    mysqli_close($link);
    
    return $fuel_tanks;
}

// Load all secondary engines.
function loadSecondaryEngines()
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT * FROM `secondary_engines`";
    $result = mysqli_query($link, $sql);
    $secondary_engines = array();
    while ($cur_secondary_engine = mysqli_fetch_assoc($result))
    {
        $secondary_engines[] = $cur_secondary_engine;
    }

    mysqli_close($link);
    
    return $secondary_engines;
}

// Load all radars.
function loadRadars()
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT * FROM `radars`";
    $result = mysqli_query($link, $sql);
    $radars = array();
    while ($cur_radar = mysqli_fetch_assoc($result))
    {
        $radars[] = $cur_radar;
    }

    mysqli_close($link);
    
    return $radars;
}

// Load all repair droids.
function loadRepairDroids()
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT * FROM `repair_droids`";
    $result = mysqli_query($link, $sql);
    $repair_droids = array();
    while ($cur_repair_droid = mysqli_fetch_assoc($result))
    {
        $repair_droids[] = $cur_repair_droid;
    }

    mysqli_close($link);
    
    return $repair_droids;
}

// Load all magnetic grips.
function loadMagneticGrips()
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT * FROM `magnetic_grips`";
    $result = mysqli_query($link, $sql);
    $magnetic_grips = array();
    while ($cur_magnetic_grip = mysqli_fetch_assoc($result))
    {
        $magnetic_grips[] = $cur_magnetic_grip;
    }

    mysqli_close($link);
    
    return $magnetic_grips;
}

// Load all weapons.
function loadWeapons()
{
    // Connect to DB
    $link = connect();
    $sql = "SELECT * FROM `weapons`";
    $result = mysqli_query($link, $sql);
    $weapons = array();
    while ($cur_weapon = mysqli_fetch_assoc($result))
    {
        $weapons[] = $cur_weapon;
    }

    mysqli_close($link);
    
    return $weapons;
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

// Get ship fuel tank.
function loadShipFuelTank($fuel_tank_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `fuel_tanks` WHERE `name`='".$fuel_tank_name."'";
    $result = mysqli_query($link, $sql);
    $fuel_tank = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $fuel_tank;
}

// Get ship secondary engine.
function loadShipSecondaryEngine($secondary_engine_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `secondary_engines` WHERE `name`='".$secondary_engine_name."'";
    $result = mysqli_query($link, $sql);
    $secondary_engine = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $secondary_engine;
}

// Get ship radar.
function loadShipRadar($radar_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `radars` WHERE `name`='".$radar_name."'";
    $result = mysqli_query($link, $sql);
    $radar = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $radar;
}

// Get ship repair droid.
function loadShipRepairDroid($repair_droid_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `repair_droids` WHERE `name`='".$repair_droid_name."'";
    $result = mysqli_query($link, $sql);
    $repair_droid = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $repair_droid;
}

// Get ship magnetic grip.
function loadShipMagneticGrip($magnetic_grip_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `magnetic_grips` WHERE `name`='".$magnetic_grip_name."'";
    $result = mysqli_query($link, $sql);
    $magnetic_grip = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $magnetic_grip;
}

// Get ship weapon.
function loadShipWeapon($weapon_name)
{
    // Connect to DB
    $link = connect();

    // Hull
    $sql = "SELECT * FROM `weapons` WHERE `name`='".$weapon_name."'";
    $result = mysqli_query($link, $sql);
    $weapon = mysqli_fetch_assoc($result);

    mysqli_close($link);
    
    return $weapon;
}

function searchHulls($hull_search_string, $hull_search_hp_from, $hull_search_hp_to, $hull_search_maneuverability_from, $hull_search_maneuverability_to, $hull_search_capacity_from, $hull_search_capacity_to, $hull_search_cost_from, $hull_search_cost_to)
{
    // Connect to DB
    $link = connect();

    $sql = "SELECT * FROM `hulls` WHERE "
            . "name LIKE '%$hull_search_string%' ";
    if ($hull_search_hp_from !== NULL)
    {
        $sql = $sql."and hp >= $hull_search_hp_from ";
    }
    if ($hull_search_hp_to !== NULL)
    {
        $sql = $sql."and hp <= $hull_search_hp_to ";
    }
    if ($hull_search_maneuverability_from !== NULL)
    {
        $sql = $sql."and maneuverability >= $hull_search_maneuverability_from ";
    }
    if ($hull_search_maneuverability_to !== NULL)
    {
        $sql = $sql."and maneuverability <= $hull_search_maneuverability_to ";
    }
    if ($hull_search_capacity_from !== NULL)
    {
        $sql = $sql."and capacity >= $hull_search_capacity_from ";
    }
    if ($hull_search_capacity_to !== NULL)
    {
        $sql = $sql."and capacity <= $hull_search_capacity_to ";
    }
    if ($hull_search_cost_from !== NULL)
    {
        $sql = $sql."and cost >= $hull_search_cost_from ";
    }
    if ($hull_search_cost_to !== NULL)
    {
        $sql = $sql."and cost <= $hull_search_cost_to ";
    }

    $result = mysqli_query($link, $sql);
    $hulls = array();
    while ($cur_hull = mysqli_fetch_assoc($result))
    {
        $hulls[] = $cur_hull;
    }

    mysqli_close($link);
    
    return $hulls;
}
?>
