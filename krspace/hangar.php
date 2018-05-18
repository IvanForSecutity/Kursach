<?php
//
// Players hangar.
// Ships save in database in table "ships".
//

// Authorized users only!
require_once('php_functions/check_session.php');

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');
require_once('php_functions/ships_database.php');

if(isset($_POST['btnStart']))
{
    // Player should choose any available ship
    if(isset($_POST['rbtnAvailableShips']))
    {
        // Set current ship
        $_SESSION['cur_ship'] = $_POST['rbtnAvailableShips'];

        header("Location: game.php");
    }
    else
    {
        $message = '<p>You should choose any available ship to start game!</p>';
        print $message;
    }
}

// Load user's ships
$login = $_SESSION['login'];
$ships = loadUserShips($login);
?>

<html>
    <head>
        <title>Hangar</title>
        <link rel="stylesheet" href="style/my_style.css">
    </head>
    <body>
        <div style="text-align: right; padding-right: 50px; padding-top: 10px;">
            <a href="logout.php">Log Out</a>
        </div>
        <div style="text-align: left; padding-right: 50px; padding-top: 10px;">
            Your ships
            <form action="" method="POST">
                <table  class="two_columns" cellspacing="0">
                    <tr>
                        <th>Ship name</th> <th>Action</th>
                    </tr>

                    <?php foreach ($ships as $cur_ship) : ?>
                        <tr>
                            <td><p> <input type="radio" name="rbtnAvailableShips" value="<?= $cur_ship['ship_name']?>" id="<?= $cur_ship['ship_name']?>"/> <label for="<?= $cur_ship['ship_name']?>"> <?= $cur_ship['ship_name']?> </label> </p></td> <td>delete</td>
                        </tr>
                    <?php endforeach ?>
                </table>

                <br/>
                
                <input type="submit" name="btnStart" value="Start" style="margin-top: 0.2em" ><br>
            </form>           
            
            <form action="crafter.php" method="POST">
                <input type="submit" name="btnCreate" value="Create new ship" style="margin-top: 0.2em" ><br>
            </form>
        </div>
    </body>
</html>