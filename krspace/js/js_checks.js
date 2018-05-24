$(document).ready(function()
{
    $('#frmRegistration').submit(function(event) {
        if (!ValidateUserData())
        {
            event.preventDefault(); 
        }
    });
});

// Check user login
function CheckLogin(login)
{
    // Initialize a variable with a possible error message
    var error = '';

    // If login string is empty, return an error message
    if(!login)
    {
        error = "You did not enter a login";
        return error;
    }

    // The login must be at least 4, not longer than 16 characters
    var result = login.match(/^[-_.a-z\d]{4,16}$/i);

    // If the check fails, return an error message
    if(!result)
    {
        error = "Invalid characters in login or login is too short (long)";
        return error;
    }

    // If all is OK - return true
    return true;
}

// Check user password
function CheckPassword(password)
{
    // Initialize a variable with a possible error message
    var error = '';

    // If password string is empty, return an error message
    if(!password)
    {
        error = "You did not enter a password";
        return error;
    }

    // The password must be at least 6, not longer than 16 characters
    var result = password.match(/^[_!)(.a-z\d]{6,16}$/i);

    // If the check fails, return an error message
    if(!result)
    {
        error = "Invalid characters in password or password is too short (long)";
        return error;
    }

    // If all is OK - return true
    return true;
}

function ValidateUserData()
{
    var login = document.getElementById("txtLogin").value;
    var password = document.getElementById("txtPassword").value;
    var password_again = document.getElementById("txtPasswordAgain").value;
    // Removes spaces from the beginning and end of the line
    login = login.trim();
    password = password.trim();
    password_again = password_again.trim();

    // If the login fails the check, there will be an error message
    var error_login = CheckLogin(login);
    if (error_login != true)
    {
        document.getElementById("divLoginError").innerHTML = error_login;
    }
    else
    {
        document.getElementById("divLoginError").innerHTML = "";
    }
    
    // If the password fails the check, there will be an error message
    var error_password = CheckPassword(password);
    if (error_password != true)
    {
        document.getElementById("divPasswordError").innerHTML = error_password;
    }
    else
    {
        document.getElementById("divPasswordError").innerHTML = "";
    }
    
    // If the password is entered correctly, but the passwords are not identical, there will be an error message
    var error_password_again = (password === password_again);
    if (error_password_again != true)
    {
        document.getElementById("divPasswordAgainError").innerHTML = "The passwords you entered do not match";
    }
    else
    {
        document.getElementById("divPasswordAgainError").innerHTML = "";
    }
    
    if ((error_login == true) && (error_password == true) && (error_password_again == true))
    {
        return true;
    }
    else
    {
        return false;
    }
}
