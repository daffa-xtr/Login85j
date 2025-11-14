<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "config.php";

$message = "";

if (isset($_POST['login'])) {
    $email    = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
            $message = "⚠️ Akun terkunci, coba lagi setelah 5 menit.";
        } elseif (password_verify($password, $user['password'])) {
            $conn->query("UPDATE users SET failed_attempts=0, locked_until=NULL WHERE id=".$user['id']);
            $_SESSION['user'] = $user['fullname'];
            $_SESSION['last_activity'] = time();
            header("Location: home.php");
            exit;
        } else {
            $failed = $user['failed_attempts'] + 1;
            if ($failed >= 3) {
                $lock_time = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                $conn->query("UPDATE users SET failed_attempts=$failed, locked_until='$lock_time' WHERE id=".$user['id']);
                $message = "⚠️ Akun terkunci 5 menit karena 3x gagal login.";
            } else {
                $conn->query("UPDATE users SET failed_attempts=$failed WHERE id=".$user['id']);
                $message = "Email atau password salah.";
            }
        }
    } else {
        $message = "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 300px;
        }
        input {
            display: block;
            margin: 10px 0;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            padding: 10px;
            width: 100%;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background: #0069d9; }
        .message { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if($message != "") { echo "<p class='message'>$message</p>"; } ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login Sekarang</button>
        </form>
        <p>Belum punya akun? <a href="registrasi.php">Daftar di sini</a></p>
    </div>
</body>
</html>
