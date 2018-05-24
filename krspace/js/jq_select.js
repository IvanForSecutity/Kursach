var hull_hp = 0;
var hull_maneuverability = 0;
var hull_capacity = 0;
var hull_cost = 0;
var hull_modules_bitmask = 0;

var engine_speed = 0;
var engine_weight = 0;
var engine_cost = 0;

var secondary_engine_maneuverability = 0;
var secondary_engine_weight = 0;
var secondary_engine_cost = 0;

var fuel_tank_volume = 0;
var fuel_tank_weight = 0;
var fuel_tank_cost = 0;

var radar_action_radius = 0;
var radar_weight = 0;
var radar_cost = 0;

var repair_droid_health_recovery = 0;
var repair_droid_weight = 0;
var repair_droid_cost = 0;



var ModulesEnum = Object.freeze({
    "engine" : 1 << 0,
    "secondary_engine" : 1 << 1,
    "fuel_tank" : 1 << 2,
    "radar" : 1 << 3,
    "stub" : 1 << 4,
    "repair_droid" : 1 << 5,
    "stub" : 1 << 6,
    "stub" : 1 << 7,
    "stub" : 1 << 8,
    "stub" : 1 << 9,
    "stub" : 1 << 10,
    "stub" : 1 << 11,
    "stub" : 1 << 12
});

function ResetModules()
{
    document.getElementById("selShipEngine").value = "";
    document.getElementById("selShipSecondaryEngine").value = "";
    document.getElementById("selShipFuelTank").value = "";
    document.getElementById("selShipRadar").value = "";
    document.getElementById("selShipRepairDroid").value = "";
    
    engine_speed = 0;
    engine_weight = 0;
    engine_cost = 0;

    secondary_engine_maneuverability = 0;
    secondary_engine_weight = 0;
    secondary_engine_cost = 0;

    fuel_tank_volume = 0;
    fuel_tank_weight = 0;
    fuel_tank_cost = 0;

    radar_action_radius = 0;
    radar_weight = 0;
    radar_cost = 0;

    repair_droid_health_recovery = 0;
    repair_droid_weight = 0;
    repair_droid_cost = 0;
}

function ApplyModulesBitmask(modules_bitmask)
{
    if((modules_bitmask & ModulesEnum.engine) != 0)
    {
        document.getElementById("selShipEngine").disabled = false;
        document.getElementById("ship_engine_cell").className = "empty_module_background";
        $('#ship_engine').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("selShipEngine").disabled = true;
        document.getElementById("ship_engine_cell").className = "blocked_module_background";
        $('#ship_engine').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.secondary_engine) != 0)
    {
        document.getElementById("selShipSecondaryEngine").disabled = false;
        document.getElementById("ship_secondary_engine_cell").className = "empty_module_background";
        $('#ship_secondary_engine').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("selShipSecondaryEngine").disabled = true;
        document.getElementById("ship_secondary_engine_cell").className = "blocked_module_background";
        $('#ship_secondary_engine').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.fuel_tank) != 0)
    {
        document.getElementById("selShipFuelTank").disabled = false;
        document.getElementById("ship_fuel_tank_cell").className = "empty_module_background";
        $('#ship_fuel_tank').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("selShipFuelTank").disabled = true;
        document.getElementById("ship_fuel_tank_cell").className = "blocked_module_background";
        $('#ship_fuel_tank').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.radar) != 0)
    {
        document.getElementById("selShipRadar").disabled = false;
        document.getElementById("ship_radar_cell").className = "empty_module_background";
        $('#ship_radar').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("selShipRadar").disabled = true;
        document.getElementById("ship_radar_cell").className = "blocked_module_background";
        $('#ship_radar').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.repair_droid) != 0)
    {
        document.getElementById("selShipRepairDroid").disabled = false;
        document.getElementById("ship_repair_droid_cell").className = "empty_module_background";
        $('#ship_repair_droid').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("selShipRepairDroid").disabled = true;
        document.getElementById("ship_repair_droid_cell").className = "blocked_module_background";
        $('#ship_repair_droid').attr('src', "images/Icons/no.png");
    }
}

function UpdateSpaceshipParameters()
{
    // Calculate parameters
    var full_capacity = parseInt(hull_capacity);
    var free_capacity = parseInt(full_capacity) - parseInt(engine_weight) - parseInt(fuel_tank_weight) - parseInt(secondary_engine_weight) - parseInt(radar_weight) - parseInt(repair_droid_weight);

    var hp = hull_hp;
    var maneuverability = parseInt(hull_maneuverability) + parseInt(secondary_engine_maneuverability);
    var speed = ((5000 + parseInt(engine_speed)) * parseInt(free_capacity)) / (parseInt(full_capacity) * parseInt(full_capacity));
    var health_recovery = repair_droid_health_recovery;
    var cost = parseInt(hull_cost) + parseInt(engine_cost) + parseInt(fuel_tank_cost) + parseInt(secondary_engine_cost) + parseInt(radar_cost) + parseInt(repair_droid_cost);

    // Fill parameters
    document.getElementById("txtFreeCapacity").value = free_capacity;
    document.getElementById("txtFullCapacity").value = full_capacity;
 
    document.getElementById("txtHp").value = hp;
    document.getElementById("txtSpeed").value = speed;
    document.getElementById("txtManeuverability").value = maneuverability;
    document.getElementById("txtFuelTankVolume").value = fuel_tank_volume;
    document.getElementById("txtRadarActionRadius").value = radar_action_radius;
    document.getElementById("txtHealthRecovery").value = health_recovery;

    document.getElementById("txtCost").value = cost;
}

