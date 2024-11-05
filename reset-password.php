<?php
require_once('includes/init.php'); 

if(isset($_POST['submit'])) {
  $email = strip_tags($_POST['email']);
  if(empty($email)) {
    echo 'Harap isi email!';
  } else {
    $q = $connect->query('SELECT * FROM user WHERE email = '.$email.'');
    if(count((array) $q) > 0) {
      $new_password = substr(md5(time()), 0, 6);
      $update = $connect->query("UPDATE user SET password = '".$new_password."' WHERE email = '".$email."'");
      if($update) {
        echo 'Kata sandi baru Anda adalah <b>'.$new_password.'</b>';
      } else {
        echo 'Permintaan gagal!';
      }
    } else {
      echo 'Alamat email tidak ditemukan!';
    }
  }
}
?>