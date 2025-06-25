<?php
require_once __DIR__ . '/../vendor/autoload.php';

use thiagoalessio\TesseractOCR\TesseractOCR;

$conn = new mysqli('localhost', 'root', '', 'pendataan_app');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$ocrResult = '';
$error = '';
$successMsg = '';
$kategori = '';

if (isset($_GET['ocr']) && is_numeric($_GET['ocr'])) {
    $id = (int) $_GET['ocr'];
    $query = $conn->query("SELECT upload_file FROM surat_keuangan WHERE id = $id");
    if ($query && $row = $query->fetch_assoc()) {
        $filePath = __DIR__ . '/../uploads/' . $row['upload_file'];
        if (file_exists($filePath)) {
            try {
                $ocr = (new TesseractOCR($filePath))
                    ->executable('C:\Program Files\Tesseract-OCR\tesseract.exe')
                    ->lang('ind', 'eng')
                    ->psm(4, 6);
                $ocrResult = $ocr->run();

                $ml_url = "http://127.0.0.1:5000/predict";
                $payload = json_encode(["text" => $ocrResult]);

                $options = [
                    'http' => [
                        'header'  => "Content-type: application/json\r\n",
                        'method'  => 'POST',
                        'content' => $payload,
                    ],
                ];

                $context  = stream_context_create($options);
                $response = file_get_contents($ml_url, false, $context);

                if ($response !== false) {
                    $json = json_decode($response, true);
                    $kategori = $json['kategori'] ?? 'Tidak diketahui';
                    // Simpan hasil ke tabel dokumen_sp2d
                    $stmt = $conn->prepare("INSERT INTO dokumen_sp2d (nama_file, hasil_ocr, kategori, surat_keuangan_id) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("sssi", $row['upload_file'], $ocrResult, $kategori, $id);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $kategori = 'Gagal klasifikasi';
                }

                $successMsg = 'OCR berhasil diproses.';
            } catch (Exception $e) {
                // $error = 'Gagal menjalankan OCR: ' . $e->getMessage();
            }
        } else {
            $error = 'File tidak ditemukan.';
        }
    } else {
        $error = 'Data tidak valid.';
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Surat Keuangan</h5>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($successMsg): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMsg); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No SPM</th>
                            <th>Tanggal</th>
                            <th>SKPD</th>
                            <th>Kepada</th>
                            <th>Keperluan</th>
                            <th>Jumlah</th>
                            <th>Staff</th>
                            <th>File</th>
                            <th>Aksi</th>
                            <th>Hasil OCR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $result = $conn->query("SELECT sk.*, s.nama FROM surat_keuangan sk JOIN staff s ON sk.staff_id = s.id ORDER BY sk.created_at DESC");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $file = 'uploads/' . htmlspecialchars($row['upload_file']);
                                $highlight = ($row['id'] == ($_GET['ocr'] ?? null)); // Tandai baris yang sedang diproses OCR
                                echo "<tr" . ($highlight ? " style='background:#f9f9f9;'" : "") . ">";
                                echo "<td>{$no}</td>";
                                echo "<td>{$row['nospm']}</td>";
                                echo "<td>{$row['tanggal_surat']}</td>";
                                echo "<td>{$row['skpd']}</td>";
                                echo "<td>{$row['kepada']}</td>";
                                echo "<td>{$row['keperluan_untuk']}</td>";
                                echo "<td>Rp " . number_format($row['jumlah_dibayarkan'], 0, ',', '.') . "</td>";
                                echo "<td>{$row['nama']}</td>";
                                echo "<td><a href='{$file}' target='_blank' class='btn btn-sm btn-primary'>Lihat</a></td>";
                                echo "<td><a href='?page=ocr_pencairan_dana&ocr={$row['id']}' class='btn btn-sm btn-success'>Proses OCR</a></td>";

                                // Tampilkan hasil OCR jika ID sesuai
                                if ($highlight && !empty($ocrResult)) {
                                    echo "<td>
                                            <details>
                                                <summary class='text-primary fw-semibold'>Lihat</summary>
                                                <textarea readonly class='form-control' rows='8'>" . htmlspecialchars($ocrResult) . "</textarea>
                                                <div class='mt-1'><small class='badge bg-info'>Kategori: " . htmlspecialchars($kategori) . "</small></div>
                                            </details>
                                          </td>";
                                } else {
                                    echo "<td>-</td>";
                                }

                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='11'>Belum ada data surat keuangan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>