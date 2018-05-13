$(document).ready(function()
{
    $('#selShipHull').change(function()
    {
        $('#ship_hull').attr('src', $('#selShipHull option:selected').attr('data-path'));
    });
});