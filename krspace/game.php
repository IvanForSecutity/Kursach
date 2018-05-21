<?php
//
// Spaceship in action.
//

// Authorized users only!
require_once('php_functions/check_session.php');
// Spaceship should be chosen!
require_once('php_functions/check_ship.php');

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');
require_once('php_functions/ships_database.php');

// Get our ship
$ship_name = $_SESSION['cur_ship'];
$ship = loadCurrentShip($ship_name);
$hull = loadShipHull($ship['hull']);
$engine = loadShipEngine($ship['engine']);
$fuel_tank = loadShipFuelTank($ship['fuel_tank']);
$secondary_engine = loadShipSecondaryEngine($ship['secondary_engine']);
$radar = loadShipRadar($ship['radar']);
$repair_droid = loadShipRepairDroid($ship['repair_droid']);

// Get modules parameters
$hull_hp = $hull['hp'];
$hull_capacity = $hull['capacity'];
$hull_maneuverability = $hull['maneuverability'];
$hull_cost = $hull['cost'];

if ($engine != NULL)
{
    $engine_weight = $engine['weight'];
    $engine_speed = $engine['speed'];
    $engine_cost = $engine['cost'];
}
else
{
    $engine_weight = 0;
    $engine_speed = 0;
    $engine_cost = 0;
}

if ($secondary_engine != NULL)
{
    $secondary_engine_maneuverability = $secondary_engine['maneuverability'];
    $secondary_engine_weight = $secondary_engine['weight'];
    $secondary_engine_cost = $secondary_engine['cost'];
}
else
{
    $secondary_engine_maneuverability = 0;
    $secondary_engine_weight = 0;
    $secondary_engine_cost = 0;
}

if ($fuel_tank != NULL)
{
    $fuel_tank_weight = $fuel_tank['weight'];
    $fuel_tank_volume = $fuel_tank['volume'];
    $fuel_tank_cost = $fuel_tank['cost'];
}
else
{
    $fuel_tank_weight = 0;
    $fuel_tank_volume = 0;
    $fuel_tank_cost = 0;
}

if ($radar != NULL)
{
    $radar_weight = $radar['weight'];
    $radar_action_radius = $radar['action_radius'];
    $radar_cost = $radar['cost'];
}
else
{
    $radar_weight = 0;
    $radar_action_radius = 0;
    $radar_cost = 0;
}

if ($repair_droid != NULL)
{
    $repair_droid_weight = $repair_droid['weight'];
    $repair_droid_health_recovery = $repair_droid['health_recovery'];
    $repair_droid_cost = $repair_droid['cost'];
}
else
{
    $repair_droid_weight = 0;
    $repair_droid_health_recovery = 0;
    $repair_droid_cost = 0;
}

// Calculate parameters
$hp = $hull_hp;
$full_capacity = $hull_capacity;

$maneuverability = $hull_maneuverability + $secondary_engine_maneuverability;

$free_capacity = $full_capacity - $engine_weight - $fuel_tank_weight - $secondary_engine_weight - $radar_weight - $repair_droid_weight;
$speed = ((5000 + $engine_speed) * $free_capacity) / ($full_capacity * $full_capacity);
$cost = $hull_cost + $engine_cost + $fuel_tank_cost + $secondary_engine_cost + $radar_cost + $repair_droid_cost;
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style/my_style.css">
        <link rel="stylesheet" href="style/game_style.css">
        <title>Spaceship test</title>
    </head>

  <body onload="startGame()">
    <table  class="two_columns" cellspacing="0">
    <tr>
        <td>
            <a href="hangar.php">To hangar</a>
        </td>
        <td class="right_col">
            <a href="logout.php">Log Out</a>
        </td>
    </tr>
    </table>
      
    <br>
    <br>

    <div id='gamediv' style="display:flex;">
      <div id='game_field' style="border: 4px double black;display:inline">
        <canvas id="canvas_field" width="1200" height="650"></canvas>
        <script src='js/spaceshiptest.js'></script>
      </div>
      <div style="border: 4px double black;display:inline">
        <button id='stop_button' type="button">STOP</button>
        <a id='helptext'>helptext</a>
        Weapon type: <select id="WeaponType" class="select-multi" size="1" onchange="this.form.submit()">
          <option value="rocket"     > Rocket    </option>
          <option value="blaster"    > Blaster   </option>
          <option value="laser"      > Laser     </option>
        </select>
        <pre>Weapon unit count:
        Rockets:    <a id="booms_rocket">10</a>
        Blasters:   <a id="booms_blaster">9</a>
        Laser:      <a id="booms_laser">8</a>
        </pre>
        <br>
        <a>FUEL [</a><a id='fuel_v'><?php echo $fuel_tank_volume;?></a></a><a>]:</a>
        <div class='container'>
            <div class='js1'><p id="percent1">100%</p></div>
        </div>
        <a>HP [</a><a id='hp_v'><?php echo $hp;?></a></a><a>]:</a>
        <div class='container'>
            <div class='js2'><p id="percent2">100%</p></div>
        </div>
        <br> Speed: <input id='speed' type="number" value="<?php echo $speed;?>" style="margin-top: 0.2em">
        <br> Maneuverability: <input id='maneuverability' type="number" value="<?php echo $maneuverability;?>" style="margin-top: 0.2em">
       <br> Radar action radius: <input id='radar_action_radius' type="number" value="<?php echo $radar_action_radius;?>" style="margin-top: 0.2em">
       <br> Health recovery: <input id='hp' type="number" value="<?php echo $repair_droid_health_recovery;?>" style="margin-top: 0.2em">
       <br> TODO: Это затычка, которую надо потом спрятать куда-нибудь...
        <br> Hull: <input id='ship_hull' type="text" value="<?php echo $hull['image'];?>" style="margin-top: 0.2em">
        <br> Engine: <input id='ship_engine' type="text" value="<?php echo $engine['image'];?>" style="margin-top: 0.2em">
        <br> Fuel tank: <input id='ship_fuel_tank' type="text" value="<?php echo $fuel_tank['image'];?>" style="margin-top: 0.2em">
        <br> Secondary engines: <input id='ship_secondary_engine' type="text" value="<?php echo $secondary_engine['image'];?>" style="margin-top: 0.2em">
        <br> Radar: <input id='ship_radar' type="text" value="<?php echo $radar['image'];?>" style="margin-top: 0.2em">
        <br> Repair droid: <input id='ship_repair_droid' type="text" value="<?php echo $repair_droid['image'];?>" style="margin-top: 0.2em">
        <br>

      </div>

    </div>

    TODO: Крутить разные мелодии в рандомном порядке.
    <audio controls autoplay="true" loop="true" hidden="true">
            <source src="audio/Fly 2.ogg" type="audio/ogg; codecs=vorbis">
            <source src="audio/Fly 2.mp3" type="audio/mpeg">
            Тег audio не поддерживается вашим браузером.
            <a href="audio/Fly 2.mp3">Скачайте музыку</a>.
        </audio>
  </body>

</html>
