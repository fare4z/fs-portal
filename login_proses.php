<?php
include_once "includes/db_connect.php";
session_start();

$nric = $_POST['nric'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE nric = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['flash_msg'] = [
        'type' => 'error',
        'msg' => 'Sistem gagal memproses permintaan.'
    ];

    header("Location: login.php");
    exit;
}

$stmt->bind_param("s", $nric);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        $_SESSION['flash_msg'] = [
            'type' => 'success',
            'msg' => 'Log Masuk Berjaya.'
        ];

        header("Location: dashboard.php");
        exit;
    }
}

$_SESSION['flash_msg'] = [
    'type' => 'error',
    'msg' => 'Log Masuk Gagal. Sila cuba semula.'
];

header("Location: login.php");
exit;
