<?php
$id = $_GET['id'];

$query = mysqli_query($konek, "DELETE FROM disposisi WHERE id='$id'");

if ($query) {
    echo "<script>alert('Data berhasil dihapus!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=?page=disposisi_read'>";
} else {
    echo "<script>alert('Data gagal dihapus!');</script>";
    echo "<h1>" . mysqli_error($konek) . "</h1>";
}
