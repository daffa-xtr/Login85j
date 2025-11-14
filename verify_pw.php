<?php
// verify_pw.php
// Akses: http://localhost/Login/verify_pw.php?email=admin@test.com&pw=admin123
include "config.php";

if (!isset($_GET['email']) || !isset($_GET['pw'])) {
    echo "Gunakan: ?email=...&pw=... (contoh: ?email=admin@test.com&pw=admin123)";
    exit;
}

$email = trim($_GET['email']);
$pw = $_GET['pw'];

echo "Koneksi: ";
if ($conn->connect_error) {
    die("Gagal koneksi: " . $conn->connect_error);
} else {
    echo "OK<br><br>";
}

$stmt = $conn->prepare("SELECT password FROM users WHERE email=?");
if (!$stmt) {
    die("Prepare error: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $hash = $row['password'];
    echo "Hash dari DB: " . htmlspecialchars($hash) . "<br>";
    echo "Password yang diuji: " . htmlspecialchars($pw) . "<br><br>";
    if (password_verify($pw, $hash)) {
        echo "<b style='color:green'>password_verify = TRUE (password cocok)</b>";
    } else {
        echo "<b style='color:red'>password_verify = FALSE (password TIDAK cocok)</b>";
    }
} else {
    echo "User tidak ditemukan dengan email: " . htmlspecialchars($email);
}
?>