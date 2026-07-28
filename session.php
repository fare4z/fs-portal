<?php 
session_start();

$_SESSION['firstName'] = "Fareez";
$_SESSION['lastName'] = "Borhanudin";

if (isset($_SESSION['firstName'])) {
    echo $_SESSION['firstName'];
}


function logout() {
    session_destroy();
}

logout();