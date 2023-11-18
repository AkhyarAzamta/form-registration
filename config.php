<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "user_db";

$conn    = mysqli_connect($host, $user, $pass, $db);
if (!$conn) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}  else {
  // echo "KONEKSI TERHUBUNG GAES!!!";
}
?>