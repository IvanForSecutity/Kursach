<?php
//
// Crafting spaceship.
// Result saves in database in table "ships".
//

// Start the session, from which we will retrieve login and session hash
session_start();

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');

// Authorized users only!
require_once('php_functions/check_session.php');

// Connect the file with the connection parameters to the ships DB
require_once('php_functions/ships_database.php');

// Initialize variables for possible errors
$errors = array();
$errors['reg_error'] = '';

// Initialization
$txtShipName = "";

// If game starts
if(isset($_POST['btnStart']))
{
    $ship_name = $_POST['txtShipName'];
    $txtShipName = $_POST['txtShipName'];
    
    $owner = $_SESSION['login'];

    // Hull
    $hull = $_POST['selShipHull'];
        
    $engine = NULL;
    $secondary_engine = NULL;
    $fuel_tank = NULL;
    $radar = NULL;
    $repair_droid = NULL;
    $weapon_1 = NULL;
    $weapon_2 = NULL;
    $weapon_3 = NULL;
    $weapon_4 = NULL;
    $weapon_5 = NULL;
        
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
    if(isset($_POST['selShipWeapon1']))
    {
        // Weapon 1
        $weapon_1 = $_POST['selShipWeapon1'];
    }
    if(isset($_POST['selShipWeapon2']))
    {
        // Weapon 2
        $weapon_2 = $_POST['selShipWeapon2'];
    }
    if(isset($_POST['selShipWeapon3']))
    {
        // Weapon 3
        $weapon_3 = $_POST['selShipWeapon3'];
    }
    if(isset($_POST['selShipWeapon4']))
    {
        // Weapon 4
        $weapon_4 = $_POST['selShipWeapon4'];
    }
    if(isset($_POST['selShipWeapon5']))
    {
        // Weapon 5
        $weapon_5 = $_POST['selShipWeapon5'];
    }

    // Call the registration function
    $reg = registerNewShip($ship_name, $owner, $hull, $engine, $fuel_tank, $secondary_engine, $radar, $repair_droid, $weapon_1, $weapon_2, $weapon_3, $weapon_4, $weapon_5);

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
        $errors['reg_error'] = $reg;
    }
}

// Load ships modules
$hulls = loadHulls();
$engines = loadEngines();
$fuel_tanks = loadFuelTanks();
$secondary_engines = loadSecondaryEngines();
$radars = loadRadars();
$repair_droids = loadRepairDroids();
$weapons = loadWeapons();
?>

