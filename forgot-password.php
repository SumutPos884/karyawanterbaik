<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Sistem Pendukung Keputusan Metode SAW</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="assets/img/logo ku.png" type="image/x-icon">
    <link rel="icon" href="assets/img/logoku.png" type="image/x-icon">

    <style>
        .bg-purple-dark {
            background-color: #4B0082; /* Warna ungu tua */
        }
    </style>
</head>

<body class="bg-purple-dark">
    <nav class="navbar navbar-expand-lg navbar-dark bg-white shadow-lg pb-3 pt-3 font-weight-bold">
        <div class="container justify-content-center">
            <a class="navbar-brand text-center" style="font-weight: 900; color: #4B0082;" href="login.php">
                <i></i> <img width="30px" src="assets/img/logo ku.png" alt="Deskripsi Gambar">
                Sistem Pendukung Keputusan Pemilihan Siswa Berprestasi SMP Khoiru Ummah Bogor
            </a>
        </div>
    </nav>

    <?php
    require_once('includes/init.php');

    $errors = array();
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $security_answer = isset($_POST['security_answer']) ? trim($_POST['security_answer']) : '';

    if(isset($_POST['submit'])) {
        // Validasi
        if(!$username) {
            $errors[] = 'Username tidak boleh kosong';
        }
        if(!$new_password) {
            $errors[] = 'Password baru tidak boleh kosong';
        }
        if(!$security_answer) {
            $errors[] = 'Jawaban keamanan tidak boleh kosong';
        }

        if(empty($errors)) {
            $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
            $cek = mysqli_num_rows($query);
            $data = mysqli_fetch_array($query);

            if($cek > 0) {
                if($data['security_answer'] === $security_answer) {
                    // Update password
                    $hashed_password = sha1($new_password); // You should consider using a more secure hash function
                    $update_query = mysqli_query($koneksi, "UPDATE user SET password = '$hashed_password' WHERE username = '$username'");

                    if($update_query) {
                        $success_message = 'Password berhasil direset. Silakan <a href="login.php">login</a> dengan password baru Anda.';
                    } else {
                        $errors[] = 'Gagal mereset password. Silakan coba lagi.';
                    }
                } else {
                    $errors[] = 'Jawaban keamanan salah.';
                }
            } else {
                $errors[] = 'Username tidak ditemukan.';
            }
        }
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Forgot Password
                    </div>
                    <div class="card-body">
                        <?php if(!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach($errors as $error): ?>
                                    <p><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($success_message)): ?>
                            <div class="alert alert-success">
                                <?php echo $success_message; ?>
                            </div>
                        <?php else: ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="security_answer">Jawaban Keamanan</label>
                                    <input type="text" class="form-control" id="security_answer" name="security_answer">
                                </div>
                                <div class="form-group">
                                    <label for="new_password">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Reset Password</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
