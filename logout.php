<?php

@include './config/config.php';

function clearRememberToken($username)
{
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $updateToken = "UPDATE user_form SET auth_token = NULL WHERE username = '$username'";
    mysqli_query($conn, $updateToken);
}

session_start();

if (isset($_SESSION['user_name'])) {
    clearRememberToken($_SESSION['user_name']);
} elseif (isset($_SESSION['admin_name'])) {
  clearRememberToken($_SESSION['admin_name']);
}

session_unset();
session_destroy();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

setcookie('auth_token', '', time() - 3600, '/');

header('Location: ./index.php');
exit();
?>