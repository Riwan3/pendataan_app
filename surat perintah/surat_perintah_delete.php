<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "DELETE FROM surat_perintah_tugas WHERE id='$id'");

if ($query) {
    echo "<script>alert('Data berhasil dihapus!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=?page=surat_perintah_read'>";
} else {
    echo "<script>alert('Data gagal dihapus!');</script>";
}
