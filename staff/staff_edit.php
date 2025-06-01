<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "SELECT * FROM staff WHERE id='$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['simpan'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($konek, "UPDATE staff SET nip='$nip', nama='$nama', jabatan='$jabatan',alamat='$alamat'  WHERE id='$id'");

    if ($query) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=staff_read'>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
        echo "<h1>" . mysqli_error($konek) . "</h1>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Data Staff</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" value="<?= $data['nip'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" value="<?= $data['nama'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" value="<?= $data['jabatan'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" value="<?= $data['alamat'] ?>" required class="form-control">
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=staff_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>