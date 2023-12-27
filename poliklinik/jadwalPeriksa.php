<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header("Location: index.php?page=loginDokter");
    exit;
}

// Sambungkan ke database (gantilah sesuai dengan detail koneksi database Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "poli";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi database
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
                                            hari = '" . $_POST['hari'] . "',
                                            jam_mulai = '" . $_POST['jam_mulai'] . "',
                                            jam_selesai = '" . $_POST['jam_selesai'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        // Ambil id_dokter dari sesi (dokter yang sedang login)
        $id_dokter = $_SESSION['user_id'];

        $tambah = mysqli_query($mysqli, "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) 
                                            VALUES (
                                                '" . $id_dokter . "',
                                                '" . $_POST['hari'] . "',
                                                '" . $_POST['jam_mulai'] . "',
                                                '" . $_POST['jam_selesai'] . "'
                                            )");
    }
    echo "<script> 
                document.location='index.php?page=jadwal_periksa';
                </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index.php?page=jadwal_periksa';
                </script>";
}
?>

<h2>Jadwal Periksa</h2>
<br>

<div class="container">
    <!--Form Input Data-->
    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <?php
        $hari = '';
        $jam_mulai = '';
        $jam_selesai = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $hari = $row['hari'];
                $jam_mulai = $row['jam_mulai'];
                $jam_selesai = $row['jam_selesai'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputHari" class="form-label fw-bold">
                Hari
            </label>
            <div>
                <select class="form-select" name="hari" id="inputHari">
                    <option value="Senin" <?php if ($hari == 'Senin') echo 'selected' ?>>Senin</option>
                    <option value="Selasa" <?php if ($hari == 'Selasa') echo 'selected' ?>>Selasa</option>
                    <option value="Rabu" <?php if ($hari == 'Rabu') echo 'selected' ?>>Rabu</option>
                    <option value="Kamis" <?php if ($hari == 'Kamis') echo 'selected' ?>>Kamis</option>
                    <option value="Jumat" <?php if ($hari == 'Jumat') echo 'selected' ?>>Jumat</option>
                    <option value="Sabtu" <?php if ($hari == 'Sabtu') echo 'selected' ?>>Sabtu</option>
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputJamMulai" class="form-label fw-bold">
                Jam Mulai
            </label>
            <div>
                <input type="time" class="form-control" name="jam_mulai" id="inputJamMulai" value="<?php echo $jam_mulai ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputJamSelesai" class="form-label fw-bold">
                Jam Selesai
            </label>
            <div>
                <input type="time" class="form-control" name="jam_selesai" id="inputJamSelesai" value="<?php echo $jam_selesai ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </div>
    </form>
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Hari</th>
                <th scope="col">Jam Mulai</th>
                <th scope="col">Jam Selesai</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $id_dokter = $_SESSION['user_id'];
            $result = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa WHERE id_dokter = $id_dokter");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['hari'] ?></td>
                    <td><?php echo $data['jam_mulai'] ?></td>
                    <td><?php echo $data['jam_selesai'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=jadwal_periksa&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=jadwal_periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>