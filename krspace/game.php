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

// Calculate parameters
$hp = $hull['hp'];
$capacity = $hull['capacity'];
$speed = 5000 / $capacity;
$maneuverability = $hull['maneuverability'];
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="style/my_style.css">
        <title>Spaceship test</title>
    </head>
    <body onload="startGame()" >
        <div style="text-align: right; padding-right: 50px; padding-top: 10px;">
            <a href="logout.php">Log Out</a>
        </div>
        <div>
            <script src='js/spaceshiptest.js'></script>
        </div>
        
        Hp: <input id='hp' type="number" value="<?php echo $hp;?>" style="margin-top: 0.2em">
        <br>
        Speed: <input id='speed' type="number" value="<?php echo $speed;?>" style="margin-top: 0.2em">
        <br>
        Maneuverability: <input id='maneuverability' type="number" value="<?php echo $maneuverability;?>" style="margin-top: 0.2em">
        <br>

        TODO:
        Это затычка, которую надо потом спрятать куда-нибудь...
        <br>
        Hull: <input id='ship_hull' type="text" value="<?php echo $hull['image'];?>" style="margin-top: 0.2em">
        <br>

        <p>Make sure the gamearea has focus, and use the arrow keys to move the red square around.</p>
        
        <audio controls autoplay="true" loop="true" hidden="true">
            <source src="audio/Fly 2.ogg" type="audio/ogg; codecs=vorbis">
            <source src="audio/Fly 2.mp3" type="audio/mpeg">
            Тег audio не поддерживается вашим браузером.
            <a href="audio/Fly 2.mp3">Скачайте музыку</a>.
        </audio>
    </body>
</html>