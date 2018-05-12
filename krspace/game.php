<?php
//
// Spaceship in action.
//

// Authorized users only!
require_once('check_session.php');
// Spaceship should be chosen!
require_once('check_ship.php');

// Connect the file with the connection parameters to the DB
require_once('database.php');
require_once('ships_database.php');

// Get our ship
$ship_name = $_SESSION['cur_ship'];
$hull = loadCurrentShip($ship_name);
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="my_style.css">
        <title>Spaceship test</title>
    </head>
    <body onload="startGame()" >
        <div style="text-align: right; padding-right: 50px; padding-top: 10px;">
            <a href="logout.php">Log Out</a>
        </div>
        <div>
            <script src='js/spaceshiptest.js'></script>
        </div>
        
        Speed: <input id='speed' type="number"  style="margin-top: 0.2em">
        <br>
        Angles: <input id='angles' type="number"  style="margin-top: 0.2em">
        <br>
        
        TODO:
        Это затычка, которую надо потом спрятать куда-нибудь...
        <br>
        Hull: <input id='ship_hull' type="text" value="<?php echo $hull['hull'];?>" style="margin-top: 0.2em">
        <br>
        Hull: <input id='ship_hull_2' type="text" value="<?php echo $hull['hull_2'];?>" style="margin-top: 0.2em">
        <br>
        Hull: <input id='ship_hull_3' type="text" value="<?php echo $hull['hull_3'];?>" style="margin-top: 0.2em">
        <br>

        <p>Make sure the gamearea has focus, and use the arrow keys to move the red square around.</p>
    </body>
</html>