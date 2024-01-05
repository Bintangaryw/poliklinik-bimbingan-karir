<?php 
require 'koneksi.php';
error_reporting(0);
session_start();

if (!isset($_SESSION['pasien'])) {
  header("Location: loginPasien.php");
}

if (isset($_POST['save'])){
  $idpasien= $_SESSION['id-pasien'];
  $idjadwal_baru = $_POST['newIDJadwal'];
  $keluhan_baru = $_POST['newKeluhan'];

  $quericount = mysqli_query($mysqli, "SELECT * FROM daftar_poli WHERE id_jadwal='$idjadwal_baru'");
  $nomorantrian_baru = mysqli_num_rows($quericount)+1;
  if (!empty($_POST['id'])){
    $id_baru = $_POST['id'];
    $queri1 = mysqli_query($mysqli, "UPDATE daftar_poli SET 
        id_jadwal='$idjadwal_baru',
        keluhan='$keluhan_baru', 
        no_antrian='$nomorantrian_baru' WHERE id='$id_baru'");
    echo "<script>alert('Selamat, Anda berhasil merubah data Pendaftaran Poli Anda!');
        window.location.href = 'pendaftaranPoli.php';
            </script>";
  } else {
    $queri2 = mysqli_query($mysqli, "INSERT INTO 
        daftar_poli(id_pasien,id_jadwal,keluhan,no_antrian) VALUES(
            '$idpasien','$idjadwal_baru','$keluhan_baru','$nomorantrian_baru')");
    echo "<script>alert('Selamat, Anda berhasil menambah data Pendaftaran Poli Anda!');
        window.location.href = 'pendaftaranPoli.php';
            </script>";
  }
}

if (isset($_GET['aksi'])) {
  $aksi = $_GET['aksi'];
  $id = $_GET['id'];
  if ($aksi == 'hapus') {
    $queri3 = mysqli_query($mysqli, "DELETE FROM daftar_poli
        WHERE id='$id'");
    echo "<script>alert('Selamat, Anda berhasil menghapus data Pendaftaran Poli Anda!');
        window.location.href = 'pendaftaranPoli.php';
            </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pendaftaran-Poli | Pasien Poliklinik</title>

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
          <a href="#" class="d-block">Pasien <?php echo $_SESSION['pasien']?></a>
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
            <a href="pasien.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pendaftaranPoli.php" class="nav-link active">
              <i class="nav-icon fas fa-clinic-medical"></i>
              <p>Pendaftaran Poli</p>
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
                $idpasien= $_SESSION['id-pasien'];
                $jadwal='';
                $keluhan='';
                if (isset($_GET['id'])){
                  $id=$_GET['id'];
                  $queri4 = mysqli_query($mysqli, 
                      "SELECT daftar_poli.*,jadwal_periksa.*,dokter.* FROM daftar_poli
                      JOIN jadwal_periksa ON jadwal_periksa.id=daftar_poli.id_jadwal
                      JOIN dokter ON dokter.id=jadwal_periksa.id_dokter
                      WHERE daftar_poli.id=$id");
                  while ($row = mysqli_fetch_array($queri4)){
                      $poli = $row['id_poli'];
                      $jadwal = $row['id_jadwal'];
                      $keluhan = $row['keluhan'];
                  }?>
                  <input type="hidden" name="id" value="<?php echo $id ?>">
                  <?php 
                }?>

                <div class="form-group">
                  <label>No RM:</label>

                  <div class="input-group">
                    <?php 
                    $queriRM=mysqli_query($mysqli, "SELECT no_rm FROM pasien WHERE id='$idpasien'");
                    $rowRM=mysqli_fetch_array($queriRM)?>
                    <input type="text" class="form-control" value="<?php echo $rowRM['no_rm']?>" disabled>
                  </div>
                  <!-- /.input group -->
                </div>

                <!-- phone mask -->
                <div class="form-group">
                  <label>Pilih Poli:</label>
                  <div class="input-group">
                      <select class="custom-select rounded-0" id="selectPoli" name="selectedPoli">
                          <?php
                          $selectPoli='';
                          $queriPoli = mysqli_query($mysqli, "SELECT * FROM poli ORDER BY nama_poli ASC");
                          while ($rowPoli = mysqli_fetch_array($queriPoli)) {
                              $selectPoli = ($rowPoli['id'] == $poli) ? 'selected' : '';
                              echo '<option value="' . $rowPoli['id'] . '" '.$selectPoli.'>' . $rowPoli['nama_poli'] . '</option>';
                          }
                          ?>
                      </select>
                  </div>
                </div>

                <div class="form-group">
                  <label>Jadwal Dokter:</label>
                  <div class="input-group">
                      <select class="custom-select rounded-0" id="exampleSelectRounded0" name="newIDJadwal">
                          <!-- Option untuk dokter akan diatur melalui JavaScript -->
                      </select>
                  </div>
                  <!-- /.input group -->
                </div>

                <!-- Date mm/dd/yyyy -->
                <div class="form-group">
                  <label>Keluhan:</label>

                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Masukkan Keluhan"
                      name="newKeluhan" value="<?php echo $keluhan?>" required>
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
                    <th>Dokter</th>
                    <th>Jadwal</th>
                    <th>Keluhan</th>
                    <th>No Antrian</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $i= 1;
                  $queri5 = mysqli_query($mysqli, 
                    "SELECT daftar_poli.id as idi, daftar_poli.keluhan, daftar_poli.no_antrian,jadwal_periksa.*,dokter.nama as dokter FROM daftar_poli 
                    JOIN jadwal_periksa ON jadwal_periksa.id=daftar_poli.id_jadwal
                    JOIN dokter ON dokter.id=jadwal_periksa.id_dokter
                    WHERE daftar_poli.id_pasien=$idpasien");
                  while ($row = mysqli_fetch_array($queri5)){?>
                    <tr>
                      <td class="text-center" scope="row"><?php echo $i++ ?></td>
                      <td><?php echo $row['dokter']?></td>
                      <td><?php echo $row['hari'].", ".$row['jam_mulai']."-".$row['jam_selesai']?></td>
                      <td><?php echo $row['keluhan']?></td>
                      <td><?php echo $row['no_antrian']?></td>
                      <td>
                          <a class="btn btn-info rounded-pill px-3" 
                              href="pendaftaranPoli.php?id=<?php echo $row['idi'] ?>">Ubah</a>
                          <a class="btn btn-danger rounded-pill px-3" 
                              href="pendaftaranPoli.php?id=<?php echo $row['idi']?>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Mengecek apakah ada poli yang sudah dipilih pada saat pertama kali loading
        var selectedPoli = document.getElementById('selectPoli').value;

        if (selectedPoli) {
            populateDokterDropdown(selectedPoli);
        }

        document.getElementById('selectPoli').addEventListener('change', function () {
            var selectedPoli = this.value;
            populateDokterDropdown(selectedPoli);
        });

        function populateDokterDropdown(selectedPoli) {
            var dokterDropdown = document.getElementById('exampleSelectRounded0');

            // Menghapus opsi yang ada
            dokterDropdown.innerHTML = '';

            // Mengambil dokter berdasarkan poli yang dipilih
            <?php
            $queriDokter = mysqli_query($mysqli, "SELECT jadwal_periksa.id, dokter.nama, dokter.id_poli, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai FROM dokter
                JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter
                GROUP BY dokter.id, dokter.nama, dokter.id_poli, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai ORDER BY dokter.nama ASC");
            $selectJadwal='';
            while ($rowDokter = mysqli_fetch_array($queriDokter)) {
                echo 'if (' . $rowDokter['id_poli'] . ' == selectedPoli) {';
                $selectJadwal = ($rowDokter['id'] == $jadwal) ? 'selected' : '';
                echo 'var option = document.createElement("option");';
                echo 'option.value = "' . $rowDokter['id'] . '";';
                echo 'option.text = "' . $rowDokter['nama'] . ' - ' . $rowDokter['hari'] . ', ' . $rowDokter['jam_mulai'] . '-' . $rowDokter['jam_selesai'] . '";';
                echo 'option.selected = "'.$selectJadwal.'";';
                echo 'dokterDropdown.add(option);';
                echo '}';
            }
            ?>
        }
    });
</script>
</body>
</html>