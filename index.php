<?php
session_start(); // memulai fungsi session
if (!isset($_SESSION['id'])) { // mencek apakah session id belum diset
    header('location:login/login_view.php'); // kalau belum, maka langsung diarahkan ke login_view.php
}
include "pengaturan/koneksi.php";
include "template/sidebar.php";
include "template/header.php";
$page = isset($_GET['page']) ? $_GET['page'] : '';
switch ($page) {
    case "dashboard":
        include "dashboard/dashboard_view.php";
        break;
    // ----------------------------------------
    // untuk folder surat masuk
    case "surat_masuk_read":
        include "surat_masuk/surat_masuk_read.php";
        break;
    case "surat_masuk_add":
        include "surat_masuk/surat_masuk_add.php";
        break;
    case "surat_masuk_edit":
        include "surat_masuk/surat_masuk_edit.php";
        break;
    case "surat_masuk_delete":
        include "surat_masuk/surat_masuk_delete.php";
        break;
    case "surat_masuk_status":
        include "surat_masuk/surat_masuk_status.php";
        break;
    // ----------------------------------------
    // untuk folder surat keluar
    case "surat_keluar_read":
        include "surat_keluar/surat_keluar_read.php";
        break;
    case "surat_keluar_add":
        include "surat_keluar/surat_keluar_add.php";
        break;
    case "surat_keluar_edit":
        include "surat_keluar/surat_keluar_edit.php";
        break;
    case "surat_keluar_delete":
        include "surat_keluar/surat_keluar_delete.php";
        break;
    case "surat_keluar_status":
        include "surat_keluar/surat_keluar_status.php";
        break;
    // ----------------------------------------
    // untuk folder surat perjalanan
    case "surat_perjalanan_read":
        include "surat_perjalanan/surat_perjalanan_read.php";
        break;
    case "surat_perjalanan_add":
        include "surat_perjalanan/surat_perjalanan_add.php";
        break;
    case "surat_perjalanan_edit":
        include "surat_perjalanan/surat_perjalanan_edit.php";
        break;
    case "surat_perjalanan_delete":
        include "surat_perjalanan/surat_perjalanan_delete.php";
        break;
    case "surat_perjalanan_status":
        include "surat_perjalanan/surat_perjalanan_status.php";
        break;
    // ----------------------------------------
    // untuk folder surat perintah Tugas
    case "surat_perintah_read":
        include "surat_perintah/surat_perintah_read.php";
        break;
    case "surat_perintah_add":
        include "surat_perintah/surat_perintah_add.php";
        break;
    case "surat_perintah_edit":
        include "surat_perintah/surat_perintah_edit.php";
        break;
    case "surat_perintah_delete":
        include "surat_perintah/surat_perintah_delete.php";
        break;
    case "surat_perintah_status":
        include "surat_perintah/surat_perintah_status.php";
        break;
    // ----------------------------------------
    // untuk folder Kategori surat
    case "kategori_surat_read":
        include "kategori_surat/kategori_surat_read.php";
        break;
    case "kategori_surat_add":
        include "kategori_surat/kategori_surat_add.php";
        break;
    case "kategori_surat_edit":
        include "kategori_surat/kategori_surat_edit.php";
        break;
    case "kategori_surat_delete":
        include "kategori_surat/kategori_surat_delete.php";
        break;
    // ----------------------------------------
    // untuk folder Pengguna
    case "user_read":
        include "user/user_read.php";
        break;
    case "user_add":
        include "user/user_add.php";
        break;
    case "user_edit":
        include "user/user_edit.php";
        break;
    case "user_delete":
        include "user/user_delete.php";
        break;
    // ----------------------------------------
    // untuk folder Staff
    case "staff_read":
        include "staff/staff_read.php";
        break;
    case "staff_add":
        include "staff/staff_add.php";
        break;
    case "staff_edit":
        include "staff/staff_edit.php";
        break;
    case "staff_delete":
        include "staff/staff_delete.php";
        break;
    // ----------------------------------------
    // untuk folder Disposisi
    case "disposisi_read":
        include "disposisi/disposisi_read.php";
        break;
    case "disposisi_add":
        include "disposisi/disposisi_add.php";
        break;
    case "disposisi_edit":
        include "disposisi/disposisi_edit.php";
        break;
    case "disposisi_delete":
        include "disposisi/disposisi_delete.php";
        break;
    case "disposisi_status":
        include "disposisi/disposisi_status.php";
        break;
    // ----------------------------------------
    // untuk folder pencairan dana
    case "ocr_pencairan_dana":
        include "surat_keuangan/index.php";
        break;
    case "surat_keuangan_read":
        include "surat_keuangan/surat_keuangan_read.php";
        break;
    case "surat_keuangan_add":
        include "surat_keuangan/surat_keuangan_add.php";
        break;
    case "surat_keuangan_edit":
        include "surat_keuangan/surat_keuangan_edit.php";
        break;
    case "surat_keuangan_delete":
        include "surat_keuangan/surat_keuangan_delete.php";
        break;
    case "surat_keuangan_status":
        include "surat_keuangan/surat_keuangan_status.php";
        break;
}

include "template/footer.php";
