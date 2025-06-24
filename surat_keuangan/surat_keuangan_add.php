<?php
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

    if (move_uploaded_file($upload_tmp, $upload_dir . $upload_file)) {
        $query = mysqli_query($konek, "INSERT INTO surat_keuangan 
        (nospm, tanggal_surat, skpd, kepada, keperluan_untuk, jumlah_dibayarkan, staff_id, upload_file, status)
        VALUES 
        ('$nospm', '$tanggal', '$skpd', '$kepada', '$keperluan', '$jumlah', '$staff_id', '$upload_file', '$status')");

        if ($query) {
            echo "<script>alert('Data berhasil ditambahkan!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=surat_keuangan_read'>";
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
            <h5 class="card-title fw-semibold mb-4">Tambah Data Surat Keuangan</h5>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nospm" class="form-label">No SPM</label>
                    <input type="text" name="nospm" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="tanggal_surat" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal_surat" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="skpd" class="form-label">SKPD</label>
                    <input type="text" name="skpd" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="kepada" class="form-label">Kepada</label>
                    <input type="text" name="kepada" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="keperluan_untuk" class="form-label">Keperluan Untuk</label>
                    <input type="text" name="keperluan_untuk" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="jumlah_dibayarkan" class="form-label">Jumlah Dibayarkan</label>
                    <input type="number" name="jumlah_dibayarkan" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="staff_id" class="form-label">Staff</label>
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
                    <label class="form-label">Upload File</label>
                    <input type="file" name="upload_file" class="form-control" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=surat_keuangan_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>