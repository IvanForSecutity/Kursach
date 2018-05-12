<?php
//
// Spaceship verification script.
//

// TODO: Спрятать данные страницы от всех, кроме рута!

// Start the session, from which we will retrieve current ship
session_start();

require_once('functions.php');

if(!isset($_SESSION['cur_ship']))
{
    // Redirect user to the hangar page
    header('location: hangar.php');
    exit;
}
?>

