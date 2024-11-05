<?php require_once('includes/init.php'); ?>

<?php
$errors = array();
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['username']) ? trim($_POST['password']) : '';

if(isset($_POST['submit'])):
    
    // Validasi
    if(!$username) {
        $errors[] = 'Username tidak boleh kosong';
    }
    if(!$password) {
        $errors[] = 'Password tidak boleh kosong';
    }
    
    if(empty($errors)):
        $query = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username'");
        $cek = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);
        
        if($cek > 0){
            $hashed_password = sha1($password);
            if($data['password'] === $hashed_password) {
                $_SESSION["user_id"] = $data["id_user"];
                $_SESSION["username"] = $data["username"];
                $_SESSION["role"] = $data["role"];
                redirect_to("dashboard.php");
            } else {
                $errors[] = 'Username atau password salah!';
            }
        } else {
            $errors[] = 'Username atau password salah!';
        }
        
    endif;

endif;    
?>

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
        <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />
        <link rel="shortcut icon" href="assets/img/sumut.jpeg" type="image/x-icon">
        <link rel="icon" href="assets/img/sumut.jpeg" type="image/x-icon">

        <style>
            .bg-purple-dark {
                background-color: #003b7b; /* Warna ungu tua */
            }

            /* Animasi modal */
            .modal-content {
                animation: modalFadeIn 0.8s ease;
            }

            @keyframes modalFadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.8);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .d-flex .btn {
                margin-right: 10px;
            }

            .btn-user {
                min-width: 100px;
            }
        </style>
    </head>

   <body class="bg-purple-dark">
    <nav class="navbar navbar-expand-lg navbar-dark bg-white shadow-lg pb-3 pt-3 font-weight-bold">
        <div class="container justify-content-center">
            <a class="navbar-brand text-center" style="font-weight: 900; color: #003b7b;" href="login.php">
                <i></i> <img width="30px" src="assets/img/sumut.jpeg" alt="Deskripsi Gambar">
                Sistem Pendukung Keputusan Pemilihan Karyawan Terbaik
            </a>
        </div>
    </nav>

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center mt-5">
            <div class="col-xl-6 col-lg-6 col-md-8 mt-2">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">

                                    <div class="text-center">
                                         <img width="150px" src="assets/img/sumut.jpeg" >
                                         <br>
                                        <h1 class="h4 text-gray-900 mb-4">Login Account</h1>
                                    </div>
                                    <?php if(!empty($errors)): ?>
                                        <?php foreach($errors as $error): ?>
                                            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>  

                                    <!-- Form login dan button -->
                                    <form class="user text-center" action="login.php" method="post">
                                        <div class="form-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input required autocomplete="off" type="text" value="<?php echo htmlentities($username); ?>" class="form-control form-control-user" id="exampleInputUser" placeholder="Username" name="username" />
                                        </div>
                                        <div class="form-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            </div>
                                            <input required autocomplete="off" type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-eye" onclick="togglePassword()"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Container untuk tiga tombol -->
                                        <div class="d-flex justify-content-center">
                                            <!-- Button Login -->
                                            <button name="submit" type="submit" class="btn btn-warning btn-user mr-2">
                                                <i class="fas fa-fw fa-sign-in-alt mr-1"></i> Masuk
                                            </button>

                                            <!-- Button SPK -->
                                            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalSPK">
                                                SPK
                                            </button>

                                            <!-- Button SAW -->
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSAW">
                                                SAW
                                            </button>
                                        </div>
                                    </form>

                                    <div class="text-center mt-3">
                                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal SPK -->
    <div class="modal fade" id="modalSPK" tabindex="-1" role="dialog" aria-labelledby="modalSPKTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSPKTitle">Penjelasan SPK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Sistem Pendukung Keputusan (SPK) adalah sistem yang digunakan untuk mendukung pengambilan keputusan dengan memanfaatkan metode-metode tertentu. Salah satunya adalah metode *Simple Additive Weighting (SAW)* yang digunakan untuk merangking alternatif yang ada berdasarkan kriteria yang sudah ditentukan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal SAW -->
    <div class="modal fade" id="modalSAW" tabindex="-1" role="dialog" aria-labelledby="modalSAWTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSAWTitle">Penjelasan SAW</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    *Simple Additive Weighting (SAW)* adalah metode yang digunakan dalam SPK untuk menjumlahkan semua nilai kriteria yang sudah diberi bobot. Metode ini sering digunakan karena kesederhanaannya dan efektivitasnya dalam memecahkan masalah pengambilan keputusan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>
    
    <!-- Script untuk toggle visibility password -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('exampleInputPassword');
            var icon = document.querySelector('.fa-eye');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    </body>
</html>