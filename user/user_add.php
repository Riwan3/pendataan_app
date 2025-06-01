<?php

if (isset($_POST['simpan'])) {
    // Mengambil data dari form
    $password = md5($_POST['password']); // Hashing password menggunakan md5
    $role = $_POST['role'];
    $staff_id = $_POST['staff_id'];
    $nip = $_POST['nip'];

    // Menjalankan query untuk menyimpan data
    $query = mysqli_query($konek, "INSERT INTO users (password, role, staff_id, nip) VALUES ('$password', '$role', '$staff_id', '$nip')");

    // Memeriksa apakah query berhasil
    if ($query) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=user_read'>";
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($konek) . "');</script>";
    }
}
?>


<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Data Pengguna</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" name="password" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="pimpinan">Pimpinan</option>
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
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=user_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>