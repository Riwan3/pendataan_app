<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendataan | BPKAD</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon1.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@latest/tabler-icons.min.css">

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="?page=dashboard" class="text-nowrap logo-img">
                        <img src="assets/images/logos/baner-2048x260.jpg" width="220" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="?page=dashboard" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Data Surat
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <?php if ($_SESSION['role'] != 'staff') : ?>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="?page=surat_perintah_read" aria-expanded="false">
                                                    <span>
                                                        <i class="ti ti-briefcase"></i>
                                                    </span>
                                                    <span class="hide-menu">Surat Perintah <br>Tugas</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="?page=surat_masuk_read" aria-expanded="false">
                                                <span>
                                                    <i class="ti ti-files"></i>
                                                </span>
                                                <span class="hide-menu">Surat Masuk</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="?page=surat_keluar_read" aria-expanded="false">
                                                <span>
                                                    <i class="ti ti-id-badge"></i>
                                                </span>
                                                <span class="hide-menu">Surat Keluar</span>
                                            </a>
                                        </li>
                                        <?php if ($_SESSION['role'] != 'staff') : ?>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="?page=disposisi_read" aria-expanded="false">
                                                    <span>
                                                        <i class="ti ti-tag"></i>
                                                    </span>
                                                    <span class="hide-menu">Disposisi</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="?page=surat_perjalanan_read" aria-expanded="false">
                                                    <span>
                                                        <i class="ti ti-car"></i>
                                                    </span>
                                                    <span class="hide-menu">Surat Perintah <br> Perjalanan Dinas</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="?page=surat_keuangan_read" aria-expanded="false">
                                                    <span>
                                                        <i class="ti ti-wallet"></i>
                                                    </span>
                                                    <span class="hide-menu">Surat Perintah <br> Pencairan Dana</span>
                                                </a>
                                            </li>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Laporan
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <!-- <li class="nav-small-cap">
                                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                            <span class="hide-menu">LAPORAN</span>
                                        </li> -->
                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="surat_perintah/surat_perintah_print.php" target="_blank" aria-expanded="false">
                                                <span>
                                                    <i class="ti ti-printer"></i>
                                                </span>
                                                <span class="hide-menu">Laporan Surat <br>Perintah</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="disposisi/disposisi_print.php" target="_blank" aria-expanded="false">
                                                <span>
                                                    <i class="ti ti-printer"></i>
                                                </span>
                                                <span class="hide-menu">Laporan Surat <br>Disposisi</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="surat_masuk/surat_masuk_print.php" target="_blank" aria-expanded="false">
                                                <span>
                                                    <i class="ti ti-printer"></i>
                                                </span>
                                                <span class="hide-menu">Laporan <br> Surat Masuk</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="surat_keluar/surat_keluar_print.php" target="_blank" aria-expanded="false">
                                                <span>
                                                    <i class="ti ti-printer"></i>
                                                </span>
                                                <span class="hide-menu">Laporan <br> Surat Keluar</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="surat_perjalanan/surat_perjalanan_print.php" target="_blank" aria-expanded="false">
                                                <span>
                                                    <i class="ti ti-printer"></i>
                                                </span>
                                                <span class="hide-menu">Laporan Surat <br>Perjalanan</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="surat_keuangan/surat_keuangan_print.php" target="_blank" aria-expanded="false">
                                                <span>
                                                    <i class="ti ti-printer"></i>
                                                </span>
                                                <span class="hide-menu">Laporan Surat <br>keuangan</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_SESSION['role'] != 'staff' && $_SESSION['role'] != 'pimpinan') : ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Data Master
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="?page=user_read" aria-expanded="false">
                                                    <span>
                                                        <i class="ti ti-user"></i>
                                                    </span>
                                                    <span class="hide-menu">Pengguna</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="?page=staff_read" aria-expanded="false">
                                                    <span>
                                                        <i class="ti ti-id-badge"></i>
                                                    </span>
                                                    <span class="hide-menu">Staff</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="?page=kategori_surat_read" aria-expanded="false">
                                                    <span>
                                                        <i class="ti ti-clipboard"></i>
                                                    </span>
                                                    <span class="hide-menu">Kategori Surat</span>
                                                </a>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="?page=ocr_pencairan_dana" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-currency-dollar"></i>
                                    </span>
                                    <span class="hide-menu">OCR Surat Keuangan</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="login/logout.php" aria-expanded="false" onclick="return confirm('Ingin logout dari sistem?');">
                                    <span>
                                        <i class="ti ti-user"></i>
                                    </span>
                                    <span class="hide-menu">Logout</span>
                                </a>
                            </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>