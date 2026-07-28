<?php
// Set Cookie 
setcookie("username", "Fareez", time() + 30 * 24 * 60 * 60, "/");
setcookie("isLoggedIn", true, time()+3600, "/");

// Retrieve Cookie
if (!isset($_COOKIE['username'])) {
    echo "Cookie named 'username' is not set!";
} else {
    echo "Cookie 'username' is set!<br>";
    echo "Value is: " . $_COOKIE['username'];
}
