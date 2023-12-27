<?php
session_start();

// Periksa apakah pengguna sudah login dan merupakan dokter
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'dokter') {
    // Jika tidak, arahkan ke halaman login
    header("Location: index.php");
    exit();
}

// Sambungkan ke database (gantilah sesuai dengan detail koneksi database Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "poli";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil nama dokter dari database berdasarkan ID dokter yang login
$id_dokter = $_SESSION['user_id']; // Sesuaikan dengan nama kolom ID pada tabel dokter
$query = "SELECT nama FROM dokter WHERE id = $id_dokter";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Jika data ditemukan, ambil nama dokter dari hasil query
    $row = $result->fetch_assoc();
    $nama_dokter = $row['nama'];
} else {
    // Jika data tidak ditemukan, tetapkan nilai default
    $nama_dokter = 'Nama Dokter';
}

// Tutup koneksi database
$conn->close();
?>
<!-- Sisanya tetap sama seperti sebelumnya -->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Informasi Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Menu</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="dashboardDokter.php?page=jadwalPeriksa">Jadwal Periksa</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="dashboardDokter.php?page=riwayatPasien">Riwayat Pasien</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main role="main" class="container">
        <?php
        if (isset($_GET['page'])) {
            include($_GET['page'] . ".php");
        } else {
            // Perbarui pesan selamat datang dengan nama dokter yang login
            echo "<br><h2>Selamat Datang di Sistem Informasi Poliklinik, Dokter $nama_dokter!</h2>";
        }
        ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
<!-- ... (bagian script yang lain) ... -->
</body>

</html>