<?php
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengganti query dan menyesuaikan nama tabel menjadi "dokter"
    $query = "SELECT * FROM dokter WHERE nip = '$username' AND password = '$password'";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Query error: " . $mysqli->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Menyimpan informasi dokter ke dalam session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_type'] = 'dokter';
        header("Location: dokterDashboard.php"); // Mengarahkan ke halaman dokterDashboard
        exit(); // Penting untuk keluar setelah melakukan redirect
    } else {
        $error = "NIP atau password salah";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Login Dokter</div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=loginDokter">
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
                            <label for="username">NIP Dokter</label>
                            <!-- Mengganti name menjadi "username" agar sesuai dengan POST -->
                            <input type="text" name="username" class="form-control" required placeholder="Masukkan NIP dokter">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <!-- Mengganti name menjadi "password" agar sesuai dengan POST -->
                            <input type="password" name="password" class="form-control" required placeholder="Masukkan password dokter">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="mt-3">Belum punya akun? <a href="index.php?page=registerDokter">Register</a></p>
                        <p class="mt-3">Login sebagai Admin <a href="index.php?page=loginUser">Admin Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>