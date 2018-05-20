<?php
//
// Crafting spaceship.
// Result saves in database in table "ships".
//

// TODO: Нет смысла вручную заполнять все модули, корпуса... Надо все из БД подгружать.
// TODO: Стили в Opera!

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
        // Engine was chosen
        $engine = $_POST['selShipEngine'];
        // Fuel tank was chosen
        $fuel_tank = $_POST['selShipFuelTank'];
        // Secondary engines was chosen
        $secondary_engines = $_POST['selShipSecondaryEngines'];

        // Call the registration function
        $reg = registerNewShip($ship_name, $owner, $hull, $engine, $fuel_tank, $secondary_engines);

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
$engine = loadShipEngine("Jumper");
$engine_image = $engine['image']."1.png";
$fuel_tank = loadShipFuelTank("Classic");
$fuel_tank_image = $fuel_tank['image']."1.png";
$secondary_engines = loadShipSecondaryEngines("Turber");
$secondary_engines_image = $secondary_engines['image']."1.png";

// Calculate parameters
$hp = $hull['hp'];
$full_capacity = $hull['capacity'];
$maneuverability = $hull['maneuverability'] + $secondary_engines['maneuverability'];

$engine_weight = $engine['weight'];
$engine_speed = $engine['speed'];

$fuel_tank_weight = $fuel_tank['weight'];
$fuel_tank_volume = $fuel_tank['volume'];

$secondary_engines_weight = $secondary_engines['weight'];

$free_capacity = $full_capacity - $engine_weight - $fuel_tank_weight - $secondary_engines_weight;
$speed = ((5000 + $engine_speed) * $free_capacity) / ($full_capacity * $full_capacity);
$cost = $hull['cost'] + $engine['cost'] + $fuel_tank['cost'] + $secondary_engines['cost'];

