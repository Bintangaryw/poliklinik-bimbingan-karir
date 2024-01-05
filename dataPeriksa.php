<?php 
require 'koneksi.php';
error_reporting(0);
session_start();

if (!isset($_SESSION['dokter'])) {
  header("Location: loginDokter.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data-Periksa | Dokter Poliklinik</title>

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
            <a href="dataJadwal.php" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Data Jadwal</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="dataPeriksa.php" class="nav-link active">
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
            <h1>Data Pemeriksaan Pasien</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12"> 

            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Tabel Periksa</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Pasien</th>
                    <th>Jadwal</th>
                    <th>Keluhan</th>
                    <th>No Antrian</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $i= 1;
                  $iddokter= $_SESSION['id-dokter'];
                  $queriPeriksa = mysqli_query($mysqli, 
                    "SELECT daftar_poli.id as idi, daftar_poli.keluhan, daftar_poli.no_antrian, daftar_poli.pemeriksaan,jadwal_periksa.*,pasien.nama as pasien FROM daftar_poli 
                    JOIN jadwal_periksa ON jadwal_periksa.id=daftar_poli.id_jadwal
                    JOIN pasien ON pasien.id=daftar_poli.id_pasien
                    WHERE jadwal_periksa.id_dokter=$iddokter
                    ORDER BY hari,jam_mulai,no_antrian ASC");
                  while ($row = mysqli_fetch_array($queriPeriksa)){?>
                    <tr>
                      <td class="text-center" scope="row"><?php echo $i++ ?></td>
                      <td><?php echo $row['pasien']?></td>
                      <td><?php echo $row['hari'].", ".$row['jam_mulai']."-".$row['jam_selesai']?></td>
                      <td><?php echo $row['keluhan']?></td>
                      <td><?php echo $row['no_antrian']?></td>
                      <td>
                        <?php
                        if ($row['pemeriksaan'] == 1) {?>
                            <a class="btn btn-success rounded-pill px-3" style="pointer-events: none;">Sudah Diperiksa</a>
                        <?php
                        } else {?>
                            <a class="btn btn-warning rounded-pill px-3" type="button" 
                                data-toggle="modal" data-target="#modal-lg<?php echo $row['idi']?>">Belum Diperiksa</a>
                        <?php }?>
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

<?php 
$i= 1;
$iddokter= $_SESSION['id-dokter'];
$queriPeriksa = mysqli_query($mysqli, 
  "SELECT daftar_poli.id as idi, daftar_poli.keluhan, daftar_poli.no_antrian, daftar_poli.pemeriksaan,jadwal_periksa.*,pasien.nama as pasien FROM daftar_poli 
  JOIN jadwal_periksa ON jadwal_periksa.id=daftar_poli.id_jadwal
  JOIN pasien ON pasien.id=daftar_poli.id_pasien
  WHERE jadwal_periksa.id_dokter=$iddokter
  ORDER BY hari,jam_mulai,no_antrian ASC");
while ($row = mysqli_fetch_array($queriPeriksa)){
  $iddafpoli_baru = $row['idi'];
  if (isset($_POST['save'.$iddafpoli_baru])){
    $tanggal_baru = date("Y-m-d");
    $catatan_baru = $_POST['newCatatan'];
    $queri1 = mysqli_query($mysqli, "INSERT INTO 
        periksa(id_daftar_poli,tgl_periksa,catatan) VALUES(
            '$iddafpoli_baru','$tanggal_baru','$catatan_baru')");
    if($queri1){
      $periksa_baru = $mysqli->insert_id;
      $listobat = $_POST['newIdObat'];
      foreach ($listobat as $obat_baru){
        $queri2 = mysqli_query($mysqli, "INSERT INTO 
            detail_periksa(id_periksa,id_obat) VALUES('$periksa_baru','$obat_baru')");
      }
      $queriharga = mysqli_query($mysqli, 
          "SELECT GROUP_CONCAT(obat.harga) as harga FROM daftar_poli 
          JOIN jadwal_periksa ON jadwal_periksa.id=daftar_poli.id_jadwal 
          JOIN pasien ON pasien.id=daftar_poli.id_pasien 
          JOIN periksa ON daftar_poli.id=periksa.id_daftar_poli 
          JOIN detail_periksa ON periksa.id=detail_periksa.id_periksa 
          JOIN obat ON obat.id=detail_periksa.id_obat 
          WHERE periksa.id=$periksa_baru");
      $row = mysqli_fetch_array($queriharga);
      $biaya_baru = 150000 + array_sum(explode(',', $row['harga']));
      $queri3 = mysqli_query($mysqli, "UPDATE periksa SET
                biaya_periksa='$biaya_baru' WHERE id='$periksa_baru'");
    }
    $queri4 = mysqli_query($mysqli, "UPDATE daftar_poli SET
              pemeriksaan='1' WHERE id='$iddafpoli_baru'");
    echo "<script>alert('Selamat, Anda berhasil menambah data Pemeriksaan!');
          window.location.href = 'dataPeriksa.php';
              </script>";
  }
  ?>
  <div class="modal fade" id="modal-lg<?php echo $row['idi']?>">
    <div class="modal-dialog modal-lg">
      <div method="POST" class="modal-content">
        <form method="post">
        <div class="modal-header">
          <h4 class="modal-title">Form Input Pemeriksaan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Date mm/dd/yyyy -->
          <div class="form-group">
            <label>Catatan:</label>

            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Catatan"
                name="newCatatan" required>
            </div>
            <!-- /.input group -->
          </div>
          <!-- /.form group -->

          <!-- phone mask -->
          <div class="form-group">
            <label>Obat:</label>

            <div class="input-group">
              <select class="custom-select rounded-0" id="exampleSelectRounded0<?php echo $row['idi']; ?>" name="newIdObat[]" multiple="multiple" onchange="updateTotalHarga(<?php echo $row['idi']; ?>)" required>
                <?php 
                $queriObat=mysqli_query($mysqli, "SELECT * FROM obat ORDER BY nama_obat ASC");
                while ($rowObat=mysqli_fetch_array($queriObat)){?>
                    <option value="<?php echo $rowObat['id'] ?>" data-harga="<?php echo $rowObat['harga'] ?>">
                        <?php echo $rowObat['nama_obat']?>
                    </option>
                <?php }?>
              </select>
            </div>
            <!-- /.input group -->
          </div>
          <div class="form-group">
            <label>Biaya Periksa:</label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Total Harga" name="totalHarga" id="totalHarga<?php echo $row['idi']; ?>" value="Rp 150000" disabled>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="save<?php echo $row['idi']?>">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
<?php } ?>

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
  $(document).ready(function() {
    $('.custom-select').select2({
      placeholder: "Silahkan Pilih Obat"
    });
  });
</script>
<script>
  function updateTotalHarga(id) {
      var originalHarga = 150000;
      var totalHarga = originalHarga;
      var selectedObat = document.getElementById('exampleSelectRounded0' + id);
      for (var i = 0; i < selectedObat.options.length; i++) {
          if (selectedObat.options[i].selected) {
              // Assuming harga is stored as data attribute in the option
              var harga = parseFloat(selectedObat.options[i].getAttribute('data-harga'));
              totalHarga += harga;
          }
      }
      // Update the value of the disabled input field for total harga
      document.getElementById('totalHarga' + id).value = "Rp " + totalHarga;
  }
</script>
</body>
</html>