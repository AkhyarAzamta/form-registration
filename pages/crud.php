<?php
@include '../config/config.php';
?>
<section class="mx-auto" style="margin: 7rem">
  <!-- untuk memasukkan data -->
  <div class="card">
    <div class="card-header bg-info bg-gradient ">
      Edit Data
    </div>
    <div class="card-body">
      <form action="" method="POST">
        <div class="mb-3 row">
        </div>
        <div class="mb-3 row">
          <label for="organization" class="col-sm-2 col-form-label">Organization</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="organization" name="organization" value="<?php echo $organization ?>" autocomplete="off">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="address" class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="province" class="col-sm-2 col-form-label">Province</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="province" name="province" value="<?php echo $province ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="nik" class="col-sm-2 col-form-label">NIK</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="nik" name="nik" value="<?php echo $nik ?>" autocomplete="off">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="npwp" class="col-sm-2 col-form-label">NPWP</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="npwp" name="npwp" value="<?php echo $npwp ?>" autocomplete="off">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="phone" class="col-sm-2 col-form-label">PHONE</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="phone" name="phone" value="<?php echo $phone ?>" autocomplete="off">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" autocomplete="off">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="username" class="col-sm-2 col-form-label">Username</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>" autocomplete="off">
          </div>
        </div>
        <div class="col-12">
          <input type="submit" name="simpan" value="Simpan Data" class="btn btn-success" />
          <a class="btn btn-info " href="admin_page.php" role="button">Batal</a>
        </div>
    </div>
    </form>

</section>