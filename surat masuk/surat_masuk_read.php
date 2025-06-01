<?php
// Pastikan koneksi ke database sudah dilakukan sebelumnya
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Surat Masuk</h5>
            <?php if ($_SESSION['role'] != 'pimpinan') : ?>
                <a href="?page=surat_masuk_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Kategori</th>
                        <th>Tanggal Terima</th>
                        <th>File Upload</th> <!-- Kolom untuk menampilkan file upload -->
                        <?php if ($_SESSION['role'] != 'pimpinan') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($konek, "SELECT s.*, k.nama_kategori FROM surat_masuk s LEFT JOIN kategori_surat k ON s.kategori_id = k.id");
                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr>
                        <td>{$no}</td>
                        <td>" . htmlspecialchars($data['nomor_surat']) . "</td>
                        <td>" . htmlspecialchars($data['tanggal']) . "</td>
                        <td>" . htmlspecialchars($data['pengirim']) . "</td>
                        <td>" . htmlspecialchars($data['perihal']) . "</td>
                        <td>" . htmlspecialchars($data['nama_kategori']) . "</td>
                        <td>" . htmlspecialchars($data['tanggal_terima']) . "</td>
                        <td>";

                        // Menampilkan link untuk mengunduh file jika ada
                        if (!empty($data['upload_file'])) {
                            echo "<a href='uploads/" . htmlspecialchars($data['upload_file']) . "' class='btn btn-info btn-sm' target='_blank'>Unduh</a>";
                        } else {
                            echo "Tidak ada file";
                        }

                        echo "</td>";

                        // Kondisi untuk menampilkan tombol berdasarkan role
                        if ($_SESSION['role'] != 'pimpinan') {  // Pimpinan tidak melihat tombol
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