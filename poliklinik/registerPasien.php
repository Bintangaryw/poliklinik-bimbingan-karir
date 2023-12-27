<?php
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];

    $tahun_bulan = date('Ym');
    $result = $mysqli->query("SELECT MAX(id) AS max_id FROM pasien");
    $row = $result->fetch_assoc();
    $id_pasien = ($row['max_id'] ?? 0) + 1;
    $no_rm = $tahun_bulan . '-' . sprintf('%03d', $id_pasien);

    $insert_query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) 
                     VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm')";

    if (mysqli_query($mysqli, $insert_query)) {
        echo "<script>
                alert('Pendaftaran Berhasil'); 
                document.location='index.php?page=loginPasien';
              </script>";
    } else {
        $error = "Pendaftaran gagal";
    }
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Register Pasien</div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=registerPasien">
                        <?php
                        if (isset($error)) {
                            echo '<div class="alert alert-danger">' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                        }
                        ?>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama anda">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" required placeholder="Masukkan alamat">
                        </div>
                        <div class="form-group">
                            <label for="no_ktp">No. KTP</label>
                            <input type="text" name="no_ktp" class="form-control" required placeholder="Masukkan no. KTP">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="text" name="no_hp" class="form-control" required placeholder="Masukkan no. HP">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </form>
                    <div class="text-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>