<?php
//
// User's personal area.
//

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
        <link rel="stylesheet" href="style/page_style.css">
    </head>
    <body>
        <table  class="two_columns" cellspacing="0">
        <tr>
            <td>
                <a href="hangar.php">To hangar</a>
            </td>
            <td class="right_col">
                <a href="logout.php">Log Out</a>
            </td>
        </tr>
        </table>
        <div style="text-align: left; padding-right: 50px; padding-top: 10px;">
            Your account
            <br><br>
            <form action="" method="POST">
                <table  class="ships_table" cellspacing="0">
                    <tr>
                        <th>Parameter</th> <th>Value</th>
                    </tr>
                    
                    <tr>
                        <td>
                            Login
                        </td>
                        <td>
                            <input type="text" name="txtName" value="<?php echo $login;?>" style="margin-top: 0.2em" readonly="true">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Registration date
                        </td>
                        <td>
                            <input type="text" name="txtRegDate" value="<?php echo $reg_date['reg_date'];?>" style="margin-top: 0.2em" readonly="true">
                        </td>
                    </tr>
                </table>
                <br/>

                <input type="submit" name="btnDeleteAccount" value="Delete account" style="margin-top: 0.2em" ><br>
            </form>
        </div>
    </body>
</html>

