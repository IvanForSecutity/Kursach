<?php

// Anti-CSRF token
$token = md5(openssl_random_pseudo_bytes(20));
$_SESSION['token'] = $token;

?>