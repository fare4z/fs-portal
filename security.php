<?php
$raw_email = "  hacker@example.com <script> alert('hello')</script> ";

// echo $raw_email;

// 1. Sanitize: Remove whitespace and dangerous tags
$clean_email = filter_var(trim($raw_email), FILTER_SANITIZE_EMAIL);

echo $clean_email;

// 2. Validate: Check if it's actually a valid email format
// if (filter_var($clean_email, FILTER_VALIDATE_EMAIL)) {
//  echo "Valid email: $clean_email";
// } else {
//  echo "Invalid email provided!";
// }


$plainPassword = "password";

$md5_password = md5($plainPassword);
$sha1_password = sha1($plainPassword);

$password_hash = password_hash($plainPassword,PASSWORD_DEFAULT);

echo "<br>Plain Password : " . $plainPassword;
echo "<br>";
echo "MD5 Pass : " . $md5_password;
echo "<br> SHA1 Pass " . $sha1_password;
echo "<br> Password Hash ". $password_hash;
echo "<br>";

if(password_verify("password123", $password_hash)) {
    echo "Correct Password";
} else {
    echo "Incorrect Password";
}



?>
