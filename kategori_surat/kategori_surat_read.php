<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Kategori Surat</h5>
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <a href="?page=kategori_surat_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Surat</th>
                        <?php if ($_SESSION['role'] == 'admin') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($konek, "SELECT * FROM kategori_surat");
                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr>
                <td>{$no}</td>
                <td>{$data['nama_kategori']}</td>";

                        // Kondisi untuk menampilkan tombol berdasarkan role setelah nama_kategori
                        if ($_SESSION['role'] != 'viewer') {
                            echo "<td>
                <a href='?page=kategori_surat_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                <a href='?page=kategori_surat_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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