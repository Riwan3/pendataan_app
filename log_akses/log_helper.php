<?php
function logAksesDokumen(mysqli $conn, int $userId, int $dokumenId, string $jenisDokumen): void
{
    $jenisDokumen = strtolower($jenisDokumen);
    $allowedTypes = ['surat_masuk', 'surat_keluar', 'surat_keuangan', 'dokumen_sp2d'];

    if (!in_array($jenisDokumen, $allowedTypes)) {
        return; // jika tidak valid, stop
    }

    // Cek apakah sudah ada log akses < 5 menit terakhir
    $cek = $conn->prepare("
        SELECT id FROM log_akses_dokumen 
        WHERE user_id = ? AND dokumen_id = ? AND jenis_dokumen = ? 
        AND waktu_akses >= NOW() - INTERVAL 5 MINUTE
    ");
    $cek->bind_param("iis", $userId, $dokumenId, $jenisDokumen);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows === 0) {
        // Jika belum ada, simpan log baru
        $insert = $conn->prepare("
            INSERT INTO log_akses_dokumen (user_id, dokumen_id, jenis_dokumen)
            VALUES (?, ?, ?)
        ");
        $insert->bind_param("iis", $userId, $dokumenId, $jenisDokumen);
        $insert->execute();
        $insert->close();
    }

    $cek->close();
}
