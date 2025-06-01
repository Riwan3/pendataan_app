<?php
session_start();
include "../pengaturan/koneksi.php";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($konek, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE nip = '$username' AND password = '$password'";
    $result = mysqli_query($konek, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $dataLogin = mysqli_fetch_assoc($result);

        $_SESSION['id'] = $dataLogin['id'];
        $_SESSION['role'] = $dataLogin['role'];

        echo "<script>alert('Selamat datang" . $dataLogin['nama'] . "!')</script>";
        echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
    } else {
        echo "<script>alert('Username atau Password salah!')</script>";
        echo "<meta http-equiv='refresh' content='0; url=login_view.php'>";
    }
} else {
    echo "<script>alert('Akses tidak diizinkan!')</script>";
    echo "<meta http-equiv='refresh' content='0; url=login_view.php'>";
}
