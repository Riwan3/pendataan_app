<?php
session_start();

if (!isset($_SESSION['role'])) {
    die("Akses dilarang. Anda belum login.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pendataan_app";

$konek = new mysqli($servername, $username, $password, $dbname);
if ($konek->connect_error) {
    die("Koneksi gagal: " . $konek->connect_error);
}

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
            <?php if ($_SESSION['role'] != 'viewer') : ?>
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
                        <?php if ($_SESSION['role'] != 'viewer') : ?>
                            <th>Status</th>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = $result->fetch_assoc()) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($data['perihal']); ?></td>
                            <td><?= htmlspecialchars($data['nama']); ?></td>
                            <td><?= htmlspecialchars($data['catatan']); ?></td>
                            <td><?= htmlspecialchars($data['tanggal_disposisi']); ?></td>
                            <td>
                                <?php if (!empty($data['upload_file'])) : ?>
                                    <a href="uploads/<?= htmlspecialchars($data['upload_file']); ?>" target="_blank">Lihat File</a>
                                <?php else : ?>
                                    <span class="text-muted">Tidak ada file</span>
                                <?php endif; ?>
                            </td>
                            <?php if ($_SESSION['role'] != 'viewer') : ?>
                                <td>
                                    <?php if ($_SESSION['role'] == 'admin' && $data['status'] == 'Diajukan') : ?>
                                        <a href="?page=disposisi_status&id=<?= $data['id']; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Ingin Mengubah status?')">
                                            Ubah Status: <?= htmlspecialchars($data['status']); ?>
                                        </a>
                                    <?php else : ?>
                                        <?= htmlspecialchars($data['status']); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?page=disposisi_edit&id=<?= $data['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?page=disposisi_delete&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$stmt->close();
$konek->close();
?>