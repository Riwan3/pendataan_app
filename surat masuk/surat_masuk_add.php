<?php
if (isset($_POST['simpan'])) {
    $nomor_surat = $_POST['nomor_surat'];
    $tanggal = $_POST['tanggal'];
    $pengirim = $_POST['pengirim'];
    $perihal = $_POST['perihal'];
    $kategori_id = $_POST['kategori_id'];
    $tanggal_terima = $_POST['tanggal_terima'];

    // Menangani upload file
    $upload_file = $_FILES['upload_file']['name'];
    $upload_tmp = $_FILES['upload_file']['tmp_name'];
    $upload_dir = 'uploads/'; // Pastikan direktori ini ada dan dapat ditulisi

    // Memindahkan file ke direktori yang diinginkan
    if (move_uploaded_file($upload_tmp, $upload_dir . $upload_file)) {
        // Jika upload berhasil, simpan data ke database
        $query = mysqli_query($konek, "INSERT INTO surat_masuk (nomor_surat, tanggal, pengirim, perihal, kategori_id, tanggal_terima, upload_file, status)
        VALUES ('$nomor_surat', '$tanggal', '$pengirim', '$perihal', '$kategori_id', '$tanggal_terima', '$upload_file', 'Diajukan')");

        if ($query) {
            echo "<script>alert('Data berhasil ditambahkan!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=surat_masuk_read'>";
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
            <h5 class="card-title fw-semibold mb-4">Tambah Surat Masuk</h5>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="nomor_surat" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Pengirim</label>
                    <input type="text" name="pengirim" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Perihal</label>
                    <textarea name="perihal" required class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        $queryKategori = mysqli_query($konek, "SELECT id, nama_kategori FROM kategori_surat");
                        while ($row = mysqli_fetch_assoc($queryKategori)) {
                            echo "<option value='{$row['id']}'>{$row['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Terima</label>
                    <input type="date" name="tanggal_terima" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File</label>
                    <input type="file" name="upload_file" class="form-control" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=surat_masuk_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>