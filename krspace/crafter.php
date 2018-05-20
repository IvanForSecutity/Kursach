<?php
//
// Crafting spaceship.
// Result saves in database in table "ships".
//

// TODO: Стили в Opera! Или все норм?

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
        $secondary_engine = $_POST['selShipSecondaryEngine'];
        // Radar was chosen
        $radar = $_POST['selShipRadar'];
        // Repair droid was chosen
        $repair_droid = $_POST['selShipRepairDroid'];

        // Call the registration function
        $reg = registerNewShip($ship_name, $owner, $hull, $engine, $fuel_tank, $secondary_engine, $radar, $repair_droid);

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

// Load ships modules
$hulls = loadHulls();
$engines = loadEngines();
$fuel_tanks = loadFuelTanks();
$secondary_engines = loadSecondaryEngines();
$radars = loadRadars();
$repair_droids = loadRepairDroids();

// Load current modules
$hull = loadShipHull("Glader");
$hull_image = $hull['image']."1.png";
$selShipHull = "Glader";
$engine = loadShipEngine("Jumper");
$engine_image = $engine['image']."1.png";
$selShipEngine = "Jumper";
$fuel_tank = loadShipFuelTank("Classic");
$fuel_tank_image = $fuel_tank['image']."1.png";
$selShipFuelTank = "Classic";
$secondary_engine = loadShipSecondaryEngine("Turber");
$secondary_engine_image = $secondary_engine['image']."1.png";
$selShipSecondaryEngine = "Turber";
$radar = loadShipRadar("Altarter");
$radar_image = $radar['image']."1.png";
$selShipRadar = "Altarter";
$repair_droid = loadShipRepairDroid("Andr. I");
$repair_droid_image = $repair_droid['image']."1.png";
$selShipRepairDroid = "Andr. I";

// Calculate parameters
$hp = $hull['hp'];
$full_capacity = $hull['capacity'];
$maneuverability = $hull['maneuverability'] + $secondary_engine['maneuverability'];

$engine_weight = $engine['weight'];
$engine_speed = $engine['speed'];

$fuel_tank_weight = $fuel_tank['weight'];
$fuel_tank_volume = $fuel_tank['volume'];

$secondary_engine_weight = $secondary_engine['weight'];

$radar_weight = $radar['weight'];
$radar_action_radius = $radar['action_radius'];

$repair_droid_weight = $repair_droid['weight'];
$repair_droid_health_recovery = $repair_droid['health_recovery'];

$free_capacity = $full_capacity - $engine_weight - $fuel_tank_weight - $secondary_engine_weight - $radar_weight - $repair_droid_weight;
$speed = ((5000 + $engine_speed) * $free_capacity) / ($full_capacity * $full_capacity);
$cost = $hull['cost'] + $engine['cost'] + $fuel_tank['cost'] + $secondary_engine['cost'] + $radar['cost'] + $repair_droid['cost'];

