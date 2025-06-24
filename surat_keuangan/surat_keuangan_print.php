<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Surat Keuangan</title>
    <style>
        @page {
            size: A3 landscape;
            margin: 5mm;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .sheet {
            padding: 20mm;
        }

        .header-line {
            border-top: 3px solid black;
            margin-top: 5px;
        }

        .tabeldatasp2d {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tabeldatasp2d th {
            border: 1px solid black;
            padding: 8px;
            background: #dbdbdb;
            font-size: 10px;
        }

        .tabeldatasp2d td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }

        .tabeldatasp2d tr {
            page-break-inside: avoid;
        }

        .signature-section {
            margin-top: 30px;
        }

        .tabeldatasp2d thead {
            display: table-header-group;
        }

        .new-page {
            page-break-before: always;
        }
    </style>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</head>

<body class="A3 lan">
    <section class="sheet">
        <table style="width: 100%;">
            <tr>
                <td style="width: 100px;">
                    <img src="../assets/images/logos/favicon1.png" width="110" height="110" alt="">
                </td>
                <td align="center">
                    <p style="font-size: 24px"><b>Badan Pengelola Keuangan dan Aset Daerah</b></p>
                    <br>
                    <p style="margin-top: -40px;">Ulu Benteng, Marabahan, Barito Kuala 70513<br>
                        Telepon 0511-4799543<br>
                        https://bpkad.baritokualakab.go.id//</p>
                </td>
            </tr>
        </table>
        <div class="header-line"></div>
        <div style="text-align: right; margin-top: 10px;">Marabahan, <?php echo date('j F Y'); ?></div>
        <div style="text-align: center;">
            <h2>Laporan Surat Keuangan</h2>
        </div>

        <table class="tabeldatasp2d">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. SPM</th>
                    <th>Tanggal Surat</th>
                    <th>SKPD</th>
                    <th>Kepada</th>
                    <th>Keperluan</th>
                    <th>Jumlah Dibayarkan</th>
                    <th>Staff</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "", "pendataan_app");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT sk.*, s.nama FROM surat_keuangan sk
                        JOIN staff s ON sk.staff_id = s.id
                        ORDER BY sk.tanggal_surat DESC";
                $result = $conn->query($sql);
                $no = 1;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td style='text-align: center;'>{$no}</td>
                                <td style='text-align: center;'>{$row['nospm']}</td>
                                <td style='text-align: center;'>{$row['tanggal_surat']}</td>
                                <td style='text-align: center;'>{$row['skpd']}</td>
                                <td style='text-align: center;'>{$row['kepada']}</td>
                                <td style='text-align: center;'>{$row['keperluan_untuk']}</td>
                                <td style='text-align: center;'>Rp " . number_format($row['jumlah_dibayarkan'], 0, ',', '.') . "</td>
                                <td style='text-align: center;'>{$row['nama']}</td>
                            </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center;'>Tidak ada data</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <div class="signature-section">
            <table width="100%">
                <tr>
                    <td style="text-align: right; vertical-align: bottom; height: 100px">
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