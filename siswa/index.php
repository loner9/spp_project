<?php

include('header.php');

$duids = "";
$duid = "";
$duidd = "";
$dibayar = Get_added_amount($connect, $_SESSION["stud_id"], $_SESSION["paym_id"]);
if ($dibayar == null) {
    $duid = "Belum Bayar";
    $duids = "0";
} else {
    $duid = "";
    $duids = $dibayar;
}
?>
<div class="container" style="margin-top:30px">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9"><b>Riwayat Pembayaran</b></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Nama Siswa</th>
                        <td><?php echo Get_student_name($connect, $_SESSION["stud_id"]); ?></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td><?php echo Get_student_grade_name($connect, $_SESSION["stud_id"]); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggungan</th>
                        <td><span id="tanggungan"><?php echo Get_student_dependent($connect, $_SESSION["paym_id"]); ?> / <?php echo Get_student_dependent_year($connect, $_SESSION["paym_id"]); ?></span></td>
                    </tr>
                    <tr>
                        <th>Dibayarkan</th>
                        <td><?php echo $duid; ?> - Rp <span id="dibayar"><?php echo $duids ?></span></td>
                    </tr>
                </table>
                <div class="table-responsive">
                    <span id="message_operation"></span>
                    <table class="table table-striped table-bordered" id="trsct_table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Dibayar</th>
                                <th>Tahun SPP</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

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
<script type="text/javascript" src="../assets/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="../assets/css/datepicker.css" />

<script>
    $(document).ready(function() {
        //load data ke datatable
        var dependent = $('#tanggungan').text();
        var paid = $('#dibayar').text();
        var max_paid = parseInt(dependent - paid);
        var min_paid = 125000;
        var dataTable = $('#trsct_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "ajax": {
                url: "siswa_action.php",
                method: "POST",
                data: {
                    action: 'fetch'
                },
            }
        });

        $('#paym_date').datepicker({
            locale: 'no',
            format: 'yyyy-mm-dd',
            autoclose: true,
            container: '#formModal modal-body'
        });

        $('#max_paid').text(max_paid);

    });
</script>