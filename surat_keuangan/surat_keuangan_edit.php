<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "SELECT * FROM surat_keuangan WHERE id='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['simpan'])) {
    $nospm = $_POST['nospm'];
    $tanggal = $_POST['tanggal_surat'];
    $skpd = $_POST['skpd'];
    $kepada = $_POST['kepada'];
    $keperluan = $_POST['keperluan_untuk'];
    $jumlah = $_POST['jumlah_dibayarkan'];
    $staff_id = $_POST['staff_id'];
    $upload_file = $_FILES['upload_file']['name'];
    $upload_tmp = $_FILES['upload_file']['tmp_name'];
    $upload_dir = 'uploads/';
    $status = 'Diajukan';

    if (!empty($upload_file)) {
        move_uploaded_file($upload_tmp, $upload_dir . $upload_file);
        $query = mysqli_query($konek, "UPDATE surat_keuangan 
            SET nospm='$nospm', tanggal_surat='$tanggal', skpd='$skpd', kepada='$kepada', keperluan_untuk='$keperluan', 
                jumlah_dibayarkan='$jumlah', staff_id='$staff_id', upload_file='$upload_file', status='$status'
            WHERE id='$id'");
    } else {
        $query = mysqli_query($konek, "UPDATE surat_keuangan 
            SET nospm='$nospm', tanggal_surat='$tanggal', skpd='$skpd', kepada='$kepada', keperluan_untuk='$keperluan', 
                jumlah_dibayarkan='$jumlah', staff_id='$staff_id', status='$status'
            WHERE id='$id'");
    }

    if ($query) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=surat_keuangan_read'>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Surat Keuangan</h5>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">No. SPM</label>
                    <input type="text" name="nospm" value="<?= $data['nospm'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" value="<?= $data['tanggal_surat'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">SKPD</label>
                    <input type="text" name="skpd" value="<?= $data['skpd'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Kepada</label>
                    <input type="text" name="kepada" value="<?= $data['kepada'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Keperluan Untuk</label>
                    <input type="text" name="keperluan_untuk" value="<?= $data['keperluan_untuk'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Dibayarkan</label>
                    <input type="number" name="jumlah_dibayarkan" value="<?= $data['jumlah_dibayarkan'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilih Staff</label>
                    <select name="staff_id" class="form-control" required>
                        <option value="">-- Pilih Staff --</option>
                        <?php
                        $queryStaff = mysqli_query($konek, "SELECT * FROM staff");
                        while ($row = mysqli_fetch_assoc($queryStaff)) {
                            $selected = $data['staff_id'] == $row['id'] ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['nama']}, {$row['nip']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File (Opsional)</label>
                    <input type="file" name="upload_file" class="form-control">
                    <small>File saat ini: <?= htmlspecialchars($data['upload_file']) ?></small>
                </div>
                <br>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=surat_keuangan_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>