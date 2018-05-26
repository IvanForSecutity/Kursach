<?php
//
// Spaceship in action.
//

// Start the session, from which we will retrieve login and session hash
session_start();

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');

// Authorized users only!
require_once('php_functions/check_session.php');
// Spaceship should be chosen!
require_once('php_functions/check_ship.php');

// Connect the file with the connection parameters to the ships DB
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
$magnetic_grip = loadShipMagneticGrip($ship['magnetic_grip']);
$weapon_1 = loadShipWeapon($ship['weapon_1']);
$weapon_2 = loadShipWeapon($ship['weapon_2']);
$weapon_3 = loadShipWeapon($ship['weapon_3']);
$weapon_4 = loadShipWeapon($ship['weapon_4']);
$weapon_5 = loadShipWeapon($ship['weapon_5']);

// Get modules parameters
$hull_hp = $hull['hp'];
$hull_maneuverability = $hull['maneuverability'];
$hull_capacity = $hull['capacity'];
$hull_cost = $hull['cost'];

if ($engine != NULL)
{
    $engine_speed = $engine['speed'];
    $engine_weight = $engine['weight'];
    $engine_cost = $engine['cost'];
}
else
{
    $engine_speed = 0;
    $engine_weight = 0;
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
    $fuel_tank_volume = $fuel_tank['volume'];
    $fuel_tank_weight = $fuel_tank['weight'];
    $fuel_tank_cost = $fuel_tank['cost'];
}
else
{
    $fuel_tank_volume = 0;
    $fuel_tank_weight = 0;
    $fuel_tank_cost = 0;
}

if ($radar != NULL)
{
    $radar_action_radius = $radar['action_radius'];
    $radar_weight = $radar['weight'];
    $radar_cost = $radar['cost'];
}
else
{
    $radar_action_radius = 0;
    $radar_weight = 0;
    $radar_cost = 0;
}

if ($repair_droid != NULL)
{
    $repair_droid_health_recovery = $repair_droid['health_recovery'];
    $repair_droid_weight = $repair_droid['weight'];
    $repair_droid_cost = $repair_droid['cost'];
}
else
{
    $repair_droid_health_recovery = 0;
    $repair_droid_weight = 0;
    $repair_droid_cost = 0;
}

if ($magnetic_grip != NULL)
{
    $magnetic_grip_action_radius = $magnetic_grip['action_radius'];
    $magnetic_grip_carrying_capacity = $magnetic_grip['carrying_capacity'];
    $magnetic_grip_weight = $magnetic_grip['weight'];
    $magnetic_grip_cost = $magnetic_grip['cost'];
}
else
{
    $magnetic_grip_action_radius = 0;
    $magnetic_grip_carrying_capacity = 0;
    $magnetic_grip_weight = 0;
    $magnetic_grip_cost = 0;
}

if ($weapon_1 != NULL)
{
    $weapon_1_type = $weapon_1['type'];
    $weapon_1_damage = $weapon_1['damage'];
    $weapon_1_ammunition = $weapon_1['ammunition'];
    $weapon_1_recharge_time = $weapon_1['recharge_time'];
    $weapon_1_range_of_fire = $weapon_1['range_of_fire'];
    $weapon_1_weight = $weapon_1['weight'];
    $weapon_1_cost = $weapon_1['cost'];
}
else
{
    $weapon_1_type = "";
    $weapon_1_damage = 0;
    $weapon_1_ammunition = 0;
    $weapon_1_recharge_time = 0;
    $weapon_1_range_of_fire = 0;
    $weapon_1_weight = 0;
    $weapon_1_cost = 0;
}

if ($weapon_2 != NULL)
{
    $weapon_2_type = $weapon_2['type'];
    $weapon_2_damage = $weapon_2['damage'];
    $weapon_2_ammunition = $weapon_2['ammunition'];
    $weapon_2_recharge_time = $weapon_2['recharge_time'];
    $weapon_2_range_of_fire = $weapon_2['range_of_fire'];
    $weapon_2_weight = $weapon_2['weight'];
    $weapon_2_cost = $weapon_2['cost'];
}
else
{
    $weapon_2_type = "";
    $weapon_2_damage = 0;
    $weapon_2_ammunition = 0;
    $weapon_2_recharge_time = 0;
    $weapon_2_range_of_fire = 0;
    $weapon_2_weight = 0;
    $weapon_2_cost = 0;
}

if ($weapon_3 != NULL)
{
    $weapon_3_type = $weapon_3['type'];
    $weapon_3_damage = $weapon_3['damage'];
    $weapon_3_ammunition = $weapon_3['ammunition'];
    $weapon_3_recharge_time = $weapon_3['recharge_time'];
    $weapon_3_range_of_fire = $weapon_3['range_of_fire'];
    $weapon_3_weight = $weapon_3['weight'];
    $weapon_3_cost = $weapon_3['cost'];
}
else
{
    $weapon_3_type = "";
    $weapon_3_damage = 0;
    $weapon_3_ammunition = 0;
    $weapon_3_recharge_time = 0;
    $weapon_3_range_of_fire = 0;
    $weapon_3_weight = 0;
    $weapon_3_cost = 0;
}

