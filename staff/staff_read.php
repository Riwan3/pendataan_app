<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Staff</h5>
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <a href="?page=staff_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Staff</th>
                        <th>Jabatan</th>
                        <th>Alamat</th>
                        <?php if ($_SESSION['role'] == 'admin') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($konek, "SELECT * FROM staff");
                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$data['nip']}</td>
                                <td>{$data['nama']}</td>
                                <td>{$data['jabatan']}</td>
                                <td>{$data['alamat']}</td>
                                ";
                        // Kondisi untuk menampilkan tombol berdasarkan role setelah kolom jabatan
                        if ($_SESSION['role'] == 'admin') {
                            echo "<td>
                <a href='?page=staff_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                <a href='?page=staff_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                </td>";
                        }
                        $no++;
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>