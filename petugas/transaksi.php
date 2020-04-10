<?php

include('header.php');

$MonthArray = array(
    "1" => "January", "2" => "February", "3" => "March", "4" => "April",
    "5" => "May", "6" => "June", "7" => "July", "8" => "August",
    "9" => "September", "10" => "October", "11" => "November", "12" => "December",
);

// $query = "
// SELECT SUM(jumlah_bayar) as dibayar FROM pembayaran
// ";
$duids = "";
$duid = "";
$duidd = "";
$dibayar = Get_added_amount($connect, $_GET["student_id"], $_GET["paym_id"]);
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
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-info btn-sm">Tambah</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Nama Siswa</th>
                        <td><?php echo Get_student_name($connect, $_GET["student_id"]); ?></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td><?php echo Get_student_grade_name($connect, $_GET["student_id"]); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggungan</th>
                        <td><span id="tanggungan"><?php echo Get_student_dependent($connect, $_GET["paym_id"]); ?></span> / <?php echo Get_student_dependent_year($connect, $_GET["paym_id"]); ?></td>
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
                                <th>Bulan Dibayar</th>
                                <th>Nominal</th>
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

<div class="modal" id="formModal">
    <div class="modal-dialog">
        <form method="post" id="transaction_form">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Tanggal Dibayar <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" name="paym_date" id="paym_date" placeholder="Select" class="form-control" value="">
                                <span id="error_paym_date" class="text-danger"></span>
                                <span id="error_paym_date" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Bulan Dibayar <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="paym_month" id="paym_month" multiple>
                                    <!-- <option value="">Pilih Bulan</option> -->
                                    <?php
                                    foreach ($MonthArray as $monthNum => $month) {
                                        $selected = (isset($getMonth) && $getMonth == $monthNum) ? 'selected' : '';
                                        //Uncomment line below if you want to prefix the month number with leading 0 'Zero'
                                        //$monthNum = str_pad($monthNum, 2, "0", STR_PAD_LEFT);
                                        echo '<option ' . $selected . ' value="' . $monthNum . '">' . $month . '</option>';
                                    }
                                    ?>
                                </select>
                                <span id="error_paym_month" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Pilih Tahun <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="paym_year" id="paym_year">
                                    <!-- <option value="">Pilih Tahun</option> -->
                                    <?php
                                    for ($year = 2001; $year <= 2090; $year++) {
                                        $selected = (isset($getYear) && $getYear == $year) ? 'selected' : '';
                                        echo "<option value=$year $selected>$year</option>";
                                    }
                                    ?>
                                </select>
                                <span id="error_paym_year" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Nominal Dibayar <span class="text-info">*Max Rp.<span id="max_paid"></span>*</span></label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" step="125000" value="125000" oninput="document.getElementById('rVal').innerHTML = this.value" name="paym_amount" id="paym_amount" class="form-control" />
                                    </div>
                                    <label id="rVal">125000</label>
                                </div>
                                <span id="error_paym_amount" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $_SESSION["staff_id"]; ?>" />
                    <input type="hidden" name="student_id" id="student_id" value="<?php echo $_GET["student_id"]; ?>" />
                    <input type="hidden" name="paym_id" id="paym_id" value="<?php echo $_GET["paym_id"]; ?>" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="../assets/plugins/bootstrap-4.1.3/js/bootstrap.min.js"></script>
<!-- Fontawesome Plugin JS -->
<script type="text/javascript" src="../assets/plugins/fontawesome-free-5.5.0-web/js/all.min.js"></script>
<!-- DataTables Plugin JS -->
<script type="text/javascript" src="../assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
<!-- Chosen Plugin JS -->
<script type="text/javascript" src="../assets/plugins/chosen-bootstrap-4/js/chosen.jquery.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="../assets/css/datepicker.css" />

<style>
    .datepicker {
        z-index: 1600 !important;
        /* has to be larger than 1050 */
    }
</style>

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
                url: "transaksi_action.php",
                method: "POST",
                data: {
                    action: 'fetch'
                },
            }
        });

        $('#paym_month').chosen({
            width: '200px'
        });

        $('#paym_year').chosen({
            width: '200px'
        });

        $('#paym_date').datepicker({
            locale: 'no',
            format: 'yyyy-mm-dd',
            autoclose: true,
            container: '#formModal modal-body'
        });

        $('#max_paid').text(max_paid);

        $('#paym_amount').attr({
            "type": "range",
            "max": max_paid,
            "min": min_paid
        });

        // untuk cek pembayaran
        if (dependent === paid) {
            $('#add_button').attr('disabled', 'disabled');
            $('#add_button').text('Lunas');
        } else {
            $('#add_button').text('Tambah');
        }

        //menampilkan modal tambah kelas
        $('#add_button').click(function() {
            $('#modal_title').text('Tambah Pembayaran');
            $('#button_action').val('Add');
            $('#action').val('Add');
            $('#formModal').modal('show');
            clear_field();
        });

        function clear_field() {
            $('#transaction_form')[0].reset();
            $('#error_paym_date').text('');
            $('#error_paym_month').text('');
            $('#error_paym_year').text('');
            $('#error_paym_amount').text('');
        }
        //aksi setelah submit form tambah kelas
        $('#transaction_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "transaksi_action.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                //disable button add
                beforeSend: function() {
                    $('#button_action').attr('disabled', 'disabled');
                    $('#button_action').val('Validate...');
                },
                success: function(data) {
                    $('#button_action').attr('disabled', false);
                    $('#button_action').val($('#action').val());
                    if (data.success) {
                        $('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
                        clear_field();
                        //relaod table pada dataTable
                        dataTable.ajax.reload();
                        location.reload(true);
                        //hide modal
                        $('#formModal').modal('hide');
                    }
                    if (data.error) {
                        if (data.error_paym_date != '') {
                            $('#error_paym_date').text(data.error_paym_date);
                        } else {
                            $('#error_paym_date').text('');
                        }
                        if (data.error_paym_month != '') {
                            $('#error_paym_month').text(data.error_paym_month);
                        } else {
                            $('#error_paym_month').text('');
                        }
                        if (data.error_paym_year != '') {
                            $('#error_paym_year').text(data.error_paym_year);
                        } else {
                            $('#error_paym_year').text('');
                        }
                        if (data.error_paym_amount != '') {
                            $('#error_paym_amount').text(data.error_paym_amount);
                        } else {
                            $('#error_paym_amount').text('');
                        }
                    }
                }
            })
        });



    });
</script>