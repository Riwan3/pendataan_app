<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "SELECT * FROM kategori_surat WHERE id='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['simpan'])) {
    $nama_kategori = $_POST['nama_kategori'];

    $query = mysqli_query($konek, "UPDATE kategori_surat 
    SET nama_kategori='$nama_kategori' WHERE id='$id'");

    if ($query) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=kategori_surat_read'>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
        echo "<h1>" . mysqli_error($konek) . "</h1>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Data Kategori Surat</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Kategori Surat</label>
                    <input type="text" name="nama_kategori" value="<?= $data['nama_kategori'] ?>" required class="form-control">
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=kategori_surat_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>