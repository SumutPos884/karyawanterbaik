<?php
require_once('includes/init.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
    $data = mysqli_fetch_array($query);

    if ($data) {
        $token = bin2hex(random_bytes(50)); // Generate token
        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
        );
        $expDate = date("Y-m-d H:i:s", $expFormat);

        $update = mysqli_query($koneksi, "UPDATE user SET reset_token = '$token', reset_exp = '$expDate' WHERE email = '$email'");

        $resetLink = "http://yourdomain.com/reset-password.php?token=" . $token;

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'farelnugroho40@gmail.com';
            $mail->Password   = 'dawel123@';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('farelnugroho40@gmail.com', 'admin');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body    = 'Klik tautan berikut untuk mereset password Anda: <a href="' . $resetLink . '">Reset Password</a>';
            $mail->AltBody = 'Klik tautan berikut untuk mereset password Anda: ' . $resetLink;

            $mail->send();
            echo 'Tautan reset password telah dikirim ke email Anda.';
        } catch (Exception $e) {
            echo "Pesan tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email tidak ditemukan.";
    }
}
?>
