<?php
require_once('includes/init.php');

$user_role = get_role();
if($user_role == 'admin' || $user_role == 'user') {

$page = "Hasil";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">&nbsp;&nbsp;<i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>
    <button onclick="printPage()" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak Data </button>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Hasil Akhir Perankingan</h6>
    </div>

    <div class="card-body">
        <form method="GET" action="">
            <div class="form-group">
                <label for="jabatan">Pilih jabatan:</label>
                <select name="jabatan" id="jabatan" class="form-control" onchange="this.form.submit()">
                    <option value="">Semua jabatan</option>
                    <?php
                    $jabatanQuery = mysqli_query($koneksi, "SELECT * FROM jabatan");
                    while ($jabatanData = mysqli_fetch_array($jabatanQuery)) {
                        $selected = isset($_GET['jabatan']) && $_GET['jabatan'] == $jabatanData['jabatan'] ? 'selected' : '';
                        echo "<option value='".$jabatanData['jabatan']."' $selected>".$jabatanData['jabatan']."</option>";
                    }
                    ?>
                </select>
            </div>
        </form>
        <div id="printArea">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-purple">
                        <tr align="center">
                            <th>Nama Karyawan</th>
                            <th>Nilai</th>
                            <th width="15%">Rank</th>
                    </thead>
                    <tbody>
                        <?php 
                        $no=0;
                        $jabatan = isset($_GET['jabatan']) ? $_GET['jabatan'] : '';
                        $queryStr = "SELECT * FROM hasil JOIN alternatif ON hasil.id_alternatif=alternatif.id_alternatif";
                        if ($jabatan) {
                            $queryStr .= " WHERE alternatif.jabatan = '$jabatan'";
                        }
                        $queryStr .= " ORDER BY hasil.nilai DESC";
                        $query = mysqli_query($koneksi, $queryStr);
                        while($data = mysqli_fetch_array($query)){
                            $no++;
                        ?>
                        <tr align="center">
                            <td align="left"><?= $data['nama'] ?></td>
                            <td><?= $data['nilai'] ?></td>
                            <td><?= $no; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function printPage() {
    var jabatan = document.getElementById('jabatan').value;
    var url = 'cetak.php?jabatan=' + jabatan;
    window.open(url, '_blank');
}
</script>

<?php
require_once('template/footer.php');
}
else {
    header('Location: login.php');
}
?>
