$(document).ready(function()
{
    $('#frmCrafter').submit(function(event) { 
        if (!ValidateShip())
        {
            event.preventDefault(); 
        }
    });
});

var full_capacity = 0;
var free_capacity = 0;

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

var magnetic_grip_action_radius = 0;
var magnetic_grip_carrying_capacity = 0;
var magnetic_grip_weight = 0;
var magnetic_grip_cost = 0;

var weapon_1_type = "";
var weapon_1_damage = 0;
var weapon_1_ammunition = 0;
var weapon_1_recharge_time = 0;
var weapon_1_range_of_fire = 0;
var weapon_1_weight = 0;
var weapon_1_cost = 0;

var weapon_2_type = "";
var weapon_2_damage = 0;
var weapon_2_ammunition = 0;
var weapon_2_recharge_time = 0;
var weapon_2_range_of_fire = 0;
var weapon_2_weight = 0;
var weapon_2_cost = 0;

var weapon_3_type = "";
var weapon_3_damage = 0;
var weapon_3_ammunition = 0;
var weapon_3_recharge_time = 0;
var weapon_3_range_of_fire = 0;
var weapon_3_weight = 0;
var weapon_3_cost = 0;

var weapon_4_type = "";
var weapon_4_damage = 0;
var weapon_4_ammunition = 0;
var weapon_4_recharge_time = 0;
var weapon_4_range_of_fire = 0;
var weapon_4_weight = 0;
var weapon_4_cost = 0;

var weapon_5_type = "";
var weapon_5_damage = 0;
var weapon_5_ammunition = 0;
var weapon_5_recharge_time = 0;
var weapon_5_range_of_fire = 0;
var weapon_5_weight = 0;
var weapon_5_cost = 0;



var ModulesEnum = Object.freeze({
    "engine" : 1 << 0,
    "secondary_engine" : 1 << 1,
    "fuel_tank" : 1 << 2,
    "radar" : 1 << 3,
    "stub" : 1 << 4,
    "repair_droid" : 1 << 5,
    "stub" : 1 << 6,
    "magnetic_grip" : 1 << 7,
    "weapon_1" : 1 << 8,
    "weapon_2" : 1 << 9,
    "weapon_3" : 1 << 10,
    "weapon_4" : 1 << 11,
    "weapon_5" : 1 << 12
});

