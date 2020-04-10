<?php

//login.php
//menggunakan file db connerct
include('config/config.php');

session_start();

if (isset($_SESSION["stud_id"])) {
    header('location:siswa/index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ahmad Koirul Anwar">
    <!-- favicon -->
    <link rel="shortcut icon" href="assets/img/logo.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-4.1.3/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/css/dataTables.bootstrap4.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/fontawesome-free-5.5.0-web/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- jQuery -->
    <script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
    <!-- title -->
    <title>Login | Ez - SPP</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light d-flex flex-column flex-md-row
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
                        <a class="nav-link mr-1 menu" id="beranda" href="index.php">
                            <i class="fas fa-arrow-alt-circle-left title-icon"></i> Kembali
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="jumbotron text-center">
        <h1>Ez - SPP</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4" style="margin-top:20px;">
                <div class="card">
                    <div class="card-header">Login Siswa</div>
                    <div class="card-body">
                        <!-- form login -->
                        <form method="post" id="stud_login_form">
                            <div class="form-group">
                                <label>Nama Siswa</label>
                                <input type="text" name="stud_username" id="stud_username" class="form-control" />
                                <span id="error_stud_username" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label>NIS</label>
                                <input type="text" name="stud_unique" id="stud_unique" class="form-control" />
                                <span id="error_stud_unique" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="stud_login" id="stud_login" class="btn btn-info" value="Login" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script type="text/javascript" src="assets/plugins/bootstrap-4.1.3/js/bootstrap.min.js"></script>
    <!-- SweetAlert Plugin JS -->
    <script type="text/javascript" src="assets/plugins/sweetalert/js/sweetalert.min.js"></script>
</body>
</html>

<script>
    // script jquery
    $(document).ready(function() {
        //proses pengecekan login
        $('#stud_login_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "config/check_stud_login.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    //disable button login
                    $('#stud_login').val('Validate...');
                    $('#stud_login').attr('disabled', 'disabled');
                },
                success: function(data) {
                    //percabangan berhasil/tidak
                    if (data.success) {
                        location.href = "siswa/index.php";
                    }
                    if (data.error) {
                        $('#stud_login').val('Login');
                        $('#stud_login').attr('disabled', false);
                        if (data.error_stud_username != '') {
                            $('#error_stud_username').text(data.error_stud_username);
                        } else {
                            $('#error_stud_username').text('');
                        }
                        if (data.error_stud_unique != '') {
                            $('#error_stud_unique').text(data.error_stud_unique);
                        } else {
                            $('#error_stud_unique').text('');
                        }
                    }
                }
            })
        });
    });
</script>