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

$validOrder = ['nomor_surat', 'tanggal', 'pengirim', 'perihal', 'tanggal_terima', 'nama_kategori', 'status'];
if (!in_array($orderby, $validOrder)) {
    $orderby = 'tanggal';
}

$where = [];
if ($status !== '') $where[] = "s.status = '$status'";
if ($keyword !== '') {
    $escaped = $konek->real_escape_string($keyword);
    $where[] = "(s.nomor_surat LIKE '%$escaped%' OR s.pengirim LIKE '%$escaped%' OR s.perihal LIKE '%$escaped%' OR k.nama_kategori LIKE '%$escaped%')";
}
$whereClause = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT s.*, k.nama_kategori FROM surat_masuk s 
        LEFT JOIN kategori_surat k ON s.kategori_id = k.id
        $whereClause
        ORDER BY $orderby $sort";

$query = mysqli_query($konek, $sql);
?>

<div class="container-fluid mb-4">
    <form method="GET" action="">
        <input type="hidden" name="page" value="surat_masuk_read">
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
                    <option value="nomor_surat" <?= ($orderby == 'nomor_surat') ? 'selected' : '' ?>>Nomor Surat</option>
                    <option value="tanggal" <?= ($orderby == 'tanggal') ? 'selected' : '' ?>>Tanggal Surat</option>
                    <option value="pengirim" <?= ($orderby == 'pengirim') ? 'selected' : '' ?>>Pengirim</option>
                    <option value="perihal" <?= ($orderby == 'perihal') ? 'selected' : '' ?>>Perihal</option>
                    <option value="tanggal_terima" <?= ($orderby == 'tanggal_terima') ? 'selected' : '' ?>>Tanggal Terima</option>
                    <option value="nama_kategori" <?= ($orderby == 'nama_kategori') ? 'selected' : '' ?>>Kategori</option>
                    <option value="status" <?= ($orderby == 'status') ? 'selected' : '' ?>>Status</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Search:</label>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari nomor surat, pengirim, perihal...">
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
            <h5 class="card-title fw-semibold mb-4">Data Surat Masuk</h5>
            <?php if ($_SESSION['role'] != 'viewer') : ?>
                <a href="?page=surat_masuk_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Kategori</th>
                        <th>Tanggal Terima</th>
                        <th>File Upload</th>
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
                            <td>" . htmlspecialchars($data['nomor_surat']) . "</td>
                            <td>" . htmlspecialchars($data['tanggal']) . "</td>
                            <td>" . htmlspecialchars($data['pengirim']) . "</td>
                            <td>" . htmlspecialchars($data['perihal']) . "</td>
                            <td>" . htmlspecialchars($data['nama_kategori']) . "</td>
                            <td>" . htmlspecialchars($data['tanggal_terima']) . "</td>
                            <td>";
                        if (!empty($data['upload_file'])) {
                            echo "<a href='uploads/" . htmlspecialchars($data['upload_file']) . "' class='btn btn-info btn-sm' target='_blank'>Unduh</a>";
                        } else {
                            echo "Tidak ada file";
                        }
                        echo "</td>";

                        if ($_SESSION['role'] != 'viewer') {
                            if ($_SESSION['role'] == 'admin' && $data['status'] == 'Diajukan') {
                                echo "<td><a href='?page=surat_masuk_status&id={$data['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Ingin mengubah status?\")'>Ubah Status: {$data['status']}</a></td>";
                            } else {
                                echo "<td>{$data['status']}</td>";
                            }

                            echo "<td>
                                <a href='?page=surat_masuk_edit&id={$data['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?page=surat_masuk_delete&id={$data['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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