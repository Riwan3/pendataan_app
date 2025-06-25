<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Log Akses Dokumen</title>
    <style>
        @page {
            size: A3 landscape;
            margin: 5mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .sheet {
            padding: 20mm;
        }

        .header-line {
            border-top: 1px solid #bbb;
            margin-top: 10px;
        }

        .tabel-log {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tabel-log th {
            border: 1px solid #444;
            padding: 8px;
            background-color: #eee;
            font-size: 11px;
        }

        .tabel-log td {
            border: 1px solid #444;
            padding: 6px;
            font-size: 12px;
        }

        .tabel-log tr {
            page-break-inside: avoid;
        }

        .tabel-log thead {
            display: table-header-group;
        }

        .signature-section {
            margin-top: 40px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .small-text {
            font-size: 11px;
        }

        table.noborder td,
        table.noborder {
            border: none !important;
        }
    </style>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>

<body>
    <section class="sheet">
        <!-- Header Tanpa Garis -->
        <table class="noborder" width="100%">
            <tr>
                <td width="110px">
                    <img src="../assets/images/logos/favicon1.png" width="100" height="100" alt="">
                </td>
                <td class="text-center">
                    <p style="font-size: 22px; margin: 0;"><b>Badan Pengelola Keuangan dan Aset Daerah</b></p>
                    <p class="small-text" style="margin-top: 5px;">
                        Ulu Benteng, Marabahan, Barito Kuala 70513<br>
                        Telepon 0511-4799543<br>
                        https://bpkad.baritokualakab.go.id/
                    </p>
                </td>
            </tr>
        </table>

        <div class="header-line"></div>
        <div class="text-right small-text" style="margin-top: 10px;">
            Marabahan, <?= date('j F Y') ?>
        </div>

        <h2 class="text-center">Laporan Log Akses Dokumen oleh Pengguna</h2>

        <!-- Tabel Log Akses -->
        <table class="tabel-log">
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
                $conn = new mysqli("localhost", "root", "", "pendataan_app");
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                $sql = "SELECT l.*, u.nip, u.role, s.nama AS nama_staff
                        FROM log_akses_dokumen l
                        JOIN users u ON l.user_id = u.id
                        LEFT JOIN staff s ON u.staff_id = s.id
                        ORDER BY l.waktu_akses DESC";

                $result = $conn->query($sql);
                $no = 1;

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='text-center'>{$no}</td>
                                <td class='text-center'>" . htmlspecialchars($row['nama_staff'] ?? '-') . "</td>
                                <td class='text-center'>" . htmlspecialchars($row['nip']) . "</td>
                                <td class='text-center'>" . htmlspecialchars($row['role']) . "</td>
                                <td class='text-center'>" . htmlspecialchars($row['jenis_dokumen']) . "</td>
                                <td class='text-center'>" . htmlspecialchars($row['dokumen_id']) . "</td>
                                <td class='text-center'>" . htmlspecialchars($row['waktu_akses']) . "</td>
                              </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data akses ditemukan.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <!-- Tanda Tangan Bersih -->
        <div class="signature-section">
            <table width="100%" class="noborder">
                <tr>
                    <td class="text-right" style="height: 100px;">
                        <p>Kepala Badan BPKAD</p><br><br><br><br>
                        <u><b>WIWIEN MASRURI, S.STP, M.Si</b></u><br>
                        <b>NIP. 12341316 200112 1 0901</b>
                    </td>
                </tr>
            </table>
        </div>
    </section>
</body>

</html>