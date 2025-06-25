<?php
session_start();
if (!isset($_SESSION['role'])) {
    die("Akses dilarang. Anda belum login.");
}

$konek = new mysqli("localhost", "root", "", "pendataan_app");
if ($konek->connect_error) {
    die("Koneksi gagal: " . $konek->connect_error);
}

$orderby = $_GET['orderby'] ?? 'waktu_akses';
$sort = $_GET['sort'] ?? 'DESC';
$keyword = $_GET['q'] ?? '';

$validOrder = ['waktu_akses', 'nama_staff', 'jenis_dokumen', 'dokumen_id'];
if (!in_array($orderby, $validOrder)) {
    $orderby = 'waktu_akses';
}

$where = [];
if ($keyword !== '') {
    $escaped = $konek->real_escape_string($keyword);
    $where[] = "(s.nama LIKE '%$escaped%' OR u.nip LIKE '%$escaped%' OR l.jenis_dokumen LIKE '%$escaped%' OR l.dokumen_id LIKE '%$escaped%')";
}
$whereClause = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT l.*, s.nama AS nama_staff, u.nip, u.role 
        FROM log_akses_dokumen l
        JOIN users u ON l.user_id = u.id
        LEFT JOIN staff s ON u.staff_id = s.id
        $whereClause
        ORDER BY $orderby $sort";

$query = mysqli_query($konek, $sql);
?>

<div class="container-fluid mb-4">
    <form method="GET" action="">
        <input type="hidden" name="page" value="log_akses">
        <div class="row g-2 align-items-center">
            <div class="col-md-3">
                <label class="form-label fw-bold">Sort:</label>
                <select name="sort" class="form-control">
                    <option value="ASC" <?= ($sort == 'ASC') ? 'selected' : '' ?>>ASC</option>
                    <option value="DESC" <?= ($sort == 'DESC') ? 'selected' : '' ?>>DESC</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Order By:</label>
                <select name="orderby" class="form-control">
                    <option value="waktu_akses" <?= ($orderby == 'waktu_akses') ? 'selected' : '' ?>>Waktu Akses</option>
                    <option value="nama_staff" <?= ($orderby == 'nama_staff') ? 'selected' : '' ?>>Nama Staff</option>
                    <option value="jenis_dokumen" <?= ($orderby == 'jenis_dokumen') ? 'selected' : '' ?>>Jenis Dokumen</option>
                    <option value="dokumen_id" <?= ($orderby == 'dokumen_id') ? 'selected' : '' ?>>ID Dokumen</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Search:</label>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari nama, nip, jenis dokumen...">
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
            <h5 class="card-title fw-semibold mb-4">Log Akses Dokumen</h5>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>NIP</th>
                        <th>Role</th>
                        <th>Jenis Dokumen</th>
                        <th>ID Dokumen</th>
                        <th>Waktu Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($query && mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                <td>{$no}</td>
                                <td>" . htmlspecialchars($row['nama_staff'] ?? '-') . "</td>
                                <td>{$row['nip']}</td>
                                <td>{$row['role']}</td>
                                <td>{$row['jenis_dokumen']}</td>
                                <td>{$row['dokumen_id']}</td>
                                <td>{$row['waktu_akses']}</td>
                            </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Tidak ada data.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>