function ValidateShip()
{
    // Player should choose ship name
    var ship_name = document.getElementById("txtShipName").value;
    var error_name = (ship_name != "");
    if (error_name != true)
    {
        document.getElementById("divNameError").innerHTML = "You should choose ship name!";
    }
    else
    {
        document.getElementById("divNameError").innerHTML = "";
    }

    // Player should choose ship hull
    var ship_hull = document.getElementById("txtHullChosen").value;
    var error_hull = (ship_hull != "false");
    if (error_hull != true)
    {
        document.getElementById("divHullError").innerHTML = "You should choose ship hull!";
    }
    else
    {
        document.getElementById("divHullError").innerHTML = "";
    }
    
    // Player should choose ship engine
    var ship_engine = document.getElementById("txtEngineChosen").value;
    var error_engine = (ship_engine != "false");
    if (error_engine != true)
    {
        document.getElementById("divEngineError").innerHTML = "You should choose ship engine!";
    }
    else
    {
        document.getElementById("divEngineError").innerHTML = "";
    }
    
    // Player should choose ship fuel tank
    var ship_fuel_tank = document.getElementById("txtFuelTankChosen").value;
    var error_fuel_tank = (ship_fuel_tank != "false");
    if (error_fuel_tank != true)
    {
        document.getElementById("divFuelTankError").innerHTML = "You should choose ship fuel tank!";
    }
    else
    {
        document.getElementById("divFuelTankError").innerHTML = "";
    }

    // Ship overweight
    var error_overweight = (free_capacity >= 0);
    if (error_overweight != true)
    {
        document.getElementById("divOverweightError").innerHTML = "Ship overweight!";
    }
    else
    {
        document.getElementById("divOverweightError").innerHTML = "";
    }

    if ((error_name == true) && (error_hull == true) && (error_engine == true) && (error_fuel_tank == true) && (error_overweight == true))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function ResetModules()
{  
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
    
    magnetic_grip_action_radius = 0;
    magnetic_grip_carrying_capacity = 0;
    magnetic_grip_weight = 0;
    magnetic_grip_cost = 0;
    
    weapon_1_type = "";
    weapon_1_damage = 0;
    weapon_1_ammunition = 0;
    weapon_1_recharge_time = 0;
    weapon_1_range_of_fire = 0;
    weapon_1_weight = 0;
    weapon_1_cost = 0;
    
    weapon_2_type = "";
    weapon_2_damage = 0;
    weapon_2_ammunition = 0;
    weapon_2_recharge_time = 0;
    weapon_2_range_of_fire = 0;
    weapon_2_weight = 0;
    weapon_2_cost = 0;
    
    weapon_3_type = "";
    weapon_3_damage = 0;
    weapon_3_ammunition = 0;
    weapon_3_recharge_time = 0;
    weapon_3_range_of_fire = 0;
    weapon_3_weight = 0;
    weapon_3_cost = 0;
    
    weapon_4_type = "";
    weapon_4_damage = 0;
    weapon_4_ammunition = 0;
    weapon_4_recharge_time = 0;
    weapon_4_range_of_fire = 0;
    weapon_4_weight = 0;
    weapon_4_cost = 0;
    
    weapon_5_type = "";
    weapon_5_damage = 0;
    weapon_5_ammunition = 0;
    weapon_5_recharge_time = 0;
    weapon_5_range_of_fire = 0;
    weapon_5_weight = 0;
    weapon_5_cost = 0;
}

function ApplyModulesBitmask(modules_bitmask)
{
    if((modules_bitmask & ModulesEnum.engine) !== 0)
    {
        document.getElementById("txtEngineAllowed").value = "true";
        document.getElementById("ship_engine_cell").className = "empty_module_background";
        $('#ship_engine').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("txtEngineAllowed").value = "false";
        document.getElementById("ship_engine_cell").className = "blocked_module_background";
        $('#ship_engine').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.secondary_engine) !== 0)
    {
        document.getElementById("txtSecondaryEngineAllowed").value = "true";
        document.getElementById("ship_secondary_engine_cell").className = "empty_module_background";
        $('#ship_secondary_engine').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("txtSecondaryEngineAllowed").value = "false";
        document.getElementById("ship_secondary_engine_cell").className = "blocked_module_background";
        $('#ship_secondary_engine').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.fuel_tank) !== 0)
    {
        document.getElementById("txtFuelTankAllowed").value = "true";
        document.getElementById("ship_fuel_tank_cell").className = "empty_module_background";
        $('#ship_fuel_tank').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("txtFuelTankAllowed").value = "false";
        document.getElementById("ship_fuel_tank_cell").className = "blocked_module_background";
        $('#ship_fuel_tank').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.radar) !== 0)
    {
        document.getElementById("txtRadarAllowed").value = "true";
        document.getElementById("ship_radar_cell").className = "empty_module_background";
        $('#ship_radar').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("txtRadarAllowed").value = "false";
        document.getElementById("ship_radar_cell").className = "blocked_module_background";
        $('#ship_radar').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.repair_droid) !== 0)
    {
        document.getElementById("txtRepairDroidAllowed").value = "true";
        document.getElementById("ship_repair_droid_cell").className = "empty_module_background";
        $('#ship_repair_droid').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("txtRepairDroidAllowed").value = "false";
        document.getElementById("ship_repair_droid_cell").className = "blocked_module_background";
        $('#ship_repair_droid').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.magnetic_grip) !== 0)
    {
        document.getElementById("txtMagneticGripAllowed").value = "true";
        document.getElementById("ship_magnetic_grip_cell").className = "empty_module_background";
        $('#ship_magnetic_grip').attr('src', "images/Icons/yes.png");
    }
    else
    {
        document.getElementById("txtMagneticGripAllowed").value = "false";
        document.getElementById("ship_magnetic_grip_cell").className = "blocked_module_background";
        $('#ship_magnetic_grip').attr('src', "images/Icons/no.png");
    }
    if((modules_bitmask & ModulesEnum.weapon_1) !== 0)
    {
        document.getElementById("txtWeapon1Allowed").value = "true";
        document.getElementById("ship_weapon_1_cell").className = "empty_module_background";
        $('#ship_weapon_1').attr('src', "images/Icons/yes.png");
        
        document.getElementById("Weapon1Parameters").style = "";
        document.getElementById("txtWeapon1Name").type = "";
        document.getElementById("txtWeapon1Type").type = "";
        document.getElementById("txtWeapon1Damage").type = "";
        document.getElementById("txtWeapon1Ammunition").type = "";
        document.getElementById("txtWeapon1RechargeTime").type = "";
        document.getElementById("txtWeapon1RangeOfFire").type = "";
    }
    else
    {
        document.getElementById("txtWeapon1Allowed").value = "false";
        document.getElementById("ship_weapon_1_cell").className = "blocked_module_background";
        $('#ship_weapon_1').attr('src', "images/Icons/no.png");
        
        document.getElementById("Weapon1Parameters").style = "display:none;";
        document.getElementById("txtWeapon1Name").type = "hidden";
        document.getElementById("txtWeapon1Type").type = "hidden";
        document.getElementById("txtWeapon1Damage").type = "hidden";
        document.getElementById("txtWeapon1Ammunition").type = "hidden";
        document.getElementById("txtWeapon1RechargeTime").type = "hidden";
        document.getElementById("txtWeapon1RangeOfFire").type = "hidden";
    }
    if((modules_bitmask & ModulesEnum.weapon_2) !== 0)
    {
        document.getElementById("txtWeapon2Allowed").value = "true";
        document.getElementById("ship_weapon_2_cell").className = "empty_module_background";
        $('#ship_weapon_2').attr('src', "images/Icons/yes.png");
        
        document.getElementById("Weapon2Parameters").style = "";
        document.getElementById("txtWeapon2Name").type = "";
        document.getElementById("txtWeapon2Type").type = "";
        document.getElementById("txtWeapon2Damage").type = "";
        document.getElementById("txtWeapon2Ammunition").type = "";
        document.getElementById("txtWeapon2RechargeTime").type = "";
        document.getElementById("txtWeapon2RangeOfFire").type = "";
    }
    else
    {
        document.getElementById("txtWeapon2Allowed").value = "false";
        document.getElementById("ship_weapon_2_cell").className = "blocked_module_background";
        $('#ship_weapon_2').attr('src', "images/Icons/no.png");
        
        document.getElementById("Weapon2Parameters").style = "display:none;";
        document.getElementById("txtWeapon2Name").type = "hidden";
        document.getElementById("txtWeapon2Type").type = "hidden";
        document.getElementById("txtWeapon2Damage").type = "hidden";
        document.getElementById("txtWeapon2Ammunition").type = "hidden";
        document.getElementById("txtWeapon2RechargeTime").type = "hidden";
        document.getElementById("txtWeapon2RangeOfFire").type = "hidden";
    }
    if((modules_bitmask & ModulesEnum.weapon_3) !== 0)
    {
        document.getElementById("txtWeapon3Allowed").value = "true";
        document.getElementById("ship_weapon_3_cell").className = "empty_module_background";
        $('#ship_weapon_3').attr('src', "images/Icons/yes.png");
        
        document.getElementById("Weapon3Parameters").style = "";
        document.getElementById("txtWeapon3Name").type = "";
        document.getElementById("txtWeapon3Type").type = "";
        document.getElementById("txtWeapon3Damage").type = "";
        document.getElementById("txtWeapon3Ammunition").type = "";
        document.getElementById("txtWeapon3RechargeTime").type = "";
        document.getElementById("txtWeapon3RangeOfFire").type = "";
    }
    else
    {
        document.getElementById("txtWeapon3Allowed").value = "false";
        document.getElementById("ship_weapon_3_cell").className = "blocked_module_background";
        $('#ship_weapon_3').attr('src', "images/Icons/no.png");
        
        document.getElementById("Weapon3Parameters").style = "display:none;";
        document.getElementById("txtWeapon3Name").type = "hidden";
        document.getElementById("txtWeapon3Type").type = "hidden";
        document.getElementById("txtWeapon3Damage").type = "hidden";
        document.getElementById("txtWeapon3Ammunition").type = "hidden";
        document.getElementById("txtWeapon3RechargeTime").type = "hidden";
        document.getElementById("txtWeapon3RangeOfFire").type = "hidden";
    }
    if((modules_bitmask & ModulesEnum.weapon_4) !== 0)
    {
        document.getElementById("txtWeapon4Allowed").value = "true";
        document.getElementById("ship_weapon_4_cell").className = "empty_module_background";
        $('#ship_weapon_4').attr('src', "images/Icons/yes.png");
        
        document.getElementById("Weapon4Parameters").style = "";
        document.getElementById("txtWeapon4Name").type = "";
        document.getElementById("txtWeapon4Type").type = "";
        document.getElementById("txtWeapon4Damage").type = "";
        document.getElementById("txtWeapon4Ammunition").type = "";
        document.getElementById("txtWeapon4RechargeTime").type = "";
        document.getElementById("txtWeapon4RangeOfFire").type = "";
    }
    else
    {
        document.getElementById("txtWeapon4Allowed").value = "false";
        document.getElementById("ship_weapon_4_cell").className = "blocked_module_background";
        $('#ship_weapon_4').attr('src', "images/Icons/no.png");
        
        document.getElementById("Weapon4Parameters").style = "display:none;";
        document.getElementById("txtWeapon4Name").type = "hidden";
        document.getElementById("txtWeapon4Type").type = "hidden";
        document.getElementById("txtWeapon4Damage").type = "hidden";
        document.getElementById("txtWeapon4Ammunition").type = "hidden";
        document.getElementById("txtWeapon4RechargeTime").type = "hidden";
        document.getElementById("txtWeapon4RangeOfFire").type = "hidden";
    }
    if((modules_bitmask & ModulesEnum.weapon_5) !== 0)
    {
        document.getElementById("txtWeapon5Allowed").value = "true";
        document.getElementById("ship_weapon_5_cell").className = "empty_module_background";
        $('#ship_weapon_5').attr('src', "images/Icons/yes.png");
        
        document.getElementById("Weapon5Parameters").style = "";
        document.getElementById("txtWeapon5Name").type = "";
        document.getElementById("txtWeapon5Type").type = "";
        document.getElementById("txtWeapon5Damage").type = "";
        document.getElementById("txtWeapon5Ammunition").type = "";
        document.getElementById("txtWeapon5RechargeTime").type = "";
        document.getElementById("txtWeapon5RangeOfFire").type = "";
    }
    else
    {
        document.getElementById("txtWeapon5Allowed").value = "false";
        document.getElementById("ship_weapon_5_cell").className = "blocked_module_background";
        $('#ship_weapon_5').attr('src', "images/Icons/no.png");
        
        document.getElementById("Weapon5Parameters").style = "display:none;";
        document.getElementById("txtWeapon5Name").type = "hidden";
        document.getElementById("txtWeapon5Type").type = "hidden";
        document.getElementById("txtWeapon5Damage").type = "hidden";
        document.getElementById("txtWeapon5Ammunition").type = "hidden";
        document.getElementById("txtWeapon5RechargeTime").type = "hidden";
        document.getElementById("txtWeapon5RangeOfFire").type = "hidden";
    }
}

