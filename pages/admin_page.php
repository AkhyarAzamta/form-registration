<?php
include '../config/config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
   header('location:../index.php');
   exit();
}

if (isset($_GET['op'])) {
   $op = $_GET['op'];
} else {
   $op = "";
}

if ($op == 'delete') {
   $id = $_GET['id'];
   $sql1 = "DELETE FROM user_form WHERE id = '$id'";
   $q1 = mysqli_query($conn, $sql1);
   if ($q1) {
      $sukses = "Berhasil hapus data";
   } else {
      $error = "Gagal melakukan delete data";
   }
}

if ($op == 'edit') {
   $id = $_GET['id'];
   $sql1 = "SELECT * FROM user_form WHERE id = '$id'";
   $q1 = mysqli_query($conn, $sql1);
   $r1 = mysqli_fetch_array($q1);
   $user_type = $r1['user_type'];
   $organization = $r1['organization'];
   $address = $r1['address'];
   $province = $r1['province'];
   $nik = $r1['nik'];
   $npwp = $r1['npwp'];
   $phone = $r1['phone'];
   $email = $r1['email'];
   $username = $r1['username'];
   include './crud.php';

   if ($user_type == '') {
      $error = "Data tidak ditemukan";
   }
}

if (isset($_POST['simpan'])) {
   $organization = $_POST['organization'];
   $address = $_POST['address'];
   $province = $_POST['province'];
   $nik = $_POST['nik'];
   $npwp = $_POST['npwp'];
   $phone = $_POST['phone'];
   $email = $_POST['email'];
   $username = $_POST['username'];
   header("refresh:2;url=admin_page.php"); //5 : detik
   if ($organization && $address && $province && $nik && $npwp && $phone && $email && $username) {
      if ($op == 'edit') {
         $sql1 = "UPDATE user_form SET organization='$organization', address = '$address', province = '$province', nik='$nik', npwp='$npwp', phone='$phone', email='$email', username='$username' WHERE id = '$id'";
         $q1 = mysqli_query($conn, $sql1);
         if ($q1) {
            $sukses = "Data berhasil diupdate";
         } else {
            $error = "Data gagal diupdate";
         }
      }
   } else {
      $error = "Silakan masukkan semua datanya";
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Data jabatan Mahauser_form Karyawan Tekuser_type Uninus</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
   <style>
      .mx-auto {
         width: 95vw;
      }
      .card {
         margin: 7rem 2rem;
      }
#alert {
   display: flex;
   position: absolute;
   justify-content: center;
   align-items: center;
   z-index: 100;
   top: 0;
   width: 100%;
}
   </style>
   <nav class="navbar navbar-expand-lg bg-info position-absolute w-100 top-0 ">
      <div class="container-fluid">
         <a class="navbar-brand text-dark" href="#">Welcome <span><?php echo $_SESSION['admin_name'] ?></span></a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <a class="nav-link active text-dark" aria-current="page" href="../logout.php">Logout</a>
               </li>
            </ul>
         </div>
      </div>
   </nav>
</head>

<body>
<?php
            if ($error) {
            ?>
               <div id="alert" class="alert alert-danger" role="alert">
                  <?php echo $error ?>
               </div>
            <?php
               header("refresh:5;url=admin_page.php"); //5 : detik
            }
            ?>
            <?php
            if ($sukses) {
            ?>
               <div id="alert" class="alert alert-success" role="alert">
                  <?php echo $sukses ?>
               </div>
            <?php
               header("refresh:5;url=admin_page.php");
            }
            ?>
   <!-- Display the data table -->
   <div class="card">
      <div class="card-header text-white bg-gradient bg-primary">
         Data User & Admin
      </div>
      <div class="card-body">
         <table class="table table-striped table-hover">
            <thead>
               <tr>
                  <th scope="col">User Type</th>
                  <th scope="col">Organization</th>
                  <th scope="col">Address</th>
                  <th scope="col">Province</th>
                  <th scope="col">NIK</th>
                  <th scope="col">NPWP</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Email</th>
                  <th scope="col">Username</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               // Fetch and display data from the database
               $sql = "SELECT * FROM user_form";
               $result = mysqli_query($conn, $sql);

               while ($row = mysqli_fetch_assoc($result)) {
                  $id = $row['id'];
                  $user_type = $row['user_type'];
                  $organization = $row['organization'];
                  $address = $row['address'];
                  $province = $row['province'];
                  $nik = $row['nik'];
                  $npwp = $row['npwp'];
                  $phone = $row['phone'];
                  $email = $row['email'];
                  $username = $row['username'];
               ?>
                  <tr>
                     <td scope='row'><?php echo $user_type; ?></td>
                     <td scope='row'><?php echo $organization; ?></td>
                     <td scope='row'><?php echo $address; ?></td>
                     <td scope='row'><?php echo $province; ?></td>
                     <td scope='row'><?php echo $nik; ?></td>
                     <td scope='row'><?php echo $npwp; ?></td>
                     <td scope='row'><?php echo $phone; ?></td>
                     <td scope='row'><?php echo $email; ?></td>
                     <td scope='row'><?php echo $username; ?></td>
                     <td>
                        <a href='?op=edit&id=<?php echo $id ?>'><button type="button" class="btn btn-warning">Edit</button></a>
                        <a href='?op=delete&id=<?php echo $id; ?>' onclick="return confirm('Yakin mau delete data?')"><button type='button' class='btn btn-danger'>Delete</button></a>
                     </td>
                  </tr>
               <?php
               }
               ?>
            </tbody>


      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>