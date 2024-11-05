<?php
require_once('includes/init.php');
cek_login($role = array(1));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $jabatan = $_POST['jabatan'];
    $nohp = $_POST['nohp'];

    $query = "INSERT INTO alternatif (nama, nik,jabatan, nohp) VALUES ('$nama', '$nik', '$jabatan', '$nohp')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header('Location: list-alternatif.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

require_once('template/header.php');

// Mengambil data jabatan dari database
$query_jabatan = "SELECT id, jabatan FROM jabatan";
$result_jabatan = mysqli_query($koneksi, $query_jabatan);

?>

<div class="container">
    <h2>Tambah Data Karyawan</h2>
    <form action="tambah-alternatif.php" method="post">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Jabatan</label>
            <select name="jabatan" class="form-control" required>
                <?php while($row = mysqli_fetch_assoc($result_jabatan)): ?>
                    <option value="<?php echo $row['jabatan']; ?>"><?php echo $row['jabatan']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Nohp</label>
            <input type="text" name="nohp" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
    </form>
</div>

<?php
require_once('template/footer.php');
?>
