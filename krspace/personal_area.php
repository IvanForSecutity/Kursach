<?php
//
// User's personal area.
//

// Authorized users only!
require_once('php_functions/check_session.php');

// Connect the file with the connection parameters to the DB
require_once('php_functions/database.php');

// Load user's data
$login = $_SESSION['login'];
$reg_date = getUserRegDate($login);
?>

<html>
    <head>
        <title>Personal Area</title>
        <link rel="stylesheet" href="style/my_style.css">
    </head>
    <body>
        <div style="text-align: right; padding-right: 50px; padding-top: 10px;">
            <a href="logout.php">Log Out</a>
        </div>
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
            </form>
        </div>
    </body>
</html>

