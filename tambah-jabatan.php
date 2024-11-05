<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$jabatan = (isset($_POST['jabatan'])) ? trim($_POST['jabatan']) : '';


if(isset($_POST['submit'])):	
	
	// Validasi
	if(!$jabatan) {
		$errors[] = 'jabatan tidak boleh kosong';
	}
	
	
	// Jika lolos validasi lakukan hal di bawah ini
	if(empty($errors)):
		$simpan = mysqli_query($koneksi,"INSERT INTO jabatan (jabatan) VALUES ('$jabatan')");
	
		if($simpan) {
			redirect_to('data_jabatan.php?status=sukses-baru');
		}else{
			$errors[] = 'Data gagal disimpan';
		}
	endif;

endif;

$page = "data_jabatan";
require_once('template/header.php');
?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data jabatan</h1>

	<a href="data-jabatan.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
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
			
<form action="tambah-jabatan.php" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fw fa-plus"></i> Tambah Data jabatan</h6>
		</div>
		<div class="card-body">
			<div class="row">				
				<div class="form-group col-md-12">
					<label class="font-weight-bold">nama jabatan</label>
					<input autocomplete="off" type="text" name="jabatan" required value="<?php echo $jabatan; ?>" class="form-control"/>
					
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
	</div>
</form>

<?php
require_once('template/footer.php');
?>