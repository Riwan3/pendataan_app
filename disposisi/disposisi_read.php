<?php
// Pastikan session sudah dimulai
session_start();

// Periksa apakah session role ada
if (!isset($_SESSION['role'])) {
    die("Akses dilarang. Anda belum login.");
}

// Koneksi ke database
$servername = "localhost";
$username = "root";  // Ganti dengan username MySQL Anda
$password = "";      // Ganti dengan password MySQL Anda
$dbname = "pendataan_app";

// Buat koneksi
$konek = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$konek) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query menggunakan prepared statement
$stmt = $konek->prepare("SELECT d.*, s.perihal, st.nama FROM disposisi d 
                        LEFT JOIN surat_masuk s ON d.surat_masuk_id = s.id 
                        LEFT JOIN staff st ON d.staff_id = st.id");
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Surat Disposisi</h5>
            <?php if ($_SESSION['role'] != 'staff' && $_SESSION['role'] != 'pimpinan') : ?>
                <a href="?page=disposisi_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Surat Masuk</th>
                        <th>Staff</th>
                        <th>Catatan</th>
                        <th>Tanggal Disposisi</th>
                        <th>Upload File</th>
                        <?php if ($_SESSION['role'] != 'staff' && $_SESSION['role'] != 'pimpinan') : ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>" . htmlspecialchars($data['perihal']) . "</td>
                            <td>" . htmlspecialchars($data['nama']) . "</td>
                            <td>" . htmlspecialchars($data['catatan']) . "</td>
                            <td>" . htmlspecialchars($data['tanggal_disposisi']) . "</td>
                            <td>
                                <a href='uploads/" . htmlspecialchars($data['upload_file']) . "' target='_blank'>Lihat File</a>
                            </td>";
                        if ($_SESSION['role'] != 'staff' && $_SESSION['role'] != 'pimpinan') {
                            echo "<td>
                                <a href='?page=disposisi_edit&id=" . htmlspecialchars($data['id']) . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?page=disposisi_delete&id=" . htmlspecialchars($data['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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

<?php
// Tutup koneksi
$konek->close();
?>