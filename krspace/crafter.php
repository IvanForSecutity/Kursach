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
    $magnetic_grip = NULL;
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
    if(isset($_POST['selShipMagneticGrip']))
    {
        // Magnetic grip
        $magnetic_grip = $_POST['selShipMagneticGrip'];
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
    $reg = registerNewShip($ship_name, $owner, $hull, $engine, $fuel_tank, $secondary_engine, $radar, $repair_droid, $magnetic_grip, $weapon_1, $weapon_2, $weapon_3, $weapon_4, $weapon_5);

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
$magnetic_grips = loadMagneticGrips();
$weapons = loadWeapons();
?>

<html>
    <head>
        <title>Spaceship smithy</title>
        <link rel="stylesheet" href="style/page_style.css">
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/js_crafter.js"></script>

        <link rel="stylesheet" href="style/tabs_style.css">
        <script type="text/javascript" src="js/jquery_tools.js"></script>
        <script type="text/javascript" src="js/js_tabs.js"></script>
        
        <script type="text/javascript" src="js/drag_and_drop.js"></script>
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

        <br/><br/><br/>
        
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
                    
                    <ul class="tabs">
                        <li><a href="#">Hulls</a></li>
                        <li><a href="#" class="w1">Engines</a></li>
                        <li><a href="#" class="w1">Secondary engines</a></li>
                        <li><a href="#">Fuel tanks</a></li>
                        <li><a href="#" class="w1">Radars</a></li>
                        <li><a href="#" class="w1">Repair droids</a></li>
                        <li><a href="#">Magnetic grips</a></li>
                        <li><a href="#" class="w1">Weapons</a></li>    
                    </ul>
                    
                    <br/><br/>

                    <!-- TODO: Исправить верхнюю границу панельки, которая идёт сразу после первого ряда табов. -->
                    <!-- TODO: Перетаскивание модулей для их выбора. -->
                    <!-- TODO: Поиск. -->
                    <!-- tab "panes" --> 
                    <div class="panes"> 
                        <div><h2>Hulls</h2> 
                            <p>
                                Available hulls.
                                <br/><br/>
                                <div class="container">
                                    <table class="four_columns" cellspacing="0">
                                        <tr>
                                            <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                        </tr>

                                        <?php foreach ($hulls as $cur_hull) : ?>
                                        <tr>
                                            <td>
                                                <div id="available_module_background">
                                                    <img id="<?= "imgShipHull".$cur_hull['name']?>" src="<?= $cur_hull['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragHull(event)">
                                                </div>
                                            </td>
                                            <td>
                                                <?= $cur_hull['name']?>
                                            </td>
                                            <td class="wide_col">
                                                Hp: <?= $cur_hull['hp']?> <br/>
                                                Maneuverability: <?= $cur_hull['maneuverability']?> <br/>
                                                Capacity: <?= $cur_hull['capacity']?>
                                            </td>
                                            <td class="last_col">
                                                <?= $cur_hull['cost']?> <br/>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </p>
                        </div>

                        <div class="les"><h2>Engines</h2> 
                            <p>
                                Available engines.
                                <br/><br/>
                                <div class="container">
                                    <table class="four_columns" cellspacing="0">
                                        <tr>
                                            <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                        </tr>

                                        <?php foreach ($engines as $cur_engine) : ?>
                                        <tr>
                                            <td>
                                                <div id="available_module_background">
                                                    <img id="<?= "imgShipEngine".$cur_engine['name']?>" src="<?= $cur_engine['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragEngine(event)">
                                                </div> 
                                            </td>
                                            <td>
                                                <?= $cur_engine['name']?>
                                            </td>
                                            <td class="wide_col">
                                                Speed: <?= $cur_engine['speed']?> <br/>
                                                Weigth: <?= $cur_engine['weight']?>
                                            </td>
                                            <td class="last_col">
                                                <?= $cur_engine['cost']?> <br/>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </p>
                        </div>

                        <div class="les"><h2>Secondary engines</h2> 
                            <p>
                                Available secondary engines.
                                <br/><br/>
                                <div class="container">
                                    <table class="four_columns" cellspacing="0">
                                        <tr>
                                            <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                        </tr>

                                        <?php foreach ($secondary_engines as $cur_secondary_engine) : ?>
                                        <tr>
                                            <td>
                                                <div id="available_module_background">
                                                    <img id="<?= "imgShipSecondaryEngine".$cur_secondary_engine['name']?>" src="<?= $cur_secondary_engine['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragSecondaryEngine(event)">
                                                </div>
                                            </td>
                                            <td>
                                                <?= $cur_secondary_engine['name']?>
                                            </td>
                                            <td class="wide_col">
                                                Maneuverability: <?= $cur_secondary_engine['maneuverability']?> <br/>
                                                Weigth: <?= $cur_secondary_engine['weight']?>
                                            </td>
                                            <td class="last_col">
                                                <?= $cur_secondary_engine['cost']?> <br/>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </p>
                        </div>

                        <div class="les"><h2>Fuel tanks</h2> 
                            <p>
                                Available fuel tanks.
                                <br/><br/>
                                <div class="container">
                                    <table class="four_columns" cellspacing="0">
                                        <tr>
                                            <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                        </tr>

                                        <?php foreach ($fuel_tanks as $cur_fuel_tank) : ?>
                                        <tr>
                                            <td>
                                                <div id="available_module_background">
                                                    <img id="<?= "imgShipFuelTank".$cur_fuel_tank['name']?>" src="<?= $cur_fuel_tank['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragFuelTank(event)">
                                                </div>
                                            </td>
                                            <td>
                                                <?= $cur_fuel_tank['name']?>
                                            </td>
                                            <td class="wide_col">
                                                Volume: <?= $cur_fuel_tank['volume']?> <br/>
                                                Weigth: <?= $cur_fuel_tank['weight']?>
                                            </td>
                                            <td class="last_col">
                                                <?= $cur_fuel_tank['cost']?> <br/>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </p>
                        </div>

                        <div class="les"><h2>Radars.</h2> 
                            <p>
                                Available radars.
                                <br/><br/>
                                <div class="container">
                                    <table class="four_columns" cellspacing="0">
                                        <tr>
                                            <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                        </tr>

                                        <?php foreach ($radars as $cur_radar) : ?>
                                        <tr>
                                            <td>
                                                <div id="available_module_background">
                                                    <img id="<?= "imgShipRadar".$cur_radar['name']?>" src="<?= $cur_radar['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragRadar(event)">
                                                </div>
                                            </td>
                                            <td>
                                                <?= $cur_radar['name']?>
                                            </td>
                                            <td class="wide_col">
                                                Action Radius: <?= $cur_radar['action_radius']?> <br/>
                                                Weigth: <?= $cur_radar['weight']?>
                                            </td>
                                            <td class="last_col">
                                                <?= $cur_radar['cost']?> <br/>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </p>
                        </div>
                        
                        <div class="les"><h2>Repair droids.</h2> 
                            <p>
                                Available repair droids.
                                <br/><br/>
                                <div class="container">
                                    <table class="four_columns" cellspacing="0">
                                        <tr>
                                            <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                        </tr>

                                        <?php foreach ($repair_droids as $cur_repair_droid) : ?>
                                        <tr>
                                            <td>
                                                <div id="available_module_background">
                                                    <img id="<?= "imgShipRepairDroid".$cur_repair_droid['name']?>" src="<?= $cur_repair_droid['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragRepairDroid(event)">
                                                </div>
                                            </td>
                                            <td>
                                                <?= $cur_repair_droid['name']?>
                                            </td>
                                            <td class="wide_col">
                                                Health Recovery: <?= $cur_repair_droid['health_recovery']?> <br/>
                                                Weigth: <?= $cur_repair_droid['weight']?>
                                            </td>
                                            <td class="last_col">
                                                <?= $cur_repair_droid['cost']?> <br/>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </p>
                        </div>
                        
                        <div class="les"><h2>Magnetic grips.</h2> 
                            <p>
                                Available magnetic grips.
                                <br/><br/>
                                <div class="container">
                                    <table class="four_columns" cellspacing="0">
                                        <tr>
                                            <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                        </tr>

                                        <?php foreach ($magnetic_grips as $cur_magnetic_grip) : ?>
                                        <tr>
                                            <td>
                                                <div id="available_module_background">
                                                    <img id="<?= "imgShipMagneticGrip".$cur_magnetic_grip['name']?>" src="<?= $cur_magnetic_grip['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragMagneticGrip(event)">
                                                </div>
                                            </td>
                                            <td>
                                                <?= $cur_magnetic_grip['name']?>
                                            </td>
                                            <td class="wide_col">
                                                Action Radius: <?= $cur_magnetic_grip['action_radius']?> <br/>
                                                Carrying Capacity: <?= $cur_magnetic_grip['carrying_capacity']?> <br/>
                                                Weigth: <?= $cur_magnetic_grip['weight']?>
                                            </td>
                                            <td class="last_col">
                                                <?= $cur_magnetic_grip['cost']?> <br/>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </p>
                        </div>
                        
                        <div class="les"><h2>Weapons.</h2> 
                            <p>
                                Available weapons.
                                <br/><br/>
                                <div class="container">
                                    <table class="four_columns" cellspacing="0">
                                        <tr>
                                            <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                        </tr>

                                        <?php foreach ($weapons as $cur_weapon) : ?>
                                        <tr>
                                            <td>
                                                <div id="available_module_background">
                                                    <img id="<?= "imgShipWeapon".$cur_weapon['name']?>" src="<?= $cur_weapon['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragWeapon(event)">
                                                </div>
                                            </td>
                                            <td>
                                                <?= $cur_weapon['name']?>
                                            </td>
                                            <td class="wide_col">
                                                Type: <?php switch ($cur_weapon['type'])
                                                {
                                                    case "blaster":
                                                        echo "Blaster";
                                                        break;
                                                    case "laser_weapon":
                                                        echo "Laser weapon";
                                                        break;
                                                    case "missile_weapon":
                                                        echo "Missile weapon";
                                                        break;
                                                    case "plasma_weapon":
                                                        echo "Plasma weapon";
                                                        break;
                                                }
                                                ?> <br/>
                                                Damage: <?= $cur_weapon['damage']?> <br/>
                                                Ammunition: <?= $cur_weapon['ammunition']?> <br/>
                                                Recharge Time: <?= $cur_weapon['recharge_time']?> <br/>
                                                Range Of Fire: <?= $cur_weapon['range_of_fire']?> <br/>
                                                Weigth: <?= $cur_weapon['weight']?>
                                            </td>
                                            <td class="last_col">
                                                <?= $cur_weapon['cost']?> <br/>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </td>
                <td class="center_col">
                    <div class='circle-container'>
                        <c href='#' class='center'>
                            <div id="ship_hull_cell" class="empty_hull_background" ondrop="dropHull(event)" ondragover="allowDrop(event)">
                                <img id="ship_hull" src="images/Icons/yes.png" class="hull_image" draggable="true" ondragstart="dragCurHull(event)">
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtHullChosen" value="false" readonly="true">
                            Hull
                        </c>

                        <z href='#' class='deg250'>
                            <div id="ship_weapon_1_cell" class="blocked_module_background" ondrop="dropWeapon1(event)" ondragover="allowDrop(event)">
                                <img id="ship_weapon_1" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurWeapon1(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtWeapon1Allowed" value="false" readonly="true">
                            <input type="hidden" id="txtWeapon1Chosen" value="false" readonly="true">
                        </z>
                        <z href='#' class='deg270'>
                            <div id="ship_weapon_2_cell" class="blocked_module_background" ondrop="dropWeapon2(event)" ondragover="allowDrop(event)">
                                <img id="ship_weapon_2" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurWeapon2(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtWeapon2Allowed" value="false" readonly="true">
                            <input type="hidden" id="txtWeapon2Chosen" value="false" readonly="true">
                            Weapons
                        </z>
                        <z href='#' class='deg290'>
                            <div id="ship_weapon_3_cell" class="blocked_module_background" ondrop="dropWeapon3(event)" ondragover="allowDrop(event)">
                                <img id="ship_weapon_3" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurWeapon3(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtWeapon3Allowed" value="false" readonly="true">
                            <input type="hidden" id="txtWeapon3Chosen" value="false" readonly="true">
                        </z>
                        <z href='#' class='deg260'>
                            <div id="ship_weapon_4_cell" class="blocked_module_background" ondrop="dropWeapon4(event)" ondragover="allowDrop(event)">
                                <img id="ship_weapon_4" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurWeapon4(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtWeapon4Allowed" value="false" readonly="true">
                            <input type="hidden" id="txtWeapon4Chosen" value="false" readonly="true">
                        </z>
                        <z href='#' class='deg280'>
                            <div id="ship_weapon_5_cell" class="blocked_module_background" ondrop="dropWeapon5(event)" ondragover="allowDrop(event)">
                                <img id="ship_weapon_5" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurWeapon5(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtWeapon5Allowed" value="false" readonly="true">
                            <input type="hidden" id="txtWeapon5Chosen" value="false" readonly="true">
                        </z>

                        <z href='#' class='deg325'>
                            <div id="ship_radar_cell" class="blocked_module_background" ondrop="dropRadar(event)" ondragover="allowDrop(event)">
                                <img id="ship_radar" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurRadar(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtRadarAllowed" value="false" readonly="true">
                            <input type="hidden" id="txtRadarChosen" value="false" readonly="true">
                            Radar
                        </z>
                        <z href='#' class='deg35'>  <img src="images/stub.jpg"> </z>

                        <z href='#' class='deg70'>
                            <div id="ship_magnetic_grip_cell" class="blocked_module_background" ondrop="dropMagneticGrip(event)" ondragover="allowDrop(event)">
                                <img id="ship_magnetic_grip" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurMagneticGrip(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtMagneticGripAllowed" value="false" readonly="true">
                            <input type="hidden" id="txtMagneticGripChosen" value="false" readonly="true">
                            Magnetic grip
                        </z>
                        <z href='#' class='deg90'>  <img src="images/stub.jpg"> </z>
                        <z href='#' class='deg110'>
                            <div id="ship_repair_droid_cell" class="blocked_module_background" ondrop="dropRepairDroid(event)" ondragover="allowDrop(event)">
                                <img id="ship_repair_droid" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurRepairDroid(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtRepairDroidAllowed" value="false" readonly="true">
                            <input type="hidden" id="txtRepairDroidChosen" value="false" readonly="true">
                            Repair droid
                        </z>
                        
                        <z href='#' class='deg145'>
                            <div id="ship_fuel_tank_cell" class="blocked_module_background" ondrop="dropFuelTank(event)" ondragover="allowDrop(event)">
                                <img id="ship_fuel_tank" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurFuelTank(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtFuelTankAllowed" value="false" readonly="true">
                            <input type="hidden" id="txtFuelTankChosen" value="false" readonly="true">
                            Fuel tank
                        </z>
                        <z href='#' class='deg180'>
                            <div id="ship_secondary_engine_cell" class="blocked_module_background" ondrop="dropSecondaryEngine(event)" ondragover="allowDrop(event)">
                                <img id="ship_secondary_engine" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurSecondaryEngine(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtSecondaryEngineAllowed" value="false" readonly="true">
                            <input type="hidden" id="txtSecondaryEngineChosen" value="false" readonly="true">
                            Secondary engine
                        </z>
                        <z href='#' class='deg215'>
                            <div id="ship_engine_cell" class="blocked_module_background" ondrop="dropEngine(event)" ondragover="allowDrop(event)">
                                <img id="ship_engine" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurEngine(event)"> 
                            </div>
                            <!-- Hidden fields -->
                            <input type="hidden" id="txtEngineAllowed" value="false" readonly="true">
                            <input type="hidden" id="txtEngineChosen" value="false" readonly="true">
                            Engine
                        </z>
                    </div>

                    <br/><br/><br/><br/><br/>
                    
                    <div id="ship_engine_cell" class="recycle_bin_background" ondrop="dropRecycleBin(event)" ondragover="allowDrop(event)">
                        <img src="images/Icons/recycle_bin_empty.png" class="module_image">
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
                    Magnetic grip action radius: <input type="text" id="txtMagneticGripActionRadius" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/>
                    Magnetic grip carrying capacity: <input type="text" id="txtMagneticGripCarryingCapacity" value="0" style="margin-top: 0.2em" readonly="true">
                    <br/> <br/>
                    <div id="Weapon1Parameters" style='display:none;'>
                        Weapon 1. <br/>
                        Type: <input type="hidden" id="txtWeapon1Type" value="0" readonly="true"> <br/>
                        Damage: <input type="hidden" id="txtWeapon1Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input type="hidden" id="txtWeapon1Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input type="hidden" id="txtWeapon1RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input type="hidden" id="txtWeapon1RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon1Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon1Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="Weapon2Parameters" style='display:none;'>
                        Weapon 2. <br/>
                        Type: <input type="hidden" id="txtWeapon2Type" value="0" readonly="true"> <br/>
                        Damage: <input type="hidden" id="txtWeapon2Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input type="hidden" id="txtWeapon2Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input type="hidden" id="txtWeapon2RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input type="hidden" id="txtWeapon2RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon2Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon2Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="Weapon3Parameters" style='display:none;'>
                        Weapon 3. <br/>
                        Type: <input type="hidden" id="txtWeapon3Type" value="0" readonly="true"> <br/>
                        Damage: <input type="hidden" id="txtWeapon3Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input type="hidden" id="txtWeapon3Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input type="hidden" id="txtWeapon3RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input type="hidden" id="txtWeapon3RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon3Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon3Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="Weapon4Parameters" style='display:none;'>
                        Weapon 4. <br/>
                        Type: <input type="hidden" id="txtWeapon4Type" value="0" readonly="true"> <br/>
                        Damage: <input type="hidden" id="txtWeapon4Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input type="hidden" id="txtWeapon4Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input type="hidden" id="txtWeapon4RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input type="hidden" id="txtWeapon4RangeOfFire" value="0" readonly="true"> <br/>
                        <input type="hidden" id="txtWeapon4Weight" value="0" readonly="true">
                        <input type="hidden" id="txtWeapon4Cost" value="0" readonly="true">
                        <br/>
                    </div>
                    <div id="Weapon5Parameters" style='display:none;'>
                        Weapon 5. <br/>
                        Type: <input type="hidden" id="txtWeapon5Type" value="0" readonly="true"> <br/>
                        Damage: <input type="hidden" id="txtWeapon5Damage" value="0" readonly="true"> <br/>
                        Ammunition: <input type="hidden" id="txtWeapon5Ammunition" value="0" readonly="true"> <br/>
                        Recharge Time: <input type="hidden" id="txtWeapon5RechargeTime" value="0" readonly="true"> <br/>
                        Range Of Fire:<input type="hidden" id="txtWeapon5RangeOfFire" value="0" readonly="true"> <br/>
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
                    </div>
                    <div id="EngineParameters">
                        <input type="hidden" id="txtEngineSpeed" value="0" readonly="true">
                        <input type="hidden" id="txtEngineWeight" value="0" readonly="true">
                        <input type="hidden" id="txtEngineCost" value="0" readonly="true">
                    </div>
                    <div id="SecondaryEngineParameters">
                        <input type="hidden" id="txtSecondaryEngineManeuverability" value="0" readonly="true">
                        <input type="hidden" id="txtSecondaryEngineWeight" value="0" readonly="true">
                        <input type="hidden" id="txtSecondaryEngineCost" value="0" readonly="true">
                    </div>
                    <div id="FuelTankParameters">
                        <input type="hidden" id="txtFuelTankVolume" value="0" readonly="true">
                        <input type="hidden" id="txtFuelTankWeight" value="0" readonly="true">
                        <input type="hidden" id="txtFuelTankCost" value="0" readonly="true">
                    </div>
                    <div id="RadarParameters">
                        <input type="hidden" id="txtRadarActionRadius" value="0" readonly="true">
                        <input type="hidden" id="txtRadarWeight" value="0" readonly="true">
                        <input type="hidden" id="txtRadarCost" value="0" readonly="true">
                    </div>
                    <div id="RepairDroidParameters">
                        <input type="hidden" id="txtRepairDroidHealthRecovery" value="0" readonly="true">
                        <input type="hidden" id="txtRepairDroidWeight" value="0" readonly="true">
                        <input type="hidden" id="txtRepairDroidCost" value="0" readonly="true">
                    </div>
                    <div id="MagneticGripParameters">
                        <input type="hidden" id="txtMagneticGripActionRadius" value="0" readonly="true">
                        <input type="hidden" id="txtMagneticGripCarryingCapacity" value="0" readonly="true">
                        <input type="hidden" id="txtMagneticGripWeight" value="0" readonly="true">
                        <input type="hidden" id="txtMagneticGripCost" value="0" readonly="true">
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