if(isset($_POST['selShipHull']) || isset($_POST['selShipEngine']) || isset($_POST['selShipFuelTank']) || isset($_POST['selShipSecondaryEngines']))
{
    // Save entered values
    $selShipHull = $_POST['selShipHull'];
    $selShipEngine = $_POST['selShipEngine'];
    $selShipFuelTank = $_POST['selShipFuelTank'];
    $selShipSecondaryEngines = $_POST['selShipSecondaryEngines'];
    
    $txtShipName = $_POST['txtShipName'];
    
    // Load current modules
    $hull = loadShipHull($_POST['selShipHull']);
    $hull_image = $hull['image']."1.png";
    $engine = loadShipEngine($_POST['selShipEngine']);
    $engine_image = $engine['image']."1.png";
    $fuel_tank = loadShipFuelTank($_POST['selShipFuelTank']);
    $fuel_tank_image = $fuel_tank['image']."1.png";
    $secondary_engines = loadShipSecondaryEngines($_POST['selShipSecondaryEngines']);
    $secondary_engines_image = $secondary_engines['image']."1.png";

    // Calculate parameters
    $hp = $hull['hp'];
    $full_capacity = $hull['capacity'];
    $maneuverability = $hull['maneuverability'] + $secondary_engines['maneuverability'];

    $engine_weight = $engine['weight'];
    $engine_speed = $engine['speed'];

    $fuel_tank_weight = $fuel_tank['weight'];
    $fuel_tank_volume = $fuel_tank['volume'];

    $secondary_engines_weight = $secondary_engines['weight'];

    $free_capacity = $full_capacity - $engine_weight - $fuel_tank_weight - $secondary_engines_weight;
    $speed = ((5000 + $engine_speed) * $free_capacity) / ($full_capacity * $full_capacity);
    $cost = $hull['cost'] + $engine['cost'] + $fuel_tank['cost'] + $secondary_engines['cost'];
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
                    Ship name: <input type="text" name="txtShipName" value="<?php echo $txtShipName;?>" style="margin-top: 0.2em">
                    <br>
                    <br>
                    Hull:
                    <select id="selShipHull" name="selShipHull" class="select-multi" size="1" onchange="this.form.submit()">
                        <option data-path="images/Hulls/Glader/1.png"         value="Glader"         <?= (isset($selShipHull) && $selShipHull == "Glader")         ? " selected=\"selected\"" : "" ?>> Glader         </option>
                        <option data-path="images/Hulls/Temper (Blue)/1.png"  value="Temper (Blue)"  <?= (isset($selShipHull) && $selShipHull == "Temper (Blue)")  ? " selected=\"selected\"" : "" ?>> Temper (Blue)  </option>
                        <option data-path="images/Hulls/Temper (Red)/1.png"   value="Temper (Red)"   <?= (isset($selShipHull) && $selShipHull == "Temper (Red)")   ? " selected=\"selected\"" : "" ?>> Temper (Red)   </option>
                        <option data-path="images/Hulls/Temper (Green)/1.png" value="Temper (Green)" <?= (isset($selShipHull) && $selShipHull == "Temper (Green)") ? " selected=\"selected\"" : "" ?>> Temper (Green) </option>
                    </select>
                    <br>
                    Engine:
                    <select id="selShipEngine" name="selShipEngine" class="select-multi" size="1" onchange="this.form.submit()">
                        <option data-path="images/Engines/Jumper/1.png"    value="Jumper"    <?= (isset($selShipEngine) && $selShipEngine == "Jumper")    ? " selected=\"selected\"" : "" ?>> Jumper    </option>
                        <option data-path="images/Engines/Pop-Uper/1.png"  value="Pop-Uper"  <?= (isset($selShipEngine) && $selShipEngine == "Pop-Uper")  ? " selected=\"selected\"" : "" ?>> Pop-Uper  </option>
                        <option data-path="images/Engines/Turbine/1.png"   value="Turbine"   <?= (isset($selShipEngine) && $selShipEngine == "Turbine")   ? " selected=\"selected\"" : "" ?>> Turbine   </option>
                        <option data-path="images/Engines/Turbine I/1.png" value="Turbine I" <?= (isset($selShipEngine) && $selShipEngine == "Turbine I") ? " selected=\"selected\"" : "" ?>> Turbine I </option>
                    </select>
                    <br/>
                    Fuel Tank:
                    <select id="selShipFuelTank" name="selShipFuelTank" class="select-multi" size="1" onchange="this.form.submit()">
                        <option data-path="images/Fuel tanks/Classic/1.png" value="Classic" <?= (isset($selShipFuelTank) && $selShipFuelTank == "Classic") ? " selected=\"selected\"" : "" ?>> Classic </option>
                        <option data-path="images/Fuel tanks/Literer/1.png" value="Literer" <?= (isset($selShipFuelTank) && $selShipFuelTank == "Literer") ? " selected=\"selected\"" : "" ?>> Literer </option>
                        <option data-path="images/Fuel tanks/Xpacer/1.png"  value="Xpacer"  <?= (isset($selShipFuelTank) && $selShipFuelTank == "Xpacer")  ? " selected=\"selected\"" : "" ?>> Xpacer  </option>
                    </select>
                    <br/>
                    Secondary engines:
                    <select id="selShipSecondaryEngines" name="selShipSecondaryEngines" class="select-multi" size="1" onchange="this.form.submit()">
                        <option data-path="images/Secondary engines/Turber/1.png"   value="Turber"   <?= (isset($selShipSecondaryEngines) && $selShipSecondaryEngines == "Turber")   ? " selected=\"selected\"" : "" ?>> Turber   </option>
                        <option data-path="images/Secondary engines/Windmill/1.png" value="Windmill" <?= (isset($selShipSecondaryEngines) && $selShipSecondaryEngines == "Windmill") ? " selected=\"selected\"" : "" ?>> Windmill </option>
                    </select>
                    <br/>
                </td>
                <td class="center_col">
                    <div class='circle-container'>
                        <c href='#' class='center'>
                            <div class="hull_background">
                                <img id="ship_hull" src="<?php echo $hull_image;?>" class="hull_image">
                            </div>
                        </a>

                        <a href='#' class='deg250'> <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg270'> <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg290'> <img src="images/stub.jpg"> </a>

                        <a href='#' class='deg330'> <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg30'>  <img src="images/stub.jpg"> </a>

                        <a href='#' class='deg70'>  <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg90'>  <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg110'>
                            <div class="module_background">
                                <img id="ship_secondary_engines" src="<?php echo $secondary_engines_image;?>" class="module_image">
                            </div>
                        </a>

                        <a href='#' class='deg150'>
                            <div class="module_background">
                                <img id="ship_fuel_tank" src="<?php echo $fuel_tank_image;?>" class="module_image">
                            </div>
                        </a>
                        <a href='#' class='deg210'>
                            <div class="module_background">
                                <img id="ship_engine" src="<?php echo $engine_image;?>" class="module_image">
                            </div>
                        </a>
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
                    Fuel tank volume: <input type="text" name="txtFuelTankVolume" value="<?php echo $fuel_tank_volume;?>" style="margin-top: 0.2em" readonly="true">
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
