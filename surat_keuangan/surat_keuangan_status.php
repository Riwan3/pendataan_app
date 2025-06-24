<?php
include '../koneksi.php';

$id = $_GET['id'] ?? null;
$status = 'Disetujui';

$query = mysqli_query($konek, "UPDATE surat_keuangan SET status='$status' WHERE id='$id'");

if ($query && mysqli_affected_rows($konek) > 0) {
    echo "<script>alert('Status berhasil diubah!'); window.location.href='?page=surat_keuangan_read';</script>";
} else {
    echo "<script>alert('Status tidak berubah!');</script>";
    echo "<br><b>Status sekarang:</b> (cek manual)";
    echo "<br><b>Query:</b> UPDATE surat_keuangan SET status='$status' WHERE id='$id'";
}
