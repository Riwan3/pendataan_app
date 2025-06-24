<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Surat Masuk</title>

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
        <title>Laporan Surat Masuk</title>
        <!-- Header Laporan -->
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
            <h2>Laporan Surat Masuk</h2>
        </div>

        <!-- Tabel Data Surat Masuk -->
        <table class="tabeldatasp2d">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Pengirim</th>
                    <th>Perihal</th>
                    <th>Kategori Surat</th>
                    <th>Tanggal Terima</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database MySQL
                $servername = "localhost";
                $username = "root";  // Ganti dengan username MySQL Anda
                $password = "";      // Ganti dengan password MySQL Anda
                $dbname = "pendataan_app";

                // Buat koneksi
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Cek koneksi
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                // Query untuk mengambil data dari tabel surat_masuk
                $sql = "SELECT sm.nomor_surat, sm.tanggal, sm.pengirim, sm.perihal, ks.nama_kategori, sm.tanggal_terima, sm.upload_file
                        FROM surat_masuk sm
                        JOIN kategori_surat ks ON sm.kategori_id = ks.id";
                $result = $conn->query($sql);
                $no = 1;
                // Menampilkan data dalam tabel
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td style='text-align: center;'>" . $no++ . "</td>
                            <td style='text-align: center;'>" . $row["nomor_surat"] . "</td>
                            <td style='text-align: center;'>" . $row["tanggal"] . "</td>
                            <td style='text-align: center;'>" . $row["pengirim"] . "</td>
                            <td style='text-align: center;'>" . $row["perihal"] . "</td>
                            <td style='text-align: center;'>" . $row["nama_kategori"] . "</td>
                            <td style='text-align: center;'>" . $row["tanggal_terima"] . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No data available</td></tr>";
                }

                // Tutup koneksi
                $conn->close();
                ?>
            </tbody>
        </table>

        <!-- Tanda tangan di halaman terakhir -->
        <div class="signature-section">
            <table width="100%">
                <tr>
                    <td style="text-align: right; vertical-align: bottom; height: 100px">
                        <p>Kepala Badan BPKAD</p><br>
                        <br>
                        <br>
                        <br>
                        <u><b>WIWIEN MASRURI,S.STP.M.Si</b></u><br>
                        <b>NIP. 12341316 200112 1 0901</b>
                    </td>
                </tr>
            </table>
        </div>
    </section>
</body>

</html>