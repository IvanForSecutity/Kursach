function SearchHulls()
{
    var search_string = document.getElementById("txtHullSearchString").value;
    
    var ajax_request = "hull_search_string=" + search_string;
    
    if (document.getElementById("txtHullHpFrom").value !== "")
    {
        ajax_request += "&hull_search_hp_from=" + document.getElementById("txtHullHpFrom").value;
    }
    if (document.getElementById("txtHullHpTo").value !== "")
    {
        ajax_request += "&hull_search_hp_to=" + document.getElementById("txtHullHpTo").value;
    }
    if (document.getElementById("txtHullManeuverabilityFrom").value !== "")
    {
        ajax_request += "&hull_search_maneuverability_from=" + document.getElementById("txtHullManeuverabilityFrom").value;
    }
    if (document.getElementById("txtHullManeuverabilityTo").value !== "")
    {
        ajax_request += "&hull_search_maneuverability_to=" + document.getElementById("txtHullManeuverabilityTo").value;
    }
    if (document.getElementById("txtHullCapacityFrom").value !== "")
    {
        ajax_request += "&hull_search_capacity_from=" + document.getElementById("txtHullCapacityFrom").value;
    }
    if (document.getElementById("txtHullCapacityTo").value !== "")
    {
        ajax_request += "&hull_search_capacity_to=" + document.getElementById("txtHullCapacityTo").value;
    }
    if (document.getElementById("txtHullCostFrom").value !== "")
    {
        ajax_request += "&hull_search_cost_from=" + document.getElementById("txtHullCostFrom").value;
    }
    if (document.getElementById("txtHullCostTo").value !== "")
    {
        ajax_request += "&hull_search_cost_to=" + document.getElementById("txtHullCostTo").value;
    }

    $.ajax({
        type: "GET",
        url: "ajax/search_modules.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            document.getElementById("divAvailableHulls").innerHTML = data;

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}

function SearchEngines()
{
    var search_string = document.getElementById("txtEngineSearchString").value;
    
    var ajax_request = "engine_search_string=" + search_string;
    
    if (document.getElementById("txtEngineSpeedFrom").value !== "")
    {
        ajax_request += "&engine_search_speed_from=" + document.getElementById("txtEngineSpeedFrom").value;
    }
    if (document.getElementById("txtEngineSpeedTo").value !== "")
    {
        ajax_request += "&engine_search_speed_to=" + document.getElementById("txtEngineSpeedTo").value;
    }
    if (document.getElementById("txtEngineWeightFrom").value !== "")
    {
        ajax_request += "&engine_search_weight_from=" + document.getElementById("txtEngineWeightFrom").value;
    }
    if (document.getElementById("txtEngineWeightTo").value !== "")
    {
        ajax_request += "&engine_search_weight_to=" + document.getElementById("txtEngineWeightTo").value;
    }
    if (document.getElementById("txtEngineCostFrom").value !== "")
    {
        ajax_request += "&engine_search_cost_from=" + document.getElementById("txtEngineCostFrom").value;
    }
    if (document.getElementById("txtEngineCostTo").value !== "")
    {
        ajax_request += "&engine_search_cost_to=" + document.getElementById("txtEngineCostTo").value;
    }

    $.ajax({
        type: "GET",
        url: "ajax/search_modules.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            document.getElementById("divAvailableEngines").innerHTML = data;

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}

function SearchSecondaryEngines()
{
    var search_string = document.getElementById("txtSecondaryEngineSearchString").value;
    
    var ajax_request = "secondary_engine_search_string=" + search_string;
    
    if (document.getElementById("txtSecondaryEngineManeuverabilityFrom").value !== "")
    {
        ajax_request += "&secondary_engine_search_maneuverability_from=" + document.getElementById("txtSecondaryEngineManeuverabilityFrom").value;
    }
    if (document.getElementById("txtSecondaryEngineManeuverabilityTo").value !== "")
    {
        ajax_request += "&secondary_engine_search_maneuverability_to=" + document.getElementById("txtSecondaryEngineManeuverabilityTo").value;
    }
    if (document.getElementById("txtSecondaryEngineWeightFrom").value !== "")
    {
        ajax_request += "&secondary_engine_search_weight_from=" + document.getElementById("txtSecondaryEngineWeightFrom").value;
    }
    if (document.getElementById("txtSecondaryEngineWeightTo").value !== "")
    {
        ajax_request += "&secondary_engine_search_weight_to=" + document.getElementById("txtSecondaryEngineWeightTo").value;
    }
    if (document.getElementById("txtSecondaryEngineCostFrom").value !== "")
    {
        ajax_request += "&secondary_engine_search_cost_from=" + document.getElementById("txtSecondaryEngineCostFrom").value;
    }
    if (document.getElementById("txtSecondaryEngineCostTo").value !== "")
    {
        ajax_request += "&secondary_engine_search_cost_to=" + document.getElementById("txtSecondaryEngineCostTo").value;
    }

    $.ajax({
        type: "GET",
        url: "ajax/search_modules.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            document.getElementById("divAvailableSecondaryEngines").innerHTML = data;

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}

function SearchFuelTanks()
{
    var search_string = document.getElementById("txtFuelTankSearchString").value;
    
    var ajax_request = "fuel_tank_search_string=" + search_string;
    
    if (document.getElementById("txtFuelTankVolumeFrom").value !== "")
    {
        ajax_request += "&fuel_tank_search_volume_from=" + document.getElementById("txtFuelTankVolumeFrom").value;
    }
    if (document.getElementById("txtFuelTankVolumeTo").value !== "")
    {
        ajax_request += "&fuel_tank_search_volume_to=" + document.getElementById("txtFuelTankVolumeTo").value;
    }
    if (document.getElementById("txtFuelTankWeightFrom").value !== "")
    {
        ajax_request += "&fuel_tank_search_weight_from=" + document.getElementById("txtFuelTankWeightFrom").value;
    }
    if (document.getElementById("txtFuelTankWeightTo").value !== "")
    {
        ajax_request += "&fuel_tank_search_weight_to=" + document.getElementById("txtFuelTankWeightTo").value;
    }
    if (document.getElementById("txtFuelTankCostFrom").value !== "")
    {
        ajax_request += "&fuel_tank_search_cost_from=" + document.getElementById("txtFuelTankCostFrom").value;
    }
    if (document.getElementById("txtFuelTankCostTo").value !== "")
    {
        ajax_request += "&fuel_tank_search_cost_to=" + document.getElementById("txtFuelTankCostTo").value;
    }

    $.ajax({
        type: "GET",
        url: "ajax/search_modules.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            document.getElementById("divAvailableFuelTanks").innerHTML = data;

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}

function SearchRadars()
{
    var search_string = document.getElementById("txtRadarSearchString").value;
    
    var ajax_request = "radar_search_string=" + search_string;
    
    if (document.getElementById("txtRadarActionRadiusFrom").value !== "")
    {
        ajax_request += "&radar_search_action_radius_from=" + document.getElementById("txtRadarActionRadiusFrom").value;
    }
    if (document.getElementById("txtRadarActionRadiusTo").value !== "")
    {
        ajax_request += "&radar_search_action_radius_to=" + document.getElementById("txtRadarActionRadiusTo").value;
    }
    if (document.getElementById("txtRadarWeightFrom").value !== "")
    {
        ajax_request += "&radar_search_weight_from=" + document.getElementById("txtRadarWeightFrom").value;
    }
    if (document.getElementById("txtRadarWeightTo").value !== "")
    {
        ajax_request += "&radar_search_weight_to=" + document.getElementById("txtRadarWeightTo").value;
    }
    if (document.getElementById("txtRadarCostFrom").value !== "")
    {
        ajax_request += "&radar_search_cost_from=" + document.getElementById("txtRadarCostFrom").value;
    }
    if (document.getElementById("txtRadarCostTo").value !== "")
    {
        ajax_request += "&radar_search_cost_to=" + document.getElementById("txtRadarCostTo").value;
    }

    $.ajax({
        type: "GET",
        url: "ajax/search_modules.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            document.getElementById("divAvailableRadars").innerHTML = data;

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}

function SearchRepairDroids()
{
    var search_string = document.getElementById("txtRepairDroidSearchString").value;
    
    var ajax_request = "repair_droid_search_string=" + search_string;
    
    if (document.getElementById("txtRepairDroidHealthRecoveryFrom").value !== "")
    {
        ajax_request += "&repair_droid_search_health_recovery_from=" + document.getElementById("txtRepairDroidHealthRecoveryFrom").value;
    }
    if (document.getElementById("txtRepairDroidHealthRecoveryTo").value !== "")
    {
        ajax_request += "&repair_droid_search_health_recovery_to=" + document.getElementById("txtRepairDroidHealthRecoveryTo").value;
    }
    if (document.getElementById("txtRepairDroidWeightFrom").value !== "")
    {
        ajax_request += "&repair_droid_search_weight_from=" + document.getElementById("txtRepairDroidWeightFrom").value;
    }
    if (document.getElementById("txtRepairDroidWeightTo").value !== "")
    {
        ajax_request += "&repair_droid_search_weight_to=" + document.getElementById("txtRepairDroidWeightTo").value;
    }
    if (document.getElementById("txtRepairDroidCostFrom").value !== "")
    {
        ajax_request += "&repair_droid_search_cost_from=" + document.getElementById("txtRepairDroidCostFrom").value;
    }
    if (document.getElementById("txtRepairDroidCostTo").value !== "")
    {
        ajax_request += "&repair_droid_search_cost_to=" + document.getElementById("txtRepairDroidCostTo").value;
    }

    $.ajax({
        type: "GET",
        url: "ajax/search_modules.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            document.getElementById("divAvailableRepairDroids").innerHTML = data;

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}

function SearchMagneticGrips()
{
    var search_string = document.getElementById("txtMagneticGripSearchString").value;
    
    var ajax_request = "magnetic_grip_search_string=" + search_string;
    
    if (document.getElementById("txtMagneticGripActionRadiusFrom").value !== "")
    {
        ajax_request += "&magnetic_grip_search_action_radius_from=" + document.getElementById("txtMagneticGripActionRadiusFrom").value;
    }
    if (document.getElementById("txtMagneticGripActionRadiusTo").value !== "")
    {
        ajax_request += "&magnetic_grip_search_action_radius_to=" + document.getElementById("txtMagneticGripActionRadiusTo").value;
    }
    if (document.getElementById("txtMagneticGripCarryingCapacityFrom").value !== "")
    {
        ajax_request += "&magnetic_grip_search_carrying_capacity_from=" + document.getElementById("txtMagneticGripCarryingCapacityFrom").value;
    }
    if (document.getElementById("txtMagneticGripCarryingCapacityTo").value !== "")
    {
        ajax_request += "&magnetic_grip_search_carrying_capacity_to=" + document.getElementById("txtMagneticGripCarryingCapacityTo").value;
    }
    if (document.getElementById("txtMagneticGripWeightFrom").value !== "")
    {
        ajax_request += "&magnetic_grip_search_weight_from=" + document.getElementById("txtMagneticGripWeightFrom").value;
    }
    if (document.getElementById("txtMagneticGripWeightTo").value !== "")
    {
        ajax_request += "&magnetic_grip_search_weight_to=" + document.getElementById("txtMagneticGripWeightTo").value;
    }
    if (document.getElementById("txtMagneticGripCostFrom").value !== "")
    {
        ajax_request += "&magnetic_grip_search_cost_from=" + document.getElementById("txtMagneticGripCostFrom").value;
    }
    if (document.getElementById("txtMagneticGripCostTo").value !== "")
    {
        ajax_request += "&magnetic_grip_search_cost_to=" + document.getElementById("txtMagneticGripCostTo").value;
    }

    $.ajax({
        type: "GET",
        url: "ajax/search_modules.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            document.getElementById("divAvailableMagneticGrips").innerHTML = data;

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}

function SearchWeapons()
{
    var search_string = document.getElementById("txtWeaponSearchString").value;
    
    var ajax_request = "weapon_search_string=" + search_string;
  
    if (document.getElementById("txtWeaponType").value !== "")
    {
        ajax_request += "&weapon_search_type=" + document.getElementById("txtWeaponType").value;
    }
    if (document.getElementById("txtWeaponDamageFrom").value !== "")
    {
        ajax_request += "&weapon_search_damage_from=" + document.getElementById("txtWeaponDamageFrom").value;
    }
    if (document.getElementById("txtWeaponDamageTo").value !== "")
    {
        ajax_request += "&weapon_search_damage_to=" + document.getElementById("txtWeaponDamageTo").value;
    }
    if (document.getElementById("txtWeaponAmmunitionFrom").value !== "")
    {
        ajax_request += "&weapon_search_ammunition_from=" + document.getElementById("txtWeaponAmmunitionFrom").value;
    }
    if (document.getElementById("txtWeaponAmmunitionTo").value !== "")
    {
        ajax_request += "&weapon_search_ammunition_to=" + document.getElementById("txtWeaponAmmunitionTo").value;
    }
    if (document.getElementById("txtWeaponRechargeTimeFrom").value !== "")
    {
        ajax_request += "&weapon_search_recharge_time_from=" + document.getElementById("txtWeaponRechargeTimeFrom").value;
    }
    if (document.getElementById("txtWeaponRechargeTimeTo").value !== "")
    {
        ajax_request += "&weapon_search_recharge_time_to=" + document.getElementById("txtWeaponRechargeTimeTo").value;
    }
    if (document.getElementById("txtWeaponRangeOfFireFrom").value !== "")
    {
        ajax_request += "&weapon_search_range_of_fire_from=" + document.getElementById("txtWeaponRangeOfFireFrom").value;
    }
    if (document.getElementById("txtWeaponRangeOfFireTo").value !== "")
    {
        ajax_request += "&weapon_search_range_of_fire_to=" + document.getElementById("txtWeaponRangeOfFireTo").value;
    }
    if (document.getElementById("txtWeaponWeightFrom").value !== "")
    {
        ajax_request += "&weapon_search_weight_from=" + document.getElementById("txtWeaponWeightFrom").value;
    }
    if (document.getElementById("txtWeaponWeightTo").value !== "")
    {
        ajax_request += "&weapon_search_weight_to=" + document.getElementById("txtWeaponWeightTo").value;
    }
    if (document.getElementById("txtWeaponCostFrom").value !== "")
    {
        ajax_request += "&weapon_search_cost_from=" + document.getElementById("txtWeaponCostFrom").value;
    }
    if (document.getElementById("txtWeaponCostTo").value !== "")
    {
        ajax_request += "&weapon_search_cost_to=" + document.getElementById("txtWeaponCostTo").value;
    }

    $.ajax({
        type: "GET",
        url: "ajax/search_modules.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            document.getElementById("divAvailableWeapons").innerHTML = data;

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}
