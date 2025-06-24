<div class="container-fluid">
    <h4 class="mb-4">Dashboard</h4>
    <div class="row">
        <?php
        $cards = [
            [
                'title' => 'Surat Masuk',
                'count' => mysqli_num_rows(mysqli_query($konek, "SELECT * FROM surat_masuk")),
                'icon'  => 'ti ti-mail',
                'color' => 'primary',
                'link'  => '?page=surat_masuk_read'
            ],
            [
                'title' => 'Surat Keluar',
                'count' => mysqli_num_rows(mysqli_query($konek, "SELECT * FROM surat_keluar")),
                'icon'  => 'ti ti-send',
                'color' => 'success',
                'link'  => '?page=surat_keluar_read'
            ],
            [
                'title' => 'Surat Perintah Tugas',
                'count' => mysqli_num_rows(mysqli_query($konek, "SELECT * FROM surat_perintah_tugas")),
                'icon'  => 'ti ti-clipboard-text',
                'color' => 'warning',
                'link'  => '?page=surat_perintah_read'
            ],
            [
                'title' => 'Surat Keuangan',
                'count' => mysqli_num_rows(mysqli_query($konek, "SELECT * FROM surat_keuangan")),
                'icon'  => 'ti ti-currency-dollar',
                'color' => 'danger',
                'link'  => '?page=surat_keuangan_read'
            ],
            [
                'title' => 'Perjalanan Dinas',
                'count' => mysqli_num_rows(mysqli_query($konek, "SELECT * FROM surat_perjalanan_dinas")),
                'icon'  => 'ti ti-map',
                'color' => 'info',
                'link'  => '?page=surat_perjalanan_dinas_read'
            ],
            [
                'title' => 'Disposisi',
                'count' => mysqli_num_rows(mysqli_query($konek, "SELECT * FROM disposisi")),
                'icon'  => 'ti ti-file-check',
                'color' => 'secondary',
                'link'  => '?page=disposisi_read'
            ],
            [
                'title' => 'Staff',
                'count' => mysqli_num_rows(mysqli_query($konek, "SELECT * FROM staff")),
                'icon'  => 'ti ti-users',
                'color' => 'dark',
                'link'  => '?page=staff_read'
            ],
        ];

        foreach ($cards as $card) {
            echo "
            <div class='col-md-3 mb-4'>
                <div class='card text-white bg-{$card['color']} shadow-sm'>
                    <div class='card-body'>
                        <div class='d-flex justify-content-between align-items-center'>
                            <div>
                                <h2 class='fw-bold'>{$card['count']}</h2>
                                <p class='mb-0'>{$card['title']}</p>
                            </div>
                            <i class='{$card['icon']}' style='font-size: 2rem;'></i>
                        </div>
                    </div>
                    <div class='card-footer text-center'>
                        <a href='{$card['link']}' class='text-white small stretched-link'>More info <i class='ti ti-chevron-right'></i></a>
                    </div>
                </div>
            </div>";
        }
        ?>
    </div>
</div>