if ($weapon_4 != NULL)
{
    $weapon_4_type = $weapon_4['type'];
    $weapon_4_damage = $weapon_4['damage'];
    $weapon_4_ammunition = $weapon_4['ammunition'];
    $weapon_4_recharge_time = $weapon_4['recharge_time'];
    $weapon_4_range_of_fire = $weapon_4['range_of_fire'];
    $weapon_4_weight = $weapon_4['weight'];
    $weapon_4_cost = $weapon_4['cost'];
}
else
{
    $weapon_4_type = "";
    $weapon_4_damage = 0;
    $weapon_4_ammunition = 0;
    $weapon_4_recharge_time = 0;
    $weapon_4_range_of_fire = 0;
    $weapon_4_weight = 0;
    $weapon_4_cost = 0;
}

if ($weapon_5 != NULL)
{
    $weapon_5_type = $weapon_5['type'];
    $weapon_5_damage = $weapon_5['damage'];
    $weapon_5_ammunition = $weapon_5['ammunition'];
    $weapon_5_recharge_time = $weapon_5['recharge_time'];
    $weapon_5_range_of_fire = $weapon_5['range_of_fire'];
    $weapon_5_weight = $weapon_5['weight'];
    $weapon_5_cost = $weapon_5['cost'];
}
else
{
    $weapon_5_type = "";
    $weapon_5_damage = 0;
    $weapon_5_ammunition = 0;
    $weapon_5_recharge_time = 0;
    $weapon_5_range_of_fire = 0;
    $weapon_5_weight = 0;
    $weapon_5_cost = 0;
}

// Calculate parameters
$hp = $hull_hp;
$full_capacity = $hull_capacity;

$maneuverability = $hull_maneuverability + $secondary_engine_maneuverability;

$free_capacity = $full_capacity
        - $engine_weight - $fuel_tank_weight - $secondary_engine_weight
        - $radar_weight
        - $repair_droid_weight - $magnetic_grip_weight
        - $weapon_1_weight - $weapon_2_weight - $weapon_3_weight - $weapon_4_weight - $weapon_5_weight;