function HullChanged()
{
    // If hull was chosen
    if (document.getElementById("selShipHull").value != "")
    {
        // Change hull cell
        document.getElementById("ship_hull_cell").className = "hull_background";

        // Change hull picture
        $('#ship_hull').attr('src', $('#selShipHull option:selected').attr('data-path'));

        var hull_name = document.getElementById("selShipHull").value;

        // Get hull parameters
        var ajax_request = "hull_name=" + hull_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_ship_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtHullHp').val(data.hp);
                $('#txtHullManeuverability').val(data.maneuverability);
                $('#txtHullCapacity').val(data.capacity);
                $('#txtHullCost').val(data.cost);
                //$('#txtHullModulesBitmask').val(data.modules_bitmask);
                
                hull_hp = data.hp;
                hull_maneuverability = data.maneuverability;
                hull_capacity = data.capacity;
                hull_cost = data.cost;
                hull_modules_bitmask = data.modules_bitmask;

                ResetModules();
                ApplyModulesBitmask(hull_modules_bitmask);
                UpdateSpaceshipParameters();

                return true;
            },
            error: function() { 
                msg(errorText,"error",5000);

                return false;
            }	
        });
    }
    else
    {
        // Hull cell is empty

        document.getElementById("ship_hull_cell").className = "empty_hull_background";
        $('#ship_hull').attr('src', "images/Icons/yes.png");
        $('#txtHullHp').val(0);
        $('#txtHullManeuverability').val(0);
        $('#txtHullCapacity').val(0);
        $('#txtHullCost').val(0);
        
        hull_hp = 0;
        hull_maneuverability = 0;
        hull_capacity = 0;
        hull_cost = 0;
        hull_modules_bitmask = 0;

        ResetModules();
        ApplyModulesBitmask(hull_modules_bitmask);
        UpdateSpaceshipParameters();
    }
}

function EngineChanged()
{
    // If engine was chosen
    if (document.getElementById("selShipEngine").value != "")
    {
        // Change engine cell
        document.getElementById("ship_engine_cell").className = "module_background";

        // Change engine picture
        $('#ship_engine').attr('src', $('#selShipEngine option:selected').attr('data-path'));

        var engine_name = document.getElementById("selShipEngine").value;

        // Get engine parameters
        var ajax_request = "engine_name=" + engine_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_ship_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtEngineSpeed').val(data.speed);
                $('#txtEngineWeight').val(data.weight);
                $('#txtEngineCost').val(data.cost);
                
                engine_speed = data.speed;
                engine_weight = data.weight;
                engine_cost = data.cost;
                
                UpdateSpaceshipParameters();

                return true;
            },
            error: function() { 
                msg(errorText,"error",5000);

                return false;
            }	
        });
    }
    else
    {
        // Engine cell is empty
        
        document.getElementById("ship_engine_cell").className = "empty_module_background";
        $('#ship_engine').attr('src', "images/Icons/yes.png");
        $('#txtEngineSpeed').val(0);
        $('#txtEngineWeight').val(0);
        $('#txtEngineCost').val(0);

        engine_speed = 0;
        engine_weight = 0;
        engine_cost = 0;
        
        UpdateSpaceshipParameters();
    }
}

function SecondaryEngineChanged()
{
    // If secondary engine was chosen
    if (document.getElementById("selShipSecondaryEngine").value != "")
    {
        // Change secondary engine cell
        document.getElementById("ship_secondary_engine_cell").className = "module_background";

        // Change secondary engine picture
        $('#ship_secondary_engine').attr('src', $('#selShipSecondaryEngine option:selected').attr('data-path'));

        var secondary_engine_name = document.getElementById("selShipSecondaryEngine").value;

        // Get secondary engine parameters
        var ajax_request = "secondary_engine_name=" + secondary_engine_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_ship_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtSecondaryEngineManeuverability').val(data.maneuverability);
                $('#txtSecondaryEngineWeight').val(data.weight);
                $('#txtSecondaryEngineCost').val(data.cost);
                
                secondary_engine_maneuverability = data.maneuverability;
                secondary_engine_weight = data.weight;
                secondary_engine_cost = data.cost;

                UpdateSpaceshipParameters();

                return true;
            },
            error: function() { 
                msg(errorText,"error",5000);

                return false;
            }	
        });
    }
    else
    {
        // Secondary engine cell is empty
        
        document.getElementById("ship_secondary_engine_cell").className = "empty_module_background";
        $('#ship_secondary_engine').attr('src', "images/Icons/yes.png");
        $('#txtSecondaryEngineManeuverability').val(0);
        $('#txtSecondaryEngineWeight').val(0);
        $('#txtSecondaryEngineCost').val(0);
        
        secondary_engine_maneuverability = 0;
        secondary_engine_weight = 0;
        secondary_engine_cost = 0;
        
        UpdateSpaceshipParameters();
    }
}

