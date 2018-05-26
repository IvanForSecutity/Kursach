<?php
//
// Players hangar.
// Ships save in database in table "ships".
//

// TODO: Стили!

// Start the session, from which we will retrieve login and session hash
session_start();

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');

// Authorized users only!
require_once('php_functions/check_session.php');

// Connect the file with the connection parameters to the ships DB
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

// Check if delete button was pressed
foreach ($ships as $cur_ship)
{
    if(isset($_POST[$cur_ship['ship_name']]))
    {
        $ship_name = $cur_ship['ship_name'];
        deleteShip($ship_name);
        header("Refresh:0");
    }
}
?>

<html>
    <head>
        <title>Hangar</title>
        <link rel="stylesheet" href="style/page_style.css">
    </head>
    <body>
        <table  class="two_columns" cellspacing="0">
        <tr>
            <td>
                <a href="personal_area.php">Personal Area</a>
            </td>
            <td class="right_col">
                <a href="logout.php">Log Out</a>
            </td>
        </tr>
        </table>
        
        <div style="text-align: left; padding-right: 50px; padding-top: 10px;">
            Your ships
            <br><br>
            <form action="" method="POST">
                <table  class="ships_table" cellspacing="0">
                    <tr>
                        <th>Ship name</th> <th>Action</th>
                    </tr>

                    <?php foreach ($ships as $cur_ship) : ?>
                        <tr>
                            <td>
                                <p> <input type="radio" name="rbtnAvailableShips" value="<?= $cur_ship['ship_name']?>" id="<?= $cur_ship['ship_name']?>"/> <label for="<?= $cur_ship['ship_name']?>"> <?= $cur_ship['ship_name']?> </label> </p>
                            </td>
                            <td>
                                <button type="submit" name="<?= $cur_ship['ship_name']?>" class="input_image"><img src="images\Icons\no.png" weight="20px" height="20px"></button>
                            </td>
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