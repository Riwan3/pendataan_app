<?php
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Surat Perintah Tugas</h5>
            <?php if ($_SESSION['role'] != 'viewer') : ?>
                <a href="?page=surat_perintah_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal</th>
                        <th>Tujuan</th>
                        <th>Perihal</th>
                        <th>Keterangan</th>
                        <th>Staff</th>
                        <th>File Upload</th>
                        <?php if ($_SESSION['role'] != 'viewer') : ?>
                            <th>Status</th>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($konek, "SELECT s.nama, spt.id, spt.no_surat, spt.tanggal, spt.tujuan, spt.perihal, spt.keterangan, spt.upload_file, spt.status
                    FROM surat_perintah_tugas spt
                    JOIN staff s ON spt.staff_id = s.id
                    ");
                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$data['no_surat']}</td>
                            <td>{$data['tanggal']}</td>
                            <td>{$data['tujuan']}</td>
                            <td>{$data['perihal']}</td>
                            <td>{$data['keterangan']}</td>
                            <td>{$data['nama']}</td>
                            <td>
                            ";
                        // Menampilkan link untuk mengunduh file jika ada
                        if (!empty($data['upload_file'])) {
                            echo "<a href='uploads/" . htmlspecialchars($data['upload_file']) . "' class='btn btn-info btn-sm' target='_blank'>Unduh</a>";
                        } else {
                            echo "Tidak ada file";
                        }
                        echo "</td>";

                        // Kondisi untuk menampilkan tombol berdasarkan role
                        if ($_SESSION['role'] != 'viewer') {  // Hanya user dengan role selain yang bisa melihat tombol
                            if ($_SESSION['role'] == 'admin' && $data['status'] == 'Diajukan') {
                                echo "<td><a href='?page=surat_perintah_status&id={$data['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Ingin Mengubah status?\")'>Ubah Status: {$data['status']}</a></td>";
                            } else if ($_SESSION['role'] != 'viewer') {
                                echo "<td>{$data['status']}</td>";
                            }
                            // Kondisi untuk menampilkan tombol berdasarkan role
                            echo "<td>
                        <a href='?page=surat_masuk_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='?page=surat_masuk_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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