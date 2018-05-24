<?php
//
// Spaceship verification script.
//

require_once('php_functions/functions.php');

if(!isset($_SESSION['cur_ship']))
{
    // Redirect user to the hangar page
    header('location: hangar.php');
    exit;
}
?>

