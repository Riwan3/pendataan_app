<?php
session_start();

// Cek login
if (!isset($_SESSION['role'])) {
    die("Akses dilarang. Anda belum login.");
}

$konek = new mysqli("localhost", "root", "", "pendataan_app");
if ($konek->connect_error) {
    die("Koneksi gagal: " . $konek->connect_error);
}

// Get filter/sort/search dari URL
$status = $_GET['status'] ?? '';
$orderby = $_GET['orderby'] ?? 'tanggal';
$sort = $_GET['sort'] ?? 'DESC';
$keyword = $_GET['q'] ?? '';

// Validasi kolom order by
$validOrder = ['no_surat', 'tanggal', 'tujuan', 'perihal', 'keterangan', 'status', 'nama'];
if (!in_array($orderby, $validOrder)) {
    $orderby = 'tanggal';
}

// Filter
$where = [];
if ($status !== '') $where[] = "spt.status = '$status'";
if ($keyword !== '') {
    $escaped = $konek->real_escape_string($keyword);
    $where[] = "(spt.no_surat LIKE '%$escaped%' OR spt.tujuan LIKE '%$escaped%' OR spt.perihal LIKE '%$escaped%')";
}
$whereClause = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT s.nama, spt.id, spt.no_surat, spt.tanggal, spt.tujuan, spt.perihal, spt.keterangan, spt.upload_file, spt.status
        FROM surat_perintah_tugas spt
        JOIN staff s ON spt.staff_id = s.id
        $whereClause
        ORDER BY $orderby $sort";

?>

<div class="container-fluid mb-4">
    <form method="GET" action="">
        <input type="hidden" name="page" value="surat_perintah_read">
        <div class="row g-2 align-items-center">
            <div class="col-md-3">
                <label class="form-label fw-bold">Status:</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    <option value="Diajukan" <?= ($status == 'Diajukan') ? 'selected' : '' ?>>Diajukan</option>
                    <option value="Disetujui" <?= ($status == 'Disetujui') ? 'selected' : '' ?>>Disetujui</option>
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
                    <option value="tanggal" <?= ($orderby == 'tanggal') ? 'selected' : '' ?>>Tanggal</option>
                    <option value="no_surat" <?= ($orderby == 'no_surat') ? 'selected' : '' ?>>Nomor Surat</option>
                    <option value="tujuan" <?= ($orderby == 'tujuan') ? 'selected' : '' ?>>Tujuan</option>
                    <option value="perihal" <?= ($orderby == 'perihal') ? 'selected' : '' ?>>Perihal</option>
                    <option value="status" <?= ($orderby == 'status') ? 'selected' : '' ?>>Status</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Pencarian:</label>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari no surat, tujuan, perihal...">
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
                    $query = mysqli_query($konek, $sql);
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
                            <td>";
                        if (!empty($data['upload_file'])) {
                            echo "<a href='uploads/" . htmlspecialchars($data['upload_file']) . "' class='btn btn-info btn-sm' target='_blank'>Unduh</a>";
                        } else {
                            echo "Tidak ada file";
                        }
                        echo "</td>";

                        if ($_SESSION['role'] != 'viewer') {
                            if ($_SESSION['role'] == 'admin' && $data['status'] == 'Diajukan') {
                                echo "<td><a href='?page=surat_perintah_status&id={$data['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Ingin mengubah status?\")'>Ubah Status: {$data['status']}</a></td>";
                            } else {
                                echo "<td>{$data['status']}</td>";
                            }

                            echo "<td>
                                <a href='?page=surat_perintah_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?page=surat_perintah_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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