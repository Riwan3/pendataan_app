<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "SELECT * FROM disposisi WHERE id='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['simpan'])) {
    $surat_masuk_id = $_POST['surat_masuk_id'];
    $staff_id = $_POST['staff_id'];
    $catatan = $_POST['catatan'];
    $tanggal_disposisi = $_POST['tanggal_disposisi'];
    // Menangani upload file
    $upload_file = $_FILES['upload_file']['name'];
    $upload_tmp = $_FILES['upload_file']['tmp_name'];
    $upload_dir = 'uploads/'; // Pastikan direktori ini ada dan dapat ditulisi

    // Jika file di-upload, pindahkan file dan update database
    if (!empty($upload_file)) {
        // Memindahkan file ke direktori yang diinginkan
        if (move_uploaded_file($upload_tmp, $upload_dir . $upload_file)) {
            // Update data dengan file baru
            $query = mysqli_query($konek, "UPDATE disposisi 
            SET surat_masuk_id='$surat_masuk_id', staff_id='$staff_id', catatan='$catatan', tanggal_disposisi='$tanggal_disposisi', upload_file='$upload_file'
            WHERE id='$id'");
        } else {
            echo "<script>alert('File gagal diupload!');</script>";
        }
    } else {
        // Jika tidak ada file baru, update data tanpa mengubah file
        $query = mysqli_query($konek, "UPDATE disposisi 
            SET surat_masuk_id='$surat_masuk_id', staff_id='$staff_id', catatan='$catatan', tanggal_disposisi='$tanggal_disposisi'
        WHERE id='$id'");
    }

    if ($query) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=disposisi_read'>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Data Disposisi</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Surat Masuk</label>
                    <select name="surat_masuk_id" class="form-control" required>
                        <?php
                        $querySurat = mysqli_query($konek, "SELECT * FROM surat_masuk");
                        while ($row = mysqli_fetch_assoc($querySurat)) {
                            $selected = $data['surat_masuk_id'] == $row['id'] ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['perihal']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Staff</label>
                    <select name="staff_id" class="form-control" required>
                        <option value="">-- Pilih Staff --</option>
                        <?php
                        $queryStaff = mysqli_query($konek, "SELECT * FROM staff");
                        while ($row = mysqli_fetch_assoc($queryStaff)) {
                            echo "<option value='{$row['id']}'>{$row['nama']}, {$row['nip']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control"><?= $data['catatan'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Disposisi</label>
                    <input type="date" name="tanggal_disposisi" value="<?= $data['tanggal_disposisi'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File (Opsional)</label>
                    <input type="file" name="upload_file" class="form-control">
                    <small>File saat ini: <?= htmlspecialchars($data['upload_file']) ?></small>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=disposisi_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>