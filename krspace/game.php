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

// Calculate parameters
$hp = $hull['hp'];
$full_capacity = $hull['capacity'];
$maneuverability = $hull['maneuverability'];

$engine_weight = $engine['weight'];
$engine_speed = $engine['speed'];

$fuel_tank_weight = $fuel_tank['weight'];
$fuel_tank_volume = $fuel_tank['volume'];

$free_capacity = $full_capacity - $engine_weight - $fuel_tank_weight;
$speed = ((5000 + $engine_speed) * $free_capacity) / ($full_capacity * $full_capacity);
?>

  <html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="style/game_style.css">
    <title>Spaceship test</title>

  </head>

  <body onload="startGame()">
    <div style="text-align: right; padding-right: 50px; padding-top: 10px;">
      <a href="logout.php">Log Out</a>
    </div>
    <div id='gamediv' style="display:flex;">
      <div id='game_field' style="border: 4px double black;display:inline">
        <canvas id="canvas_field" width="1200" height="650"></canvas>
        <script src='js/spaceshiptest.js'></script>
      </div>
      <div style="border: 4px double black;display:inline">
        <button id='stop_button' type="button">STOP</button>
        <p id='helptext'>rocket</p>
        Weapon type: <select id="WeaponType" class="select-multi" size="1" onchange="this.form.submit()">
          <option value="rocket"     > Rocket    </option>
          <option value="blaster"    > Blaster   </option>
          <option value="laser"      > Laser     </option>
        </select>
        <br>Weapon unit count: <p id="booms_cnt"></p>
        <br>
        <a>FUEL</a><a id='fuel_v'><?php echo $fuel_tank_volume;?></a></a><a>:</a>
        <div class='container'>
            <div class='js'><p id="percent">100%</p></div>
        </div>
        <br>Hp: <input id='hp' type="number" value="<?php echo $hp;?>" style="margin-top: 0.2em">
        <br> Speed: <input id='speed' type="number" value="<?php echo $speed;?>" style="margin-top: 0.2em">
        <br> Maneuverability: <input id='maneuverability' type="number" value="<?php echo $maneuverability;?>" style="margin-top: 0.2em">
        <br> Fuel tank volume: <input id='fuel_tank_volume' type="number" value="<?php echo $fuel_tank_volume;?>" style="margin-top: 0.2em">
        <br> TODO: Это затычка, которую надо потом спрятать куда-нибудь...
        <br> Hull: <input id='ship_hull' type="text" value="<?php echo $hull['image'];?>" style="margin-top: 0.2em">
        <br> Engine: <input id='ship_engine' type="text" value="<?php echo $engine['image'];?>" style="margin-top: 0.2em">
        <br> Fuel tank: <input id='ship_fuel_tank' type="text" value="<?php echo $fuel_tank['image'];?>" style="margin-top: 0.2em">
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
