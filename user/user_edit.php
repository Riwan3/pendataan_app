<?php
$id = $_GET['id'];
$query = mysqli_query($konek, "SELECT u.*, s.nama AS nama FROM users u LEFT JOIN staff s ON u.staff_id = s.id");
$data = mysqli_fetch_array($query);

if (isset($_POST['simpan'])) {
    $password = $_POST['password'];
    $role = $_POST['role'];
    $staff_id = $_POST['staff_id'];

    $query = mysqli_query($konek, "UPDATE users password=MD5('$password'), role='$role', staff_id='$staff_id' WHERE id='$id'");

    if ($query) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=user_read'>";
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
        echo "<h1>" . mysqli_error($konek) . "</h1>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Data Pengguna</h5>
            <form method="post" action="">
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
                    <label for="password" class="form-label">Password</label>
                    <input type="text" name="password" value="<?= $data['password'] ?>" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="<?= $data['role'] ?>"><?= $data['role'] ?></option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="pimpinan">Pimpinan</option>

                    </select>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="?page=user_read" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>
</div>