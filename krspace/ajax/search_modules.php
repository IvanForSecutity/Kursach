<?php

// Connect the file with the connection parameters to the DB
require_once('../php_functions/database.php');
require_once('../php_functions/ships_database.php');

if (isset($_GET['hull_search_string']))
{
    $hull_search_string = $_GET['hull_search_string'];
    $hull_search_hp_from = NULL;
    $hull_search_hp_to = NULL;
    $hull_search_maneuverability_from = NULL;
    $hull_search_maneuverability_to = NULL;
    $hull_search_capacity_from = NULL;
    $hull_search_capacity_to = NULL;
    $hull_search_cost_from = NULL;
    $hull_search_cost_to = NULL;
    
    if (isset($_GET['hull_search_hp_from']))
    {
        $hull_search_hp_from = $_GET['hull_search_hp_from'];
    }
    if (isset($_GET['hull_search_hp_to']))
    {
        $hull_search_hp_to = $_GET['hull_search_hp_to'];
    }
    if (isset($_GET['hull_search_maneuverability_from']))
    {
        $hull_search_maneuverability_from = $_GET['hull_search_maneuverability_from'];
    }
    if (isset($_GET['hull_search_maneuverability_to']))
    {
        $hull_search_maneuverability_to = $_GET['hull_search_maneuverability_to'];
    }
    if (isset($_GET['hull_search_capacity_from']))
    {
        $hull_search_capacity_from = $_GET['hull_search_capacity_from'];
    }
    if (isset($_GET['hull_search_capacity_to']))
    {
        $hull_search_capacity_to = $_GET['hull_search_capacity_to'];
    }
    if (isset($_GET['hull_search_cost_from']))
    {
        $hull_search_cost_from = $_GET['hull_search_cost_from'];
    }
    if (isset($_GET['hull_search_cost_to']))
    {
        $hull_search_cost_to = $_GET['hull_search_cost_to'];
    }

    $hulls = searchHulls($hull_search_string,
            $hull_search_hp_from, $hull_search_hp_to,
            $hull_search_maneuverability_from, $hull_search_maneuverability_to,
            $hull_search_capacity_from, $hull_search_capacity_to,
            $hull_search_cost_from, $hull_search_cost_to);

    print '<table class="parameters_table" cellspacing="0">';
    print '<thead>';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';
    print '</thead>';

    print '<tbody>';
    foreach ($hulls as $cur_hull):
    print '<tr>';
    print '    <td>';
    print '    <div class="available-container">';
    print '        <div class="available_module_background">';
    print "            <img id='imgShipHull$cur_hull[name]' src='$cur_hull[image]1.png' class='available_module_image' draggable='true' ondragstart='dragHull(event)'>";
    print '        </div>';
    print '    </td>';
    print '    </div>';
    print '    <td>';
    print "        $cur_hull[name]";
    print '    </td>';
    print '    <td class="wide_col">';
    print "        Hp: $cur_hull[hp] <br/>";
    print "        Maneuverability: $cur_hull[maneuverability] <br/>";
    print "        Capacity: $cur_hull[capacity]";
    print '    </td>';
    print '    <td class="last_col">';
    print "        $cur_hull[cost] <br/>";
    print '    </td>';
    print '</tr>';
    endforeach;
    print '</tbody>';
    print '</table>';
}

if (isset($_GET['engine_search_string']))
{
    $search_string = $_GET['engine_search_string'];
    $search_speed_from = NULL;
    $search_speed_to = NULL;
    $search_weight_from = NULL;
    $search_weight_to = NULL;
    $search_cost_from = NULL;
    $search_cost_to = NULL;
    
    if (isset($_GET['engine_search_speed_from']))
    {
        $search_speed_from = $_GET['engine_search_speed_from'];
    }
    if (isset($_GET['engine_search_speed_to']))
    {
        $search_speed_to = $_GET['engine_search_speed_to'];
    }
    if (isset($_GET['engine_search_weight_from']))
    {
        $search_weight_from = $_GET['engine_search_weight_from'];
    }
    if (isset($_GET['engine_search_weight_to']))
    {
        $search_weight_to = $_GET['engine_search_weight_to'];
    }
    if (isset($_GET['engine_search_cost_from']))
    {
        $search_cost_from = $_GET['engine_search_cost_from'];
    }
    if (isset($_GET['engine_search_cost_to']))
    {
        $search_cost_to = $_GET['engine_search_cost_to'];
    }

    $engines = searchEngines($search_string,
            $search_speed_from, $search_speed_to,
            $search_weight_from, $search_weight_to,
            $search_cost_from, $search_cost_to);

    print '<table class="four_columns" cellspacing="0">';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';

    foreach ($engines as $cur_engine):
    print '<tr>';
    print '    <td>';
    print '        <div id="available_module_background">';
    print "            <img id='imgShipEngine$cur_engine[name]' src='$cur_engine[image]1.png' class='available_module_image' draggable='true' ondragstart='dragEngine(event)'>";
    print '        </div>';
    print '    </td>';
    print '    <td>';
    print "        $cur_engine[name]";
    print '    </td>';
    print '    <td class="wide_col">';
    print "        Speed: $cur_engine[speed] <br/>";
    print "        Weight: $cur_engine[weight]";
    print '    </td>';
    print '    <td class="last_col">';
    print "        $cur_engine[cost] <br/>";
    print '    </td>';
    print '</tr>';
    endforeach;
    print '</table>';
}