function UpdateSpaceshipParameters()
{
    // Calculate parameters
    full_capacity = parseInt(hull_capacity);
    free_capacity = parseInt(full_capacity)
            - parseInt(engine_weight) - parseInt(fuel_tank_weight) - parseInt(secondary_engine_weight)
            - parseInt(radar_weight)
            - parseInt(repair_droid_weight) - parseInt(magnetic_grip_weight)
            - parseInt(weapon_1_weight) - parseInt(weapon_2_weight) - parseInt(weapon_3_weight) - parseInt(weapon_4_weight) - parseInt(weapon_5_weight);

    var hp = hull_hp;
    var maneuverability = parseInt(hull_maneuverability) + parseInt(secondary_engine_maneuverability);
    var speed = (parseInt(engine_speed) / parseInt(full_capacity)) * ((parseInt(free_capacity) / parseInt(full_capacity)) + 1);
    var health_recovery = repair_droid_health_recovery;
    var cost = parseInt(hull_cost)
            + parseInt(engine_cost) + parseInt(fuel_tank_cost) + parseInt(secondary_engine_cost)
            + parseInt(radar_cost)
            + parseInt(repair_droid_cost) + parseInt(magnetic_grip_cost)
            + parseInt(weapon_1_cost) + parseInt(weapon_2_cost) + parseInt(weapon_3_cost) + parseInt(weapon_4_cost) + parseInt(weapon_5_cost);

    // Fill parameters
    document.getElementById("txtFreeCapacity").value = free_capacity;
    document.getElementById("txtFullCapacity").value = full_capacity;
 
    document.getElementById("txtHp").value = hp;
    document.getElementById("txtSpeed").value = speed;
    document.getElementById("txtManeuverability").value = maneuverability;
    document.getElementById("txtFuelTankVolume").value = fuel_tank_volume;
    document.getElementById("txtRadarActionRadius").value = radar_action_radius;
    document.getElementById("txtHealthRecovery").value = health_recovery;
    document.getElementById("txtMagneticGripActionRadius").value = magnetic_grip_action_radius;
    document.getElementById("txtMagneticGripCarryingCapacity").value = magnetic_grip_carrying_capacity;
    
    document.getElementById("txtWeapon1Type").value = weapon_1_type;
    document.getElementById("txtWeapon1Damage").value = weapon_1_damage;
    document.getElementById("txtWeapon1Ammunition").value = weapon_1_ammunition;
    document.getElementById("txtWeapon1RechargeTime").value = weapon_1_recharge_time;
    document.getElementById("txtWeapon1RangeOfFire").value = weapon_1_range_of_fire;
    document.getElementById("txtWeapon2Type").value = weapon_2_type;
    document.getElementById("txtWeapon2Damage").value = weapon_2_damage;
    document.getElementById("txtWeapon2Ammunition").value = weapon_2_ammunition;
    document.getElementById("txtWeapon2RechargeTime").value = weapon_2_recharge_time;
    document.getElementById("txtWeapon2RangeOfFire").value = weapon_2_range_of_fire;
    document.getElementById("txtWeapon3Type").value = weapon_3_type;
    document.getElementById("txtWeapon3Damage").value = weapon_3_damage;
    document.getElementById("txtWeapon3Ammunition").value = weapon_3_ammunition;
    document.getElementById("txtWeapon3RechargeTime").value = weapon_3_recharge_time;
    document.getElementById("txtWeapon3RangeOfFire").value = weapon_3_range_of_fire;
    document.getElementById("txtWeapon4Type").value = weapon_4_type;
    document.getElementById("txtWeapon4Damage").value = weapon_4_damage;
    document.getElementById("txtWeapon4Ammunition").value = weapon_4_ammunition;
    document.getElementById("txtWeapon4RechargeTime").value = weapon_4_recharge_time;
    document.getElementById("txtWeapon4RangeOfFire").value = weapon_4_range_of_fire;
    document.getElementById("txtWeapon5Type").value = weapon_5_type;
    document.getElementById("txtWeapon5Damage").value = weapon_5_damage;
    document.getElementById("txtWeapon5Ammunition").value = weapon_5_ammunition;
    document.getElementById("txtWeapon5RechargeTime").value = weapon_5_recharge_time;
    document.getElementById("txtWeapon5RangeOfFire").value = weapon_5_range_of_fire;

    document.getElementById("txtCost").value = cost;
}

