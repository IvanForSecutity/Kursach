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

    print '<table class="four_columns" cellspacing="0">';
    print '<tr>';
    print '    <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>';
    print '</tr>';

    foreach ($hulls as $cur_hull):
    print '<tr>';
    print '    <td>';
    print '        <div id="available_module_background">';
    print "            <img id='imgShipHull$cur_hull[name]' src='$cur_hull[image]1.png' class='available_module_image' draggable='true' ondragstart='dragHull(event)'>";
    print '        </div>';
    print '    </td>';
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
    print '</table>';
}

?>
