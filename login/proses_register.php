<?php
if (isset($_POST['daftar'])) {
    $username = $_POST['username'];
    $no_telp = $_POST['no_telp'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $password = md5($_POST['password']);
    include('../pengaturan/koneksi.php');
    $cek_akun = mysqli_query($konek, "select * from pengguna where username ='$username'");
    if (mysqli_num_rows($cek_akun) > 0) {
        echo "<script>alert('username sudah terdaftar di sistem')</script>";
        echo "<meta http-equiv='refresh' content='0; url=register_view.php>";
    } else {
        $exe = mysqli_query($konek, "insert into pengguna (username, nama_lengkap, no_telp, password, status, status_akun) values ('$username', '$nama_lengkap', '$no_telp', '$password', 'Admin', 'Diajukan')");
        if ($exe) {
            echo "<script>alert('Akun kamu berhasil didaftarkan ke sistem.')</script>";
            echo "<meta http-equiv='refresh' content='0; url=login_view.php'>";
        } else {
            echo "<script>alert('Pendaftaran akun kamu gagal disimpan. Harap isi data dnegan benar')</script>";
            echo "<meta http-equiv='refresh' content='0; url=../register_view.php'>";
        }
    }
}
