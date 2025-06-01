<?php
if (isset($_POST['simpan'])) {
    $no_surat = $_POST['no_surat'];
    $tanggal = $_POST['tanggal'];
    $penerima = $_POST['penerima'];
    $perihal = $_POST['perihal'];
    $kategori_id = $_POST['kategori_id'];

    // Menangani upload file
    $upload_file = $_FILES['upload_file']['name'];
    $upload_tmp = $_FILES['upload_file']['tmp_name'];
    $upload_dir = 'uploads/'; // Pastikan direktori ini ada dan dapat ditulisi

    // Memindahkan file ke direktori yang diinginkan
    if (move_uploaded_file($upload_tmp, $upload_dir . $upload_file)) {
        // Jika upload berhasil, simpan data ke database
        $query = mysqli_query($konek, "INSERT INTO surat_keluar (no_surat, tanggal, penerima, perihal, kategori_id, upload_file)
        VALUES ('$no_surat', '$tanggal', '$penerima', '$perihal', '$kategori_id', '$upload_file')");

        if ($query) {
            echo "<script>alert('Data berhasil ditambahkan!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=surat_keluar_read'>";
        } else {
            echo "<script>alert('Data gagal ditambahkan!');</script>";
        }
    } else {
        echo "<script>alert('File gagal diupload!');</script>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Data Surat Keluar</h5>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="no_surat" class="form-label">No Surat</label>
                    <input type="text" name="no_surat" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="penerima" class="form-label">Penerima</label>
                    <input type="text" name="penerima" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="perihal" class="form-label">Perihal</label>
                    <input type="text" name="perihal" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori Surat</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori Surat --</option>
                        <?php
                        $queryInstansi = mysqli_query($konek, "SELECT id, nama_kategori FROM kategori_surat");
                        while ($row = mysqli_fetch_assoc($queryInstansi)) {
                            echo "<option value='{$row['id']}'>{$row['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File</label>
                    <input type="file" name="upload_file" class="form-control" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=surat_keluar_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>