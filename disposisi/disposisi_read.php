<?php
session_start();
if (!isset($_SESSION['role'])) {
    die("Akses dilarang. Anda belum login.");
}

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pendataan_app";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$status = $_GET['status'] ?? '';
$orderby = $_GET['orderby'] ?? 'tanggal_disposisi';
$sort = $_GET['sort'] ?? 'DESC';
$keyword = $_GET['q'] ?? '';

// Validasi kolom order by
$validOrder = ['tanggal_disposisi', 'catatan', 'status', 'perihal', 'nama'];
if (!in_array($orderby, $validOrder)) {
    $orderby = 'tanggal_disposisi';
}

$where = [];
if ($status !== '') $where[] = "d.status = '$status'";
if ($keyword !== '') {
    $escaped = $conn->real_escape_string($keyword);
    $where[] = "(s.perihal LIKE '%$escaped%' OR st.nama LIKE '%$escaped%' OR d.catatan LIKE '%$escaped%')";
}
$whereClause = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT d.*, s.perihal, st.nama FROM disposisi d
        LEFT JOIN surat_masuk s ON d.surat_masuk_id = s.id
        LEFT JOIN staff st ON d.staff_id = st.id
        $whereClause
        ORDER BY $orderby $sort";

$result = $conn->query($sql);
?>

<div class="container-fluid mb-4">
    <form method="GET" action="">
        <input type="hidden" name="page" value="disposisi_read">
        <div class="row g-2 align-items-center">
            <div class="col-md-3">
                <label class="form-label fw-bold">Status:</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    <option value="Diajukan" <?= ($status == 'Diajukan') ? 'selected' : '' ?>>Diajukan</option>
                    <option value="Selesai" <?= ($status == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
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
                    <option value="tanggal_disposisi" <?= ($orderby == 'tanggal_disposisi') ? 'selected' : '' ?>>Tanggal Disposisi</option>
                    <option value="perihal" <?= ($orderby == 'perihal') ? 'selected' : '' ?>>Perihal</option>
                    <option value="nama" <?= ($orderby == 'nama') ? 'selected' : '' ?>>Nama Staff</option>
                    <option value="catatan" <?= ($orderby == 'catatan') ? 'selected' : '' ?>>Catatan</option>
                    <option value="status" <?= ($orderby == 'status') ? 'selected' : '' ?>>Status</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Search:</label>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari perihal, staff, catatan...">
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
            <h5 class="card-title fw-semibold mb-4">Data Disposisi Surat</h5>
            <?php if ($_SESSION['role'] != 'viewer') : ?>
                <a href="?page=disposisi_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Perihal</th>
                        <th>Staff</th>
                        <th>Catatan</th>
                        <th>Tanggal Disposisi</th>
                        <th>File</th>
                        <?php if ($_SESSION['role'] != 'viewer') : ?>
                            <th>Status</th>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['perihal']); ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['catatan']); ?></td>
                            <td><?= htmlspecialchars($row['tanggal_disposisi']); ?></td>
                            <td>
                                <?php if (!empty($row['upload_file'])) : ?>
                                    <a href="uploads/<?= htmlspecialchars($row['upload_file']); ?>" class="btn btn-info btn-sm" target="_blank">Lihat File</a>
                                <?php else : ?>
                                    <span class="text-muted">Tidak ada file</span>
                                <?php endif; ?>
                            </td>
                            <?php if ($_SESSION['role'] != 'viewer') : ?>
                                <td>
                                    <?php if ($_SESSION['role'] == 'admin' && $row['status'] == 'Diajukan') : ?>
                                        <a href="?page=disposisi_status&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Ubah status?')">
                                            Ubah Status: <?= htmlspecialchars($row['status']); ?>
                                        </a>
                                    <?php else : ?>
                                        <?= htmlspecialchars($row['status']); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?page=disposisi_edit&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?page=disposisi_delete&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
$conn->close();
?>