if (isset($_GET['secondary_engine_search_string']))
{
    $search_string = $_GET['secondary_engine_search_string'];
    $search_maneuverability_from = NULL;
    $search_maneuverability_to = NULL;
    $search_weight_from = NULL;
    $search_weight_to = NULL;
    $search_cost_from = NULL;
    $search_cost_to = NULL;
    
    if (isset($_GET['secondary_engine_search_maneuverability_from']))
    {
        $search_maneuverability_from = $_GET['secondary_engine_search_maneuverability_from'];
    }
    if (isset($_GET['secondary_engine_search_maneuverability_to']))
    {
        $search_maneuverability_to = $_GET['secondary_engine_search_maneuverability_to'];
    }
    if (isset($_GET['secondary_engine_search_weight_from']))
    {
        $search_weight_from = $_GET['secondary_engine_search_weight_from'];
    }
    if (isset($_GET['secondary_engine_search_weight_to']))
    {
        $search_weight_to = $_GET['secondary_engine_search_weight_to'];
    }
    if (isset($_GET['secondary_engine_search_cost_from']))
    {
        $search_cost_from = $_GET['secondary_engine_search_cost_from'];
    }
    if (isset($_GET['secondary_engine_search_cost_to']))
    {
        $search_cost_to = $_GET['secondary_engine_search_cost_to'];
    }

    $secondary_engines = searchSecondaryEngines($search_string,
            $search_maneuverability_from, $search_maneuverability_to,
            $search_weight_from, $search_weight_to,
            $search_cost_from, $search_cost_to);

    print '<table class="four_columns" cellspacing="0">';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';

    foreach ($secondary_engines as $cur_secondary_engine):
    print '<tr>';
    print '    <td>';
    print '        <div id="available_module_background">';
    print "            <img id='imgShipSecondaryEngine$cur_secondary_engine[name]' src='$cur_secondary_engine[image]1.png' class='available_module_image' draggable='true' ondragstart='dragSecondaryEngine(event)'>";
    print '        </div>';
    print '    </td>';
    print '    <td>';
    print "        $cur_secondary_engine[name]";
    print '    </td>';
    print '    <td class="wide_col">';
    print "        Maneuverability: $cur_secondary_engine[maneuverability] <br/>";
    print "        Weight: $cur_secondary_engine[weight]";
    print '    </td>';
    print '    <td class="last_col">';
    print "        $cur_secondary_engine[cost] <br/>";
    print '    </td>';
    print '</tr>';
    endforeach;
    print '</table>';
}

