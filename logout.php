<?php
session_start();
session_destroy();

session_start();
$_SESSION['flash_msg'] = [
    'type' => 'success',
    'msg' => 'Anda telah log keluar.'
];
header("Location: login.php");
exit;
