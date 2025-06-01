<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "SELECT * FROM surat_masuk WHERE id='$id'");
$data = mysqli_fetch_array($query);

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

    // Jika file di-upload, pindahkan file dan update database
    if (!empty($upload_file)) {
        // Memindahkan file ke direktori yang diinginkan
        if (move_uploaded_file($upload_tmp, $upload_dir . $upload_file)) {
            // Update data dengan file baru
            $query = mysqli_query($konek, "UPDATE surat_masuk 
            SET nomor_surat='$nomor_surat', tanggal='$tanggal', pengirim='$pengirim', perihal='$perihal', kategori_id='$kategori_id', tanggal_terima='$tanggal_terima', upload_file='$upload_file'
            WHERE id='$id'");
        } else {
            echo "<script>alert('File gagal diupload!');</script>";
        }
    } else {
        // Jika tidak ada file baru, update data tanpa mengubah file
        $query = mysqli_query($konek, "UPDATE surat_masuk 
        SET nomor_surat='$nomor_surat', tanggal='$tanggal', pengirim='$pengirim', perihal='$perihal', kategori_id='$kategori_id', tanggal_terima='$tanggal_terima'
        WHERE id='$id'");
    }

    if ($query) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=surat_masuk_read'>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Surat Masuk</h5>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="nomor_surat" value="<?= htmlspecialchars($data['nomor_surat']) ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal" value="<?= htmlspecialchars($data['tanggal']) ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Pengirim</label>
                    <input type="text" name="pengirim" value="<?= htmlspecialchars($data['pengirim']) ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Perihal</label>
                    <textarea name="perihal" required class="form-control"><?= htmlspecialchars($data['perihal']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori Surat</label>
                    <select name="kategori_id" class="form-control" required>
                        <?php
                        $querykategori = mysqli_query($konek, "SELECT id, nama_kategori FROM kategori_surat");
                        while ($row = mysqli_fetch_assoc($querykategori)) {
                            $selected = $data['kategori_id'] == $row['id'] ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Terima</label>
                    <input type="date" name="tanggal_terima" value="<?= htmlspecialchars($data['tanggal_terima']) ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File (Opsional)</label>
                    <input type="file" name="upload_file" class="form-control">
                    <small>File saat ini: <?= htmlspecialchars($data['upload_file']) ?></small>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=surat_masuk_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>