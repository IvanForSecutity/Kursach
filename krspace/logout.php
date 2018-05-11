<?php

//
// The user exit from the system script.
// Since users are authorized through sessions,
// their login and session hash are stored in the $ _SESSION super-globan array.
// To log out, simply destroy the values of the array
// $ _SESSION ['login'] and $ _SESSION ['session_hash'],
// after which we redirect the user to the authorization page
//

// TODO: Это не для красоты. Надо бы кнопочку везде добавить для выхода...
// TODO: И вообще, надо как-то закрывать сессию через некоторое время. Или оно само?

session_start();

unset($_SESSION['login']);
unset($_SESSION['session_hash']);
unset($_SESSION['cur_ship']);
header('location: login.php');
?>
