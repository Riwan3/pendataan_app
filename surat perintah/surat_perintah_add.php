<?php
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

    // Memindahkan file ke direktori
    if (move_uploaded_file($upload_tmp, $upload_dir . $upload_file)) {
        // Jika file berhasil di-upload, simpan data ke database
        $query = mysqli_query($konek, "INSERT INTO surat_perintah_tugas (no_surat, tanggal, tujuan, perihal, keterangan, staff_id, upload_file)
        VALUES ('$no_surat', '$tanggal', '$tujuan', '$perihal', '$keterangan', '$staff_id', '$upload_file')");

        if ($query) {
            echo "<script>alert('Data berhasil ditambahkan!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=surat_perintah_read'>";
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
            <h5 class="card-title fw-semibold mb-4">Tambah Data Surat Perintah Tugas</h5>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="no_surat" class="form-label">No Surat</label>
                    <input type="text" name="no_surat" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="tugas" class="form-label">Tujuan</label>
                    <input type="text" name="tujuan" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="tugas" class="form-label">Perihal</label>
                    <input type="text" name="perihal" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="tugas" class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="staff_id" class="form-label">Staff</label>
                    <select name="staff_id" class="form-control" required>
                        <option value="">-- Staff --</option>
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
                <a href="?page=surat_perintah_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>