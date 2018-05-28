<?php
//
// Players hangar.
// Ships save in database in table "ships".
//

// TODO: Стили!

// Start the session, from which we will retrieve login and session hash
session_start();

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');

// Authorized users only!
require_once('php_functions/check_session.php');

// Connect the file with the connection parameters to the ships DB
require_once('php_functions/ships_database.php');

if(isset($_POST['btnStart']))
{
    // Player should choose any available ship
    if(isset($_POST['rbtnAvailableShips']))
    {
        // Set current ship
        $_SESSION['cur_ship'] = $_POST['rbtnAvailableShips'];

        header("Location: game.php");
    }
    else
    {
        $message = '<p class="error">You should choose any available ship to start game!</p><br>';
        print $message;
    }
}

// Load user's ships
$login = $_SESSION['login'];
$ships = loadUserShips($login);

// Check if delete button was pressed
foreach ($ships as $cur_ship)
{
    if(isset($_POST[$cur_ship['ship_name']]))
    {
        $ship_name = $cur_ship['ship_name'];
        deleteShip($ship_name);
        header("Refresh:0");
    }
}
?>

<html>

<head>
  <title>Hangar</title>
  <link rel="stylesheet" href="style/page_style.css">
  <link rel="stylesheet" href="style/hangar_style.css">
</head>

<body bgcolor="#eafff7" >
  <div>
    <button id="personal_area_button" class="hangar_button_up" onclick="window.location.href='personal_area.php'"><span>Personal Area</span></button>
    <button id="logout_button" style="float: right;margin-right:25px;" class="hangar_button_up" onclick="window.location.href='logout.php'"><span>Log Out</span></button>
  </div>
  <div style="float: center;text-align: left; padding-right: 50px; padding-top: 10px;">
    <p class="form-title" style="form-title">
      Your ships</p>
    <form action="" method="POST">
      <table class="cool_table">
        <thead>
          <tr>
            <th>Ship name</th>
            <th>Action</th>
          </tr>
        </thead>
        <?php foreach ($ships as $cur_ship) : ?>
        <tbody>
          <tr>
            <td>
              <p> <input type="radio" name="rbtnAvailableShips" value="<?= $cur_ship['ship_name']?>" id="<?= $cur_ship['ship_name']?>" /> <label for="<?= $cur_ship['ship_name']?>"> <?= $cur_ship['ship_name']?> </label> </p>
            </td>
            <td>
              <button type="submit" name="<?= $cur_ship['ship_name']?>" class="input_image"><img src="images\Icons\no.png" weight="20px" height="20px"></button>
            </td>
          </tr>
        </tbody>
        <?php endforeach ?>
      </table>
      <br/>
      <div style="width:200px;margin: 0 auto;">
        <input type="submit" class="hangar_button" name="btnStart" value="Start" style="width:100%"><br>
      </div>
    </form>

    <form action="crafter.php" method="POST">
    <div style="width:200px;margin: 0 auto;">
      <input type="submit" class="hangar_button" name="btnCreate" value="Create new ship" style="width:100%"><br>
    </div>
    </form>
  </div>
</body>

</html>