if (isset($_GET['fuel_tank_search_string']))
{
    $search_string = $_GET['fuel_tank_search_string'];
    $search_volume_from = NULL;
    $search_volume_to = NULL;
    $search_weight_from = NULL;
    $search_weight_to = NULL;
    $search_cost_from = NULL;
    $search_cost_to = NULL;
    
    if (isset($_GET['fuel_tank_search_volume_from']))
    {
        $search_volume_from = $_GET['fuel_tank_search_volume_from'];
    }
    if (isset($_GET['fuel_tank_search_volume_to']))
    {
        $search_volume_to = $_GET['fuel_tank_search_volume_to'];
    }
    if (isset($_GET['fuel_tank_search_weight_from']))
    {
        $search_weight_from = $_GET['fuel_tank_search_weight_from'];
    }
    if (isset($_GET['fuel_tank_search_weight_to']))
    {
        $search_weight_to = $_GET['fuel_tank_search_weight_to'];
    }
    if (isset($_GET['fuel_tank_search_cost_from']))
    {
        $search_cost_from = $_GET['fuel_tank_search_cost_from'];
    }
    if (isset($_GET['fuel_tank_search_cost_to']))
    {
        $search_cost_to = $_GET['fuel_tank_search_cost_to'];
    }

    $fuel_tanks = searchFuelTanks($search_string,
            $search_volume_from, $search_volume_to,
            $search_weight_from, $search_weight_to,
            $search_cost_from, $search_cost_to);

    print '<table class="four_columns" cellspacing="0">';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';

    foreach ($fuel_tanks as $cur_fuel_tank):
    print '<tr>';
    print '    <td>';
    print '        <div id="available_module_background">';
    print "            <img id='imgShipFuelTank$cur_fuel_tank[name]' src='$cur_fuel_tank[image]1.png' class='available_module_image' draggable='true' ondragstart='dragFuelTank(event)'>";
    print '        </div>';
    print '    </td>';
    print '    <td>';
    print "        $cur_fuel_tank[name]";
    print '    </td>';
    print '    <td class="wide_col">';
    print "        Volume: $cur_fuel_tank[volume] <br/>";
    print "        Weight: $cur_fuel_tank[weight]";
    print '    </td>';
    print '    <td class="last_col">';
    print "        $cur_fuel_tank[cost] <br/>";
    print '    </td>';
    print '</tr>';
    endforeach;
    print '</table>';
}

if (isset($_GET['radar_search_string']))
{
    $search_string = $_GET['radar_search_string'];
    $search_action_radius_from = NULL;
    $search_action_radius_to = NULL;
    $search_weight_from = NULL;
    $search_weight_to = NULL;
    $search_cost_from = NULL;
    $search_cost_to = NULL;
    
    if (isset($_GET['radar_search_action_radius_from']))
    {
        $search_action_radius_from = $_GET['radar_search_action_radius_from'];
    }
    if (isset($_GET['radar_search_action_radius_to']))
    {
        $search_action_radius_to = $_GET['radar_search_action_radius_to'];
    }
    if (isset($_GET['radar_search_weight_from']))
    {
        $search_weight_from = $_GET['radar_search_weight_from'];
    }
    if (isset($_GET['radar_search_weight_to']))
    {
        $search_weight_to = $_GET['radar_search_weight_to'];
    }
    if (isset($_GET['radar_search_cost_from']))
    {
        $search_cost_from = $_GET['radar_search_cost_from'];
    }
    if (isset($_GET['radar_search_cost_to']))
    {
        $search_cost_to = $_GET['radar_search_cost_to'];
    }

    $radars = searchRadars($search_string,
            $search_action_radius_from, $search_action_radius_to,
            $search_weight_from, $search_weight_to,
            $search_cost_from, $search_cost_to);

    print '<table class="four_columns" cellspacing="0">';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';

    foreach ($radars as $cur_radar):
    print '<tr>';
    print '    <td>';
    print '        <div id="available_module_background">';
    print "            <img id='imgShipRadar$cur_radar[name]' src='$cur_radar[image]1.png' class='available_module_image' draggable='true' ondragstart='dragRadar(event)'>";
    print '        </div>';
    print '    </td>';
    print '    <td>';
    print "        $cur_radar[name]";
    print '    </td>';
    print '    <td class="wide_col">';
    print "        Action radius: $cur_radar[action_radius] <br/>";
    print "        Weight: $cur_radar[weight]";
    print '    </td>';
    print '    <td class="last_col">';
    print "        $cur_radar[cost] <br/>";
    print '    </td>';
    print '</tr>';
    endforeach;
    print '</table>';
}

