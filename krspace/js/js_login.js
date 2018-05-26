function LogIn()
{
    if (ValidateLoginData())
    {
        AuthorizeUser();
    }
}

// Local parameter for password hashing
var local_parameter = "hecatonicosachoron";

function ValidateLoginData()
{
    var login = document.getElementById("txtLogin").value;
    var password = document.getElementById("txtPassword").value;

    // Removes spaces from the beginning and end of the line
    login = login.trim();
    password = password.trim();

    // If the login is empty, there will be an error message
    var error_login = (login !== "");
    if (error_login != true)
    {
        document.getElementById("divLoginError").innerHTML = "You did not enter a login";
    }
    else
    {
        document.getElementById("divLoginError").innerHTML = "";
    }
    
    // If the password is empty, there will be an error message
    var error_password = (password !== "");
    if (error_password != true)
    {
        document.getElementById("divPasswordError").innerHTML = "You did not enter a password";
    }
    else
    {
        document.getElementById("divPasswordError").innerHTML = "";
    }
    
    if ((error_login === true) && (error_password === true))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function AuthorizeUser()
{
    var login = document.getElementById("txtLogin").value;
    var password = document.getElementById("txtPassword").value;
    var remember = $("#cbxRemember").prop('checked') ? 1 : 0;

    // Removes spaces from the beginning and end of the line
    login = login.trim();
    password = password.trim();
    
    // Calculate sha512 hash of password + local parameter
    new Sha512();
    var hashed_password = Sha512.hash(password + local_parameter);

    var ajax_request = "auth=true" + "&login=" + login + "&hashed_password=" + hashed_password + "&remember=" + remember;

    $.ajax({
        type: "POST",
        url: "ajax/users_authorization.php",
        data: ajax_request,
        dataType: "html",
        success: function(data) {
            if(data.indexOf('You have been successfully authorized in the system') + 1)
            {
                // Success
                document.getElementById("divLoginResult").className = "";
                document.getElementById("divLoginResult").innerHTML = data;

                // Redirect to hangar page
                setTimeout(function(){
                    window.location.href = 'hangar.php';
                }, 5 * 1000);
            }
            else
            {
                // Failure
                document.getElementById("divLoginResult").className = "error";
                document.getElementById("divLoginResult").innerHTML = data;
            }            

            return true;
        },
        error: function() { 
            msg(errorText,"error",5000);

            return false;
        }	
    });
}


