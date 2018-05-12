<?php
//
// Crafting spaceship.
// Result saves in database in table "ships".
//

// Authorized users only!
require_once('php_functions/check_session.php');

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');
require_once('php_functions/ships_database.php');

// If game starts
if(isset($_POST['btnStart']))
{
    // Player should choose ship name
    if($_POST['txtShipName'])
    {
        $ship_name = $_POST['txtShipName'];
        $owner = $_SESSION['login'];
        
        // Hull was chosen
        $hull = $_POST['selShipHullColor'];
        switch ($hull)
        {
        case "images/blue_1.jpg":
            $hull_2 = "images/blue_2.jpg";
            $hull_3 = "images/blue_3.jpg";
            break;
        case "images/red_1.jpg":
            $hull_2 = "images/red_2.jpg";
            $hull_3 = "images/red_3.jpg";
            break;
        case "images/green_1.jpg":
            $hull_2 = "images/green_2.jpg";
            $hull_3 = "images/green_3.jpg";
            break;
        }

        // Call the registration function
        $reg = registerNewShip($ship_name, $owner, $hull, $hull_2, $hull_3);

        // If ship successfully registered, inform the user
        if($reg === true)
        {
            $message = '<p>Your new ship registered in the system! Game starts...</p>';
            print $message;
            
            // Set current ship
            $_SESSION['cur_ship'] = $ship_name;
            
            // Redirect to game page
            // TODO: Вариант с хедером мне нравится больше, чем это некошерное нечто. 
            // Однако, на вариант с хедером php ругается, мол body уже послано...
            // Насколько я понял, если как-то сделать вызов registerNewShip ПОСЛЕ вызова header - все будет ОК.
            // Стрёмная какая-то ошибка...
            //header('Refresh: 5; URL = game.php');
            echo '<script>location.replace("game.php");</script>';
            exit;
        }
        // Otherwise, we inform the user of an error
        else
        {
            print $reg;
        }
    }
    else
    {
        $message = '<p>You should choose ship name!</p>';
        print $message;
    }
}
?>

<html>
    <head>
        <title>Spaceship smithy</title>
        <link rel="stylesheet" href="style/my_style.css">
        <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="js/jq_select.js"></script>
    </head>
    <body>
        <div style="text-align: right; padding-right: 50px; padding-top: 10px;">
            <a href="logout.php">Log Out</a>
        </div>
        <div class='circle-container'>
            <c href='#' class='center'> <img id="ship_hull" src="images/blue_1.jpg" width=10%> </a>
            
            <a href='#' class='deg250'> <img src="images/stub.jpg"> </a>
            <a href='#' class='deg270'> <img src="images/stub.jpg"> </a>
            <a href='#' class='deg290'> <img src="images/stub.jpg"> </a>
            
            <a href='#' class='deg330'> <img src="images/stub.jpg"> </a>
            <a href='#' class='deg30'>  <img src="images/stub.jpg"> </a>
            
            <a href='#' class='deg70'>  <img src="images/stub.jpg"> </a>
            <a href='#' class='deg90'>  <img src="images/stub.jpg"> </a>
            
            <a href='#' class='deg110'> <img src="images/stub.jpg"> </a>
            <a href='#' class='deg150'> <img src="images/stub.jpg"> </a>
            <a href='#' class='deg210'> <img src="images/stub.jpg"> </a>
        </div>
        
        <div style="text-align: center; padding-top: 50px;">
            <form action="" method="POST">
                <select id="ship_hull_color" name="selShipHullColor" class="select-multi" size="1">
                    <option data-path="images/blue_1.jpg" value="images/blue_1.jpg" class="blue_color"> Синий </option>
                    <option data-path="images/red_1.jpg" value="images/red_1.jpg" class="red_color"> Красный </option>
                    <option data-path="images/green_1.jpg" value="images/green_1.jpg" class="green_color"> Зелёный </option>
                </select>
                
                <br/>
                Ship name: <input type="text" name="txtShipName" style="margin-top: 0.2em">
                <br>

                <input type="submit" name="btnStart" value="Start" style="margin-top: 0.2em" ><br>
            </form>
        </div>
    </body>
</html>
