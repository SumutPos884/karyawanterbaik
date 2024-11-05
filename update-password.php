<?php
require_once('includes/init.php');

if (isset($_POST['token']) && isset($_POST['password'])) {
    $token = $_POST['token'];
    $password = sha1(trim($_POST['password']));
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE reset_token = '$token' AND reset_exp > NOW()");
    $data = mysqli_fetch_array($query);

    if ($data) {
        $update = mysqli_query($koneksi, "UPDATE user SET password = '$password', reset_token = NULL, reset_exp = NULL WHERE id_user = '{$data['id_user']}'");
        if ($update) {
            echo "Password berhasil direset. Silakan <a href='login.php'>login</a>.";
        } else {
            echo "Terjadi kesalahan. Silakan coba lagi.";
        }
    } else {
        echo "Token tidak valid atau telah kedaluwarsa.";
    }
}
?>
