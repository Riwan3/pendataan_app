<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "SELECT * FROM surat_perintah_tugas WHERE id='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['simpan'])) {
    $no_surat = $_POST['no_surat'];
    $tanggal = $_POST['tanggal'];
    $tujuan = $_POST['tujuan'];
    $perihal = $_POST['perihal'];
    $keterangan = $_POST['keterangan'];
    $staff_id = $_POST['staff_id'];
    // Menangani upload file
    $upload_file = $_FILES['upload_file']['name'];
    $upload_tmp = $_FILES['upload_file']['tmp_name'];
    $upload_dir = 'uploads/'; // Pastikan direktori ini ada dan dapat ditulisi

    // Jika ada file baru yang di-upload
    if (!empty($upload_file)) {
        // Pindahkan file ke direktori yang diinginkan
        move_uploaded_file($upload_tmp, $upload_dir . $upload_file);
        // Update data dengan file baru
        $query = mysqli_query($konek, "UPDATE surat_perintah_tugas 
        SET no_surat='$no_surat', tanggal='$tanggal', tujuan='$tujuan', perihal='$perihal', keterangan='$keterangan', staff_id='$staff_id', upload_file='$upload_file', status='Diajukan'
        WHERE id='$id'");
    } else {
        // Jika tidak ada file baru, tetap gunakan file yang ada
        $query = mysqli_query($konek, "UPDATE surat_perintah_tugas 
        SET no_surat='$no_surat', tanggal='$tanggal', tujuan='$tujuan', perihal='$perihal',  staff_id='$staff_id', keterangan='$keterangan', status='Diajukan'
        WHERE id='$id'");
    }

    if ($query) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=surat_perintah_read'>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Surat Perintah Tugas</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="no_surat" value="<?= $data['no_surat'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tujuan</label>
                    <input type="text" name="tujuan" value="<?= $data['tujuan'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Perihal</label>
                    <input type="text" name="perihal" value="<?= $data['perihal'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" value="<?= $data['keterangan'] ?>" required class="form-control">
                </div>
                <br>
                <select name="staff_id" class="form-control" required>
                    <option value="">-- Pilih Staff --</option>
                    <?php
                    $queryStaff = mysqli_query($konek, "SELECT * FROM staff");
                    while ($row = mysqli_fetch_assoc($queryStaff)) {
                        echo "<option value='{$row['id']}'>{$row['nama']}, {$row['nip']}</option>";
                    }
                    ?>
                </select>
                <div class="mb-3">
                    <label class="form-label">Upload File (Opsional)</label>
                    <input type="file" name="upload_file" class="form-control">
                    <small>File saat ini: <?= htmlspecialchars($data['upload_file']) ?></small>
                </div>
                <br>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=surat_perintah_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>