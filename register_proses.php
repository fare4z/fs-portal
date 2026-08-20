<?php
include_once "includes/db_connect.php";
session_start();
$name = $_POST['name'];
$nric = $_POST['nric'];
$program = $_POST['program'];
$password = $_POST['password'];

// var_dump($_POST);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if (strlen($nric) <> 12) {
    $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Please Enter 12 Character only'];

    header("Location: register.php");
    exit;
}

$sql = "SELECT * from users where nric = ?";
$stmt = $conn->prepare($sql);

// Bind Parameter
$stmt->bind_param("s", $nric);
$stmt->execute();
// Get result
$result = $stmt->get_result();

if ($result->num_rows >= 1) { 
     $_SESSION['flash_msg'] = [
        'type' => 'error',
        'msg' => 'Nombor IC sudah wujud.'
    ];

    header("Location: login.php");
    die;
}

// Prepare SQL stament for insert

// 1. Prepare the SQL statement ('?' are secure placeholders)

$sql = "INSERT into users (name, nric, program, password) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);

// 2. Bind parameters ("ssss" = 4 strings)
$stmt->bind_param("ssss", $name, $nric, $program, $hashed_password);

if ($stmt->execute()) {
    $stmt->close();
    $_SESSION['flash_msg'] = ['type' => 'success', 'msg' => 'Pendaftaran Berjaya. Sila log masuk menggunakan nombor ic dan password yang didaftarkan'];
    header("Location: login.php");
} else {
    $stmt->close();
    // return false;
    $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Pendaftaran Tidak Berjaya'];

    header("Location: register.php");
}
