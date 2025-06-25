<?php
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    die("Akses tidak sah.");
}

$id = (int) $_GET['id'];
$userId = (int) $_SESSION['user_id'];
logAksesDokumen($konek, $userId, $id, 'dokumen_sp2d');

// Ambil detail dokumen SP2D
$stmt = $konek->prepare("
    SELECT ds.*, sk.nospm, sk.kepada, sk.keperluan_untuk
    FROM dokumen_sp2d ds
    LEFT JOIN surat_keuangan sk ON ds.surat_keuangan_id = sk.id
    WHERE ds.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Dokumen SP2D tidak ditemukan.");
}
?>

<div class="container mt-4">
    <h4 class="mb-3">Detail Dokumen SP2D (OCR)</h4>
    <table class="table table-bordered">
        <tr>
            <th>Nama File</th>
            <td><?= htmlspecialchars($data['nama_file']) ?></td>
        </tr>
        <tr>
            <th>Kategori Hasil ML</th>
            <td><span class="badge bg-info"><?= htmlspecialchars($data['kategori']) ?></span></td>
        </tr>
        <tr>
            <th>Tanggal Upload</th>
            <td><?= htmlspecialchars($data['created_at']) ?></td>
        </tr>

        <?php if (!empty($data['nospm'])): ?>
            <tr>
                <th>No SPM Terkait</th>
                <td><?= htmlspecialchars($data['nospm']) ?></td>
            </tr>
            <tr>
                <th>Kepada</th>
                <td><?= htmlspecialchars($data['kepada']) ?></td>
            </tr>
            <tr>
                <th>Keperluan</th>
                <td><?= htmlspecialchars($data['keperluan_untuk']) ?></td>
            </tr>
        <?php endif; ?>

        <tr>
            <th>Cuplikan Hasil OCR</th>
            <td>
                <textarea readonly class="form-control" rows="10"><?= htmlspecialchars($data['hasil_ocr']) ?></textarea>
            </td>
        </tr>
    </table>
    <a href="?page=dokumen_sp2d_read" class="btn btn-secondary">Kembali</a>
</div>