<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$page = "data_jabatan";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">&nbsp;&nbsp;<i class="fas fa-fw fa-users"></i> Data jabatan</h1>
    <a href="tambah-jabatan.php" class="btn btn-success"> <i class="fa fa-plus"></i> Tambah Data </a>
</div>

<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';
$msg = '';
switch($status):
    case 'sukses-baru':
        $msg = 'Data berhasil disimpan';
        break;
    case 'sukses-hapus':
        $msg = 'Data behasil dihapus';
        break;
    case 'sukses-edit':
        $msg = 'Data behasil diupdate';
        break;
endswitch;

if($msg):
    echo '<div class="alert alert-info">'.$msg.'</div>';
endif;
?>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold" style="color: #4B0082;"><i class="fa fa-table"></i> Daftar Data jabatan</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-purple">
                    <tr align="center">    
                        <th width="5%">No</th>
                        <th>Nama jabatan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>            
                <?php
                $no=0;
                $query = mysqli_query($koneksi,"SELECT * FROM jabatan");            
                while($data = mysqli_fetch_array($query)):
                $no++;
                ?>
                    <tr align="center">
                        <td><?php echo $no; ?></td>
                        <td align="left"><?php echo $data['jabatan']; ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="edit-jabatan.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="hapus-jabatan.php?id=<?php echo $data['id']; ?>" onclick="return confirm ('Apakah anda yakin untuk meghapus data ini')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                <a data-toggle="tooltip" data-placement="bottom" title="Lihat karyawan" href="data_siswa.php?jabatan=<?php echo $data['jabatan']; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
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
