///Drag'n Drop functions

function allowDrop(ev) 
{
    ev.preventDefault();
}

function dragHull(ev) 
{
    ev.dataTransfer.setData("hull_id", ev.target.id);
    ev.dataTransfer.effectAllowed = "copy";
}
function dropHull(ev) 
{
    ev.preventDefault();
    var data = ev.dataTransfer.getData("hull_id");

    if (data !== "")
    {
        var sel_hull = document.getElementById(data);

        // Change hull cell
        document.getElementById("ship_hull_cell").className = "hull_background";

        // Change hull picture
        $('#ship_hull').attr('src', sel_hull.src);

        var hull_name = sel_hull.id.substr(11);    // Remove "imgShipHull"

        HullChanged(hull_name);
    }
}

function dragEngine(ev) 
{
    ev.dataTransfer.setData("engine_id", ev.target.id);
    ev.dataTransfer.effectAllowed = "copy";
}
function dropEngine(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtEngineAllowed").value === "true")
    {
        var data = ev.dataTransfer.getData("engine_id");

        if (data !== "")
        {
            var sel_engine = document.getElementById(data);

            // Change engine cell
            document.getElementById("ship_engine_cell").className = "module_background";

            // Change engine picture
            $('#ship_engine').attr('src', sel_engine.src);

            var engine_name = sel_engine.id.substr(13);    // Remove "imgShipEngine"

            EngineChanged(engine_name);
        }
    }
}

function dragSecondaryEngine(ev) 
{
    ev.dataTransfer.setData("secondary_engine_id", ev.target.id);
    ev.dataTransfer.effectAllowed = "copy";
}
function dropSecondaryEngine(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtSecondaryEngineAllowed").value === "true")
    {
        var data = ev.dataTransfer.getData("secondary_engine_id");

        if (data !== "")
        {
            var sel_secondary_engine = document.getElementById(data);

            // Change secondary engine cell
            document.getElementById("ship_secondary_engine_cell").className = "module_background";

            // Change secondary engine picture
            $('#ship_secondary_engine').attr('src', sel_secondary_engine.src);

            var secondary_engine_name = sel_secondary_engine.id.substr(22);    // Remove "imgShipSecondaryEngine"

            SecondaryEngineChanged(secondary_engine_name);
        }
    }
}

function dragFuelTank(ev) 
{
    ev.dataTransfer.setData("fuel_tank_id", ev.target.id);
    ev.dataTransfer.effectAllowed = "copy";
}
function dropFuelTank(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtFuelTankAllowed").value === "true")
    {
        var data = ev.dataTransfer.getData("fuel_tank_id");

        if (data !== "")
        {
            var sel_fuel_tank = document.getElementById(data);

            // Change fuel tank cell
            document.getElementById("ship_fuel_tank_cell").className = "module_background";

            // Change fuel tank picture
            $('#ship_fuel_tank').attr('src', sel_fuel_tank.src);

            var fuel_tank_name = sel_fuel_tank.id.substr(15);    // Remove "imgShipFuelTank"

            FuelTankChanged(fuel_tank_name);
        }
    }
}

function dragRadar(ev) 
{
    ev.dataTransfer.setData("radar_id", ev.target.id);
    ev.dataTransfer.effectAllowed = "copy";
}
function dropRadar(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtRadarAllowed").value === "true")
    {
        var data = ev.dataTransfer.getData("radar_id");

        if (data !== "")
        {
            var sel_radar = document.getElementById(data);

            // Change radar cell
            document.getElementById("ship_radar_cell").className = "module_background";

            // Change radar picture
            $('#ship_radar').attr('src', sel_radar.src);

            var radar_name = sel_radar.id.substr(12);    // Remove "imgShipRadar"

            RadarChanged(radar_name);
        }
    }
}

function dragRepairDroid(ev) 
{
    ev.dataTransfer.setData("repair_droid_id", ev.target.id);
    ev.dataTransfer.effectAllowed = "copy";
}
function dropRepairDroid(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtRepairDroidAllowed").value === "true")
    {
        var data = ev.dataTransfer.getData("repair_droid_id");

        if (data !== "")
        {
            var sel_repair_droid = document.getElementById(data);

            // Change repair droid cell
            document.getElementById("ship_repair_droid_cell").className = "module_background";

            // Change repair droid picture
            $('#ship_repair_droid').attr('src', sel_repair_droid.src);

            var repair_droid_name = sel_repair_droid.id.substr(18);    // Remove "imgShipRepairDroid"

            RepairDroidChanged(repair_droid_name);
        }
    }
}

