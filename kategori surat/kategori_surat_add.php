<?php
if (isset($_POST['simpan'])) {
    $nama_kategori = $_POST['nama_kategori'];

    $query = mysqli_query($konek, "INSERT INTO kategori_surat (nama_kategori)
    VALUES ('$nama_kategori')");

    if ($query) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=kategori_surat_read'>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!');</script>";
        echo "<h1>" . mysqli_error($konek) . "</h1>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Data Kategori Surat</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Kategori Surat</label>
                    <input type="text" name="nama_kategori" required class="form-control">
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=kategori_surat_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>