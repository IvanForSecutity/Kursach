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
    $hull = $_POST['txtHullName'];

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

    if(isset($_POST['txtEngineName']))
    {
        // Engine
        $engine = $_POST['txtEngineName'];
    }
    if(isset($_POST['txtSecondaryEngineName']))
    {
        // Secondary engine
        $secondary_engine = $_POST['txtSecondaryEngineName'];
    }
    if(isset($_POST['txtFuelTankName']))
    {
        // Fuel tank
        $fuel_tank = $_POST['txtFuelTankName'];
    }
    if(isset($_POST['txtRadarName']))
    {
        // Radar
        $radar = $_POST['txtRadarName'];
    }
    if(isset($_POST['txtRepairDroidName']))
    {
        // Repair droid
        $repair_droid = $_POST['txtRepairDroidName'];
    }
    if(isset($_POST['txtMagneticGripName']))
    {
        // Magnetic grip
        $magnetic_grip = $_POST['txtMagneticGripName'];
    }
    if(isset($_POST['txtWeapon1Name']))
    {
        // Weapon 1
        $weapon_1 = $_POST['txtWeapon1Name'];
    }
    if(isset($_POST['txtWeapon2Name']))
    {
        // Weapon 2
        $weapon_2 = $_POST['txtWeapon2Name'];
    }
    if(isset($_POST['txtWeapon3Name']))
    {
        // Weapon 3
        $weapon_3 = $_POST['txtWeapon3Name'];
    }
    if(isset($_POST['txtWeapon4Name']))
    {
        // Weapon 4
        $weapon_4 = $_POST['txtWeapon4Name'];
    }
    if(isset($_POST['txtWeapon5Name']))
    {
        // Weapon 5
        $weapon_5 = $_POST['txtWeapon5Name'];
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

        <script type="text/javascript" src="js/js_search.js"></script>

        <link rel="stylesheet" href="style/crafter_style.css">

        <script> Resize(); </script>
    </head>
    <body class="crafter_body" onresize="Resize()" bgcolor="#eafff7">
        <script>
            function Resize()
            {
              var resize_koef = window.innerWidth / 1920;
              var new_text_size = (28*(resize_koef)).toFixed(0);

              document.getElementById("divShipModules").style["fontSize"] = new_text_size;
              document.getElementById("divShipModulesTitle").style["fontSize"] = new_text_size;

              document.getElementById("divHullsPane").style["fontSize"] = new_text_size;

              document.getElementById("divCircleContainer").style["fontSize"] = new_text_size;

              document.getElementById("divShipParametersTitle").style["fontSize"] = new_text_size;
              document.getElementById("divShipParameters").style["fontSize"] = new_text_size;
            }
        </script>
        <div>
          <button id="hangar_button" class="hangar_button_up" onclick="window.location.href='hangar.php'"><span>To hangar</span></button>
          <button id="logout_button" style="float: right;" class="hangar_button_up" onclick="window.location.href='logout.php'"><span>Log Out</span></button>
        </div>
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

        <form action="" method="POST" id="frmCrafter" >
          <div style="width:99%;display:flex;">
            <div style="display: inline-block;width:33%;float:top">
              <div id="divShipModules" class="ship_modules">
                  <div id="divShipModulesTitle" class="ship_modules_title"> Spaceship modules </div>
                  <br>
                  <br/>
                  Ship name: <input type="text" id="txtShipName" name="txtShipName" value="<?php echo $txtShipName;?>" style="width: 75%;">
                  <br>
                  <br>
                  <div style="border: 1px solid #0a6f4d;margin:5px;">
                  <div style="width:100%;">
                  <ul class="tabs">
                      <li><a href="#">Hulls</a></li>
                      <li><a href="#" >Engines</a></li>
                      <li><a href="#" >Secondary engines</a></li>
                      <li><a href="#">Fuel tanks</a></li>
                      <li><a href="#" >Radars</a></li>
                      <li><a href="#" >Repair droids</a></li>
                      <li><a href="#">Magnetic grips</a></li>
                      <li><a href="#" >Weapons</a></li>
                  </ul>
                  </div>

                  <!-- TODO: Исправить верхнюю границу панельки, которая идёт сразу после первого ряда табов. -->
                  <!-- TODO: Исправить перетаскивание установленных модулей из центра. -->
                  <!-- TODO: Перетаскивать модули за квадраты, а не картинки. -->
                  <!-- tab "panes" -->
                  <div class="panes">
                      <div id="divHullsPane" class="panes_div"><h2>Hulls</h2>
                          <p>
                              <!-- TODO: Поиск по доступным модулям... -->
                              <!-- Search -->
                              <div class="main_search_field">
                                  <input type="text" id="txtHullSearchString" class="main_search_string">
                                  <input type="button" name="btnHullSearch" value="Search" class="login_button" onclick="SearchHulls()"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Hp </label>
                                  <input type="text" id="txtHullHpFrom" placeholder="from" class="small_input"> <input type="text" id="txtHullHpTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label  class="small_input"> Maneuverability </label>
                                  <input type="text" id="txtHullManeuverabilityFrom" placeholder="from" class="small_input"> <input type="text" id="txtHullManeuverabilityTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Capacity </label>
                                  <input type="text" id="txtHullCapacityFrom" placeholder="from" class="small_input"> <input type="text" id="txtHullCapacityTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Cost </label>
                                  <input type="text" id="txtHullCostFrom" placeholder="from" class="small_input"> <input type="text" id="txtHullCostTo" placeholder="to" class="small_input"> <br/>
                              </div>

                              <br/><br/>

                              <div id="divAvailableHulls" class="container">
                                  <table class="parameters_table" >
                                    <thead>
                                      <tr>
                                          <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach ($hulls as $cur_hull) : ?>
                                    <tr>
                                        <td>
                                            <div class='available-container'>
                                                <div class="available_module_background">
                                                    <img id="<?= "imgShipHull".$cur_hull['name']?>" src="<?= $cur_hull['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragHull(event)">
                                                </div>
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

                                    </tbody>

                                  </table>
                              </div>
                          </p>
                      </div>

                      <div class="panes_div"><h2>Engines</h2>
                          <p>
                              <!-- Search -->
                              <div class="main_search_field">
                                  <input type="text" id="txtEngineSearchString" class="main_search_string">
                                  <input type="button" name="btnEngineSearch" value="Search" class="login_button" onclick="SearchEngines()"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Speed </label>
                                  <input type="text" id="txtEngineSpeedFrom" placeholder="from" class="small_input"> <input type="text" id="txtEngineSpeedTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Weight </label>
                                  <input type="text" id="txtEngineWeightFrom" placeholder="from" class="small_input"> <input type="text" id="txtEngineWeightTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Cost </label>
                                  <input type="text" id="txtEngineCostFrom" placeholder="from" class="small_input"> <input type="text" id="txtEngineCostTo" placeholder="to" class="small_input"> <br/>
                              </div>

                              <br/><br/>

                              <div id="divAvailableEngines" class="container">
                                  <table class="parameters_table">
                                      <tr>
                                          <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                      </tr>

                                      <?php foreach ($engines as $cur_engine) : ?>
                                      <tr>
                                          <td>
                                              <div class='available-container'>
                                                  <div class="available_module_background">
                                                      <img id="<?= "imgShipEngine".$cur_engine['name']?>" src="<?= $cur_engine['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragEngine(event)">
                                                  </div>
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

                      <div class="panes_div"><h2>Secondary engines</h2>
                          <p>
                              <!-- Search -->
                              <div class="main_search_field">
                                  <input type="text" id="txtSecondaryEngineSearchString" class="main_search_string">
                                  <input type="button" name="btnSecondaryEngineSearch" value="Search" class="login_button" onclick="SearchSecondaryEngines()"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Maneuverability </label>
                                  <input type="text" id="txtSecondaryEngineManeuverabilityFrom" placeholder="from" class="small_input"> <input type="text" id="txtSecondaryEngineManeuverabilityTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Weight </label>
                                  <input type="text" id="txtSecondaryEngineWeightFrom" placeholder="from" class="small_input"> <input type="text" id="txtSecondaryEngineWeightTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Cost </label>
                                  <input type="text" id="txtSecondaryEngineCostFrom" placeholder="from" class="small_input"> <input type="text" id="txtSecondaryEngineCostTo" placeholder="to" class="small_input"> <br/>
                              </div>

                              <br/><br/>

                              <div id="divAvailableSecondaryEngines" class="container">
                                  <table class="parameters_table">
                                      <tr>
                                          <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                      </tr>

                                      <?php foreach ($secondary_engines as $cur_secondary_engine) : ?>
                                      <tr>
                                          <td>
                                              <div class='available-container'>
                                                  <div class="available_module_background">
                                                      <img id="<?= "imgShipSecondaryEngine".$cur_secondary_engine['name']?>" src="<?= $cur_secondary_engine['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragSecondaryEngine(event)">
                                                  </div>
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

                      <div class="panes_div"><h2>Fuel tanks</h2>
                          <p>
                              <!-- Search -->
                              <div class="main_search_field">
                                  <input type="text" id="txtFuelTankSearchString" class="main_search_string">
                                  <input type="button" name="btnFuelTankSearch" value="Search" class="login_button" onclick="SearchFuelTanks()"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Volume </label>
                                  <input type="text" id="txtFuelTankVolumeFrom" placeholder="from" class="small_input"> <input type="text" id="txtFuelTankVolumeTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Weight </label>
                                  <input type="text" id="txtFuelTankWeightFrom" placeholder="from" class="small_input"> <input type="text" id="txtFuelTankWeightTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Cost </label>
                                  <input type="text" id="txtFuelTankCostFrom" placeholder="from" class="small_input"> <input type="text" id="txtFuelTankCostTo" placeholder="to" class="small_input"> <br/>
                              </div>

                              <br/><br/>

                              <div id="divAvailableFuelTanks" class="container">
                                  <table class="parameters_table">
                                      <tr>
                                          <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                      </tr>

                                      <?php foreach ($fuel_tanks as $cur_fuel_tank) : ?>
                                      <tr>
                                          <td>
                                              <div class='available-container'>
                                                  <div class="available_module_background">
                                                      <img id="<?= "imgShipFuelTank".$cur_fuel_tank['name']?>" src="<?= $cur_fuel_tank['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragFuelTank(event)">
                                                  </div>
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

                      <div class="panes_div"><h2>Radars</h2>
                          <p>
                              <!-- Search -->
                              <div class="main_search_field">
                                  <input type="text" id="txtRadarSearchString" class="main_search_string">
                                  <input type="button" name="btnRadarSearch" value="Search" class="login_button" onclick="SearchRadars()"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Action radius </label>
                                  <input type="text" id="txtRadarActionRadiusFrom" placeholder="from" class="small_input"> <input type="text" id="txtRadarActionRadiusTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Weight </label>
                                  <input type="text" id="txtRadarWeightFrom" placeholder="from" class="small_input"> <input type="text" id="txtRadarWeightTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Cost </label>
                                  <input type="text" id="txtRadarCostFrom" placeholder="from" class="small_input"> <input type="text" id="txtRadarCostTo" placeholder="to" class="small_input"> <br/>
                              </div>

                              <br/><br/>

                              <div id="divAvailableRadars" class="container">
                                  <table class="parameters_table">
                                      <tr>
                                          <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                      </tr>

                                      <?php foreach ($radars as $cur_radar) : ?>
                                      <tr>
                                          <td>
                                              <div class='available-container'>
                                                  <div class="available_module_background">
                                                      <img id="<?= "imgShipRadar".$cur_radar['name']?>" src="<?= $cur_radar['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragRadar(event)">
                                                  </div>
                                              </div>
                                          </td>
                                          <td>
                                              <?= $cur_radar['name']?>
                                          </td>
                                          <td class="wide_col">
                                              Action radius: <?= $cur_radar['action_radius']?> <br/>
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

                      <div class="panes_div"><h2>Repair droids</h2>
                          <p>
                              <!-- Search -->
                              <div class="main_search_field">
                                  <input type="text" id="txtRepairDroidSearchString" class="main_search_string">
                                  <input type="button" name="btnRepairDroidSearch" value="Search" class="login_button" onclick="SearchRepairDroids()"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Health recovery </label>
                                  <input type="text" id="txtRepairDroidHealthRecoveryFrom" placeholder="from" class="small_input"> <input type="text" id="txtRepairDroidHealthRecoveryTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Weight </label>
                                  <input type="text" id="txtRepairDroidWeightFrom" placeholder="from" class="small_input"> <input type="text" id="txtRepairDroidWeightTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Cost </label>
                                  <input type="text" id="txtRepairDroidCostFrom" placeholder="from" class="small_input"> <input type="text" id="txtRepairDroidCostTo" placeholder="to" class="small_input"> <br/>
                              </div>

                              <br/><br/>

                              <div id="divAvailableRepairDroids" class="container">
                                  <table class="parameters_table">
                                      <tr>
                                          <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                      </tr>

                                      <?php foreach ($repair_droids as $cur_repair_droid) : ?>
                                      <tr>
                                          <td>
                                              <div class='available-container'>
                                                  <div class="available_module_background">
                                                      <img id="<?= "imgShipRepairDroid".$cur_repair_droid['name']?>" src="<?= $cur_repair_droid['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragRepairDroid(event)">
                                                  </div>
                                              </div>
                                          </td>
                                          <td>
                                              <?= $cur_repair_droid['name']?>
                                          </td>
                                          <td class="wide_col">
                                              Health recovery: <?= $cur_repair_droid['health_recovery']?> <br/>
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

                      <div class="panes_div"><h2>Magnetic grips</h2>
                          <p>
                              <!-- Search -->
                              <div class="main_search_field">
                                  <input type="text" id="txtMagneticGripSearchString" class="main_search_string">
                                  <input type="button" name="btnMagneticGripSearch" value="Search" class="login_button" onclick="SearchMagneticGrips()"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Action radius </label>
                                  <input type="text" id="txtMagneticGripActionRadiusFrom" placeholder="from" class="small_input"> <input type="text" id="txtMagneticGripActionRadiusTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Carrying capacity </label>
                                  <input type="text" id="txtMagneticGripCarryingCapacityFrom" placeholder="from" class="small_input"> <input type="text" id="txtMagneticGripCarryingCapacityTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Weight </label>
                                  <input type="text" id="txtMagneticGripWeightFrom" placeholder="from" class="small_input"> <input type="text" id="txtMagneticGripWeightTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Cost </label>
                                  <input type="text" id="txtMagneticGripCostFrom" placeholder="from" class="small_input"> <input type="text" id="txtMagneticGripCostTo" placeholder="to" class="small_input"> <br/>
                              </div>

                              <br/><br/>

                              <div id="divAvailableMagneticGrips" class="container">
                                  <table class="parameters_table">
                                      <tr>
                                          <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                      </tr>

                                      <?php foreach ($magnetic_grips as $cur_magnetic_grip) : ?>
                                      <tr>
                                          <td>
                                              <div class='available-container'>
                                                  <div class="available_module_background">
                                                      <img id="<?= "imgShipMagneticGrip".$cur_magnetic_grip['name']?>" src="<?= $cur_magnetic_grip['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragMagneticGrip(event)">
                                                  </div>
                                              </div>
                                          </td>
                                          <td>
                                              <?= $cur_magnetic_grip['name']?>
                                          </td>
                                          <td class="wide_col">
                                              Action radius: <?= $cur_magnetic_grip['action_radius']?> <br/>
                                              Carrying capacity: <?= $cur_magnetic_grip['carrying_capacity']?> <br/>
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

                      <div class="panes_div"><h2>Weapons</h2>
                          <p>
                              <!-- Search -->
                              <div class="main_search_field">
                                  <input type="text" id="txtWeaponSearchString" class="main_search_string">
                                  <input type="button" name="btnWeaponSearch" value="Search" class="login_button" onclick="SearchWeapons()"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Type </label>
                                  <select id="txtWeaponType" class="small_input" size="1">
                                      <option value=""> </option>
                                      <option value="blaster"> Blaster </option>
                                      <option value="laser_weapon"> Laser weapon </option>
                                      <option value="missile_weapon"> Missile weapon </option>
                                      <option value="plasma_weapon"> Plasma weapon </option>
                                  </select>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Damage </label>
                                  <input type="text" id="txtWeaponDamageFrom" placeholder="from" class="small_input"> <input type="text" id="txtWeaponDamageTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Ammunition </label>
                                  <input type="text" id="txtWeaponAmmunitionFrom" placeholder="from" class="small_input"> <input type="text" id="txtWeaponAmmunitionTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Recharge time </label>
                                  <input type="text" id="txtWeaponRechargeTimeFrom" placeholder="from" class="small_input"> <input type="text" id="txtWeaponRechargeTimeTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Range of fire: </label>
                                  <input type="text" id="txtWeaponRangeOfFireFrom" placeholder="from" class="small_input"> <input type="text" id="txtWeaponRangeOfFireTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Weight </label>
                                  <input type="text" id="txtWeaponWeightFrom" placeholder="from" class="small_input"> <input type="text" id="txtWeaponWeightTo" placeholder="to" class="small_input"> <br/>
                              </div>
                              <div class="search_field">
                                  <label class="small_input"> Cost </label>
                                  <input type="text" id="txtWeaponCostFrom" placeholder="from" class="small_input"> <input type="text" id="txtWeaponCostTo" placeholder="to" class="small_input"> <br/>
                              </div>

                              <br/><br/>

                              <div id="divAvailableWeapons" class="container">
                                  <table class="parameters_table">
                                      <tr>
                                          <th>Img</th> <th>Name</th> <th>Parameters</th> <th>Cost</th>
                                      </tr>

                                      <?php foreach ($weapons as $cur_weapon) : ?>
                                      <tr>
                                          <td>
                                              <div class='available-container'>
                                                  <div class="available_module_background">
                                                      <img id="<?= "imgShipWeapon".$cur_weapon['name']?>" src="<?= $cur_weapon['image']."1.png"?>" class="available_module_image" draggable="true" ondragstart="dragWeapon(event)">
                                                  </div>
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
                                              Recharge time: <?= $cur_weapon['recharge_time']?> <br/>
                                              Range of fire: <?= $cur_weapon['range_of_fire']?> <br/>
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
              </div>
            </div>
            </div>

              <div style="display: inline-block;width:33%;float:center;text-align:center;">
                <div id="divCircleContainer" class='circle-container'>
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
                    <z href='#' class='deg35'>
                        <div class="blocked_module_background">
                            <img src="images/stub.jpg" class="module_image">
                        </div>
                    </z>

                    <z href='#' class='deg70'>
                        <div id="ship_magnetic_grip_cell" class="blocked_module_background" ondrop="dropMagneticGrip(event)" ondragover="allowDrop(event)">
                            <img id="ship_magnetic_grip" src="images/Icons/no.png" class="module_image" draggable="true" ondragstart="dragCurMagneticGrip(event)">
                        </div>
                        <!-- Hidden fields -->
                        <input type="hidden" id="txtMagneticGripAllowed" value="false" readonly="true">
                        <input type="hidden" id="txtMagneticGripChosen" value="false" readonly="true">
                        Magnetic grip
                    </z>
                    <z href='#' class='deg90'>
                        <div class="blocked_module_background">
                            <img src="images/stub.jpg" class="module_image">
                        </div>
                    </z>
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

                    <z href='#' class='deg90_far'>
                        <div id="ship_engine_cell" class="recycle_bin_background" ondrop="dropRecycleBin(event)" ondragover="allowDrop(event)">
                            <img src="images/Icons/recycle_bin_empty.png" class="module_image">
                        </div>
                    </z>
                </div>
              </div>

                <div style="display: inline-block;width:33%;float:top">
                  <div id="divShipParameters" class="ship_parameters">
                      <div id="divShipParametersTitle" class="ship_parameters_title"> Spaceship parameters </div>
                      <br/><br/>
                      <table class="cool_table2">
                          <tr>
                              <th>Parameter</th> <th>Value</th>
                          </tr>

                          <tr>
                              <td> Capacity </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtFreeCapacity" value="0" class="parameter_small_input" readonly="true"> /
                                      <input type="text" id="txtFullCapacity" value="0" class="parameter_small_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Hp </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtHp" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Speed </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtSpeed" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Maneuverability </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtManeuverability" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Fuel tank volume </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtFuelTankVolume" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Radar action radius </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtRadarActionRadius" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Health recovery </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtHealthRecovery" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Magnetic grip action radius </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtMagneticGripActionRadius" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Magnetic grip carrying capacity </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="text" id="txtMagneticGripCarryingCapacity" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                      </table>
                      <table id="Weapon1Parameters" class="cool_table2" style="display: none;">
                          <tr>
                              <th>Weapon 1</th> <th><input type="hidden" name="txtWeapon1Name" id="txtWeapon1Name" value="" class="weapon_name_input" readonly="true"></th>
                          </tr>
                          <tr>
                              <td> Type </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon1Type" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Damage </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon1Damage" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Ammunition </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon1Ammunition" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Recharge Time </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon1RechargeTime" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Range Of Fire </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon1RangeOfFire" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                              <div class="parameter_field">
                                  <input type="hidden" id="txtWeapon1Weight" value="0" readonly="true">
                                  <input type="hidden" id="txtWeapon1Cost" value="0" readonly="true">
                              </div>
                      </table>
                      <table id="Weapon2Parameters" class="cool_table2" style="display: none;">
                          <tr>
                              <th>Weapon 2</th> <th><input type="hidden" name="txtWeapon2Name" id="txtWeapon2Name" value="" class="weapon_name_input" readonly="true"></th>
                          </tr>
                          <tr>
                              <td> Type </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon2Type" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Damage </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon2Damage" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Ammunition </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon2Ammunition" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Recharge Time </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon2RechargeTime" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Range Of Fire </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon2RangeOfFire" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                              <div class="parameter_field">
                                  <input type="hidden" id="txtWeapon2Weight" value="0" readonly="true">
                                  <input type="hidden" id="txtWeapon2Cost" value="0" readonly="true">
                              </div>
                      </table>
                      <table id="Weapon3Parameters" class="cool_table2" style="display: none;">
                          <tr>
                              <th>Weapon 3</th> <th><input type="hidden" name="txtWeapon3Name" id="txtWeapon3Name" value="" class="weapon_name_input" readonly="true"></th>
                          </tr>
                          <tr>
                              <td> Type </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon3Type" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Damage </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon3Damage" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Ammunition </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon3Ammunition" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Recharge Time </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon3RechargeTime" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Range Of Fire </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon3RangeOfFire" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                              <div class="parameter_field">
                                  <input type="hidden" id="txtWeapon3Weight" value="0" readonly="true">
                                  <input type="hidden" id="txtWeapon3Cost" value="0" readonly="true">
                              </div>
                      </table>
                      <table id="Weapon4Parameters" class="cool_table2" style="display: none;">
                          <tr>
                              <th>Weapon 4</th> <th><input type="hidden" name="txtWeapon4Name" id="txtWeapon4Name" value="" class="weapon_name_input" readonly="true"></th>
                          </tr>
                          <tr>
                              <td> Type </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon4Type" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Damage </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon4Damage" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Ammunition </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon4Ammunition" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Recharge Time </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon4RechargeTime" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Range Of Fire </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon4RangeOfFire" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                              <div class="parameter_field">
                                  <input type="hidden" id="txtWeapon4Weight" value="0" readonly="true">
                                  <input type="hidden" id="txtWeapon4Cost" value="0" readonly="true">
                              </div>
                      </table>
                      <table id="Weapon5Parameters" class="cool_table2" style="display: none;">
                          <tr>
                              <th>Weapon 5</th> <th><input type="hidden" name="txtWeapon5Name" id="txtWeapon5Name" value="" class="weapon_name_input" readonly="true"></th>
                          </tr>
                          <tr>
                              <td> Type </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon5Type" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Damage </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon5Damage" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Ammunition </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon5Ammunition" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Recharge Time </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon5RechargeTime" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td> Range Of Fire </td>
                              <td>
                                  <div class="parameter_field">
                                      <input type="hidden" id="txtWeapon5RangeOfFire" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                              <div class="parameter_field">
                                  <input type="hidden" id="txtWeapon5Weight" value="0" readonly="true">
                                  <input type="hidden" id="txtWeapon5Cost" value="0" readonly="true">
                              </div>
                      </table>

                      <br/><br/>

                      <table class="cool_table2">
                          <tr>
                              <td> Cost </td>
                              <td >
                                  <div class="parameter_field">
                                      <input type="text" id="txtCost" value="0" class="parameter_input" readonly="true">
                                  </div>
                              </td>
                          </tr>
                      </table>

                      <!-- Hidden fields -->

                      <div id="HullParameters">
                          <input type="hidden" name="txtHullName" id="txtHullName" value="" readonly="true">
                          <input type="hidden" id="txtHullHp" value="0" readonly="true">
                          <input type="hidden" id="txtHullManeuverability" value="0" readonly="true">
                          <input type="hidden" id="txtHullCapacity" value="0" readonly="true">
                          <input type="hidden" id="txtHullCost" value="0" readonly="true">
                      </div>
                      <div id="EngineParameters">
                          <input type="hidden" name="txtEngineName" id="txtEngineName" value="" readonly="true">
                          <input type="hidden" id="txtEngineSpeed" value="0" readonly="true">
                          <input type="hidden" id="txtEngineWeight" value="0" readonly="true">
                          <input type="hidden" id="txtEngineCost" value="0" readonly="true">
                      </div>
                      <div id="SecondaryEngineParameters">
                          <input type="hidden" name="txtSecondaryEngineName" id="txtSecondaryEngineName" value="" readonly="true">
                          <input type="hidden" id="txtSecondaryEngineManeuverability" value="0" readonly="true">
                          <input type="hidden" id="txtSecondaryEngineWeight" value="0" readonly="true">
                          <input type="hidden" id="txtSecondaryEngineCost" value="0" readonly="true">
                      </div>
                      <div id="FuelTankParameters">
                          <input type="hidden" name="txtFuelTankName" id="txtFuelTankName" value="" readonly="true">
                          <input type="hidden" id="txtFuelTankVolume" value="0" readonly="true">
                          <input type="hidden" id="txtFuelTankWeight" value="0" readonly="true">
                          <input type="hidden" id="txtFuelTankCost" value="0" readonly="true">
                      </div>
                      <div id="RadarParameters">
                          <input type="hidden" name="txtRadarName" id="txtRadarName" value="" readonly="true">
                          <input type="hidden" id="txtRadarActionRadius" value="0" readonly="true">
                          <input type="hidden" id="txtRadarWeight" value="0" readonly="true">
                          <input type="hidden" id="txtRadarCost" value="0" readonly="true">
                      </div>
                      <div id="RepairDroidParameters">
                          <input type="hidden" name="txtRepairDroidName" id="txtRepairDroidName" value="" readonly="true">
                          <input type="hidden" id="txtRepairDroidHealthRecovery" value="0" readonly="true">
                          <input type="hidden" id="txtRepairDroidWeight" value="0" readonly="true">
                          <input type="hidden" id="txtRepairDroidCost" value="0" readonly="true">
                      </div>
                      <div id="MagneticGripParameters">
                          <input type="hidden" name="txtMagneticGripName" id="txtMagneticGripName" value="" readonly="true">
                          <input type="hidden" id="txtMagneticGripActionRadius" value="0" readonly="true">
                          <input type="hidden" id="txtMagneticGripCarryingCapacity" value="0" readonly="true">
                          <input type="hidden" id="txtMagneticGripWeight" value="0" readonly="true">
                          <input type="hidden" id="txtMagneticGripCost" value="0" readonly="true">
                      </div>
                  </div>
                </div>
          </div>
            <div style="text-align: center; padding-top: 50px;">
                <input type="submit" name="btnStart" value="Start" class="login_button" style="margin-top: 0.2em" ><br>
            </div>
        </form>
    </body>
</html>