function HullChanged(hull_name)
{
    // If hull was chosen
    if (hull_name !== "")
    {
        // Get hull parameters
        var ajax_request = "hull_name=" + hull_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtHullHp').val(data.hp);
                $('#txtHullManeuverability').val(data.maneuverability);
                $('#txtHullCapacity').val(data.capacity);
                $('#txtHullCost').val(data.cost);
                
                hull_hp = data.hp;
                hull_maneuverability = data.maneuverability;
                hull_capacity = data.capacity;
                hull_cost = data.cost;
                hull_modules_bitmask = data.modules_bitmask;
                
                document.getElementById("txtHullChosen").value = "true";
                document.getElementById("txtHullName").value = hull_name;

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
        
        document.getElementById("txtHullChosen").value = "false";
        document.getElementById("txtHullName").value = "";

        ResetModules();
        ApplyModulesBitmask(hull_modules_bitmask);
        UpdateSpaceshipParameters();
    }
}

function EngineChanged(engine_name)
{
    // If engine was chosen
    if (engine_name !== "")
    {
        // Get engine parameters
        var ajax_request = "engine_name=" + engine_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtEngineSpeed').val(data.speed);
                $('#txtEngineWeight').val(data.weight);
                $('#txtEngineCost').val(data.cost);
                
                engine_speed = data.speed;
                engine_weight = data.weight;
                engine_cost = data.cost;

                document.getElementById("txtEngineChosen").value = "true";
                document.getElementById("txtEngineName").value = engine_name;

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
        
        document.getElementById("txtEngineChosen").value = "false";
        document.getElementById("txtEngineName").value = "";
        
        UpdateSpaceshipParameters();
    }
}

