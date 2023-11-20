<?php

@include './config/config.php';

if (isset($_POST['submit'])) {
   $user_type = $_POST['user_type'];
   $organization = mysqli_real_escape_string($conn, $_POST['organization']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);
   $province = mysqli_real_escape_string($conn, $_POST['province']);
   $nik = mysqli_real_escape_string($conn, $_POST['nik']);
   $npwp = mysqli_real_escape_string($conn, $_POST['npwp']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];

   $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";
   $result = mysqli_query($conn, $select);

   $number = preg_match('@[0-9]@', $pass);
   $uppercase = preg_match('@[A-Z]@', $pass);
   $lowercase = preg_match('@[a-z]@', $pass);
   $specialChars = preg_match('@[^\w]@', $pass);

   if (strlen($pass) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
      $error[] = "Password minimal harus 8 karakter, terdiri dari huruf kecil, huruf besar, angka, dan karakter spesial.";
   } elseif ($pass != $cpass) {
      $error[] = 'Password tidak cocok!';
   } else {
      if (mysqli_num_rows($result) > 0) {
         $error[] = 'User already exists!';
      } else {
         $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
         $insert = "INSERT INTO user_form(user_type, organization, address, province, nik, npwp, phone, email, username, password) VALUES ('$user_type', '$organization', '$address', '$province', '$nik', '$npwp', '$phone', '$email', '$username', '$hashedPassword')";
         mysqli_query($conn, $insert);
         header('location:./index.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Daftar Sekarang</title>
   <link rel='stylesheet' type='text/css' href='./assets/css/style.css' />
</head>

<body>
   <section class="container-regist">
      <img src="./assets/images/sipd.png" alt="Logo SIPD" style="width: 250px; height: 100px;">
      <form action="" id="registrationForm" method="POST">
         <h2>FORM REGISTRASI</h2>
         <!-- Jenis Profil -->
         <label for="user-type">Jenis Profil<span class="required">*</span></label>
         <select name="user_type" required>
            <option value="" disabled selected>-- Pilih Jenis Profil --</option>
            <option value="user" <?php if (isset($_POST['user_type']) && $_POST['user_type'] == 'user') echo 'selected'; ?>>user</option>
            <option value="admin" <?php if (isset($_POST['user_type']) && $_POST['user_type'] == 'admin') echo 'selected'; ?>>admin</option>
         </select>
         <!-- Nama Lembaga -->
         <label for="organization">Nama Lembaga/Organisasi/Individu<span class="required">*</span></label>
         <input autocomplete="off" type="text" id="organization" name="organization" value="<?php echo isset($_POST['organization']) ? $_POST['organization'] : ''; ?>" required placeholder="Nama Lembaga/Organisasi/Individu">
         <!-- Alamat -->
         <label for="address">Alamat<span class="required">*</span></label>
         <input autocomplete="off" id="address" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>" required placeholder="Alamat"></input autocomplete="off">
         <!-- Provinsi -->
         <label for="province">Provinsi<span class="required">*</span></label>
         <input autocomplete="off" type="text" id="province" name="province" value="<?php echo isset($_POST['province']) ? $_POST['province'] : ''; ?>" required placeholder="Provinsi">
         <!-- NIK -->
         <label for="nik">NIK<span class="required">*</span></label>
         <input autocomplete="off" type="text" id="nik" name="nik" value="<?php echo isset($_POST['nik']) ? $_POST['nik'] : ''; ?>" required placeholder="NIK">
         <!-- NPWP -->
         <label for="npwp">NPWP<span class="required">*</span></label>
         <input autocomplete="off" type="text" id="npwp" name="npwp" value="<?php echo isset($_POST['npwp']) ? $_POST['npwp'] : ''; ?>" required placeholder="NPWP">
         <!-- No. Telepon -->
         <label for="phone">No. Telepon<span class="required">*</span></label>
         <input autocomplete="off" type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" required placeholder="No. Telepon">
         <!-- Email -->
         <label for="email">Email<span class="required">*</span></label>
         <input autocomplete="off" type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required placeholder="Email">
         <!-- Username -->
         <label for="username">Username<span class="required">*</span></label>
         <input autocomplete="off" type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required placeholder="Username">
         <!-- Password -->
         <label for="password">Password<span class="required">*</span></label>
         <input autocomplete="off" type="password" id="password" name="password" required placeholder="Password">
         <div class="error-message" id="password-error"></div>
         <!-- Konfirmasi Password -->
         <label for="confirm-password">Konfirmasi Password<span class="required">*</span></label>
         <input type="password" id="confirm-password" name="cpassword" required placeholder="Konfirmasi">
         <?php
         if (isset($error)) {
            foreach ($error as $error_message) {
               echo '<div style="padding-bottom: 5px;" id="password-error">' . $error_message . '</div>';
            }
         } else {
            echo '<div class="error-message" id="password-error"></div>';
         }
         ?>
         <input type="submit" name="submit" value="Simpan" id="submit-button" disabled>
         <p class="account">Sudah Punya Akun? <a href="./index.php">Yuk Masuk</a></p>
      </form>
   </section>
   <script type="text/javascript" src="./assets/js/script.js"></script>
</body>

</html>