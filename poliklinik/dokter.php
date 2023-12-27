<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginUser");
    exit;
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
                                 nama = '" . $_POST['nama'] . "',
                                 alamat = '" . $_POST['alamat'] . "',
                                 no_hp = '" . $_POST['no_hp'] . "',
                                 id_poli = '" . $_POST['id_poli'] . "',
                                 nip = '" . $_POST['nip'] . "',
                                 password = '" . $_POST['password'] . "'
                                 WHERE
                                 id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO dokter (nama, alamat, no_hp, id_poli, nip, password) 
                                 VALUES (
                                     '" . $_POST['nama'] . "',
                                     '" . $_POST['alamat'] . "',
                                     '" . $_POST['no_hp'] . "',
                                     '" . $_POST['id_poli'] . "',
                                     '" . $_POST['nip'] . "',
                                     '" . $_POST['password'] . "'
                                 )");
    }
    echo "<script> 
                document.location='index.php?page=dokter';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='index.php?page=dokter';
                </script>";
}
?>
<h2>Dokter</h2>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama = '';
        $alamat = '';
        $no_hp = '';
        $id_poli = '';
        $nip = '';
        $password = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM dokter
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_hp = $row['no_hp'];
                $id_poli = $row['id_poli'];
                $nip = $row['nip'];
                $password = $row['password'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputNama" class="form-label fw-bold">
                Nama Dokter
            </label>
            <div>
                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputAlamat" class="form-label fw-bold">
                Alamat
            </label>
            <div>
                <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputNoHP" class="form-label fw-bold">
                Nomor HP
            </label>
            <div>
                <input type="text" class="form-control" name="no_hp" id="inputNoHP" placeholder="Nomor HP" value="<?php echo $no_hp ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputPoli" class="form-label fw-bold">
                Poli
            </label>
            <div>
                <select class="form-control" name="id_poli" id="inputPoli">
                    <?php
                    $result_poli = mysqli_query($mysqli, "SELECT * FROM poli");
                    while ($data_poli = mysqli_fetch_array($result_poli)) {
                        $selected = ($id_poli == $data_poli['id']) ? 'selected' : '';
                        echo "<option value='" . $data_poli['id'] . "' $selected>" . $data_poli['nama_poli'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputNIP" class="form-label fw-bold">
                NIP
            </label>
            <div>
                <input type="text" class="form-control" name="nip" id="inputNIP" placeholder="NIP" value="<?php echo $nip ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputPassword" class="form-label fw-bold">
                Password
            </label>
            <div>
                <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" value="<?php echo $password ?>">
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
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">Nomor HP</th>
                <th scope="col">Poli</th>
                <th scope="col">NIP</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT dokter.*, poli.nama_poli FROM dokter JOIN poli ON dokter.id_poli = poli.id");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['nama_poli'] ?></td>
                    <td><?php echo $data['nip'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>