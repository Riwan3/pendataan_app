<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "SELECT * FROM surat_perjalanan_dinas WHERE id='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['simpan'])) {
    $nomor_surat = $_POST['nomor_surat'];
    $tanggal_pergi = $_POST['tanggal_pergi'];
    $tanggal_pulang = $_POST['tanggal_pulang'];
    $tempat_tujuan = $_POST['tempat_tujuan'];
    $tempat_berangkat = $_POST['tempat_berangkat'];
    $anggaran = $_POST['anggaran'];
    $surat_perintah_id = $_POST['surat_perintah_id'];

    $query = mysqli_query($konek, "UPDATE surat_perjalanan_dinas 
    SET nomor_surat='$nomor_surat', tanggal_pergi='$tanggal_pergi', tanggal_pulang='$tanggal_pulang', tempat_tujuan='$tempat_tujuan', tempat_berangkat='$tempat_berangkat', anggaran='$anggaran', surat_perintah_id='$surat_perintah_id', status='Diajukan'
    WHERE id='$id'");

    if ($query) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=surat_perjalanan_read'>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Surat Perintah Perjalanan Dinas</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="nomor_surat" value="<?= $data['nomor_surat'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pergi</label>
                    <input type="date" name="tanggal_pergi" value="<?= $data['tanggal_pergi'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pulang</label>
                    <input type="date" name="tanggal_pulang" value="<?= $data['tanggal_pulang'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tempat Tujuan</label>
                    <input type="text" name="tempat_tujuan" value="<?= $data['tempat_tujuan'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tempat Berangkat</label>
                    <input type="text" name="tempat_berangkat" value="<?= $data['tempat_berangkat'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Anggaran</label>
                    <input type="text" name="anggaran" value="<?= $data['anggaran'] ?>" required class="form-control">
                </div>
                <br>
                <select name="surat_perintah_id" class="form-control" required>
                    <option value="">-- Pilih Surat Perintah --</option>
                    <?php
                    $queryStaff = mysqli_query($konek, "SELECT * FROM surat_perintah_tugas");
                    while ($row = mysqli_fetch_assoc($queryStaff)) {
                        echo "<option value='{$row['id']}'>{$row['perihal']}</option>";
                    }
                    ?>
                </select>
                <br>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=surat_perjalanan_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>