<?php
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    die("Akses tidak sah.");
}

$id = (int) $_GET['id'];
$userId = (int) $_SESSION['user_id'];
logAksesDokumen($konek, $userId, $id, 'surat_keuangan');

// Ambil detail surat keuangan
$stmt = $konek->prepare("
    SELECT sk.*, st.nama AS nama_staff
    FROM surat_keuangan sk
    LEFT JOIN staff st ON sk.staff_id = st.id
    WHERE sk.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Surat keuangan tidak ditemukan.");
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Detail Surat Keuangan</h4>
            <table class="table table-bordered">
                <tr>
                    <th>No SPM</th>
                    <td><?= htmlspecialchars($data['nospm']) ?></td>
                </tr>
                <tr>
                    <th>Tanggal Surat</th>
                    <td><?= htmlspecialchars($data['tanggal_surat']) ?></td>
                </tr>
                <tr>
                    <th>SKPD</th>
                    <td><?= htmlspecialchars($data['skpd']) ?></td>
                </tr>
                <tr>
                    <th>Kepada</th>
                    <td><?= htmlspecialchars($data['kepada']) ?></td>
                </tr>
                <tr>
                    <th>Keperluan Untuk</th>
                    <td><?= htmlspecialchars($data['keperluan_untuk']) ?></td>
                </tr>
                <tr>
                    <th>Jumlah Dibayarkan</th>
                    <td>Rp <?= number_format($data['jumlah_dibayarkan'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <th>Staff</th>
                    <td><?= htmlspecialchars($data['nama_staff']) ?></td>
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
            <a href="?page=surat_keuangan_read" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>