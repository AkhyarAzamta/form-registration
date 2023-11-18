<?php

@include 'config.php';

if(isset($_POST['submit'])){
   $user_type = $_POST['user_type'];
   $organization = mysqli_real_escape_string($conn, $_POST['organization']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);
   $province = mysqli_real_escape_string($conn, $_POST['province']);
   $nik = mysqli_real_escape_string($conn, $_POST['nik']);
   $npwp = mysqli_real_escape_string($conn, $_POST['npwp']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   
   $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";
   $result = mysqli_query($conn, $select);
// echo "eror sebelum baris 20";
   if(mysqli_num_rows($result) > 0){
      echo "eror sebelum baris 23";
      $error[] = 'User already exists!';
   } else {
      echo "eror sebelum baris 27";
      if($pass != $cpass){
         $error[] = 'Password not matched!';

      } else {
         echo "eror sebelum baris 33";
         $insert = "INSERT INTO user_form(user_type, organization, address, province, nik, npwp, phone, email, username, password) VALUES ('$user_type', '$organization', '$address', '$province', '$nik', '$npwp', '$phone', '$email', '$username', '$pass')";
         mysqli_query($conn, $insert);
         header('location:index.php');

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
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel='stylesheet' type='text/css' href='./css/style.css' />


</head>
<body>
<section>
      <img src="./spid.png" alt="Logo SIPD" style="width: 250px; height: 100px;">
    <form action="" id="registrationForm" method="POST">
      <h2>FORM REGISTRASI</h2>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>

      <label for="user-type">Jenis Profil<span class="required">*</span></label>
      <select name="user_type" required>
        <option value="" disabled selected>-- Pilih Jenis Profil --</option>
        <option value="user">user</option>
        <option value="admin">admin</option>
      </select>

      <label for="organization">Nama Lembaga/Organisasi/Individu<span class="required">*</span></label>
      <input type="text" id="organization" name="organization" required placeholder="Nama Lembaga/Organisasi/Individu">

      <label for="address">Alamat<span class="required">*</span></label>
      <input id="address" name="address" required placeholder="Alamat"></input>

      <label for="province">Provinsi<span class="required">*</span></label>
      <input type="text" id="province" name="province" required placeholder="Provinsi">

      <label for="nik">NIK<span class="required">*</span></label>
      <input type="text" id="nik" name="nik" required placeholder="NIK">

      <label for="npwp">NPWP<span class="required">*</span></label>
      <input type="text" id="npwp" name="npwp" required placeholder="NPWP">

      <label for="phone">No. Telepon<span class="required">*</span></label>
      <input type="tel" id="phone" name="phone" required placeholder="No. Telepon">

      <label for="email">Email<span class="required">*</span></label>
      <input type="email" id="email" name="email" required placeholder="Email">

      <label for="username">Username<span class="required">*</span></label>
      <input type="text" id="username" name="username" required placeholder="Username">

      <label for="password">Password<span class="required">*</span></label>
      <input type="password" id="password" name="password" required placeholder="Password">
      <div class="error-message" id="password-error"></div>
      
      <label for="confirm-password">Konfirmasi Password<span class="required">*</span></label>
      <input type="password" id="confirm-password" name="cpassword" required placeholder="Konfirmasi">

      <input type="submit" name="submit" value="register now" class="form-btn">      <!-- onclick="validateForm()" disabled -->
    </form>
  </section>
  <!-- <script src="./js/script.js"></script> -->
</body>
</html>