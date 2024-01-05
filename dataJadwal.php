<?php 
require 'koneksi.php';
error_reporting(0);
session_start();

if (!isset($_SESSION['dokter'])) {
  header("Location: loginDokter.php");
}

if (isset($_POST['save'])){
  $iddokter= $_SESSION['id-dokter'];
  $hari_baru = $_POST['newHari'];
  $jammulai_baru = $_POST['newJamMulai'];
  $jamselesai_baru = $_POST['newJamSelesai'];

  $queriPoli = mysqli_query($mysqli, "SELECT poli.id FROM poli
    JOIN dokter ON dokter.id_poli=poli.id
    WHERE dokter.id='$iddokter'");
  $rowPoli = mysqli_fetch_assoc($queriPoli);
  $poli = $rowPoli['id'];

  $existing_jadwal = mysqli_query($mysqli, "SELECT hari, jam_mulai, jam_selesai FROM jadwal_periksa
    JOIN dokter ON dokter.id=jadwal_periksa.id_dokter
    WHERE dokter.id_poli='$poli' AND hari='$hari_baru'");

  $new_jam_mulai = strtotime($jammulai_baru);
  $new_jam_selesai = strtotime($jamselesai_baru);
  $is_conflict = false;
  while ($row = mysqli_fetch_assoc($existing_jadwal)) {
    $existing_jam_mulai = strtotime($row['jam_mulai']);
    $existing_jam_selesai = strtotime($row['jam_selesai']);

    if (
        ($existing_jam_mulai < $new_jam_mulai  && $new_jam_mulai < $existing_jam_selesai) ||
        ($existing_jam_mulai < $new_jam_selesai && $new_jam_selesai < $existing_jam_selesai) ||
        ($new_jam_mulai < $existing_jam_mulai && $existing_jam_selesai < $new_jam_selesai )
    ) {
        $is_conflict = true;
        break;
    }
  }

  if ($is_conflict) {
      echo "<script>alert('Maaf, Jadwal baru bertabrakan dengan Jadwal yang sudah ada. Silakan pilih Jadwal yang lain.');
          window.location.href = 'dataJadwal.php';
          </script>";
  } else {
    if ($new_jam_mulai>$new_jam_selesai){
      echo "<script>alert('Jam Mulai harus diawal dan Jam Selesai harus diakhir!');
          window.location.href = 'dataJadwal.php';
              </script>";
    } else{
      if (!empty($_POST['id'])){
        $id_baru = $_POST['id'];
        $queri1 = mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
            hari='$hari_baru',
            jam_mulai='$jammulai_baru',
            jam_selesai='$jamselesai_baru' WHERE id='$id_baru'");
        echo "<script>alert('Selamat, Anda berhasil merubah data Jadwal Anda!');
            window.location.href = 'dataJadwal.php';
                </script>";
      } else {
        $queri2 = mysqli_query($mysqli, "INSERT INTO 
            jadwal_periksa(id_dokter,hari,jam_mulai,jam_selesai) VALUES(
                '$iddokter','$hari_baru','$jammulai_baru','$jamselesai_baru')");
        echo "<script>alert('Selamat, Anda berhasil menambah data Jadwal Anda!');
            window.location.href = 'dataJadwal.php';
                </script>";
      }
    }
  }
}

if (isset($_GET['aksi'])) {
  $aksi = $_GET['aksi'];
  $id = $_GET['id'];
  if ($aksi == 'hapus') {
    $queri3 = mysqli_query($mysqli, "DELETE FROM jadwal_periksa 
        WHERE id='$id'");
    echo "<script>alert('Selamat, Anda berhasil menghapus data Jadwal Anda!');
        window.location.href = 'dataJadwal.php';
            </script>";
  } else if ($aksi == 'noubah') {
    echo "<script>alert('Maaf, Anda tidak dapat mengupdate jadwal pada Hari H.');
        window.location.href = 'dataJadwal.php';
        </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data-Jadwal | Dokter Poliklinik</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
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
<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Poliklinik</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Dokter <?php echo $_SESSION['dokter']?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="dokter.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="dataDiri.php" class="nav-link">
              <i class="nav-icon fas fa-user-md"></i>
              <p>Data Diri</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="dataJadwal.php" class="nav-link active">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Data Jadwal</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="dataPeriksa.php" class="nav-link">
              <i class="nav-icon fas fa-stethoscope"></i>
              <p>Data Periksa Pasien</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="dataRiwayat.php" class="nav-link">
              <i class="nav-icon fas fa-notes-medical"></i>
              <p>Data Riwayat Pasien</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Jadwal</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <form method="POST" class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Form Input Jadwal</h3>
              </div>
              <div class="card-body">
                <?php 
                $iddokter= $_SESSION['id-dokter'];
                $hari='';
                $jammulai='';
                $jamselesai='';
                if (isset($_GET['id'])){
                  $id=$_GET['id'];
                  $queri4 = mysqli_query($mysqli, 
                      "SELECT * FROM jadwal_periksa
                      WHERE id=$id");
                  while ($row = mysqli_fetch_array($queri4)){
                      $hari = $row['hari'];
                      $jammulai = $row['jam_mulai'];
                      $jamselesai = $row['jam_selesai'];
                  }?>
                  <input type="hidden" name="id" value="<?php echo $id ?>">
                  <?php 
                }?>
                <!-- phone mask -->
                <div class="form-group">
                  <label>Hari:</label>

                  <div class="input-group">
                    <select class="custom-select rounded-0" id="exampleSelectRounded0" name="newHari">
                        <?php 
                        $select = '';
                        $queriHari = mysqli_query($mysqli, "SHOW COLUMNS FROM jadwal_periksa LIKE 'hari'");
                        $rowHari = mysqli_fetch_assoc($queriHari);
                        $enumValues = explode("','", substr($rowHari['Type'], 6, -2));
                        foreach ($enumValues as $value) {
                            $select = ($value == $hari) ? 'selected' : '';?>
                            <option value="<?php echo $value ?>" <?php echo $select ?>>
                                <?php echo $value ?>
                            </option>
                        <?php } ?>
                    </select>
                  </div>
                  <!-- /.input group -->
                </div>

                <!-- Date mm/dd/yyyy -->
                <div class="form-group">
                  <label>Jam Mulai:</label>

                  <div class="input-group">
                    <input type="time" class="form-control"
                      name="newJamMulai" value="<?php echo $jammulai?>" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Jam Selesai:</label>

                  <div class="input-group">
                    <input type="time" class="form-control" 
                      name="newJamSelesai" value="<?php echo $jamselesai?>" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="save">Submit</button>
              </div>
              <!-- /.card -->
            </form> 

            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Tabel Jadwal</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $i= 1;
                  $queri5 = mysqli_query($mysqli, 
                    "SELECT * FROM jadwal_periksa WHERE id_dokter=$iddokter");
              
                  function translateDayToIndonesian($day) {
                    switch ($day) {
                      case "Monday":
                          return "Senin";
                      case "Tuesday":
                          return "Selasa";
                      case "Wednesday":
                          return "Rabu";
                      case "Thursday":
                          return "Kamis";
                      case "Friday":
                          return "Jumat";
                      case "Saturday":
                          return "Sabtu";
                      case "Sunday":
                          return "Minggu";
                      default:
                          return $day;
                    }
                  }
                  $hari_ini = date("l");
                  $hari_ini = translateDayToIndonesian($hari_ini);
                  while ($row = mysqli_fetch_array($queri5)){?>
                    <tr>
                      <td class="text-center" scope="row"><?php echo $i++ ?></td>
                      <td><?php echo $row['hari']?></td>
                      <td><?php echo $row['jam_mulai']?></td>
                      <td><?php echo $row['jam_selesai']?></td>
                      <td>
                        <?php 
                        if ($row['hari']==$hari_ini){?>
                          <a class="btn btn-info rounded-pill px-3" 
                              href="dataJadwal.php?id=<?php echo $row['id']?>
                                  &aksi=noubah">Ubah</a>
                        <?php } else{?>
                          <a class="btn btn-info rounded-pill px-3" 
                              href="dataJadwal.php?id=<?php echo $row['id'] ?>">Ubah</a>
                        <?php }?>
                          <a class="btn btn-danger rounded-pill px-3" 
                              href="dataJadwal.php?id=<?php echo $row['id']?>
                                  &aksi=hapus">Hapus</a>
                      </td>
                    </tr>
                  <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
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