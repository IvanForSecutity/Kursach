<?php
//
// Crafting spaceship.
// Result saves in database in table "ships".
//

// TODO: Вынести расчет параметров в отдельную функцию, а то он в 3 местах повторяется

// Start the session, from which we will retrieve login and session hash
session_start();

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');

// Authorized users only!
require_once('php_functions/check_session.php');

// Connect the file with the connection parameters to the ships DB
require_once('php_functions/ships_database.php');

function validateShip()
{
    // Player should choose ship name
    if(!$_POST['txtShipName'])
    {
        $message = '<p>You should choose ship name!</p>';
        print $message;
        return false;
    }

    // Player should choose ship hull
    if(!$_POST['selShipHull'])
    {
        $message = '<p>You should choose ship hull!</p>';
        print $message;
        return false;
    }

    return true;
}

// If game starts
if(isset($_POST['btnStart']))
{
    if (validateShip())
    {
        $ship_name = $_POST['txtShipName'];
        $owner = $_SESSION['login'];

        // Hull
        $hull = $_POST['selShipHull'];
        
        $engine = NULL;
        $secondary_engine = NULL;
        $fuel_tank = NULL;
        $radar = NULL;
        $repair_droid = NULL;
        
        if(isset($_POST['selShipEngine']))
        {
            // Engine
            $engine = $_POST['selShipEngine'];
        }
        if(isset($_POST['selShipSecondaryEngine']))
        {
            // Secondary engine
            $secondary_engine = $_POST['selShipSecondaryEngine'];
        }
        if(isset($_POST['selShipFuelTank']))
        {
            // Fuel tank
            $fuel_tank = $_POST['selShipFuelTank'];
        }
        if(isset($_POST['selShipRadar']))
        {
            // Radar
            $radar = $_POST['selShipRadar'];
        }
        if(isset($_POST['selShipRepairDroid']))
        {
            // Repair droid
            $repair_droid = $_POST['selShipRepairDroid'];
        }

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
?>

<html>
    <head>
        <title>Spaceship smithy</title>
        <link rel="stylesheet" href="style/my_style.css">
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/jq_select.js"></script>
    </head>
    <body>
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
                    <select id="selShipHull" name="selShipHull" class="select-multi" size="1" onchange="HullChanged()">
                        <option value=""> </option>
                        <?php foreach ($hulls as $cur_hull) : ?>
                            <option data-path="images/Hulls/<?= $cur_hull['name']?>/1.png" value="<?= $cur_hull['name']?>" <?= (isset($selShipHull) && $selShipHull == $cur_hull['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_hull['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br>
                    Engine:
                    <select id="selShipEngine" name="selShipEngine" class="select-multi" size="1" onchange="EngineChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($engines as $cur_engine) : ?>
                            <option data-path="images/Engines/<?= $cur_engine['name']?>/1.png" value="<?= $cur_engine['name']?>" <?= (isset($selShipEngine) && $selShipEngine == $cur_engine['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_engine['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Secondary engines:
                    <select id="selShipSecondaryEngine" name="selShipSecondaryEngine" class="select-multi" size="1" onchange="SecondaryEngineChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($secondary_engines as $cur_secondary_engine) : ?>
                            <option data-path="images/Secondary engines/<?= $cur_secondary_engine['name']?>/1.png" value="<?= $cur_secondary_engine['name']?>" <?= (isset($selShipSecondaryEngine) && $selShipSecondaryEngine == $cur_secondary_engine['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_secondary_engine['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Fuel Tank:
                    <select id="selShipFuelTank" name="selShipFuelTank" class="select-multi" size="1" onchange="FuelTankChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($fuel_tanks as $cur_fuel_tank) : ?>
                            <option data-path="images/Fuel tanks/<?= $cur_fuel_tank['name']?>/1.png" value="<?= $cur_fuel_tank['name']?>" <?= (isset($selShipFuelTank) && $selShipFuelTank == $cur_fuel_tank['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_fuel_tank['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Radar:
                    <select id="selShipRadar" name="selShipRadar" class="select-multi" size="1" onchange="RadarChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($radars as $cur_radar) : ?>
                            <option data-path="images/Radars/<?= $cur_radar['name']?>/1.png" value="<?= $cur_radar['name']?>" <?= (isset($selShipRadar) && $selShipRadar == $cur_radar['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_radar['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Repair droid:
                    <select id="selShipRepairDroid" name="selShipRepairDroid" class="select-multi" size="1" onchange="RepairDroidChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($repair_droids as $cur_repair_droid) : ?>
                            <option data-path="images/Repair droids/<?= $cur_repair_droid['name']?>/1.png" value="<?= $cur_repair_droid['name']?>" <?= (isset($selShipRepairDroid) && $selShipRepairDroid == $cur_repair_droid['name']) ? " selected=\"selected\"" : "" ?>> <?= $cur_repair_droid['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                </td>
                <td class="center_col">
                    <div class='circle-container'>
                        <c href='#' class='center'>
                            <div id="ship_hull_cell" class="empty_hull_background">
                                <img id="ship_hull" src="images/Icons/ok.png" class="hull_image">
                            </div>
                        </a>

                        <a href='#' class='deg250'> <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg270'> <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg290'> <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg260'> <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg280'> <img src="images/stub.jpg"> </a>

                        <a href='#' class='deg330'>
                            <div id="ship_radar_cell" class="blocked_module_background">
                                <img id="ship_radar" src="images/Icons/delete.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg30'>  <img src="images/stub.jpg"> </a>

                        <a href='#' class='deg70'>  <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg90'>  <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg110'>
                            <div id="ship_repair_droid_cell" class="blocked_module_background">
                                <img id="ship_repair_droid" src="images/Icons/delete.png" class="module_image"> 
                            </div>
                        </a>
                        
                        <a href='#' class='deg150'>
                            <div id="ship_fuel_tank_cell" class="blocked_module_background">
                                <img id="ship_fuel_tank" src="images/Icons/delete.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg180'>
                            <div id="ship_secondary_engine_cell" class="blocked_module_background">
                                <img id="ship_secondary_engine" src="images/Icons/delete.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg210'>
                            <div id="ship_engine_cell" class="blocked_module_background">
                                <img id="ship_engine" src="images/Icons/delete.png" class="module_image"> 
                            </div>
                        </a>
                    </div> 
                </td>
                <td class="right_col">
                    Spaceship parameters:
                    <br/>
                    <br>
                    Capacity: <input type="text" id="txtFreeCapacity" value="0" style="margin-top: 0.2em" readonly="true">
                    / <input type="text" id="txtFullCapacity" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    <br/>
                    Hp: <input type="text" id="txtHp" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Speed: <input type="text" id="txtSpeed" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Maneuverability: <input type="text" id="txtManeuverability" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Fuel tank volume: <input type="text" id="txtFuelTankVolume" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Radar action radius: <input type="text" id="txtRadarActionRadius" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Health recovery: <input type="text" id="txtHealthRecovery" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    <br/>
                    Cost: <input type="text" id="txtCost" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    <br/>
                    <br/>
                    <!-- Hidden fields -->
                    <br/>
                    <div id="HullParameters">
                        <input type="hidden" id="txtHullHp" value="0" readonly="true">
                        <input type="hidden" id="txtHullManeuverability" value="0" readonly="true">
                        <input type="hidden" id="txtHullCapacity" value="0" readonly="true">
                        <input type="hidden" id="txtHullCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <br/>
                    <div id="EngineParameters">
                        <input type="hidden" id="txtEngineSpeed" value="0" readonly="true">
                        <input type="hidden" id="txtEngineWeight" value="0" readonly="true">
                        <input type="hidden" id="txtEngineCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <br/>
                    <div id="SecondaryEngineParameters">
                        <input type="hidden" id="txtSecondaryEngineManeuverability" value="0" readonly="true">
                        <input type="hidden" id="txtSecondaryEngineWeight" value="0" readonly="true">
                        <input type="hidden" id="txtSecondaryEngineCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <br/>
                    <div id="FuelTankParameters">
                        <input type="hidden" id="txtFuelTankVolume" value="0" readonly="true">
                        <input type="hidden" id="txtFuelTankWeight" value="0" readonly="true">
                        <input type="hidden" id="txtFuelTankCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <br/>
                    <div id="RadarParameters">
                        <input type="hidden" id="txtRadarActionRadius" value="0" readonly="true">
                        <input type="hidden" id="txtRadarWeight" value="0" readonly="true">
                        <input type="hidden" id="txtRadarCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <br/>
                    <div id="RepairDroidParameters">
                        <input type="hidden" id="txtRepairDroidHealthRecovery" value="0" readonly="true">
                        <input type="hidden" id="txtRepairDroidWeight" value="0" readonly="true">
                        <input type="hidden" id="txtRepairDroidCost" value="0" readonly="true">
                        <br/>
                    </div>
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
