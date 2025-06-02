<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Surat Perjalanan Dinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table th,
        .table td {
            white-space: nowrap;
            text-align: center;
            padding: 20px;
        }

        td {
            word-break: break-word;
            max-width: 600px;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Data Surat Perintah Perjalanan Dinas</h5>
                <?php if ($_SESSION['role'] != 'viewer') : ?>
                    <a href="?page=surat_perjalanan_add" class="btn btn-primary mb-3"><i class="ti ti-plus"></i> Tambah Data</a>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat Perintah Perjalanan Dinas</th>
                                <th>Tanggal Pergi</th>
                                <th>Tanggal Pulang</th>
                                <th>Tempat Tujuan</th>
                                <th>Tempat Berangkat</th>
                                <th>Anggaran</th>
                                <th>Nomor Surat Perintah Tugas</th>
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
                            $query = mysqli_query($konek, "SELECT spd.id, spd.nomor_surat, spd.tanggal_pergi, spd.tanggal_pulang, 
                                                                spd.tempat_tujuan, spd.tempat_berangkat, spd.anggaran, spd.status, 
                                                                spt.no_surat, spt.tanggal, spt.tujuan, spt.perihal, 
                                                                spt.keterangan, s.nama
                                                        FROM surat_perjalanan_dinas spd
                                                        JOIN surat_perintah_tugas spt ON spd.surat_perintah_id = spt.id
                                                        JOIN staff s ON spt.staff_id = s.id
                                                        ");
                            $no = 1;
                            while ($data = mysqli_fetch_array($query)) {
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$data['nomor_surat']}</td>
                                    <td>{$data['tanggal_pergi']}</td>
                                    <td>{$data['tanggal_pulang']}</td>
                                    <td>{$data['tempat_tujuan']}</td>
                                    <td>{$data['tempat_berangkat']}</td>
                                    <td>{$data['anggaran']}</td>
                                    <td>{$data['no_surat']}</td>
                                    <td>{$data['tanggal']}</td>
                                    <td>{$data['tujuan']}</td>
                                    <td>{$data['perihal']}</td>
                                    <td>{$data['keterangan']}</td>
                                    <td>{$data['nama']}</td>";


                                // Kondisi untuk menampilkan tombol berdasarkan role
                                if ($_SESSION['role'] != 'viewer') {  // Hanya user dengan role selain yang bisa melihat tombol
                                    if ($_SESSION['role'] == 'admin' && $data['status'] == 'Diajukan') {
                                        echo "<td><a href='?page=surat_perjalanan_status&id={$data['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Ingin Mengubah status?\")'>Ubah Status: {$data['status']}</a></td>";
                                    } else if ($_SESSION['role'] != 'viewer') {
                                        echo "<td>{$data['status']}</td>";
                                    }
                                    // Kondisi untuk menampilkan tombol berdasarkan role
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
                </div> <!-- Akhir table-responsive -->
            </div>
        </div>
    </div>
</body>

</html>