function SecondaryEngineChanged(secondary_engine_name)
{
    // If secondary engine was chosen
    if (secondary_engine_name !== "")
    {
        // Get secondary engine parameters
        var ajax_request = "secondary_engine_name=" + secondary_engine_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtSecondaryEngineManeuverability').val(data.maneuverability);
                $('#txtSecondaryEngineWeight').val(data.weight);
                $('#txtSecondaryEngineCost').val(data.cost);

                secondary_engine_maneuverability = data.maneuverability;
                secondary_engine_weight = data.weight;
                secondary_engine_cost = data.cost;

                document.getElementById("txtSecondaryEngineChosen").value = "true";
                document.getElementById("txtSecondaryEngineName").value = secondary_engine_name;

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

        document.getElementById("txtSecondaryEngineChosen").value = "false";
        document.getElementById("txtSecondaryEngineName").value = "";
        
        UpdateSpaceshipParameters();
    }
}

function FuelTankChanged(fuel_tank_name)
{
    // If fuel tank was chosen
    if (fuel_tank_name !== "")
    {
        // Get fuel tank parameters
        var ajax_request = "fuel_tank_name=" + fuel_tank_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtFuelTankVolume').val(data.volume);
                $('#txtFuelTankWeight').val(data.weight);
                $('#txtFuelTankCost').val(data.cost);
                
                fuel_tank_volume = data.volume;
                fuel_tank_weight = data.weight;
                fuel_tank_cost = data.cost;
                
                document.getElementById("txtFuelTankChosen").value = "true";
                document.getElementById("txtFuelTankName").value = fuel_tank_name;

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
        
        document.getElementById("txtFuelTankChosen").value = "false";
        document.getElementById("txtFuelTankName").value = "";
        
        UpdateSpaceshipParameters();
    }
}

