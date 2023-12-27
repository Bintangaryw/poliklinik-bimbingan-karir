<?php
if (!isset($_SESSION)) {
    session_start();
}

// Cek apakah sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['no_rm'])) {
    header("Location: index.php?page=loginPasien");
}

// Ambil no_rm dari session
$no_rm = $_SESSION['no_rm'];

// Query untuk mendapatkan data pasien berdasarkan no_rm
$query_pasien = "SELECT * FROM pasien WHERE no_rm = '$no_rm'";
$result_pasien = $mysqli->query($query_pasien);

if (!$result_pasien) {
    die("Query error: " . $mysqli->error);
}

// Ambil data pasien
$row_pasien = $result_pasien->fetch_assoc();
$nama_pasien = $row_pasien['nama'];
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Daftar Poli</div>
                <div class="card-body">
                    <p>Selamat datang, <?php echo $nama_pasien; ?> (No RM: <?php echo $no_rm; ?>)</p>
                    <form method="POST" action="proses_daftarpoli.php">
                        <div class="form-group">
                            <label for="poli">Pilih Poli</label>
                            <select name="poli" class="form-control" required>
                                <?php
                                // Query untuk mendapatkan data poli
                                $query_poli = "SELECT * FROM poli";
                                $result_poli = $mysqli->query($query_poli);

                                if (!$result_poli) {
                                    die("Query error: " . $mysqli->error);
                                }

                                // Tampilkan data poli dalam dropdown
                                while ($row_poli = $result_poli->fetch_assoc()) {
                                    echo '<option value="' . $row_poli['id'] . '">' . $row_poli['nama_poli'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jadwal">Pilih Jadwal Periksa</label>
                            <select name="jadwal" class="form-control" required>
                                <?php
                                // Mendapatkan nilai dari dropdown poli yang dipilih
                                $selected_poli = isset($_POST['poli']) ? $_POST['poli'] : null;

                                // Query untuk mendapatkan data jadwal periksa berdasarkan poli yang dipilih
                                if ($selected_poli) {
                                    $query_jadwal = "SELECT j.id, d.nama, j.hari, j.jam_mulai, j.jam_selesai
                     FROM jadwal_periksa j
                     JOIN dokter d ON j.id_dokter = d.id
                     WHERE d.id_poli = ?";
                                    $stmt = $mysqli->prepare($query_jadwal);
                                    $stmt->bind_param("i", $selected_poli);
                                    $stmt->execute();
                                    $result_jadwal = $stmt->get_result();

                                    // Loop untuk menampilkan data jadwal periksa dalam dropdown
                                    while ($row_jadwal = $result_jadwal->fetch_assoc()) {
                                        echo '<option value="' . $row_jadwal['id'] . '">' . $row_jadwal['nama'] . ' - ' . $row_jadwal['hari'] . ' (' . $row_jadwal['jam_mulai'] . ' - ' . $row_jadwal['jam_selesai'] . ')</option>';
                                    }

                                    $stmt->close();
                                }

                                ?>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>