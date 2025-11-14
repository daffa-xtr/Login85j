<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "users"; // pastikan sesuai nama database di phpMyAdmin

$conn = new mysqli("localhost", "root", "", "users");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
