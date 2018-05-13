// TODO: Сейчас оно не используется. Если так и не пригодится - надо удалить, вместе с jquery.

$(document).ready(function()
{
    $('#selShipHull').change(function()
    {
        $('#ship_hull').attr('src', $('#selShipHull option:selected').attr('data-path'));
    });
});