function dragMagneticGrip(ev) 
{
    ev.dataTransfer.setData("magnetic_grip_id", ev.target.id);
    ev.dataTransfer.effectAllowed = "copy";
}
function dropMagneticGrip(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtMagneticGripAllowed").value === "true")
    {
        var data = ev.dataTransfer.getData("magnetic_grip_id");

        if (data !== "")
        {
            var sel_magnetic_grip = document.getElementById(data);

            // Change magnetic grip cell
            document.getElementById("ship_magnetic_grip_cell").className = "module_background";

            // Change magnetic grip picture
            $('#ship_magnetic_grip').attr('src', sel_magnetic_grip.src);

            var magnetic_grip_name = sel_magnetic_grip.id.substr(19);    // Remove "imgShipMagneticGrip"

            MagneticGripChanged(magnetic_grip_name);
        }
    }
}

function dragWeapon(ev) 
{
    ev.dataTransfer.setData("weapon_id", ev.target.id);
    ev.dataTransfer.effectAllowed = "copy";
}
function dropWeapon1(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtWeapon1Allowed").value === "true")
    {
        var data = ev.dataTransfer.getData("weapon_id");

        if (data !== "")
        {
            var sel_weapon_1 = document.getElementById(data);

            // Change weapon cell
            document.getElementById("ship_weapon_1_cell").className = "module_background";

            // Change weapon picture
            $('#ship_weapon_1').attr('src', sel_weapon_1.src);

            var weapon_1_name = sel_weapon_1.id.substr(13);    // Remove "imgShipWeapon"

            Weapon1Changed(weapon_1_name);
        }
    }
}
function dropWeapon2(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtWeapon2Allowed").value === "true")
    {
        var data = ev.dataTransfer.getData("weapon_id");

        if (data !== "")
        {
            var sel_weapon_2 = document.getElementById(data);

            // Change weapon cell
            document.getElementById("ship_weapon_2_cell").className = "module_background";

            // Change weapon picture
            $('#ship_weapon_2').attr('src', sel_weapon_2.src);

            var weapon_2_name = sel_weapon_2.id.substr(13);    // Remove "imgShipWeapon"

            Weapon2Changed(weapon_2_name);
        }
    }
}
function dropWeapon3(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtWeapon3Allowed").value === "true")
    {
        var data = ev.dataTransfer.getData("weapon_id");

        if (data !== "")
        {
            var sel_weapon_3 = document.getElementById(data);

            // Change weapon cell
            document.getElementById("ship_weapon_3_cell").className = "module_background";

            // Change weapon picture
            $('#ship_weapon_3').attr('src', sel_weapon_3.src);

            var weapon_3_name = sel_weapon_3.id.substr(13);    // Remove "imgShipWeapon"

            Weapon3Changed(weapon_3_name);
        }
    }
}
function dropWeapon4(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtWeapon4Allowed").value === "true")
    {
        var data = ev.dataTransfer.getData("weapon_id");

        if (data !== "")
        {
            var sel_weapon_4 = document.getElementById(data);

            // Change weapon cell
            document.getElementById("ship_weapon_4_cell").className = "module_background";

            // Change weapon picture
            $('#ship_weapon_4').attr('src', sel_weapon_4.src);

            var weapon_4_name = sel_weapon_4.id.substr(13);    // Remove "imgShipWeapon"

            Weapon4Changed(weapon_4_name);
        }
    }
}
function dropWeapon5(ev) 
{
    ev.preventDefault();
    if (document.getElementById("txtWeapon5Allowed").value === "true")
    {
        var data = ev.dataTransfer.getData("weapon_id");

        if (data !== "")
        {
            var sel_weapon_5 = document.getElementById(data);

            // Change weapon cell
            document.getElementById("ship_weapon_5_cell").className = "module_background";

            // Change weapon picture
            $('#ship_weapon_5').attr('src', sel_weapon_5.src);

            var weapon_5_name = sel_weapon_5.id.substr(13);    // Remove "imgShipWeapon"

            Weapon5Changed(weapon_5_name);
        }
    }
}

