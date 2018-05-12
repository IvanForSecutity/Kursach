<?php

//
// Function for connecting to the MySQL database.
// The function does not accept any parameters.
// The function is intended to be used, basically, with one database
//
// TODO: Спрятать данные страницы от всех, кроме рута!
// TODO: Меня заебало видеть варнинги от нашего чересчур нового mysql. Надо бы функции заменить на новые чтоли...

function connect() {
    // Declare the variables in which the parameters for connecting to the DB will be stored
    $db_host = 'localhost';     // Server
    $db_user = 'root';          // Login
    $db_password = '';          // Password
    $db_name = 'kr_database';   // DB name
    $port = '3306';
    $link = mysqli_init();
    $conn = mysqli_real_connect(
            $link, $db_host, $db_user, $db_password, $db_name, $port
    );
    // Connect to server
    //$conn = mysql_connect($db_host, $db_user, $db_password) or die("<p>Невозможно подключиться к СУБД: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

    // This part of the code is only executed if the connection to the server is successful.
    // Choose DB
    $db = mysqli_select_db ($link,$db_name ) or die("<p>Невозможно подключиться к базе данных: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");

    // This part of the code is only executed if the connection to the database is successful.
    // Tell the server that the data we receive from it, we need in the UTF-8 encoding
    $query = mysqli_query($link,"set names utf8" ) or die("<p>Невозможно выполнить запрос к базе данных: " . mysqli_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
        return $link;
}
?>