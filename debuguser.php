<?php
include "config.php";

$email = 'admin@test.com'; // ganti dengan email yang mau dicek

$stmt = $conn->prepare("SELECT id, fullname, email, password, failed_attempts, locked_until FROM users WHERE email=?");
if (!$stmt) { die("Prepare error: " . $conn->error); }
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    echo "<pre>ROW FROM DB:\n";
    print_r($row);
    echo "</pre>";
} else {
    echo "User tidak ditemukan dengan email: " . htmlspecialchars($email);
}
?>