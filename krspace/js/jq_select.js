$(document).ready(function()
{
    $('#ship_hull_color').change(function()
    {
        $('#ship_hull').attr('src', $('#ship_hull_color option:selected').attr('data-path'));
    });
});