function RadarChanged(radar_name)
{
    // If radar was chosen
    if (radar_name !== "")
    {
        // Get radar parameters
        var ajax_request = "radar_name=" + radar_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtRadarActionRadius').val(data.action_radius);
                $('#txtRadarWeight').val(data.weight);
                $('#txtRadarCost').val(data.cost);
                
                radar_action_radius = data.action_radius;
                radar_weight = data.weight;
                radar_cost = data.cost;
                
                document.getElementById("txtRadarChosen").value = "true";
                document.getElementById("txtRadarName").value = radar_name;

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
        
        document.getElementById("txtRadarChosen").value = "false";
        document.getElementById("txtRadarName").value = "";
        
        UpdateSpaceshipParameters();
    }
}

function RepairDroidChanged(repair_droid_name)
{
    // If repair droid was chosen
    if (repair_droid_name !== "")
    {
        // Get repair droid parameters
        var ajax_request = "repair_droid_name=" + repair_droid_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtRepairDroidHealthRecovery').val(data.health_recovery);
                $('#txtRepairDroidWeight').val(data.weight);
                $('#txtRepairDroidCost').val(data.cost);
                
                repair_droid_health_recovery = data.health_recovery;
                repair_droid_weight = data.weight;
                repair_droid_cost = data.cost;
                
                document.getElementById("txtRepairDroidChosen").value = "true";
                document.getElementById("txtRepairDroidName").value = repair_droid_name;

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
        
        document.getElementById("txtRepairDroidChosen").value = "false";
        document.getElementById("txtRepairDroidName").value = "";
        
        UpdateSpaceshipParameters();
    }
}

function MagneticGripChanged(magnetic_grip_name)
{
    // If magnetic grip was chosen
    if (magnetic_grip_name !== "")
    {
        // Get magnetic grip parameters
        var ajax_request = "magnetic_grip_name=" + magnetic_grip_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtMagneticGripActionRadius').val(data.action_radius);
                $('#txtMagneticGripCarryingCapacity').val(data.carrying_capacity);
                $('#txtMagneticGripWeight').val(data.weight);
                $('#txtMagneticGripCost').val(data.cost);
                
                magnetic_grip_action_radius = data.action_radius;
                magnetic_grip_carrying_capacity = data.carrying_capacity;
                magnetic_grip_weight = data.weight;
                magnetic_grip_cost = data.cost;
                
                document.getElementById("txtMagneticGripChosen").value = "true";
                document.getElementById("txtMagneticGripName").value = magnetic_grip_name;

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
        // Magnetic grip cell is empty
        
        document.getElementById("ship_magnetic_grip_cell").className = "empty_module_background";
        $('#ship_magnetic_grip').attr('src', "images/Icons/yes.png");
        $('#txtMagneticGripActionRadius').val(0);
        $('#txtMagneticGripCarryingCapacity').val(0);
        $('#txtMagneticGripWeight').val(0);
        $('#txtMagneticGripCost').val(0);
        
        magnetic_grip_action_radius = 0;
        magnetic_grip_carrying_capacity = 0;
        magnetic_grip_weight = 0;
        magnetic_grip_cost = 0;
        
        document.getElementById("txtMagneticGripChosen").value = "false";
        document.getElementById("txtMagneticGripName").value = "";
        
        UpdateSpaceshipParameters();
    }
}

function Weapon1Changed(weapon_name)
{
    // If weapon 1 was chosen
    if (weapon_name !== "")
    {
        // Get weapon 1 parameters
        var ajax_request = "weapon_name=" + weapon_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtWeapon1Type').val(data.type);
                $('#txtWeapon1Damage').val(data.damage);
                $('#txtWeapon1Ammunition').val(data.ammunition);
                $('#txtWeapon1RechargeTime').val(data.recharge_time);
                $('#txtWeapon1RangeOfFire').val(data.range_of_fire);
                $('#txtWeapon1Weight').val(data.weight);
                $('#txtWeapon1Cost').val(data.cost);
                
                weapon_1_type = data.type;
                weapon_1_damage = data.damage;
                weapon_1_ammunition = data.ammunition;
                weapon_1_recharge_time = data.recharge_time;
                weapon_1_range_of_fire = data.range_of_fire;
                weapon_1_weight = data.weight;
                weapon_1_cost = data.cost;
                
                document.getElementById("txtWeapon1Chosen").value = "true";
                document.getElementById("txtWeapon1Name").value = weapon_name;

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
        // Weapon 1 cell is empty
        
        document.getElementById("ship_weapon_1_cell").className = "empty_module_background";
        $('#ship_weapon_1').attr('src', "images/Icons/yes.png");
        $('#txtWeapon1Type').val("");
        $('#txtWeapon1Damage').val(0);
        $('#txtWeapon1Ammunition').val(0);
        $('#txtWeapon1RechargeTime').val(0);
        $('#txtWeapon1RangeOfFire').val(0);
        $('#txtWeapon1Weight').val(0);
        $('#txtWeapon1Cost').val(0);
        
        weapon_1_type = "";
        weapon_1_damage = 0;
        weapon_1_ammunition = 0;
        weapon_1_recharge_time = 0;
        weapon_1_range_of_fire = 0;
        weapon_1_weight = 0;
        weapon_1_cost = 0;
        
        document.getElementById("txtWeapon1Chosen").value = "false";
        document.getElementById("txtWeapon1Name").value = "";

        UpdateSpaceshipParameters();
    }
}

