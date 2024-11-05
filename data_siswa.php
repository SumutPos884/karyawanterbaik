<?php
require_once('includes/init.php');
cek_login($role = array(1));

$page = "Data Siswa";
require_once('template/header.php');

$jabatan = isset($_GET['jabatan']) ? $_GET['jabatan'] : '';

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">&nbsp;&nbsp;<i class="fas fa-fw fa-users"></i> Data karyawan jabatan <?php echo $jabatan; ?></h1>
    <a href="tambah-alternatif.php?jabatan=<?php echo $jabatan; ?>" class="btn btn-success"> <i class="fa fa-plus"></i> Tambah Data </a>
</div>

<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';
$msg = '';
switch ($status) {
    case 'sukses-baru':
        $msg = 'Data berhasil disimpan';
        break;
    case 'sukses-hapus':
        $msg = 'Data berhasil dihapus';
        break;
    case 'sukses-edit':
        $msg = 'Data berhasil diupdate';
        break;
}

if ($msg) {
    echo '<div class="alert alert-info">' . $msg . '</div>';
}
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Daftar Data karyawan jabatan <?php echo $jabatan; ?></h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-purple">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>jabatan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $query = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE jabatan = '$jabatan'");
                    while ($data = mysqli_fetch_array($query)) :
                        $no++;
                    ?>
                        <tr align="center">
                            <td><?php echo $no; ?></td>
                            <td align="left"><?php echo $data['nama']; ?></td>
                            <td align="left"><?php echo $data['jabatan']; ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="edit-alternatif.php?id=<?php echo $data['id_alternatif']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                    <a data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="hapus-alternatif.php?id=<?php echo $data['id_alternatif']; ?>" onclick="return confirm('Apakah anda yakin untuk menghapus data ini')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once('template/footer.php');
?>
