<?php 
require 'koneksi.php';
error_reporting(0);
session_start();

if (isset($_POST['submit'])){
  $nama_baru = $_POST['newNama'];
  $username_baru = $_POST['newUsername'];
  $password_baru = $_POST['newPassword'];
  $alamat_baru = $_POST['newAlamat'];
  $no_ktp_baru = $_POST['newNoKTP'];
  $no_hp_baru = $_POST['newNoHP'];
  $queri1 = mysqli_query($mysqli, "SELECT * FROM pasien WHERE no_ktp='$no_ktp_baru'");
  if ($queri1->num_rows > 0) {
    echo "<script>alert('Maaf tapi No KTP sudah teregistrasi!');
        window.location.href = 'registerPasien.php';
            </script>";
  } else{
    $queri2 = mysqli_query($mysqli, "INSERT INTO 
        pasien(nama,username,password,alamat,no_ktp,no_hp) VALUES(
            '$nama_baru','$username_baru','$password_baru','$alamat_baru','$no_ktp_baru','$no_hp_baru')");
    if($queri2){
        $lastid = $mysqli->insert_id;
        $tahun_sekarang = date("Y");
        $bulan_sekarang = date("m");
        $no_rm_baru = $tahun_sekarang . $bulan_sekarang . "-" . $lastid;
        $queri1 = mysqli_query($mysqli, "UPDATE pasien SET 
            no_rm='$no_rm_baru' WHERE id='$lastid'");
        echo "<script>alert('Selamat, Anda berhasil registrasi Pasien!');
            window.location.href = 'loginPasien.php';
                </script>";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Poliklinik</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary mt-5 mb-5">
    <div class="card-header text-center">
      <a href="index2.html" class="h1"><b>Register</b>PASIEN</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Lengkapi Data untuk Register</p>

      <form action="" method="post">
        <!-- Date dd/mm/yyyy -->
        <div class="form-group">
          <label>Nama:</label>

          <div class="input-group">
            <input type="text" class="form-control" placeholder="Masukkan Nama" 
              name="newNama" required>
          </div>
          <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- Date mm/dd/yyyy -->
        <div class="form-group">
          <label>Username:</label>

          <div class="input-group">
            <input type="text" class="form-control" placeholder="Masukkan Username" 
              name="newUsername" required>
          </div>
          <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- Date dd/mm/yyyy -->
        <div class="form-group">
          <label>Password:</label>

          <div class="input-group">
            <input type="password" class="form-control" placeholder="Masukkan Password" 
              name="newPassword" required>
          </div>
          <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- Date mm/dd/yyyy -->
        <div class="form-group">
          <label>Alamat:</label>

          <div class="input-group">
            <input type="text" class="form-control" placeholder="Masukkan Alamat" 
              name="newAlamat" required>
          </div>
          <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- phone mask -->
        <div class="form-group">
          <label>No KTP:</label>

          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Masukkan Nomor KTP" data-inputmask='"mask": "99-99-99-999999-9999"' data-mask 
              name="newNoKTP" required>
          </div>
          <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- phone mask -->
        <div class="form-group">
          <label>No HP:</label>

          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Masukkan Nomor HP" data-inputmask='"mask": "9999-9999-9999"' data-mask 
              name="newNoHP" required>
          </div>
          <!-- /.input group -->
        </div>
        <!-- /.form group -->
        <div class="social-auth-links text-center mt-2 mb-3">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Register Sekarang</button>
        </div>
      </form>

      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="loginPasien.php" class="btn btn-block btn-primary">Menuju Page Login</a>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="plugins/dropzone/min/dropzone.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    //Money Euro
    $('[data-mask]').inputmask()
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>
</body>
</html>
