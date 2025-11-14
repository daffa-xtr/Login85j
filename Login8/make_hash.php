<?php
// make_hash.php — akses via browser: http://localhost/Login/make_hash.php?pw=PASSWORD
if (!isset($_GET['pw'])) {
    echo "Gunakan: ?pw=PASSWORD (contoh: ?pw=admin123)";
    exit;
}
$pw = $_GET['pw'];
$hash = password_hash($pw, PASSWORD_BCRYPT);
echo "Password: " . htmlspecialchars($pw) . "<br>";
echo "Hash: " . $hash . "<br><br>";
echo "Copy baris SQL ini (ganti email sesuai):<br>";
echo "UPDATE users SET password = '" . $hash . "', failed_attempts = 0, locked_until = NULL WHERE email = 'admin@test.com';";
?>
