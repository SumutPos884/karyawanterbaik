<?php
require_once('includes/init.php');

$jabatan = isset($_GET['jabatan']) ? $_GET['jabatan'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
      <link rel="icon" href="assets/img/sumut.jpeg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Hasil Akhir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <table border='2' align="center">
<tr>
<td><img src="assets/img/sumut.jpeg" width="80" height="80"></td>
<td><font size="4"><b><center> Hasil Karyawan Terbaik Sumutpos Medan</font>
<br><font size="2">Jl. Sisingamangaraja No.74, Timbang Deli, Kec. Medan Amplas, Kota Medan, Sumatera Utara 20148 </center></font>
<font size="2"> dengan menggunakan metode SAW</font></td></tr></table>

<fieldset>
    <h1>Data Hasil Akhir</h1>

    <?php if ($jabatan): ?>
        <h2>jabatan: <?= $jabatan ?></h2>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>NIK</th>
                <th>Nilai</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=0;
            $queryStr = "SELECT * FROM hasil JOIN alternatif ON hasil.id_alternatif=alternatif.id_alternatif";
            if ($jabatan) {
                $queryStr .= " WHERE alternatif.jabatan = '$jabatan'";
            }
            $queryStr .= " ORDER BY hasil.nilai DESC";
            $query = mysqli_query($koneksi, $queryStr);
            while($data = mysqli_fetch_array($query)){
                $no++;
            ?>
            <tr>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nik'] ?></td>
                <td><?= $data['nilai'] ?></td>
                <td><?= $no; ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<script>
      window.print();
    </script>