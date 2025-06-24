<?php
session_start();
if (!isset($_SESSION['role'])) {
    die("Akses dilarang. Anda belum login.");
}

$konek = new mysqli("localhost", "root", "", "pendataan_app");
if ($konek->connect_error) {
    die("Koneksi gagal: " . $konek->connect_error);
}

// Ambil parameter
$status = $_GET['status'] ?? '';
$orderby = $_GET['orderby'] ?? 'spd.tanggal_pergi';
$sort = $_GET['sort'] ?? 'DESC';
$q = $_GET['q'] ?? '';

// Validasi kolom
$validOrder = [
    'spd.nomor_surat',
    'spd.tanggal_pergi',
    'spd.tanggal_pulang',
    'spd.tempat_tujuan',
    'spd.tempat_berangkat',
    'spd.anggaran',
    'spt.no_surat',
    'spt.tanggal',
    'spt.tujuan',
    'spt.perihal',
    'spt.keterangan',
    's.nama',
    'spd.status'
];

if (!in_array($orderby, $validOrder)) {
    $orderby = 'spd.tanggal_pergi';
}

// Bangun WHERE clause
$where = [];
if ($status !== '') $where[] = "spd.status = '$status'";
if ($q !== '') {
    $escaped = $konek->real_escape_string($q);
    $where[] = "(spd.nomor_surat LIKE '%$escaped%' 
        OR spd.tempat_tujuan LIKE '%$escaped%' 
        OR spt.perihal LIKE '%$escaped%' 
        OR s.nama LIKE '%$escaped%')";
}
$whereClause = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Query
$sql = "SELECT spd.id, spd.nomor_surat, spd.tanggal_pergi, spd.tanggal_pulang, 
               spd.tempat_tujuan, spd.tempat_berangkat, spd.anggaran, spd.status,
               spt.no_surat AS no_surat_perintah, spt.tanggal AS tanggal_perintah, 
               spt.tujuan, spt.perihal, spt.keterangan, s.nama
        FROM surat_perjalanan_dinas spd
        JOIN surat_perintah_tugas spt ON spd.surat_perintah_id = spt.id
        JOIN staff s ON spt.staff_id = s.id
        $whereClause
        ORDER BY $orderby $sort";

$result = $konek->query($sql);
?>

<div class="container-fluid mb-4">
    <form method="GET" action="">
        <input type="hidden" name="page" value="surat_perjalanan_read">
        <div class="row g-2 align-items-center">
            <div class="col-md-3">
                <label class="form-label fw-bold">Status:</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    <option value="Diajukan" <?= ($status == 'Diajukan') ? 'selected' : '' ?>>Diajukan</option>
                    <option value="Disetujui" <?= ($status == 'Disetujui') ? 'selected' : '' ?>>Disetujui</option>
                    <option value="Ditolak" <?= ($status == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Sort:</label>
                <select name="sort" class="form-control">
                    <option value="ASC" <?= ($sort == 'ASC') ? 'selected' : '' ?>>ASC</option>
                    <option value="DESC" <?= ($sort == 'DESC') ? 'selected' : '' ?>>DESC</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Order By:</label>
                <select name="orderby" class="form-control">
                    <option value="spd.nomor_surat" <?= ($orderby == 'spd.nomor_surat') ? 'selected' : '' ?>>Nomor SPPD</option>
                    <option value="spd.tanggal_pergi" <?= ($orderby == 'spd.tanggal_pergi') ? 'selected' : '' ?>>Tanggal Pergi</option>
                    <option value="spd.tanggal_pulang" <?= ($orderby == 'spd.tanggal_pulang') ? 'selected' : '' ?>>Tanggal Pulang</option>
                    <option value="spd.tempat_tujuan" <?= ($orderby == 'spd.tempat_tujuan') ? 'selected' : '' ?>>Tempat Tujuan</option>
                    <option value="spd.tempat_berangkat" <?= ($orderby == 'spd.tempat_berangkat') ? 'selected' : '' ?>>Tempat Berangkat</option>
                    <option value="spd.anggaran" <?= ($orderby == 'spd.anggaran') ? 'selected' : '' ?>>Anggaran</option>
                    <option value="spt.no_surat" <?= ($orderby == 'spt.no_surat') ? 'selected' : '' ?>>No Surat Perintah</option>
                    <option value="spt.tanggal" <?= ($orderby == 'spt.tanggal') ? 'selected' : '' ?>>Tanggal Perintah</option>
                    <option value="spt.tujuan" <?= ($orderby == 'spt.tujuan') ? 'selected' : '' ?>>Tujuan</option>
                    <option value="spt.perihal" <?= ($orderby == 'spt.perihal') ? 'selected' : '' ?>>Perihal</option>
                    <option value="spt.keterangan" <?= ($orderby == 'spt.keterangan') ? 'selected' : '' ?>>Keterangan</option>
                    <option value="s.nama" <?= ($orderby == 's.nama') ? 'selected' : '' ?>>Staff</option>
                    <option value="spd.status" <?= ($orderby == 'spd.status') ? 'selected' : '' ?>>Status</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Pencarian:</label>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($q) ?>" placeholder="Cari no surat, tujuan, perihal, staff...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="ti ti-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Surat Perjalanan Dinas</h5>
            <?php if ($_SESSION['role'] != 'viewer') : ?>
                <a href="?page=surat_perjalanan_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor SPPD</th>
                            <th>Tanggal Pergi</th>
                            <th>Tanggal Pulang</th>
                            <th>Tempat Tujuan</th>
                            <th>Tempat Berangkat</th>
                            <th>Anggaran</th>
                            <th>No Surat Perintah</th>
                            <th>Tanggal</th>
                            <th>Tujuan</th>
                            <th>Perihal</th>
                            <th>Keterangan</th>
                            <th>Staff</th>
                            <?php if ($_SESSION['role'] != 'viewer') : ?>
                                <th>Status</th>
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
                                <td>{$data['nomor_surat']}</td>
                                <td>{$data['tanggal_pergi']}</td>
                                <td>{$data['tanggal_pulang']}</td>
                                <td>{$data['tempat_tujuan']}</td>
                                <td>{$data['tempat_berangkat']}</td>
                                <td>{$data['anggaran']}</td>
                                <td>{$data['no_surat_perintah']}</td>
                                <td>{$data['tanggal_perintah']}</td>
                                <td>{$data['tujuan']}</td>
                                <td>{$data['perihal']}</td>
                                <td>{$data['keterangan']}</td>
                                <td>{$data['nama']}</td>";
                            if ($_SESSION['role'] != 'viewer') {
                                if ($_SESSION['role'] == 'admin' && $data['status'] == 'Diajukan') {
                                    echo "<td><a href='?page=surat_perjalanan_status&id={$data['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Ingin mengubah status?\")'>Ubah Status: {$data['status']}</a></td>";
                                } else {
                                    echo "<td>{$data['status']}</td>";
                                }
                                echo "<td>
                                    <a href='?page=surat_perjalanan_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='?page=surat_perjalanan_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                                </td>";
                            }
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>