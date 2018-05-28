<html>
    <head>
        <link rel="stylesheet" href="style/page_style.css">
        <title>Main page</title>
    </head>
    <body  >
        <div id="buttons_div" style="margin-left: 50px; margin-right: 50px">
          <button id="login_button" class="main_page_button" onclick="window.location.href='login.php'" ><span>Log In</span></button>
          <button id="registration_button" style="float: right;" class="main_page_button" onclick="window.location.href='registration.php'" ><span>Registration</span></button>
          <script>
            function Resize(){
              var resize_koef=window.innerWidth/1920;
              var new_text_size = (28*(resize_koef)).toFixed(0);
              var new_text_padding = (20*(resize_koef)).toFixed(0);
              var new_margin = (50*(resize_koef)).toFixed(0);
              document.getElementById("login_button").style["fontSize"] = new_text_size;
              document.getElementById("login_button").style.padding = new_text_padding;
              document.getElementById("registration_button").style.fontSize = new_text_size;
              document.getElementById("registration_button").style.padding = new_text_padding;
              document.getElementById("main_image_div").style["margin-left"] = new_margin;
              document.getElementById("main_image_div").style["margin-right"] = new_margin;
              document.getElementById("buttons_div").style["margin-left"] = new_margin;
              document.getElementById("buttons_div").style["margin-right"] = new_margin;
            }
          </script>
        </div>
        <div id="main_image_div" style="margin-left: 50px; margin-right: 50px">
            <img  style="width:100%"
                 src="images/start_image.jpg"
                 alt="Ship ship" >
            <br/><br/><br/>
            <p style="width:50%">Welcome to our site!</h1>
        </div>
    </body>
</html>
