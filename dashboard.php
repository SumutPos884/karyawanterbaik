<?php
require_once('includes/init.php');

$user_role = get_role();
if($user_role == 'admin' || $user_role == 'user') {
$page = "Dashboard";
require_once('template/header.php');

// Koneksi ke database dan ambil data untuk pie chart distribusi jabatan
$query = "SELECT jabatan, COUNT(nama) as jumlah FROM alternatif GROUP BY jabatan";
$result = mysqli_query($koneksi, $query);

$labels_jabatan = [];
$data_jabatan = [];
$total_karyawan = 0; // Inisialisasi variabel untuk total karyawan

while ($row = mysqli_fetch_assoc($result)) {
    $labels_jabatan[] = $row['jabatan'];
    $data_jabatan[] = $row['jumlah'];
    $total_karyawan += $row['jumlah']; // Tambahkan jumlah karyawan ke total
}

// Ambil data nama karyawan
$query_nama = "SELECT nama, jabatan, nohp FROM alternatif";
$result_nama = mysqli_query($koneksi, $query_nama);

$nama_data = [];
while ($row = mysqli_fetch_assoc($result_nama)) {
    $nama_data[] = $row;
}
?>

<div class="mb-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-home"></i> Dashboard</h1>
    </div>

    <?php
    if($user_role == 'admin') {
    ?>
    <!-- Tampilan untuk Admin -->
    <div class="alert alert-success">
        Selamat datang <span class="text-uppercase"><b><?php echo $_SESSION['username']; ?>!</b></span> Anda bisa mengoperasikan sistem dengan wewenang tertentu melalui pilihan menu di bawah.
    </div>
    
    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background: white;">
                <div class="card-body">
                    <img src="assets/img/graha.jpg" alt="Graha" width="700" height="600"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background: white;">
                <div class="card-body">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-kriteria.php" class="text-secondary text-decoration-none">Data Kriteria</a></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background: white;">
                <div class="card-body">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-sub-kriteria.php" class="text-secondary text-decoration-none">Data Sub Kriteria</a></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background: white;">
                <div class="card-body">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-alternatif.php" class="text-secondary text-decoration-none">Data Karyawan</a></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background: white;">
                <div class="card-body">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="list-penilaian.php" class="text-secondary text-decoration-none">Data Penilaian</a></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background: white;">
                <div class="card-body">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="perhitungan.php" class="text-secondary text-decoration-none">Data Perhitungan</a></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background: white;">
                <div class="card-body">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="hasil.php" class="text-secondary text-decoration-none">Data Hasil Akhir</a></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    } elseif ($user_role == 'user') {
    ?>
    <!-- Tampilan untuk User -->
    <div class="alert alert-success text-center">
        Selamat datang, <span class="text-uppercase"><b><?php echo $_SESSION['username']; ?></b></span>! Anda bisa melihat hasil perangkingan karyawan terbaik.
    </div>

    <!-- Tombol Lihat Karyawan Terbaik -->
    <div class="text-center mb-4">
        <a class="btn btn-custom btn-lg" href="hasil2.php" role="button">Lihat Karyawan Terbaik</a>
    </div>

    <!-- Dua Pie Chart: Distribusi Jabatan dan Total Karyawan Berdasarkan Nama -->
    <div class="row">
        <!-- Pie Chart untuk Distribusi Jabatan -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Jabatan Karyawan</h6>
                </div>
                <div class="card-body">
                    <div style="width: 100%; height: 300px;">
                        <canvas id="jabatanPieChart"></canvas>
                    </div>
                </div>
                <div class="text-center mt-3 mb-3">
                    <button class="btn btn-info" id="viewJabatanBtn">View</button>
                </div>
            </div>
        </div>

        <!-- Pie Chart untuk Total Karyawan Berdasarkan Nama -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Nama Karyawan</h6>
                </div>
                <div class="card-body">
                    <div style="width: 100%; height: 300px;">
                        <canvas id="namaPieChart"></canvas>
                    </div>
                </div>
                <div class="text-center mt-3 mb-3">
                    <button class="btn btn-info" id="viewNamaBtn">View</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Karyawan akan ditampilkan setelah tombol di klik -->
    <div class="row" id="jabatanTable" style="display:none;">
        <div class="col-lg-12">
            <h5 class="text-center">Data Karyawan Berdasarkan Jabatan</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>No HP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nama_data as $data) : ?>
                    <tr>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['jabatan']; ?></td>
                        <td><?php echo $data['nohp']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Data untuk pie chart distribusi jabatan
    var labels_jabatan = <?php echo json_encode($labels_jabatan); ?>;
    var data_jabatan = <?php echo json_encode($data_jabatan); ?>;

    // Data untuk pie chart total karyawan berdasarkan nama
    var labels_nama = <?php echo json_encode(array_column($nama_data, 'nama')); ?>;
    var data_nama = <?php echo json_encode(array_column($nama_data, 'jumlah')); ?>;

    // Pie Chart untuk Distribusi Jabatan
    var ctx1 = document.getElementById('jabatanPieChart').getContext('2d');
    var jabatanPieChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: labels_jabatan,
            datasets: [{
                data: data_jabatan,
                backgroundColor: ['#FF6384', '#36A2EB'], // Warna-warna untuk Manager dan Produksi
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Pie Chart untuk Total Karyawan Berdasarkan Nama
    var ctx2 = document.getElementById('namaPieChart').getContext('2d');
    var namaPieChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: labels_nama,
            datasets: [{
                data: data_nama,
                backgroundColor: ['#FFCE56', '#4BC0C0', '#FF6384', '#36A2EB'], // Warna-warna random
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // JavaScript untuk tombol tampilkan tabel jabatan
    document.getElementById('viewJabatanBtn').addEventListener('click', function() {
        var jabatanTable = document.getElementById('jabatanTable');
        if (jabatanTable.style.display === 'none') {
            jabatanTable.style.display = 'block';
        } else {
            jabatanTable.style.display = 'none';
        }
    });
    
    // JavaScript untuk tombol tampilkan tabel nama
    document.getElementById('viewNamaBtn').addEventListener('click', function() {
        var namaTable = document.getElementById('jabatanTable');
        if (namaTable.style.display === 'none') {
            namaTable.style.display = 'block';
        } else {
            namaTable.style.display = 'none';
        }
    });

    </script>

    <?php
    }
    ?>
</div>

<?php
require_once('template/footer.php');
} else {
    header('Location: login.php');
}
?>

<!-- Tambahkan CSS untuk tombol yang unik -->
<style>
    .btn-custom {
        background-color: #28a745; /* Warna hijau */
        color: white; /* Warna teks putih */
        border-radius: 50px; /* Sudut melengkung */
        padding: 10px 30px; /* Padding tambahan untuk memperbesar tombol */
        font-size: 1.25rem; /* Ukuran font lebih besar */
        transition: background-color 0.3s ease-in-out; /* Transisi saat hover */
    }

    .btn-custom:hover {
        background-color: #218838; /* Warna hijau gelap saat di-hover */
    }

    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>