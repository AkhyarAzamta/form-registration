<?php
@include './config/config.php';
function generateUniqueToken()
{
   return bin2hex(random_bytes(50));
}
if (isset($_SESSION['admin_name'])) {
   header('location:admin_page.php');
   exit();
} elseif (isset($_SESSION['user_name'])) {
   header('location:./pages/user_page.php');
   exit();
}
session_start();
if (isset($_COOKIE['auth_token'])) {
   $auth_token = mysqli_real_escape_string($conn, $_COOKIE['auth_token']);
   $selectUser = "SELECT * FROM user_form WHERE auth_token = '$auth_token'";
   $resultUser = mysqli_query($conn, $selectUser);
   if (mysqli_num_rows($resultUser) > 0) {
      $rowUser = mysqli_fetch_array($resultUser);
      if ($rowUser['user_type'] == 'admin') {
         $_SESSION['admin_name'] = $rowUser['username'];
         header('location:./pages/admin_page.php');
         exit();
      } elseif ($rowUser['user_type'] == 'user') {
         $_SESSION['user_name'] = $rowUser['username'];
         header('location:./pages/user_page.php');
         exit();
      }
   } else {
      setcookie('auth_token', '', 1, '/');
   }
}
if (isset($_POST['submit'])) {
   $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);
   $pass = $_POST['password'];
   $user_type = $_POST['user_type'];
   $remember = isset($_POST['remember']) ? $_POST['remember'] : false;
   $select = " SELECT * FROM user_form WHERE email = '$identifier' OR username = '$identifier'";
   $result = mysqli_query($conn, $select);
   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);
      $hashedPassword = $row['password'];
      if (password_verify($pass, $hashedPassword)) {
         if ($remember) {
            $auth_token = generateUniqueToken();
            $updateToken = "UPDATE user_form SET auth_token = '$auth_token' WHERE email = '$email' OR username = '$identifier'";
            mysqli_query($conn, $updateToken);
            setcookie('auth_token', $auth_token, time() + 3600 * 24 * 30, '/');
         } else {
            setcookie('auth_token', '', 1, '/');
         }
         if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['username'];
            header('location:./pages/admin_page.php');
            exit();
         } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['username'];
            header('location:./pages/user_page.php');
            exit();
         }
      } else {
         $error[] = 'Password tidak sesuai, coba ulangi kembali.';
      }
   } else {
      $error[] = 'Email/Username salah atau akun Anda belum terdaftar.';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Selamat Datang</title>
   <link rel='stylesheet' type='text/css' href='assets/css/style.css' />
</head>
<body>
   <div class="form-container">
      <img src="./assets/images/sipd.png" alt="Logo SIPD" style="width: 250px; height: 100px;">
      <form action="" method="post">
         <h3>Selamat Datang</h3>
         <input type="text" name="identifier" required placeholder="masukan username atau email">
         <input type="password" name="password" required placeholder="masukan password">
         <div class="remember-me">
            <label for="remember">Ingat Saya?
               <input type="checkbox" name="remember" id="remember">
            </label>
         </div>
         <?php
         if (isset($error)) {
            foreach ($error as $error_message) {
               echo '<div style="padding-bottom: 5px;" id="password-error">' . $error_message . '</div>';
            }
         } else {
            echo '<div class="error-message" id="password-error"></div>';
         }
         ?>
         <input type="submit" name="submit" value="Masuk" class="form-btn">
         <p class="account">Belum Punya Akun? <a href="./register_form.php">Daftar Sekarang</a></p>
      </form>
   </div>
</body>

</html>