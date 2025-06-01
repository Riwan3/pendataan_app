<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "DELETE FROM surat_perjalanan_dinas WHERE id='$id'");

if ($query) {
    echo "<script>alert('Data berhasil dihapus!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=?page=surat_perjalanan_read'>";
} else {
    echo "<script>alert('Data gagal dihapus!');</script>";
}