<html>
    <head>
        <title>Spaceship smithy</title>
        <link rel="stylesheet" href="style/page_style.css">
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/js_crafter.js"></script>
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
        
        <!-- Block for displaying error messages -->
        <div style="align-content: center; text-align: center;">
            <div class="error" id="divNameError"> </div>
            <div class="error" id="divHullError"> </div>
            <div class="error" id="divEngineError"> </div>
            <div class="error" id="divFuelTankError"> </div>
            <div class="error" id="divOverweightError"> </div>
            <div class="error" id="divRegistrationError" style="display: <?php echo $errors['reg_error'] ? 'inline-block' : 'none'; ?>;">
                <?php echo $errors['reg_error'] ? $errors['reg_error'] : ''; ?>
            </div>
        </div>

        <br/>
        <br/>
        
        <form action="" method="POST" id="frmCrafter">
            <table class="three_columns">
            <tr>
                <td>
                    Spaceship modules:
                    <br>
                    <br/>
                    Ship name: <input type="text" id="txtShipName" name="txtShipName" value="<?php echo $txtShipName;?>" style="margin-top: 0.2em">
                    <br>
                    <br>
                    Hull:
                    <select id="selShipHull" name="selShipHull" class="select-multi" size="1" onchange="HullChanged()">
                        <option value=""> </option>
                        <?php foreach ($hulls as $cur_hull) : ?>
                            <option data-path="<?= $cur_hull['image']?>1.png" value="<?= $cur_hull['name']?>"> <?= $cur_hull['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br>
                    Engine:
                    <select id="selShipEngine" name="selShipEngine" class="select-multi" size="1" onchange="EngineChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($engines as $cur_engine) : ?>
                            <option data-path="<?= $cur_engine['image']?>1.png" value="<?= $cur_engine['name']?>"> <?= $cur_engine['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Secondary engines:
                    <select id="selShipSecondaryEngine" name="selShipSecondaryEngine" class="select-multi" size="1" onchange="SecondaryEngineChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($secondary_engines as $cur_secondary_engine) : ?>
                            <option data-path="<?= $cur_secondary_engine['image']?>1.png" value="<?= $cur_secondary_engine['name']?>"> <?= $cur_secondary_engine['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Fuel Tank:
                    <select id="selShipFuelTank" name="selShipFuelTank" class="select-multi" size="1" onchange="FuelTankChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($fuel_tanks as $cur_fuel_tank) : ?>
                            <option data-path="<?= $cur_fuel_tank['image']?>1.png" value="<?= $cur_fuel_tank['name']?>"> <?= $cur_fuel_tank['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Radar:
                    <select id="selShipRadar" name="selShipRadar" class="select-multi" size="1" onchange="RadarChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($radars as $cur_radar) : ?>
                            <option data-path="<?= $cur_radar['image']?>1.png" value="<?= $cur_radar['name']?>"> <?= $cur_radar['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Repair droid:
                    <select id="selShipRepairDroid" name="selShipRepairDroid" class="select-multi" size="1" onchange="RepairDroidChanged()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($repair_droids as $cur_repair_droid) : ?>
                            <option data-path="<?= $cur_repair_droid['image']?>1.png" value="<?= $cur_repair_droid['name']?>"> <?= $cur_repair_droid['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Weapon 1:
                    <select id="selShipWeapon1" name="selShipWeapon1" class="select-multi" size="1" onchange="Weapon1Changed()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($weapons as $cur_weapon) : ?>
                            <option data-path="<?= $cur_weapon['image']?>1.png" value="<?= $cur_weapon['name']?>"> <?= $cur_weapon['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Weapon 2:
                    <select id="selShipWeapon2" name="selShipWeapon2" class="select-multi" size="1" onchange="Weapon2Changed()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($weapons as $cur_weapon) : ?>
                            <option data-path="<?= $cur_weapon['image']?>1.png" value="<?= $cur_weapon['name']?>"> <?= $cur_weapon['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Weapon 3:
                    <select id="selShipWeapon3" name="selShipWeapon3" class="select-multi" size="1" onchange="Weapon3Changed()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($weapons as $cur_weapon) : ?>
                            <option data-path="<?= $cur_weapon['image']?>1.png" value="<?= $cur_weapon['name']?>"> <?= $cur_weapon['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Weapon 4:
                    <select id="selShipWeapon4" name="selShipWeapon4" class="select-multi" size="1" onchange="Weapon4Changed()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($weapons as $cur_weapon) : ?>
                            <option data-path="<?= $cur_weapon['image']?>1.png" value="<?= $cur_weapon['name']?>"> <?= $cur_weapon['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                    Weapon 5:
                    <select id="selShipWeapon5" name="selShipWeapon5" class="select-multi" size="1" onchange="Weapon5Changed()" disabled="true">
                        <option value=""> </option>
                        <?php foreach ($weapons as $cur_weapon) : ?>
                            <option data-path="<?= $cur_weapon['image']?>1.png" value="<?= $cur_weapon['name']?>"> <?= $cur_weapon['name']?> </option>
                        <?php endforeach ?>
                    </select>
                    <br/>
                </td>
                <td class="center_col">
                    <div class='circle-container'>
                        <c href='#' class='center'>
                            <div id="ship_hull_cell" class="empty_hull_background">
                                <img id="ship_hull" src="images/Icons/yes.png" class="hull_image">
                            </div>
                        </a>

                        <a href='#' class='deg250'>
                            <div id="ship_weapon_1_cell" class="blocked_module_background">
                                <img id="ship_weapon_1" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg270'>
                            <div id="ship_weapon_2_cell" class="blocked_module_background">
                                <img id="ship_weapon_2" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg290'>
                            <div id="ship_weapon_3_cell" class="blocked_module_background">
                                <img id="ship_weapon_3" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg260'>
                            <div id="ship_weapon_4_cell" class="blocked_module_background">
                                <img id="ship_weapon_4" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg280'>
                            <div id="ship_weapon_5_cell" class="blocked_module_background">
                                <img id="ship_weapon_5" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>

                        <a href='#' class='deg330'>
                            <div id="ship_radar_cell" class="blocked_module_background">
                                <img id="ship_radar" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg30'>  <img src="images/stub.jpg"> </a>

                        <a href='#' class='deg70'>  <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg90'>  <img src="images/stub.jpg"> </a>
                        <a href='#' class='deg110'>
                            <div id="ship_repair_droid_cell" class="blocked_module_background">
                                <img id="ship_repair_droid" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>
                        
                        <a href='#' class='deg150'>
                            <div id="ship_fuel_tank_cell" class="blocked_module_background">
                                <img id="ship_fuel_tank" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg180'>
                            <div id="ship_secondary_engine_cell" class="blocked_module_background">
                                <img id="ship_secondary_engine" src="images/Icons/no.png" class="module_image"> 
                            </div>
                        </a>
                        <a href='#' class='deg210'>
                            <div id="ship_engine_cell" class="blocked_module_background">
                                <img id="ship_engine" src="images/Icons/no.png" class="module_image"> 
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
                    <br/> <br/>
                    <div id="Weapon1Parameters">
                        Weapon 1. <br/>
                        Type: <input id="txtWeapon1Type" value="0" readonly="true"> <br/>
                        Damage: <input id="txtWeapon1Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input id="txtWeapon1Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input id="txtWeapon1RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input id="txtWeapon1RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon1Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon1Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="Weapon2Parameters">
                        Weapon 2. <br/>
                        Type: <input id="txtWeapon2Type" value="0" readonly="true"> <br/>
                        Damage: <input id="txtWeapon2Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input id="txtWeapon2Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input id="txtWeapon2RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input id="txtWeapon2RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon2Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon2Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="Weapon3Parameters">
                        Weapon 3. <br/>
                        Type: <input id="txtWeapon3Type" value="0" readonly="true"> <br/>
                        Damage: <input id="txtWeapon3Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input id="txtWeapon3Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input id="txtWeapon3RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input id="txtWeapon3RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon3Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon3Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="Weapon4Parameters">
                        Weapon 4. <br/>
                        Type: <input id="txtWeapon4Type" value="0" readonly="true"> <br/>
                        Damage: <input id="txtWeapon4Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input id="txtWeapon4Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input id="txtWeapon4RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input id="txtWeapon4RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon4Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon4Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="Weapon5Parameters">
                        Weapon 5. <br/>
                        Type: <input id="txtWeapon5Type" value="0" readonly="true"> <br/>
                        Damage: <input id="txtWeapon5Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input id="txtWeapon5Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input id="txtWeapon5RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input id="txtWeapon5RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon5Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon5Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <br/>
                    <br/>
                    Cost: <input type="text" id="txtCost" value="0" style="margin-top: 0.2em" readonly="true">

                    <!-- Hidden fields -->

                    <div id="HullParameters">
                        <input type="hidden" id="txtHullHp" value="0" readonly="true">
                        <input type="hidden" id="txtHullManeuverability" value="0" readonly="true">
                        <input type="hidden" id="txtHullCapacity" value="0" readonly="true">
                        <input type="hidden" id="txtHullCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="EngineParameters">
                        <input type="hidden" id="txtEngineSpeed" value="0" readonly="true">
                        <input type="hidden" id="txtEngineWeight" value="0" readonly="true">
                        <input type="hidden" id="txtEngineCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="SecondaryEngineParameters">
                        <input type="hidden" id="txtSecondaryEngineManeuverability" value="0" readonly="true">
                        <input type="hidden" id="txtSecondaryEngineWeight" value="0" readonly="true">
                        <input type="hidden" id="txtSecondaryEngineCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="FuelTankParameters">
                        <input type="hidden" id="txtFuelTankVolume" value="0" readonly="true">
                        <input type="hidden" id="txtFuelTankWeight" value="0" readonly="true">
                        <input type="hidden" id="txtFuelTankCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="RadarParameters">
                        <input type="hidden" id="txtRadarActionRadius" value="0" readonly="true">
                        <input type="hidden" id="txtRadarWeight" value="0" readonly="true">
                        <input type="hidden" id="txtRadarCost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="RepairDroidParameters">
                        <input type="hidden" id="txtRepairDroidHealthRecovery" value="0" readonly="true">
                        <input type="hidden" id="txtRepairDroidWeight" value="0" readonly="true">
                        <input type="hidden" id="txtRepairDroidCost" value="0" readonly="true">
                        <br/>
                    </div>
                </td>
            </tr>
            </table>

            <div style="text-align: center; padding-top: 50px;">
                <input type="submit" name="btnStart" value="Start" style="margin-top: 0.2em" ><br>
            </div>
        </form>
    </body>
</html>