function FuelTankChanged()
{
    // If fuel tank was chosen
    if (document.getElementById("selShipFuelTank").value != "")
    {
        // Change fuel tank cell
        document.getElementById("ship_fuel_tank_cell").className = "module_background";

        // Change fuel tank picture
        $('#ship_fuel_tank').attr('src', $('#selShipFuelTank option:selected').attr('data-path'));

        var fuel_tank_name = document.getElementById("selShipFuelTank").value;

        // Get fuel tank parameters
        var ajax_request = "fuel_tank_name=" + fuel_tank_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_ship_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtFuelTankVolume').val(data.volume);
                $('#txtFuelTankWeight').val(data.weight);
                $('#txtFuelTankCost').val(data.cost);
                
                fuel_tank_volume = data.volume;
                fuel_tank_weight = data.weight;
                fuel_tank_cost = data.cost;

                UpdateSpaceshipParameters();

                return true;
            },
            error: function() { 
                msg(errorText,"error",5000);

                return false;
            }	
        });
    }
    else
    {
        // Fuel tank cell is empty
        
        document.getElementById("ship_fuel_tank_cell").className = "empty_module_background";
        $('#ship_fuel_tank').attr('src', "images/Icons/yes.png");
        $('#txtFuelTankVolume').val(0);
        $('#txtFuelTankWeight').val(0);
        $('#txtFuelTankCost').val(0);
        
        fuel_tank_volume = 0;
        fuel_tank_weight = 0;
        fuel_tank_cost = 0;
        
        UpdateSpaceshipParameters();
    }
}

function RadarChanged()
{
    // If radar was chosen
    if (document.getElementById("selShipRadar").value != "")
    {
        // Change radar cell
        document.getElementById("ship_radar_cell").className = "module_background";

        // Change radar picture
        $('#ship_radar').attr('src', $('#selShipRadar option:selected').attr('data-path'));

        var radar_name = document.getElementById("selShipRadar").value;

        // Get radar parameters
        var ajax_request = "radar_name=" + radar_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_ship_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtRadarActionRadius').val(data.action_radius);
                $('#txtRadarWeight').val(data.weight);
                $('#txtRadarCost').val(data.cost);
                
                radar_action_radius = data.action_radius;
                radar_weight = data.weight;
                radar_cost = data.cost;

                UpdateSpaceshipParameters();

                return true;
            },
            error: function() { 
                msg(errorText,"error",5000);

                return false;
            }	
        });
    }
    else
    {
        // Radar cell is empty
        
        document.getElementById("ship_radar_cell").className = "empty_module_background";
        $('#ship_radar').attr('src', "images/Icons/yes.png");
        $('#txtRadarActionRadius').val(0);
        $('#txtRadarWeight').val(0);
        $('#txtRadarCost').val(0);
        
        radar_action_radius = 0;
        radar_weight = 0;
        radar_cost = 0;
        
        UpdateSpaceshipParameters();
    }
}

function RepairDroidChanged()
{
    // If repair droid was chosen
    if (document.getElementById("selShipRepairDroid").value != "")
    {
        // Change repair droid cell
        document.getElementById("ship_repair_droid_cell").className = "module_background";

        // Change repair droid picture
        $('#ship_repair_droid').attr('src', $('#selShipRepairDroid option:selected').attr('data-path'));

        var repair_droid_name = document.getElementById("selShipRepairDroid").value;

        // Get repair droid parameters
        var ajax_request = "repair_droid_name=" + repair_droid_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_ship_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtRepairDroidHealthRecovery').val(data.health_recovery);
                $('#txtRepairDroidWeight').val(data.weight);
                $('#txtRepairDroidCost').val(data.cost);
                
                repair_droid_health_recovery = data.health_recovery;
                repair_droid_weight = data.weight;
                repair_droid_cost = data.cost;

                UpdateSpaceshipParameters();

                return true;
            },
            error: function() { 
                msg(errorText,"error",5000);

                return false;
            }	
        });
    }
    else
    {
        // Repair droid cell is empty
        
        document.getElementById("ship_repair_droid_cell").className = "empty_module_background";
        $('#ship_repair_droid').attr('src', "images/Icons/yes.png");
        $('#txtRepairDroidHealthRecovery').val(0);
        $('#txtRepairDroidWeight').val(0);
        $('#txtRepairDroidCost').val(0);
        
        repair_droid_health_recovery = 0;
        repair_droid_weight = 0;
        repair_droid_cost = 0;
        
        UpdateSpaceshipParameters();
    }
}
