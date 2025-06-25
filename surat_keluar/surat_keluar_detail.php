<?php
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    die("Akses tidak sah.");
}

$userId = (int) $_SESSION['user_id'];
$id = (int) $_GET['id'];

logAksesDokumen($konek, $userId, $id, 'surat_keluar');

// Ambil detail surat keluar
$stmt = $konek->prepare("
    SELECT s.*, k.nama_kategori
    FROM surat_keluar s
    LEFT JOIN kategori_surat k ON s.kategori_id = k.id
    WHERE s.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data surat keluar tidak ditemukan.");
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Detail Surat Keluar</h4>
            <table class="table table-bordered">
                <tr>
                    <th>No Surat</th>
                    <td><?= htmlspecialchars($data['no_surat']) ?></td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td><?= htmlspecialchars($data['tanggal']) ?></td>
                </tr>
                <tr>
                    <th>Penerima</th>
                    <td><?= htmlspecialchars($data['penerima']) ?></td>
                </tr>
                <tr>
                    <th>Perihal</th>
                    <td><?= htmlspecialchars($data['perihal']) ?></td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td><?= htmlspecialchars($data['nama_kategori']) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?= htmlspecialchars($data['status']) ?></td>
                </tr>
                <tr>
                    <th>File</th>
                    <td>
                        <?php if (!empty($data['upload_file'])): ?>
                            <a href="uploads/<?= htmlspecialchars($data['upload_file']) ?>" target="_blank">Lihat File</a>
                        <?php else: ?>
                            Tidak ada file
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <a href="?page=surat_keluar_read" class="btn btn-secondary">Kembali</a>
        </div>
    </div>


</div>