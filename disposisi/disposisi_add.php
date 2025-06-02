<?php
if (isset($_POST['simpan'])) {
    $surat_masuk_id = $_POST['surat_masuk_id'];
    $staff_id = $_POST['staff_id'];
    $catatan = $_POST['catatan'];
    $tanggal_disposisi = $_POST['tanggal_disposisi'];

    // Menangani upload file
    $upload_file = $_FILES['upload_file']['name'];
    $upload_tmp = $_FILES['upload_file']['tmp_name'];
    $upload_dir = 'uploads/'; // Pastikan direktori ini ada dan dapat ditulisi

    // Memindahkan file ke direktori yang diinginkan
    if (move_uploaded_file($upload_tmp, $upload_dir . $upload_file)) {
        // Jika upload berhasil, simpan data ke database
        $query = "INSERT INTO disposisi (surat_masuk_id, staff_id, catatan, tanggal_disposisi, upload_file, status) 
        VALUES ('$surat_masuk_id', '$staff_id', '$catatan', '$tanggal_disposisi', '$upload_file','Diajukan')";
        // Eksekusi query
        if (mysqli_query($konek, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=disposisi_read'>";
        } else {
            echo "<script>alert('Data gagal ditambahkan: " . mysqli_error($konek) . "');</script>";
        }
    } else {
        echo "<script>alert('File gagal diupload!');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Data Disposisi</h5>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Surat Masuk</label>
                    <select name="surat_masuk_id" class="form-control" required>
                        <option value="">-- Pilih Surat Masuk --</option>
                        <?php
                        $querySurat = mysqli_query($konek, "SELECT id, perihal FROM surat_masuk");
                        while ($row = mysqli_fetch_assoc($querySurat)) {
                            echo "<option value='{$row['id']}'>{$row['perihal']}</option>";
                        }
                        ?>
                    </select>
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
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Disposisi</label>
                    <input type="date" name="tanggal_disposisi" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File</label>
                    <input type="file" name="upload_file" class="form-control" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=disposisi_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>