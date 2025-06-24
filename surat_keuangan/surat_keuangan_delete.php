<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "DELETE FROM surat_keuangan WHERE id='$id'");

if ($query) {
    echo "<script>alert('Data berhasil dihapus!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=?page=surat_keuangan_read'>";
} else {
    echo "<script>alert('Data gagal dihapus!');</script>";
}
