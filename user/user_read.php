<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Pengguna</h5>
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <a href="?page=user_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Nama Staff</th>
                        <th>NIP</th>
                        <?php if ($_SESSION['role'] == 'admin') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil data pengguna
                    $query = "SELECT u.*, s.nama AS nama FROM users u LEFT JOIN staff s ON u.staff_id = s.id";
                    $result = mysqli_query($konek, $query);
                    $no = 1;

                    // Menampilkan data dalam tabel
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>" . htmlspecialchars($data['password']) . "</td>
                            <td>" . htmlspecialchars($data['role']) . "</td>
                            <td>" . htmlspecialchars($data['nama']) . "</td>
                            <td>" . htmlspecialchars($data['nip']) . "</td>";
                        if ($_SESSION['role'] == 'admin') {
                            echo "
                                <td>
                                    <a href='?page=user_edit&id=" . $data['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='?page=user_delete&id=" . $data['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                                </td>
                            </tr>";
                            $no++;
                        }
                    }

                    // Menangani jika tidak ada data
                    if ($no == 0) {
                        echo "<tr><td colspan='5' class='text-center'>Tidak ada data pengguna.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>