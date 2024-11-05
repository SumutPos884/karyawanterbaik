<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$ada_error = false;
$result = '';

$id = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(!$id) {
	$ada_error = 'Maaf, data tidak dapat diproses.';
} else {
	$query = mysqli_query($koneksi,"SELECT * FROM jabatan WHERE id = '$id'");
	$cek = mysqli_num_rows($query);
	
	if($cek <= 0) {
		$ada_error = 'Maaf, data tidak dapat diproses.';
	} else {
		mysqli_query($koneksi,"DELETE FROM jabatan WHERE id = '$id';");
		redirect_to('data_jabatan.php?status=sukses-hapus');
	}
}
?>

<?php
$page = "User";
require_once('template/header.php');
?>
	<?php if($ada_error): ?>
		<?php echo '<div class="alert alert-danger">'.$ada_error.'</div>'; ?>	
	<?php endif; ?>
<?php
require_once('template/footer.php');