function Weapon2Changed(weapon_name)
{
    // If weapon 2 was chosen
    if (weapon_name !== "")
    {
        // Get weapon 2 parameters
        var ajax_request = "weapon_name=" + weapon_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtWeapon2Type').val(data.type);
                $('#txtWeapon2Damage').val(data.damage);
                $('#txtWeapon2Ammunition').val(data.ammunition);
                $('#txtWeapon2RechargeTime').val(data.recharge_time);
                $('#txtWeapon2RangeOfFire').val(data.range_of_fire);
                $('#txtWeapon2Weight').val(data.weight);
                $('#txtWeapon2Cost').val(data.cost);
                
                weapon_2_type = data.type;
                weapon_2_damage = data.damage;
                weapon_2_ammunition = data.ammunition;
                weapon_2_recharge_time = data.recharge_time;
                weapon_2_range_of_fire = data.range_of_fire;
                weapon_2_weight = data.weight;
                weapon_2_cost = data.cost;
                
                document.getElementById("txtWeapon2Chosen").value = "true";
                document.getElementById("txtWeapon2Name").value = weapon_name;

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
        // Weapon 2 cell is empty
        
        document.getElementById("ship_weapon_2_cell").className = "empty_module_background";
        $('#ship_weapon_2').attr('src', "images/Icons/yes.png");
        $('#txtWeapon2Type').val("");
        $('#txtWeapon2Damage').val(0);
        $('#txtWeapon2Ammunition').val(0);
        $('#txtWeapon2RechargeTime').val(0);
        $('#txtWeapon2RangeOfFire').val(0);
        $('#txtWeapon2Weight').val(0);
        $('#txtWeapon2Cost').val(0);
        
        weapon_2_type = "";
        weapon_2_damage = 0;
        weapon_2_ammunition = 0;
        weapon_2_recharge_time = 0;
        weapon_2_range_of_fire = 0;
        weapon_2_weight = 0;
        weapon_2_cost = 0;
        
        document.getElementById("txtWeapon2Chosen").value = "false";
        document.getElementById("txtWeapon2Name").value = "";
        
        UpdateSpaceshipParameters();
    }
}
function Weapon3Changed(weapon_name)
{
    // If weapon 3 was chosen
    if (weapon_name != "")
    {
        // Get weapon 3 parameters
        var ajax_request = "weapon_name=" + weapon_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtWeapon3Type').val(data.type);
                $('#txtWeapon3Damage').val(data.damage);
                $('#txtWeapon3Ammunition').val(data.ammunition);
                $('#txtWeapon3RechargeTime').val(data.recharge_time);
                $('#txtWeapon3RangeOfFire').val(data.range_of_fire);
                $('#txtWeapon3Weight').val(data.weight);
                $('#txtWeapon3Cost').val(data.cost);
                
                weapon_3_type = data.type;
                weapon_3_damage = data.damage;
                weapon_3_ammunition = data.ammunition;
                weapon_3_recharge_time = data.recharge_time;
                weapon_3_range_of_fire = data.range_of_fire;
                weapon_3_weight = data.weight;
                weapon_3_cost = data.cost;
                
                document.getElementById("txtWeapon3Chosen").value = "true";
                document.getElementById("txtWeapon3Name").value = weapon_name;

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
        // Weapon 3 cell is empty
        
        document.getElementById("ship_weapon_3_cell").className = "empty_module_background";
        $('#ship_weapon_3').attr('src', "images/Icons/yes.png");
        $('#txtWeapon3Type').val("");
        $('#txtWeapon3Damage').val(0);
        $('#txtWeapon3Ammunition').val(0);
        $('#txtWeapon3RechargeTime').val(0);
        $('#txtWeapon3RangeOfFire').val(0);
        $('#txtWeapon3Weight').val(0);
        $('#txtWeapon3Cost').val(0);
        
        weapon_3_type = "";
        weapon_3_damage = 0;
        weapon_3_ammunition = 0;
        weapon_3_recharge_time = 0;
        weapon_3_range_of_fire = 0;
        weapon_3_weight = 0;
        weapon_3_cost = 0;
        
        document.getElementById("txtWeapon3Chosen").value = "false";
        document.getElementById("txtWeapon3Name").value = "";
        
        UpdateSpaceshipParameters();
    }
}
function Weapon4Changed(weapon_name)
{
    // If weapon 4 was chosen
    if (weapon_name != "")
    {
        // Get weapon 4 parameters
        var ajax_request = "weapon_name=" + weapon_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtWeapon4Type').val(data.type);
                $('#txtWeapon4Damage').val(data.damage);
                $('#txtWeapon4Ammunition').val(data.ammunition);
                $('#txtWeapon4RechargeTime').val(data.recharge_time);
                $('#txtWeapon4RangeOfFire').val(data.range_of_fire);
                $('#txtWeapon4Weight').val(data.weight);
                $('#txtWeapon4Cost').val(data.cost);
                
                weapon_4_type = data.type;
                weapon_4_damage = data.damage;
                weapon_4_ammunition = data.ammunition;
                weapon_4_recharge_time = data.recharge_time;
                weapon_4_range_of_fire = data.range_of_fire;
                weapon_4_weight = data.weight;
                weapon_4_cost = data.cost;
                
                document.getElementById("txtWeapon4Chosen").value = "true";
                document.getElementById("txtWeapon4Name").value = weapon_name;

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
        // Weapon 4 cell is empty
        
        document.getElementById("ship_weapon_4_cell").className = "empty_module_background";
        $('#ship_weapon_4').attr('src', "images/Icons/yes.png");
        $('#txtWeapon4Type').val("");
        $('#txtWeapon4Damage').val(0);
        $('#txtWeapon4Ammunition').val(0);
        $('#txtWeapon4RechargeTime').val(0);
        $('#txtWeapon4RangeOfFire').val(0);
        $('#txtWeapon4Weight').val(0);
        $('#txtWeapon4Cost').val(0);
        
        weapon_4_type = "";
        weapon_4_damage = 0;
        weapon_4_ammunition = 0;
        weapon_4_recharge_time = 0;
        weapon_4_range_of_fire = 0;
        weapon_4_weight = 0;
        weapon_4_cost = 0;
        
        document.getElementById("txtWeapon4Chosen").value = "false";
        document.getElementById("txtWeapon4Name").value = "";
        
        UpdateSpaceshipParameters();
    }
}
function Weapon5Changed(weapon_name)
{
    // If weapon 5 was chosen
    if (weapon_name != "")
    {
        // Get weapon 5 parameters
        var ajax_request = "weapon_name=" + weapon_name;

        $.ajax({
            type: "GET",
            url: "ajax/load_modules.php",
            data: ajax_request,
            dataType: "json",
            success: function(data) {
                $('#txtWeapon5Type').val(data.type);
                $('#txtWeapon5Damage').val(data.damage);
                $('#txtWeapon5Ammunition').val(data.ammunition);
                $('#txtWeapon5RechargeTime').val(data.recharge_time);
                $('#txtWeapon5RangeOfFire').val(data.range_of_fire);
                $('#txtWeapon5Weight').val(data.weight);
                $('#txtWeapon5Cost').val(data.cost);
                
                weapon_5_type = data.type;
                weapon_5_damage = data.damage;
                weapon_5_ammunition = data.ammunition;
                weapon_5_recharge_time = data.recharge_time;
                weapon_5_range_of_fire = data.range_of_fire;
                weapon_5_weight = data.weight;
                weapon_5_cost = data.cost;
                
                document.getElementById("txtWeapon5Chosen").value = "true";
                document.getElementById("txtWeapon5Name").value = weapon_name;

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
        // Weapon 5 cell is empty
        
        document.getElementById("ship_weapon_5_cell").className = "empty_module_background";
        $('#ship_weapon_5').attr('src', "images/Icons/yes.png");
        $('#txtWeapon5Type').val("");
        $('#txtWeapon5Damage').val(0);
        $('#txtWeapon5Ammunition').val(0);
        $('#txtWeapon5RechargeTime').val(0);
        $('#txtWeapon5RangeOfFire').val(0);
        $('#txtWeapon5Weight').val(0);
        $('#txtWeapon5Cost').val(0);
        
        weapon_5_type = "";
        weapon_5_damage = 0;
        weapon_5_ammunition = 0;
        weapon_5_recharge_time = 0;
        weapon_5_range_of_fire = 0;
        weapon_5_weight = 0;
        weapon_5_cost = 0;
        
        document.getElementById("txtWeapon5Chosen").value = "false";
        document.getElementById("txtWeapon5Name").value = "";
        
        UpdateSpaceshipParameters();
    }
}
