<?php

//header.php

include('../config/config.php');

session_start();

if (!isset($_SESSION["staff_id"])) {
    header('location:../login.php');
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi manajemen pembayaran spp">
    <meta name="keywords" content="Aplikasi SPP online">
    <meta name="author" content="Ahmad Koirul Anwar">
    <!-- favicon -->
    <link rel="shortcut icon" href="../assets/img/logo.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/bootstrap-4.1.3/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/DataTables/css/dataTables.bootstrap4.min.css">
    <!-- datepicker CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/datepicker/css/datepicker.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/fontawesome-free-5.5.0-web/css/all.min.css">
    <!-- Sweetalert CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/sweetalert/css/sweetalert.css">
    <!-- Chosen CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/chosen-bootstrap-4/css/chosen.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <!-- DatePicker CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/datepicker.css">
    <!-- jQuery -->
    <script type="text/javascript" src="../assets/js/jquery-3.3.1.js"></script>
    <!-- Moment JS -->
    <script type="text/javascript" src="../assets/js//moment.min.js"></script>
    <!-- title -->
    <title>Sistem Spp Online</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light d-flex flex-column flex-md-row
align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <div class="container">
            <!-- logo dan judul aplikasi -->
            <a class="navbar-brand" href="index.php">
                <img src="../assets/img/logo.png" width="30" height="30" class="d-inline-block align-top title-icon" alt="Logo">
                <span class="title">Ez - SPP</span>

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- menu aplikasi -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link mr-1 menu" id="beranda" href="index.php">
                            <i class="fas fa-home title-icon"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-1 menu" id="setting" href="setting.php">
                            <i class="fas fa-cog title-icon"></i> Profil
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="javascript:void(0);" class="nav-link mr-1 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-book-reader title-icon"></i> Master Data
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item menu" id="siswa" href="siswa.php">
                                <i class="fas fa-user-graduate title-icon"></i> Siswa
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item menu" id="kelas" href="kelas.php">
                                <i class="fas fa-school title-icon"></i> Kelas
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item menu" id="petugas" href="petugas.php">
                                <i class="fas fa-user-friends title-icon"></i> Petugas
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item menu" id="petugas" href="spp.php">
                                <i class="fas fa-wallet title-icon"></i> SPP
                            </a>
                        </div>

                        <!-- <a class="nav-link mr-1" id="master_data" href="javascript:void(0);">
                            <i class="fas fa-book-reader title-icon"></i> Master Data
                        </a> -->
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a href="javascript:void(0);" class="nav-link mr-1 dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-print title-icon"></i> Generate Report
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item menu" id="siswa" href="siswa.php">
                                <i class="fas fa-users title-icon"></i>Per Siswa
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item menu" id="kelas" href="kelas.php">
                                <i class="fas fa-boxes title-icon"></i>Per Kelas
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item menu" id="petugas" href="petugas.php">
                                <i class="fas fa-wallet title-icon"></i> Keseluruhan
                            </a>
                        </div>
                         <li class="nav-item">
                        <a class="nav-link mr-1 menu" id="laporan" href="report1.php">
                            <i class="fas fa-file title-icon"></i> laporan
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link mr-1 menu" id="beranda" href="logout.php">
                            <i class="fas fa-sign-out-alt title-icon"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>