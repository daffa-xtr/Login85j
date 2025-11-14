<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}

// cek timeout 5 menit
if (time() - $_SESSION['last_activity'] > 300) {
    session_unset();
    session_destroy();
    header("Location: login.html?timeout=1");
    exit;
}

$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Beranda</title>
</head>
<body>
  <h2>Selamat datang, <?php echo $_SESSION['user']; ?>!</h2>
  <a href="logout.php">Logout</a>
</body>
</html>