if(isset($_POST['selShipHull']) || isset($_POST['selShipEngine']) || isset($_POST['selShipFuelTank']) || isset($_POST['selShipSecondaryEngines']))
{
    // Save entered values
    $selShipHull = $_POST['selShipHull'];
    $selShipEngine = $_POST['selShipEngine'];
    $selShipFuelTank = $_POST['selShipFuelTank'];
    $selShipSecondaryEngine = $_POST['selShipSecondaryEngine'];
    $selShipRadar = $_POST['selShipRadar'];
    $selShipRepairDroid = $_POST['selShipRepairDroid'];
    
    $txtShipName = $_POST['txtShipName'];
    
    // Load current modules
    $hull = loadShipHull($_POST['selShipHull']);
    $hull_image = $hull['image']."1.png";
    $engine = loadShipEngine($_POST['selShipEngine']);
    $engine_image = $engine['image']."1.png";
    $fuel_tank = loadShipFuelTank($_POST['selShipFuelTank']);
    $fuel_tank_image = $fuel_tank['image']."1.png";
    $secondary_engine = loadShipSecondaryEngine($_POST['selShipSecondaryEngine']);
    $secondary_engine_image = $secondary_engine['image']."1.png";
    $radar = loadShipRadar($_POST['selShipRadar']);
    $radar_image = $radar['image']."1.png";
    $repair_droid = loadShipRepairDroid($_POST['selShipRepairDroid']);
    $repair_droid_image = $repair_droid['image']."1.png";

    // Calculate parameters
    $hp = $hull['hp'];
    $full_capacity = $hull['capacity'];
    $maneuverability = $hull['maneuverability'] + $secondary_engine['maneuverability'];

    $engine_weight = $engine['weight'];
    $engine_speed = $engine['speed'];

    $fuel_tank_weight = $fuel_tank['weight'];
    $fuel_tank_volume = $fuel_tank['volume'];

    $secondary_engine_weight = $secondary_engine['weight'];

    $radar_weight = $radar['weight'];
    $radar_action_radius = $radar['action_radius'];

    $repair_droid_weight = $repair_droid['weight'];
    $repair_droid_health_recovery = $repair_droid['health_recovery'];

    $free_capacity = $full_capacity - $engine_weight - $fuel_tank_weight - $secondary_engine_weight - $radar_weight - $repair_droid_weight;
    $speed = ((5000 + $engine_speed) * $free_capacity) / ($full_capacity * $full_capacity);
    $cost = $hull['cost'] + $engine['cost'] + $fuel_tank['cost'] + $secondary_engine['cost'] + $radar['cost'] + $repair_droid['cost'];
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
                        <?php foreach ($hulls as $cur_hull) : ?>
                            <option data-path="images/Hulls/<?= $cur_hull['name']?>/1.png" value="<?= $cur_hull['name']?>" <?= (isset($selShipHull) && $selShipHull == $cur_hull['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_hull['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br>
                    Engine:
                    <select id="selShipEngine" name="selShipEngine" class="select-multi" size="1" onchange="this.form.submit()">
                        <?php foreach ($engines as $cur_engine) : ?>
                            <option data-path="images/Engines/<?= $cur_engine['name']?>/1.png" value="<?= $cur_engine['name']?>" <?= (isset($selShipEngine) && $selShipEngine == $cur_engine['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_engine['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Fuel Tank:
                    <select id="selShipFuelTank" name="selShipFuelTank" class="select-multi" size="1" onchange="this.form.submit()">
                        <?php foreach ($fuel_tanks as $cur_fuel_tank) : ?>
                            <option data-path="images/Fuel tanks/<?= $cur_fuel_tank['name']?>/1.png" value="<?= $cur_fuel_tank['name']?>" <?= (isset($selShipFuelTank) && $selShipFuelTank == $cur_fuel_tank['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_fuel_tank['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Secondary engines:
                    <select id="selShipSecondaryEngine" name="selShipSecondaryEngine" class="select-multi" size="1" onchange="this.form.submit()">
                        <?php foreach ($secondary_engines as $cur_secondary_engine) : ?>
                            <option data-path="images/Secondary engines/<?= $cur_secondary_engine['name']?>/1.png" value="<?= $cur_secondary_engine['name']?>" <?= (isset($selShipSecondaryEngine) && $selShipSecondaryEngine == $cur_secondary_engine['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_secondary_engine['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Radar:
                    <select id="selShipRadar" name="selShipRadar" class="select-multi" size="1" onchange="this.form.submit()">
                        <?php foreach ($radars as $cur_radar) : ?>
                            <option data-path="images/Radars/<?= $cur_radar['name']?>/1.png" value="<?= $cur_radar['name']?>" <?= (isset($selShipRadar) && $selShipRadar == $cur_radar['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_radar['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Repair droid:
                    <select id="selShipRepairDroid" name="selShipRepairDroid" class="select-multi" size="1" onchange="this.form.submit()">
                        <?php foreach ($repair_droids as $cur_repair_droid) : ?>
                            <option data-path="images/Repair droids/<?= $cur_repair_droid['name']?>/1.png" value="<?= $cur_repair_droid['name']?>" <?= (isset($selShipRepairDroid) && $selShipRepairDroid == $cur_repair_droid['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_repair_droid['name']?> </option>
                        <?php endforeach ?>
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

                        <a href='#' class='deg330'>
                            <div class="module_background">
                                <img id="ship_radar" src="<?php echo $radar_image;?>" class="module_image">
                            </div>
                        </a>
                        <a href='#' class='deg30'>  <img src="images/stub.jpg"> </a>

                        <a href='#' class='deg70'>  <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg90'>
                            <div class="module_background">
                                <img id="ship_repair_droid" src="<?php echo $repair_droid_image;?>" class="module_image">
                            </div>
                        </a>
                        <a href='#' class='deg110'>
                            <div class="module_background">
                                <img id="ship_secondary_engines" src="<?php echo $secondary_engine_image;?>" class="module_image">
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
                    Radar action radius: <input type="text" name="txtRadarActionRadius" value="<?php echo $radar_action_radius;?>" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Health recovery: <input type="text" name="txtHealthRecovery" value="<?php echo $repair_droid_health_recovery;?>" style="margin-top: 0.2em" readonly="true">
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
