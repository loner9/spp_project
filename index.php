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
    <link rel="shortcut icon" href="assets/img/logo.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-4.1.3/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/css/dataTables.bootstrap4.min.css">
    <!-- datepicker CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/datepicker/css/datepicker.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/fontawesome-free-5.5.0-web/css/all.min.css">
    <!-- Sweetalert CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/sweetalert/css/sweetalert.css">
    <!-- Chosen CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/chosen-bootstrap-4/css/chosen.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- jQuery -->
    <script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
    <!-- title -->
    <title>Sistem Spp Online</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light d-flex flex-column flex-md-row
align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <div class="container">
            <!-- logo dan judul aplikasi -->
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo.png" width="30" height="30" class="d-inline-block align-top title-icon" alt="Logo">
                <span class="title">Ez - SPP</span>

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- menu aplikasi -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link mr-1 menu" href="#">
                            <i class="fas fa-home title-icon"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-1 menu" href="#fitur">
                            <i class="fas fa-box-open title-icon"></i> Fitur
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-1 menu" href="#kontak">
                            <i class="fas fa-phone title-icon"></i> Kontak
                        </a>
                    </li>
                </ul>
                <div class="navbar-text ml-lg-3">
                    <button name="login_button" class="login_button btn btn-info text-white shadow">Masuk</button>
                    <!-- <a href="#" class="login-button btn btn-info text-white shadow">Masuk</a> -->
                </div>
            </div>
        </div>
    </nav>
    <main role="main" class="container mt-5">
        <!-- menampilkan isi halaman -->
        <section class="bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <h1>Ez - SPP</h1>
                        <p class="lead">Sebuah solusi perekap data spp bagi institusi sekolah SMP SMA dan Sederajat. </p>
                        <p><a href="#" class="btn btn-info shadow mr-2">Pelajari Lanjut</a><a href="#" class="btn btn-outline-info">Some other</a></p>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2"><img src="assets/img/pembayaran.png" alt="..." class="img-fluid"></div>
                </div>
            </div>
        </section>
        <section>
            <div id="fitur" class="container">
                <h2>Keunggulan</h2>
                <!-- <p class="text-muted mb-5">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p> -->
               <br><br>
                <div class="row">
                    <div class="col-sm-6 col-lg-4 mb-3">
                        <div>
                            <i class="fas fa-glasses text-info fa-5x"></i>
                        </div>
                        <br>
                        <h6>Clean Design</h6>
                        <p class="text-muted">Dengan design yang bersih dan tidak sembarangan,kami memastikan bahwa aplikasi ini dapat memberikan pengalaman yang terbaik saat digunakan.</p>
                    </div>
                    <div class="col-sm-6 col-lg-4 mb-3">
                        <div>
                            <i class="fas fa-box text-info fa-5x"></i>
                        </div>
                        <br>
                        <h6>Minimalis</h6>
                        <p class="text-muted">Minimalis dalam design.Untuk memastikan bahwa aplikasi ini tidak mengalihkan fokus aplikasi ini saat digunakan.</p>
                    </div>
                    <div class="col-sm-6 col-lg-4 mb-3">
                        <div>
                            <i class="fas fa-book-reader text-info fa-5x"></i>
                        </div>
                        <br>
                        <h6>Easy to Master</h6>
                        <p class="text-muted">Clean Design & Minimalis, akan membuat aplikasi ini mudah untuk dikuasai. Karena fitur yang tidak berbelit dan fokus dalam fitur inti.</p>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <blockquote class="blockquote text-center mb-0">
                    <i class="fas fa-braille text-info fa-5x"></i>
                    <p class="mb-0">Simplicity Focused</p>
                    <footer class="blockquote-footer">Someone famous in
                        <cite title="Source Title">Source Title</cite>
                    </footer>
                </blockquote>
            </div>
        </section>
    </main>
    <!-- footer -->
    <div class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5>Project 101</h5>
                    <ul class="contact-info list-unstyled">
                        <li><a href="mailto:aksack.09@gmail.com" class="text-dark">aksack.09@gmail.com</a></li>
                        <li><a href="tel:089603653880" class="text-dark">+62 89 603 653 880</a></li>
                    </ul>
                    <p class="text-muted">Learner,Tech Enthusiast,.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3 bg-dark text-white" id="kontak">
        <div class="container">
            <div class="row">
                <div class="col-md-7 text-center text-md-left">
                    <p class="mb-md-0">&copy; 2020 Ahmad Koirul A. All rights reserved. </p>
                </div>
                <div class="col-md-5 text-center text-md-right">
                    <p class="mb-0">Design By <a href="https://github.com/loner9" class="external text-white">AhmadKA</a> </p>
                </div>
            </div>
        </div>
    </div>
    <!-- include JavaScript -->
    <!-- Bootstrap JS -->
    <script type="text/javascript" src="assets/plugins/bootstrap-4.1.3/js/bootstrap.min.js"></script>
    <!-- Fontawesome Plugin JS -->
    <script type="text/javascript" src="assets/plugins/fontawesome-free-5.5.0-web/js/all.min.js"></script>
    <!-- DataTables Plugin JS -->
    <script type="text/javascript" src="assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/plugins/DataTables/js/dataTables.bootstrap4.min.js"></script>
    <!-- datepicker Plugin JS -->
    <script type="text/javascript" src="assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- SweetAlert Plugin JS -->
    <script type="text/javascript" src="assets/plugins/sweetalert/js/sweetalert.min.js"></script>
    <!-- Chosen Plugin JS -->
    <script type="text/javascript" src="assets/plugins/chosen-bootstrap-4/js/chosen.jquery.js"></script>
</body>

</html>

<div class="modal" id="formModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Masuk Sebagai</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row mt-4">
                    <!-- menampilkan informasi jumlah total pembayaran -->
                    <div class="col-md-6">
                        <div class="card center">
                            <div class="center mt-4">
                                <i class="fas fa-user-circle text-info fa-7x"></i>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title" id="logSiswa"></h4>
                                <div class="md-3">
                                    <a href="loginS.php" target="_blank" class="card-text text-white">
                                        <button class="login_button btn btn-info text-white shadow">Siswa</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- menampilkan informasi jumlah data siswa -->
                    <div class="col-md-6">
                        <div class="card center">
                            <div class="center mt-4">
                                <i class="fas fa-school text-info fa-7x"></i>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title" id="logAdmin"></h4>
                                <div class="md-3">
                                    <a href="login.php" target="_blank" class="card-text text-white">
                                        <button class="login_button btn btn-info text-white shadow">Petugas</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <!-- <div class="modal-footer">
                <input type="hidden" name="student_id" id="student_id" />
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div> -->

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '.login_button', function() {
            var student_id = $(this).attr('id');
            $('#formModal').modal('show');
        });
    })
</script>