$speed = ((5000 * $free_capacity) + $engine_speed) / ($full_capacity * $full_capacity);
$cost = $hull_cost
        + $engine_cost + $fuel_tank_cost + $secondary_engine_cost
        + $radar_cost
        + $repair_droid_cost + $magnetic_grip_cost
        + $weapon_1_cost + $weapon_2_cost + $weapon_3_cost + $weapon_4_cost + $weapon_5_cost;
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style/page_style.css">
        <link rel="stylesheet" href="style/game_style.css">
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/js_game.js"></script>
        <title>Spaceship test</title>
    </head>

  <body onload="startGame()">
    <table  class="two_columns" cellspacing="0">
    <tr >
        <td>
            <a href="hangar.php" >To hangar</a>
        </td>
        <td class="right_col">
            <a href="logout.php">Log Out</a>
        </td>
    </tr>
    </table>


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
        Weapon1:    <a id="weapon1">10</a>
        Weapon2:    <a id="weapon2">9</a>
        Weapon3:    <a id="weapon3">8</a>
        Weapon4:    <a id="weapon4">0</a>
        Weapon5:    <a id="weapon5">0</a>
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
        <br> Magnetic grip action radius: <input id='hp' type="number" value="<?php echo $magnetic_grip_action_radius;?>" style="margin-top: 0.2em">
        <br> Magnetic grip carrying capacity: <input id='hp' type="number" value="<?php echo $magnetic_grip_carrying_capacity;?>" style="margin-top: 0.2em">
        <br>
        <?php if ($weapon_1 != NULL) { ?>
        <div id="Weapon1Parameters">
            Weapon 1. <br/>
            Type: <input id="txtWeapon1Type" value="<?php echo $weapon_1_type;?>" readonly="true"> <br/>
            Damage: <input id="txtWeapon1Damage" value="<?php echo $weapon_1_damage;?>" readonly="true"> <br/>
            Ammunition: <input id="txtWeapon1Ammunition" value="<?php echo $weapon_1_ammunition;?>" readonly="true"> <br/>
            Recharge Time: <input id="txtWeapon1RechargeTime" value="<?php echo $weapon_1_recharge_time;?>" readonly="true"> <br/>
            Range Of Fire:<input id="txtWeapon1RangeOfFire" value="<?php echo $weapon_1_range_of_fire;?>" readonly="true"> <br/>
        </div>
        <?php } ?>
        <?php if ($weapon_2 != NULL) { ?>
        <div id="Weapon2Parameters">
            Weapon 2. <br/>
            Type: <input id="txtWeapon2Type" value="<?php echo $weapon_2_type;?>" readonly="true"> <br/>
            Damage: <input id="txtWeapon2Damage" value="<?php echo $weapon_2_damage;?>" readonly="true"> <br/>
            Ammunition: <input id="txtWeapon2Ammunition" value="<?php echo $weapon_2_ammunition;?>" readonly="true"> <br/>
            Recharge Time: <input id="txtWeapon2RechargeTime" value="<?php echo $weapon_2_recharge_time;?>" readonly="true"> <br/>
            Range Of Fire:<input id="txtWeapon2RangeOfFire" value="<?php echo $weapon_2_range_of_fire;?>" readonly="true"> <br/>
        </div>
        <?php } ?>
        <?php if ($weapon_3 != NULL) { ?>
        <div id="Weapon3Parameters">
            Weapon 3. <br/>
            Type: <input id="txtWeapon3Type" value="<?php echo $weapon_3_type;?>" readonly="true"> <br/>
            Damage: <input id="txtWeapon3Damage" value="<?php echo $weapon_3_damage;?>" readonly="true"> <br/>
            Ammunition: <input id="txtWeapon3Ammunition" value="<?php echo $weapon_3_ammunition;?>" readonly="true"> <br/>
            Recharge Time: <input id="txtWeapon3RechargeTime" value="<?php echo $weapon_3_recharge_time;?>" readonly="true"> <br/>
            Range Of Fire:<input id="txtWeapon3RangeOfFire" value="<?php echo $weapon_3_range_of_fire;?>" readonly="true"> <br/>
        </div>
        <?php } ?>
        <?php if ($weapon_4 != NULL) { ?>
        <div id="Weapon4Parameters">
            Weapon 4. <br/>
            Type: <input id="txtWeapon4Type" value="<?php echo $weapon_4_type;?>" readonly="true"> <br/>
            Damage: <input id="txtWeapon4Damage" value="<?php echo $weapon_4_damage;?>" readonly="true"> <br/>
            Ammunition: <input id="txtWeapon4Ammunition" value="<?php echo $weapon_4_ammunition;?>" readonly="true"> <br/>
            Recharge Time: <input id="txtWeapon4RechargeTime" value="<?php echo $weapon_4_recharge_time;?>" readonly="true"> <br/>
            Range Of Fire:<input id="txtWeapon4RangeOfFire" value="<?php echo $weapon_4_range_of_fire;?>" readonly="true"> <br/>
        </div>
        <?php } ?>
        <?php if ($weapon_5 != NULL) { ?>
        <div id="Weapon5Parameters">
            Weapon 5. <br/>
            Type: <input id="txtWeapon5Type" value="<?php echo $weapon_5_type;?>" readonly="true"> <br/>
            Damage: <input id="txtWeapon5Damage" value="<?php echo $weapon_5_damage;?>" readonly="true"> <br/>
            Ammunition: <input id="txtWeapon5Ammunition" value="<?php echo $weapon_5_ammunition;?>" readonly="true"> <br/>
            Recharge Time: <input id="txtWeapon5RechargeTime" value="<?php echo $weapon_5_recharge_time;?>" readonly="true"> <br/>
            Range Of Fire:<input id="txtWeapon5RangeOfFire" value="<?php echo $weapon_5_range_of_fire;?>" readonly="true"> <br/>
        </div>
        <?php } ?>
        <!-- Hidden fields -->
        <input id='ship_hull' type="hidden" value="<?php echo $hull['image'];?>" style="margin-top: 0.2em">
        <input id='ship_engine' type="hidden" value="<?php echo $engine['image'];?>" style="margin-top: 0.2em">
        <input id='ship_fuel_tank' type="hidden" value="<?php echo $fuel_tank['image'];?>" style="margin-top: 0.2em">
        <input id='ship_secondary_engine' type="hidden" value="<?php echo $secondary_engine['image'];?>" style="margin-top: 0.2em">
        <input id='ship_radar' type="hidden" value="<?php echo $radar['image'];?>" style="margin-top: 0.2em">
        <input id='ship_repair_droid' type="hidden" value="<?php echo $repair_droid['image'];?>" style="margin-top: 0.2em">
        <br>
      </div>
    </div>

        <div id="divAudio">
            <audio controls autoplay="true" hidden="true" onended="ChangeMusic()">
                    <source id="audMusicOgg" src="" type="audio/ogg; codecs=vorbis">
                    <source id="audMusicMp3" src="" type="audio/mpeg">
                    The audio tag is not supported by your browser.
                    <a id="audMusicRef" href="">Download music</a>.
            </audio>
        </div>
    </body>
</html>
