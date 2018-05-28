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

document.getElementById("txtDebug").value = ajax_request;

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

