<?php

@include 'config.php';

// Fungsi untuk menghapus auth_token dari database
function clearRememberToken($username)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $username);

    $updateToken = "UPDATE user_form SET auth_token = NULL WHERE username = '$username'";
    mysqli_query($conn, $updateToken);
}

session_start();

// Hapus nilai auth_token dari database saat logout
if (isset($_SESSION['user_name'])) {
    clearRememberToken($_SESSION['user_name']);
} elseif (isset($_SESSION['admin_name'])) {
  clearRememberToken($_SESSION['admin_name']);
}
// Hancurkan sesi
session_unset();
session_destroy();


// Hapus cookie PHPSESSID
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Hapus semua cookie termasuk auth_token
setcookie('auth_token', '', time() - 3600, '/');

// Redirect ke halaman login
header('Location: index.php');
exit();
?>
