<?php 
include_once "includes/db_connect.php";

$name = $_POST['name'];
$nric = $_POST['nric'];
$program = $_POST['program'];
$password = $_POST['password'];

// Prepare SQL stament for insert

$sql = "INSERT into users (name, nric, program, password) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);

// Bind Parameter 
$stmt -> bind_param("ssss", $name, $nric, $program, $password);

if ($stmt->execute()) {
    $stmt->close();
    echo "Success";
} else {
    $stmt->close();
    // return false;
    echo "Fail";
}



?>