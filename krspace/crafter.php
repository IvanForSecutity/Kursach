<?php
//
// Crafting spaceship.
// Result saves in database in table "ships".
//

// Authorized users only!
require_once('php_functions/check_session.php');

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');
require_once('php_functions/ships_database.php');

// If game starts
if(isset($_POST['btnStart']))
{
    // Player should choose ship name
    if($_POST['txtShipName'])
    {
        $ship_name = $_POST['txtShipName'];
        $owner = $_SESSION['login'];
        
        // Hull was chosen
        $hull = $_POST['selShipHull'];

        // Call the registration function
        $reg = registerNewShip($ship_name, $owner, $hull);

        // If ship successfully registered, inform the user
        if($reg === true)
        {
            $message = '<p>Your new ship registered in the system! Game starts...</p>';
            print $message;
            
            // Set current ship
            $_SESSION['cur_ship'] = $ship_name;
            
            // Redirect to game page
            // TODO: Вариант с хедером мне нравится больше, чем это некошерное нечто. 
            // Однако, на вариант с хедером php ругается, мол body уже послано...
            // Насколько я понял, если как-то сделать вызов registerNewShip ПОСЛЕ вызова header - все будет ОК.
            // Стрёмная какая-то ошибка...
            //header('Refresh: 5; URL = game.php');
            echo '<script>location.replace("game.php");</script>';
            exit;
        }
        // Otherwise, we inform the user of an error
        else
        {
            print $reg;
        }
    }
    else
    {
        $message = '<p>You should choose ship name!</p>';
        print $message;
    }
}

// Initialization
$txtShipName = "";

// Load current modules
$hull = loadShipHull("Glader");
$hull_image = $hull['image']."1.png";

// Calculate parameters
$hp = $hull['hp'];
$full_capacity = $hull['capacity'];
$free_capacity = $full_capacity;
$speed = 5000 / $full_capacity;
$maneuverability = $hull['maneuverability'];
$cost = $hull['cost'];

if(isset($_POST['selShipHull']))
{
    // Save entered values
    $selShipHull = $_POST['selShipHull'];
    $txtShipName = $_POST['txtShipName'];
    
    // Load current modules
    $hull = loadShipHull($_POST['selShipHull']);
    $hull_image = $hull['image']."1.png";

    // Calculate parameters
    $hp = $hull['hp'];
    $full_capacity = $hull['capacity'];
    $free_capacity = $full_capacity;
    $speed = 5000 / $full_capacity;
    $maneuverability = $hull['maneuverability'];
    $cost = $hull['cost'];
}
?>

<html>
    <head>
        <title>Spaceship smithy</title>
        <link rel="stylesheet" href="style/my_style.css">
    </head>
    <body>
        <div style="text-align: right; padding-right: 50px; padding-top: 10px;">
            <a href="logout.php">Log Out</a>
        </div>
        
        <br/>
        <br/>
        
        <form action="" method="POST">
            <table class="three_columns">
            <tr>
                <td>
                    Spaceship modules:
                    <br>
                    <br/>
                    Hull:
                    <select id="selShipHull" name="selShipHull" class="select-multi" size="1" onchange="this.form.submit()">
                        <option data-path="images/Hulls/Glader/1.png"         value="Glader"         <?= (isset($selShipHull) && $selShipHull == "Glader")         ? " selected=\"selected\"" : "" ?>> Glader         </option>
                        <option data-path="images/Hulls/Temper (Blue)/1.png"  value="Temper (Blue)"  <?= (isset($selShipHull) && $selShipHull == "Temper (Blue)")  ? " selected=\"selected\"" : "" ?>> Temper (Blue)  </option>
                        <option data-path="images/Hulls/Temper (Red)/1.png"   value="Temper (Red)"   <?= (isset($selShipHull) && $selShipHull == "Temper (Red)")   ? " selected=\"selected\"" : "" ?>> Temper (Red)   </option>
                        <option data-path="images/Hulls/Temper (Green)/1.png" value="Temper (Green)" <?= (isset($selShipHull) && $selShipHull == "Temper (Green)") ? " selected=\"selected\"" : "" ?>> Temper (Green) </option>
                    </select>
                    <br>
                    <br/>
                    Ship name: <input type="text" name="txtShipName" value="<?php echo $txtShipName;?>" style="margin-top: 0.2em">
                    <br>
                </td>
                <td class="center_col">
                    <div class='circle-container'>
                    <c href='#' class='center'> <img id="ship_hull" src="<?php echo $hull_image;?>" width=100 height=175> </a>

                    <a href='#' class='deg250'> <img src="images/stub.jpg"> </a>
                    <a href='#' class='deg270'> <img src="images/stub.jpg"> </a>
                    <a href='#' class='deg290'> <img src="images/stub.jpg"> </a>

                    <a href='#' class='deg330'> <img src="images/stub.jpg"> </a>
                    <a href='#' class='deg30'>  <img src="images/stub.jpg"> </a>

                    <a href='#' class='deg70'>  <img src="images/stub.jpg"> </a>
                    <a href='#' class='deg90'>  <img src="images/stub.jpg"> </a>

                    <a href='#' class='deg110'> <img src="images/stub.jpg"> </a>
                    <a href='#' class='deg150'> <img src="images/stub.jpg"> </a>
                    <a href='#' class='deg210'> <img src="images/stub.jpg"> </a>
                    </div> 
                </td>
                <td class="right_col">
                    Spaceship parameters:
                    <br/>
                    <br>
                    Capacity: <input type="text" name="txtFreeCapacity" value="<?php echo $free_capacity;?>" style="margin-top: 0.2em" readonly="true">
                    / <input type="text" name="txtFullCapacity" value="<?php echo $full_capacity;?>" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    <br/>
                    Hp: <input type="text" name="txtHp" value="<?php echo $hp;?>" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Speed: <input type="text" name="txtSpeed" value="<?php echo $speed;?>" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Maneuverability: <input type="text" name="txtManeuverability" value="<?php echo $maneuverability;?>" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    <br/>
                    Cost: <input type="text" name="txtCost" value="<?php echo $cost;?>" style="margin-top: 0.2em" readonly="true">
                    <br/>
                </td>
            </tr>
            </table>

            <div style="text-align: center; padding-top: 50px;">
                <input type="submit" name="btnStart" value="Start" style="margin-top: 0.2em" ><br>
            </div>
        </form>
    </body>
</html>
