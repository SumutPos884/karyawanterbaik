<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$ada_error = false;
$result = '';

$id_alternatif = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(isset($_POST['submit'])):	
	
	$nama = $_POST['nama'];
	$nik = $_POST['nik'];
	$jabatan = $_POST['jabatan'];
	$nohp = $_POST['nohp'];
	
	// Validasi
	if(!$nama) {
		$errors[] = 'Nama tidak boleh kosong';
	}
	if(!$jabatan) {
		$errors[] = 'Jabatan tidak boleh kosong';
	}
	
	// Jika lolos validasi lakukan hal di bawah ini
	if(empty($errors)):
		
		$update = mysqli_query($koneksi,"UPDATE alternatif SET nama = '$nama', nik ='$nik', jabatan = '$jabatan', nohp = '$nohp' WHERE id_alternatif = '$id_alternatif'");
	
		if($update) {
			redirect_to('list-alternatif.php?status=sukses-edit');
		} else {
			$errors[] = 'Data gagal diupdate';
		}
	endif;

endif;

// Mengambil data jabatan dari database
$query_jabatan = "SELECT id, jabatan FROM jabatan";
$result_jabatan = mysqli_query($koneksi, $query_jabatan);
?>

<?php
$page = "Alternatif";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data Karyawan</h1>

	<a href="list-alternatif.php" class="btn btn-secondary btn-icon-split">
		<span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>
			
<?php if(!empty($errors)): ?>
	<div class="alert alert-info">
		<?php foreach($errors as $error): ?>
			<?php echo $error; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if($sukses): ?>
	<div class="alert alert-success">
		Data berhasil disimpan
	</div>	
<?php elseif($ada_error): ?>
	<div class="alert alert-info">
		<?php echo $ada_error; ?>
	</div>
<?php else: ?>		
			
<form action="edit-alternatif.php?id=<?php echo $id_alternatif; ?>" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fw fa-edit"></i> Edit Data Karyawan</h6>
		</div>
		<?php
		if(!$id_alternatif) {
		?>
		<div class="card-body">
			<div class="alert alert-danger">Data tidak ada</div>
		</div>
		<?php
		} else {
			$data = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE id_alternatif='$id_alternatif'");
			$cek = mysqli_num_rows($data);
			if($cek <= 0) {
		?>
		<div class="card-body">
			<div class="alert alert-danger">Data tidak ada</div>
		</div>
		<?php
			} else {
				while($d = mysqli_fetch_array($data)) {
		?>
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Nama</label>
					<input autocomplete="off" type="text" name="nama" required value="<?php echo $d['nama']; ?>" class="form-control"/>
					<label class="font-weight-bold">NIK</label>
					<input autocomplete="off" type="text" name="nik" required value="<?php echo $d['nik']; ?>" class="form-control"/>
					<label class="font-weight-bold">Jabatan</label>
					<select name="jabatan" class="form-control" required>
						<?php while($row = mysqli_fetch_assoc($result_jabatan)): ?>
							<option value="<?php echo $row['jabatan']; ?>" <?php if($row['jabatan'] == $d['jabatan']) echo 'selected'; ?>><?php echo $row['jabatan']; ?></option>
						<?php endwhile; ?>
					</select>
					<label class="font-weight-bold">Nomor hp</label>
					<input autocomplete="off" type="text" name="nohp" required value="<?php echo $d['nohp']; ?>" class="form-control"/>
				</div>
			</div>
		</div>
	
		<div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
		<?php
				}
			}
		}
		?>
	</div>
</form>

<?php
endif;
require_once('template/footer.php');
?>