if (isset($_GET['repair_droid_search_string']))
{
    $search_string = $_GET['repair_droid_search_string'];
    $search_health_recovery_from = NULL;
    $search_health_recovery_to = NULL;
    $search_weight_from = NULL;
    $search_weight_to = NULL;
    $search_cost_from = NULL;
    $search_cost_to = NULL;
    
    if (isset($_GET['repair_droid_search_health_recovery_from']))
    {
        $search_health_recovery_from = $_GET['repair_droid_search_health_recovery_from'];
    }
    if (isset($_GET['repair_droid_search_health_recovery_to']))
    {
        $search_health_recovery_to = $_GET['repair_droid_search_health_recovery_to'];
    }
    if (isset($_GET['repair_droid_search_weight_from']))
    {
        $search_weight_from = $_GET['repair_droid_search_weight_from'];
    }
    if (isset($_GET['repair_droid_search_weight_to']))
    {
        $search_weight_to = $_GET['repair_droid_search_weight_to'];
    }
    if (isset($_GET['repair_droid_search_cost_from']))
    {
        $search_cost_from = $_GET['repair_droid_search_cost_from'];
    }
    if (isset($_GET['repair_droid_search_cost_to']))
    {
        $search_cost_to = $_GET['repair_droid_search_cost_to'];
    }

    $repair_droids = searchRepairDroids($search_string,
            $search_health_recovery_from, $search_health_recovery_to,
            $search_weight_from, $search_weight_to,
            $search_cost_from, $search_cost_to);

    print '<table class="four_columns" cellspacing="0">';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';

    foreach ($repair_droids as $cur_repair_droid):
    print '<tr>';
    print '    <td>';
    print '        <div id="available_module_background">';
    print "            <img id='imgShipRepairDroid$cur_repair_droid[name]' src='$cur_repair_droid[image]1.png' class='available_module_image' draggable='true' ondragstart='dragRepairDroid(event)'>";
    print '        </div>';
    print '    </td>';
    print '    <td>';
    print "        $cur_repair_droid[name]";
    print '    </td>';
    print '    <td class="wide_col">';
    print "        Health recovery: $cur_repair_droid[health_recovery] <br/>";
    print "        Weight: $cur_repair_droid[weight]";
    print '    </td>';
    print '    <td class="last_col">';
    print "        $cur_repair_droid[cost] <br/>";
    print '    </td>';
    print '</tr>';
    endforeach;
    print '</table>';
}

if (isset($_GET['magnetic_grip_search_string']))
{
    $search_string = $_GET['magnetic_grip_search_string'];
    $search_action_radius_from = NULL;
    $search_action_radius_to = NULL;
    $search_carrying_capacity_from = NULL;
    $search_carrying_capacity_to = NULL;
    $search_weight_from = NULL;
    $search_weight_to = NULL;
    $search_cost_from = NULL;
    $search_cost_to = NULL;
    
    if (isset($_GET['magnetic_grip_search_action_radius_from']))
    {
        $search_action_radius_from = $_GET['magnetic_grip_search_action_radius_from'];
    }
    if (isset($_GET['magnetic_grip_search_action_radius_to']))
    {
        $search_action_radius_to = $_GET['magnetic_grip_search_action_radius_to'];
    }
    if (isset($_GET['magnetic_grip_search_carrying_capacity_from']))
    {
        $search_carrying_capacity_from = $_GET['magnetic_grip_search_carrying_capacity_from'];
    }
    if (isset($_GET['magnetic_grip_search_carrying_capacity_to']))
    {
        $search_carrying_capacity_to = $_GET['magnetic_grip_search_carrying_capacity_to'];
    }
    if (isset($_GET['magnetic_grip_search_weight_from']))
    {
        $search_weight_from = $_GET['magnetic_grip_search_weight_from'];
    }
    if (isset($_GET['magnetic_grip_search_weight_to']))
    {
        $search_weight_to = $_GET['magnetic_grip_search_weight_to'];
    }
    if (isset($_GET['magnetic_grip_search_cost_from']))
    {
        $search_cost_from = $_GET['magnetic_grip_search_cost_from'];
    }
    if (isset($_GET['magnetic_grip_search_cost_to']))
    {
        $search_cost_to = $_GET['magnetic_grip_search_cost_to'];
    }

    $magnetic_grips = searchMagneticGrips($search_string,
            $search_action_radius_from, $search_action_radius_to,
            $search_carrying_capacity_from, $search_carrying_capacity_to,
            $search_weight_from, $search_weight_to,
            $search_cost_from, $search_cost_to);

    print '<table class="four_columns" cellspacing="0">';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';

    foreach ($magnetic_grips as $cur_magnetic_grip):
    print '<tr>';
    print '    <td>';
    print '        <div id="available_module_background">';
    print "            <img id='imgShipMagneticGrip$cur_magnetic_grip[name]' src='$cur_magnetic_grip[image]1.png' class='available_module_image' draggable='true' ondragstart='dragMagneticGrip(event)'>";
    print '        </div>';
    print '    </td>';
    print '    <td>';
    print "        $cur_magnetic_grip[name]";
    print '    </td>';
    print '    <td class="wide_col">';
    print "        Action radius: $cur_magnetic_grip[action_radius] <br/>";
    print "        Carrying capacity: $cur_magnetic_grip[carrying_capacity] <br/>";
    print "        Weight: $cur_magnetic_grip[weight]";
    print '    </td>';
    print '    <td class="last_col">';
    print "        $cur_magnetic_grip[cost] <br/>";
    print '    </td>';
    print '</tr>';
    endforeach;
    print '</table>';
}

