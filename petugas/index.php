<?php

//index.php
//tampilan home admin

include('header.php');

?>

<main role="main" class="container mt-5" >
    <!-- menampilkan isi halaman -->
    <div class="content">
        <div class="content-header row">
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle title-icon"></i> Selamat Datang di <strong>Ez - SPP</strong>.
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <!-- menampilkan informasi jumlah total pembayaran -->
            <div class="col-md-4">
                <div class="card center">
                    <div class="center mt-4">
                        <i class="fas fa-user-circle text-info fa-7x"></i>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title" id="loadTotal"></h4>
                        <p class="card-text">Total Siswa</p>
                    </div>
                </div>
            </div>
            <!-- menampilkan informasi jumlah data siswa -->
            <div class="col-md-4">
                <div class="card center">
                    <div class="center mt-4">
                        <i class="fas fa-check-circle text-success fa-7x"></i>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title" id="loadLunas"></h4>
                        <p class="card-text">Spp Lunas</p>
                    </div>
                </div>
            </div>
            <!-- menampilkan informasi jumlah data kelas -->
            <div class="col-md-4">
                <div class="card center">
                    <div class="center mt-4">
                        <i class="fas fa-question-circle text-danger fa-7x"></i>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title" id="loadUnLunas"></h4>
                        <p class="card-text">Spp Belum Lunas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- footer -->
<div class="container">
    <footer class="pt-4 my-md-4 pt-md-3 border-top">
        <div class="row">
            <div class="col-12 col-md center">
                &copy; 2020 - <a class="text-info" href="http://github.com/loner9">Ahmad Koirul Anwar</a>
            </div>
        </div>
    </footer>
</div>
<!-- include JavaScript -->
<!-- Bootstrap JS -->
<script type="text/javascript" src="../assets/plugins/bootstrap-4.1.3/js/bootstrap.min.js"></script>
<!-- Fontawesome Plugin JS -->
<script type="text/javascript" src="../assets/plugins/fontawesome-free-5.5.0-web/js/all.min.js"></script>
<!-- DataTables Plugin JS -->
<script type="text/javascript" src="../assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/js/dataTables.bootstrap4.min.js"></script>
<!-- datepicker Plugin JS -->
<script type="text/javascript" src="../assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- SweetAlert Plugin JS -->
<script type="text/javascript" src="../assets/plugins/sweetalert/js/sweetalert.min.js"></script>
<!-- Chosen Plugin JS -->
<script type="text/javascript" src="../assets/plugins/chosen-bootstrap-4/js/chosen.jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#loadLunas').load('get_lunas.php');
        $('#loadUnLunas').load('get_un_lunas.php');
        $('#loadTotal').load('get_total.php');
    });
    // ==============================================================================================
</script>
</body>

</html>