<?php
//
// User's personal area.
//

// TODO: Смена пароля, аватарка и прочее

// Start the session, from which we will retrieve login and session hash
session_start();

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');

// Authorized users only!
require_once('php_functions/check_session.php');

// Load user's data
$login = $_SESSION['login'];
$reg_date = getUserRegDate($login);

// Check if delete button was pressed
if(isset($_POST['btnDeleteAccount']))
{
    deleteUser($login);
    header('location: logout.php');
}
?>

<html>
    <head>
        <title>Personal Area</title>
        <link rel="stylesheet" href="style/page_style.css" >
        <link rel="stylesheet" href="style/personal_area_style.css" >
    </head>
    <body>
        <div>
            <button id="hangar_button" class="personal_area_button_up" onclick="window.location.href='hangar.php'"><span>To hangar</span></button>
            <button id="logout_button" style="float: right;" class="personal_area_button_up" onclick="window.location.href='logout.php'"><span>Log Out</span></button>
        </div>

        <div style="text-align: center; padding-right: 5%; padding-top: 5%;">
            <p class="form-title" style="form-title">
              Your account</p>
            <form action="" method="POST">
                <table class="cool_table">
                    <thead>
                    <tr>
                        <th>Parameter</th> <th>Value</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            Login
                        </td>
                        <td>
                            <a type="text" name="txtName"  style="margin-top: 0.2em" readonly="true"><?php echo $login;?></a>
                        </td>
                    </tr>
                    </tbody>

                    <tbody>
                    <tr>
                        <td>
                            Registration date
                        </td>
                        <td>
                            <a type="text" name="txtRegDate"  style="margin-top: 0.2em" readonly="true"><?php echo $reg_date['reg_date'];?></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <br/>

                <div style="width:200px;margin: 0 auto;">
                    <input type="submit" class="personal_area_button" name="btnDeleteAccount" value="Delete account" style="width:100%"><br>
                </div>
            </form>
        </div>
    </body>
</html>
