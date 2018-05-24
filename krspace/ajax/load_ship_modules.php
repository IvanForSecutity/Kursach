<?php

// Connect the file with the connection parameters to the DB
require_once('../php_functions/database.php');
require_once('../php_functions/ships_database.php');

if (isset($_GET['hull_name']))
{
    $hull = loadShipHull($_GET['hull_name']);
    echo json_encode(array('hp'=>$hull['hp'], 'maneuverability'=>$hull['maneuverability'], 'capacity'=>$hull['capacity'], 'cost'=>$hull['cost'], 'modules_bitmask'=>$hull['modules_bitmask']));
}

if (isset($_GET['engine_name']))
{
    $engine = loadShipEngine($_GET['engine_name']);
    echo json_encode(array('speed'=>$engine['speed'], 'weight'=>$engine['weight'], 'cost'=>$engine['cost']));
}

if (isset($_GET['secondary_engine_name']))
{
    $secondary_engine = loadShipSecondaryEngine($_GET['secondary_engine_name']);
    echo json_encode(array('maneuverability'=>$secondary_engine['maneuverability'], 'weight'=>$secondary_engine['weight'], 'cost'=>$secondary_engine['cost']));
}

if (isset($_GET['fuel_tank_name']))
{
    $fuel_tank = loadShipFuelTank($_GET['fuel_tank_name']);
    echo json_encode(array('volume'=>$fuel_tank['volume'], 'weight'=>$fuel_tank['weight'], 'cost'=>$fuel_tank['cost']));
}

if (isset($_GET['radar_name']))
{
    $radar = loadShipRadar($_GET['radar_name']);
    echo json_encode(array('action_radius'=>$radar['action_radius'], 'weight'=>$radar['weight'], 'cost'=>$radar['cost']));
}

if (isset($_GET['repair_droid_name']))
{
    $repair_droid = loadShipRepairDroid($_GET['repair_droid_name']);
    echo json_encode(array('health_recovery'=>$repair_droid['health_recovery'], 'weight'=>$repair_droid['weight'], 'cost'=>$repair_droid['cost']));
}

if (isset($_GET['weapon_name']))
{
    $weapon = loadShipWeapon($_GET['weapon_name']);
    echo json_encode(array('type'=>$weapon['type'], 'damage'=>$weapon['damage'], 'ammunition'=>$weapon['ammunition'], 'recharge_time'=>$weapon['recharge_time'], 'range_of_fire'=>$weapon['range_of_fire'], 'weight'=>$weapon['weight'], 'cost'=>$weapon['cost']));
}
?>