function dragCurHull(ev) 
{
    if (document.getElementById("txtHullChosen").value === "true")
    {
        ev.dataTransfer.setData("cur_hull_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurEngine(ev) 
{
    if (document.getElementById("txtEngineChosen").value === "true")
    {
        ev.dataTransfer.setData("cur_engine_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurSecondaryEngine(ev) 
{
    if (document.getElementById("txtSecondaryEngineChosen").value === "true")
    {
        ev.dataTransfer.setData("cur_secondary_engine_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurFuelTank(ev) 
{
    if (document.getElementById("txtFuelTankChosen").value === "true")
    {
        ev.dataTransfer.setData("cur_fuel_tank_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurRadar(ev) 
{
    if (document.getElementById("txtRadarChosen").value === "true")
    {
        ev.dataTransfer.setData("cur_radar_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurRepairDroid(ev) 
{
    if (document.getElementById("txtRepairDroidChosen").value === "true")
    {
        ev.dataTransfer.setData("cur_repair_droid_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurMagneticGrip(ev) 
{
    if (document.getElementById("txtMagneticGripChosen").value === "true")
    {
        ev.dataTransfer.setData("cur_magnetic_grip_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurWeapon1(ev) 
{
    if (document.getElementById("txtWeapon1Chosen").value === "true")
    {
        ev.dataTransfer.setData("cur_weapon_1_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurWeapon2(ev) 
{
    if (document.getElementById("txtWeapon2Chosen").value === "true")
    {
        ev.dataTransfer.setData("cur_weapon_2_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurWeapon3(ev) 
{
    if (document.getElementById("txtWeapon3Chosen").value === "true")
    {
        ev.dataTransfer.setData("cur_weapon_3_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurWeapon4(ev) 
{
    if (document.getElementById("txtWeapon4Chosen").value === "true")
    {
        ev.dataTransfer.setData("cur_weapon_4_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}
function dragCurWeapon5(ev) 
{
    if (document.getElementById("txtWeapon5Chosen").value === "true")
    {
        ev.dataTransfer.setData("cur_weapon_5_id", ev.target.id);
        ev.dataTransfer.effectAllowed = "copy";
    }
}

function dropRecycleBin(ev) 
{
    ev.preventDefault();

    var data = ev.dataTransfer.getData("cur_hull_id");
    if (data !== "")
    {
        HullChanged("");
    }
    else
    {
        data = ev.dataTransfer.getData("cur_engine_id");
        if (data !== "")
        {
            EngineChanged("");
        }
        else
        {
            data = ev.dataTransfer.getData("cur_secondary_engine_id");
            if (data !== "")
            {
                SecondaryEngineChanged("");
            }
            else
            {
                data = ev.dataTransfer.getData("cur_fuel_tank_id");
                if (data !== "")
                {
                    FuelTankChanged("");
                }
                else
                {
                    data = ev.dataTransfer.getData("cur_radar_id");
                    if (data !== "")
                    {
                        RadarChanged("");
                    }
                    else
                    {
                        data = ev.dataTransfer.getData("cur_repair_droid_id");
                        if (data !== "")
                        {
                            RepairDroidChanged("");
                        }
                        else
                        {
                            data = ev.dataTransfer.getData("cur_magnetic_grip_id");
                            if (data !== "")
                            {
                                MagneticGripChanged("");
                            }
                            else
                            {
                                data = ev.dataTransfer.getData("cur_weapon_1_id");
                                if (data !== "")
                                {
                                    Weapon1Changed("");
                                }
                                else
                                {
                                    data = ev.dataTransfer.getData("cur_weapon_2_id");
                                    if (data !== "")
                                    {
                                        Weapon2Changed("");
                                    }
                                    else
                                    {
                                        data = ev.dataTransfer.getData("cur_weapon_3_id");
                                        if (data !== "")
                                        {
                                            Weapon3Changed("");
                                        }
                                        else
                                        {
                                            data = ev.dataTransfer.getData("cur_weapon_4_id");
                                            if (data !== "")
                                            {
                                                Weapon4Changed("");
                                            }
                                            else
                                            {
                                                data = ev.dataTransfer.getData("cur_weapon_5_id");
                                                if (data !== "")
                                                {
                                                    Weapon5Changed("");
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
