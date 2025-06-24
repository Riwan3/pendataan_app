<?php
include '../koneksi.php';

$id = $_GET['id'] ?? null;
$status = 'Disetujui'; // HARUS persis dengan ENUM di database

// Eksekusi update
$query = mysqli_query($konek, "UPDATE surat_perintah_tugas SET status='$status' WHERE id='$id'");

if ($query && mysqli_affected_rows($konek) > 0) {
    echo "<script>alert('Status berhasil diubah!'); window.location.href='?page=surat_perintah_read';</script>";
} else {
    echo "<script>alert('Status tidak berubah!');</script>";
    echo "<br><b>Status sekarang:</b> " . mysqli_fetch_assoc($cek)['status'];
    echo "<br><b>Query:</b> UPDATE surat_keluar SET status='$status' WHERE id='$id'";
}
