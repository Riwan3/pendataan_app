<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Surat Keluar</h5>
            <?php if ($_SESSION['role'] != 'viewer') : ?>
                <a href="?page=surat_keluar_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Penerima</th>
                        <th>Perihal</th>
                        <th>Kategori Surat</th>
                        <th>Upload File</th>
                        <?php if ($_SESSION['role'] != 'viewer') : ?>
                            <th>Status</th>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($konek, "SELECT s.*, i.nama_kategori FROM surat_keluar s JOIN kategori_surat i ON s.kategori_id = i.id");
                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$data['no_surat']}</td>
                            <td>{$data['tanggal']}</td>
                            <td>{$data['penerima']}</td>
                            <td>{$data['perihal']}</td>
                            <td>{$data['nama_kategori']}</td>
                            <td>";
                        // Menampilkan link untuk mengunduh file jika ada
                        if (!empty($data['upload_file'])) {
                            echo "<a href='uploads/" . htmlspecialchars($data['upload_file']) . "' class='btn btn-info btn-sm' target='_blank'>Unduh</a>";
                        } else {
                            echo "Tidak ada file";
                        }
                        // kondisi saat admin bisa memperbaharui status
                        if ($_SESSION['role'] != 'viewer') {  // Hanya user dengan role selain yang bisa melihat tombol
                            if ($_SESSION['role'] == 'admin' && $data['status'] == 'Diajukan') {
                                echo "<td><a href='?page=surat_keluar_status&id={$data['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Ingin Mengubah status?\")'>Ubah Status: {$data['status']}</a></td>";
                            } else if ($_SESSION['role'] != 'viewer') {
                                echo "<td>{$data['status']}</td>";
                            }
                            // Kondisi untuk menampilkan tombol berdasarkan role
                            echo "<td>
                        <a href='?page=surat_keluar_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='?page=surat_keluar_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                        </td>";
                        }
                        $no++;
                        echo "</tr>";
                    };
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>