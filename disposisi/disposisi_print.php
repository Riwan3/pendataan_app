<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Disposisi</title>

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
        <title>Laporan Disposisi Surat Masuk</title>
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
            <h2>Laporan Disposisi</h2>
        </div>

        <!-- Tabel Data Disposisi -->
        <table class="tabeldatasp2d">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Perihal</th>
                    <th>Staff</th>
                    <th>Catatan</th>
                    <th>Tanggal Disposisi</th>
                    <th>Upload File</th>
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
                // Query untuk mengambil data dari tabel disposisi
                $sql = "SELECT d.*, s.perihal, st.nama FROM disposisi d 
                                                    LEFT JOIN surat_masuk s ON d.surat_masuk_id = s.id 
                                                    LEFT JOIN staff st ON d.staff_id = st.id";
                $result = $conn->query($sql);

                // Menampilkan data dalam tabel
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td style='text-align: center;'>" . $row["id"] . "</td>
                            <td style='text-align: center;'>" . $row["perihal"] . "</td>
                            <td style='text-align: center;'>" . $row["nama"] . "</td>
                            <td style='text-align: center;'>" . $row["catatan"] . "</td>
                            <td style='text-align: center;'>" . $row["tanggal_disposisi"] . "</td>
                            <td style='text-align: center;'>" . $row["upload_file"] . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data available</td></tr>";
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
                        <b>NIP. 19830316 200112 1 001</b>
                    </td>
                </tr>
            </table>
        </div>
    </section>
</body>

</html>