<?php
if (isset($_POST['simpan'])) {
    // Mengambil data dari form
    $nomor_surat = $_POST['nomor_surat'];
    $tanggal_pergi = $_POST['tanggal_pergi'];
    $tanggal_pulang = $_POST['tanggal_pulang'];
    $tempat_tujuan = $_POST['tempat_tujuan'];
    $tempat_berangkat = $_POST['tempat_berangkat'];
    $anggaran = $_POST['anggaran'];
    $surat_perintah_id = $_POST['surat_perintah_id'];

    // Query untuk menyimpan data
    $query = "INSERT INTO surat_perjalanan_dinas (nomor_surat, tanggal_pergi, tanggal_pulang, tempat_tujuan, tempat_berangkat, anggaran, surat_perintah_id, status) 
            VALUES ('$nomor_surat', '$tanggal_pergi', '$tanggal_pulang', '$tempat_tujuan', '$tempat_berangkat', '$anggaran', '$surat_perintah_id', 'Diajukan')";

    // Eksekusi query
    if (mysqli_query($konek, $query)) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=surat_perjalanan_read'>";
    } else {
        // Menampilkan pesan kesalahan jika query gagal
        echo "<script>alert('Data gagal disimpan: " . mysqli_error($konek) . "');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Surat Perintah Perjalanan Dinas</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="nomor_surat" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pergi</label>
                    <input type="date" name="tanggal_pergi" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pulang</label>
                    <input type="date" name="tanggal_pulang" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tempat Tujuan</label>
                    <input type="text" name="tempat_tujuan" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tempat Berangkat</label>
                    <input type="text" name="tempat_berangkat" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Anggaran</label>
                    <input type="text" name="anggaran" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Surat Perintah</label>
                    <select name="surat_perintah_id" class="form-control" required>
                        <option value="">-- Pilih Surat Perintah --</option>
                        <?php
                        $queryStaff = mysqli_query($konek, "SELECT * FROM surat_perintah_tugas");
                        while ($row = mysqli_fetch_assoc($queryStaff)) {
                            echo "<option value='{$row['id']}'>{$row['perihal']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=surat_perjalanan_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>