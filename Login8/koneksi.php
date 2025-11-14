<?php
$servername = "localhost";
$database = "users";
$username = "root";
$password = "";

$conn = mysqli_connect("localhost", "root", "", "users");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());    
} else {
    echo "koneksi Berhasil";
}