if (isset($_GET['weapon_search_string']))
{
    $search_string = $_GET['weapon_search_string'];
    $search_type = NULL;
    $search_damage_from = NULL;
    $search_damage_to = NULL;
    $search_ammunition_from = NULL;
    $search_ammunition_to = NULL;
    $search_recharge_time_from = NULL;
    $search_recharge_time_to = NULL;
    $search_range_of_fire_from = NULL;
    $search_range_of_fire_to = NULL;
    $search_weight_from = NULL;
    $search_weight_to = NULL;
    $search_cost_from = NULL;
    $search_cost_to = NULL;
    
    if (isset($_GET['weapon_search_type']))
    {
        $search_type = $_GET['weapon_search_type'];
    }
    if (isset($_GET['weapon_search_damage_from']))
    {
        $search_damage_from = $_GET['weapon_search_damage_from'];
    }
    if (isset($_GET['weapon_search_damage_to']))
    {
        $search_damage_to = $_GET['weapon_search_damage_to'];
    }
    if (isset($_GET['weapon_search_ammunition_from']))
    {
        $search_ammunition_from = $_GET['weapon_search_ammunition_from'];
    }
    if (isset($_GET['weapon_search_ammunition_to']))
    {
        $search_ammunition_to = $_GET['weapon_search_ammunition_to'];
    }
    if (isset($_GET['weapon_search_recharge_time_from']))
    {
        $search_recharge_time_from = $_GET['weapon_search_recharge_time_from'];
    }
    if (isset($_GET['weapon_search_recharge_time_to']))
    {
        $search_recharge_time_to = $_GET['weapon_search_recharge_time_to'];
    }
    if (isset($_GET['weapon_search_range_of_fire_from']))
    {
        $search_range_of_fire_from = $_GET['weapon_search_range_of_fire_from'];
    }
    if (isset($_GET['weapon_search_range_of_fire_to']))
    {
        $search_range_of_fire_to = $_GET['weapon_search_range_of_fire_to'];
    }
    if (isset($_GET['weapon_search_weight_from']))
    {
        $search_weight_from = $_GET['weapon_search_weight_from'];
    }
    if (isset($_GET['weapon_search_weight_to']))
    {
        $search_weight_to = $_GET['weapon_search_weight_to'];
    }
    if (isset($_GET['weapon_search_cost_from']))
    {
        $search_cost_from = $_GET['weapon_search_cost_from'];
    }
    if (isset($_GET['weapon_search_cost_to']))
    {
        $search_cost_to = $_GET['weapon_search_cost_to'];
    }

    $weapons = searchWeapons($search_string, $search_type,
            $search_damage_from, $search_damage_to,
            $search_ammunition_from, $search_ammunition_to,
            $search_recharge_time_from, $search_recharge_time_to,
            $search_range_of_fire_from, $search_range_of_fire_to,
            $search_weight_from, $search_weight_to,
            $search_cost_from, $search_cost_to);

    print '<table class="four_columns" cellspacing="0">';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';

    foreach ($weapons as $cur_weapon):
    print '<tr>';
    print '    <td>';
    print '        <div id="available_module_background">';
    print "            <img id='imgShipWeapon$cur_weapon[name]' src='$cur_weapon[image]1.png' class='available_module_image' draggable='true' ondragstart='dragWeapon(event)'>";
    print '        </div>';
    print '    </td>';
    print '    <td>';
    print "        $cur_weapon[name]";
    print '    </td>';
    print '    <td class="wide_col">';
    print "     Type: ";
    switch ($cur_weapon['type'])
    {
        case "blaster":
            print "Blaster";
            break;
        case "laser_weapon":
            print "Laser weapon";
            break;
        case "missile_weapon":
            print "Missile weapon";
            break;
        case "plasma_weapon":
            print "Plasma weapon";
            break;
    }
    print '<br/>';
    print "        Damage: $cur_weapon[damage] <br/>";
    print "        Ammunition: $cur_weapon[ammunition]";
    print "        Recharge time: $cur_weapon[recharge_time]";
    print "        Range of fire: $cur_weapon[range_of_fire]";
    print "        Weight: $cur_weapon[weight]";
    print '    </td>';
    print '    <td class="last_col">';
    print "        $cur_weapon[cost] <br/>";
    print '    </td>';
    print '</tr>';
    endforeach;
    print '</table>';
}

?>
