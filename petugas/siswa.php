<?php

include('header.php');
?>
<div class="container" style="margin-top:30px">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">Daftar siswa</div>
                <!-- <div class="col-md-3" align="right">
                    <button type="button" id="print_button" class="btn btn-info btn-sm">Cetak Laporan</button>
                </div> -->
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <span id="message_operation"></span>
                <table class="table table-striped table-bordered" id="student_table">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
                            <th>Kelas</th>
                            <th>SPP</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

</body>

</html>

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
<script>
    $(document).ready(function() {
        //load data ke datatable

        var dataTable = $('#student_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "siswa_action.php",
                method: "POST",
                data: {
                    action: 'fetch'
                },
            },
            "columnDefs": [{
                "targets": [0, 5, 6],
                "orderable": false,
            }, ]
        });
        // var student_id = $('#student_id').val();
        $(document).on('click', '.check_student', function() {
            var student_id = $(this).attr('id');
            var paym_id = $(this).attr('value');
            window.open("transaksi.php?student_id="+student_id+"&paym_id="+paym_id);
        });

    });
</script>