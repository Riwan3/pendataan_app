<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "DELETE FROM staff WHERE id='$id'");

if ($query) {
    echo "<script>alert('Data berhasil dihapus!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=?page=staff_read'>";
} else {
    echo "<script>alert('Data gagal dihapus!');</script>";
    echo "<h1>" . mysqli_error($konek) . "</h1>";
}
