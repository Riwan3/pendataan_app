<?php
// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pendataan_app";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$status = $_GET['status'] ?? '';
$orderby = $_GET['orderby'] ?? 'tanggal_surat';
$sort = $_GET['sort'] ?? 'DESC';
$keyword = $_GET['q'] ?? '';

// Validasi kolom order by
$validOrder = ['nospm', 'tanggal_surat', 'skpd', 'kepada', 'keperluan_untuk', 'jumlah_dibayarkan', 'status', 'created_at'];
if (!in_array($orderby, $validOrder)) {
    $orderby = 'tanggal_surat';
}

$where = [];
if ($status !== '') $where[] = "sk.status = '$status'";
if ($keyword !== '') {
    $escaped = $conn->real_escape_string($keyword);
    $where[] = "(sk.nospm LIKE '%$escaped%' OR sk.kepada LIKE '%$escaped%' OR sk.keperluan_untuk LIKE '%$escaped%')";
}
$whereClause = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT sk.*, s.nama FROM surat_keuangan sk
        JOIN staff s ON sk.staff_id = s.id
        $whereClause
        ORDER BY $orderby $sort";
?>

<div class="container-fluid mb-4">
    <form method="GET" action="">
        <input type="hidden" name="page" value="surat_keuangan_read">
        <div class="row g-2 align-items-center">
            <div class="col-md-3">
                <label class="form-label fw-bold">Result Type:</label>
                <select name="status" class="form-control">
                    <option value="">Any</option>
                    <option value="Diajukan" <?= ($status == 'Diajukan') ? 'selected' : '' ?>>Diajukan</option>
                    <option value="Disetujui" <?= ($status == 'Disetujui') ? 'selected' : '' ?>>Disetujui</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Sort Order:</label>
                <select name="sort" class="form-control">
                    <option value="ASC" <?= ($sort == 'ASC') ? 'selected' : '' ?>>ASC</option>
                    <option value="DESC" <?= ($sort == 'DESC') ? 'selected' : '' ?>>DESC</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Order By:</label>
                <select name="orderby" class="form-control">
                    <option value="nospm" <?= ($orderby == 'nospm') ? 'selected' : '' ?>>No SPM</option>
                    <option value="tanggal_surat" <?= ($orderby == 'tanggal_surat') ? 'selected' : '' ?>>Tanggal Surat</option>
                    <option value="skpd" <?= ($orderby == 'skpd') ? 'selected' : '' ?>>SKPD</option>
                    <option value="kepada" <?= ($orderby == 'kepada') ? 'selected' : '' ?>>Kepada</option>
                    <option value="keperluan_untuk" <?= ($orderby == 'keperluan_untuk') ? 'selected' : '' ?>>Keperluan</option>
                    <option value="jumlah_dibayarkan" <?= ($orderby == 'jumlah_dibayarkan') ? 'selected' : '' ?>>Jumlah Dibayarkan</option>
                    <option value="status" <?= ($orderby == 'status') ? 'selected' : '' ?>>Status</option>
                    <option value="created_at" <?= ($orderby == 'created_at') ? 'selected' : '' ?>>Tanggal Input</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Search:</label>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari...">
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
            <h5 class="card-title fw-semibold mb-4">Data Surat Keuangan</h5>
            <?php if ($_SESSION['role'] != 'viewer') : ?>
                <a href="?page=surat_keuangan_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. SPM</th>
                        <th>Tanggal</th>
                        <th>SKPD</th>
                        <th>Kepada</th>
                        <th>Keperluan</th>
                        <th>Jumlah Dibayarkan</th>
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
                    $query = mysqli_query($conn, $sql);
                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$data['nospm']}</td>
                            <td>{$data['tanggal_surat']}</td>
                            <td>{$data['skpd']}</td>
                            <td>{$data['kepada']}</td>
                            <td>{$data['keperluan_untuk']}</td>
                            <td>Rp " . number_format($data['jumlah_dibayarkan'], 0, ',', '.') . "</td>
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
                                echo "<td><a href='?page=surat_keuangan_status&id={$data['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Ingin mengubah status?\")'>Ubah Status: {$data['status']}</a></td>";
                            } else {
                                echo "<td>{$data['status']}</td>";
                            }

                            echo "<td>
                                <a href='?page=surat_keuangan_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?page=surat_keuangan_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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