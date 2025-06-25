<?php
session_start();
if (!isset($_SESSION['role'])) {
    die("Akses dilarang. Anda belum login.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pendataan_app";
$konek = new mysqli($servername, $username, $password, $dbname);
if ($konek->connect_error) {
    die("Koneksi gagal: " . $konek->connect_error);
}

$status = $_GET['status'] ?? '';
$orderby = $_GET['orderby'] ?? 'tanggal';
$sort = $_GET['sort'] ?? 'DESC';
$keyword = $_GET['q'] ?? '';

$validOrder = ['no_surat', 'tanggal', 'penerima', 'perihal', 'nama_kategori', 'status'];
if (!in_array($orderby, $validOrder)) {
    $orderby = 'tanggal';
}

$where = [];
if ($status !== '') $where[] = "s.status = '$status'";
if ($keyword !== '') {
    $escaped = $konek->real_escape_string($keyword);
    $where[] = "(s.no_surat LIKE '%$escaped%' OR s.penerima LIKE '%$escaped%' OR s.perihal LIKE '%$escaped%' OR i.nama_kategori LIKE '%$escaped%')";
}
$whereClause = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT s.*, i.nama_kategori FROM surat_keluar s
        JOIN kategori_surat i ON s.kategori_id = i.id
        $whereClause
        ORDER BY $orderby $sort";

$query = mysqli_query($konek, $sql);
?>

<div class="container-fluid mb-4">
    <form method="GET" action="">
        <input type="hidden" name="page" value="surat_keluar_read">
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
                    <option value="no_surat" <?= ($orderby == 'no_surat') ? 'selected' : '' ?>>No Surat</option>
                    <option value="tanggal" <?= ($orderby == 'tanggal') ? 'selected' : '' ?>>Tanggal</option>
                    <option value="penerima" <?= ($orderby == 'penerima') ? 'selected' : '' ?>>Penerima</option>
                    <option value="perihal" <?= ($orderby == 'perihal') ? 'selected' : '' ?>>Perihal</option>
                    <option value="nama_kategori" <?= ($orderby == 'nama_kategori') ? 'selected' : '' ?>>Kategori</option>
                    <option value="status" <?= ($orderby == 'status') ? 'selected' : '' ?>>Status</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Search:</label>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari no surat, perihal, penerima...">
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
            <h5 class="card-title fw-semibold mb-4">Data Surat Keluar</h5>
            <?php if ($_SESSION['role'] != 'viewer') : ?>
                <a href="?page=surat_keluar_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Surat</th>
                        <th>Tanggal</th>
                        <th>Penerima</th>
                        <th>Perihal</th>
                        <th>Kategori</th>
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
                    while ($data = mysqli_fetch_array($query)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$data['no_surat']}</td>
                            <td>{$data['tanggal']}</td>
                            <td>{$data['penerima']}</td>
                            <td>{$data['perihal']}</td>
                            <td>{$data['nama_kategori']}</td>
                            <td>";
                        if (!empty($data['upload_file'])) {
                            echo "<a href='uploads/" . htmlspecialchars($data['upload_file']) . "' class='btn btn-info btn-sm' target='_blank'>Unduh</a>";
                        } else {
                            echo "Tidak ada file";
                        }
                        echo "</td>";

                        if ($_SESSION['role'] != 'viewer') {
                            if ($_SESSION['role'] == 'admin' && $data['status'] == 'Diajukan') {
                                echo "<td><a href='?page=surat_keluar_status&id={$data['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Ingin mengubah status?\")'>Ubah Status: {$data['status']}</a></td>";
                            } else {
                                echo "<td>{$data['status']}</td>";
                            }
                            echo "<td>
                                <a href='?page=surat_keluar_detail&id={$data['id']}' class='btn btn-info btn-sm'>Lihat</a>
                                <a href='?page=surat_keluar_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?page=surat_keluar_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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