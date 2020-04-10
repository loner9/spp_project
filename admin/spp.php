<?php

include('header.php');

$years = range(2000, strftime("%Y", time()));
?>

<div class="container" style="margin-top:30px">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">Daftar Kelas</div>
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-info btn-sm">Tambah</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <span id="message_operation"></span>
                <table class="table table-striped table-bordered" id="paym_table">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Nominal</th>
                            <th>Edit</th>
                            <th>Delete</th>
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

<div class="modal" id="formModal">
    <div class="modal-dialog">
        <form method="post" id="paym_form">
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
                            <label class="col-md-4 text-right">Tahun <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="c-datepicker-date-editor c-datepicker-single-editor year">
                                    <i class="c-datepicker-range__icon kxiconfont icon-clock"></i>
                                    <input type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" name="paym_year" id="paym_year" placeholder="Select" class="c-datepicker-data-input only-date" value="">
                                    <span id="error_paym_year" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Nominal <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="paym_amount" id="paym_amount" class="form-control" />
                                <span id="error_paym_amount" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="paym_id" id="paym_id" />
                    <input type="hidden" name="action" id="action" value="Add" />

                    <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h3 align="center">Apa anda yakin menghapus?</h3>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="../assets/plugins/bootstrap-4.1.3/js/bootstrap.min.js"></script>
<!-- Fontawesome Plugin JS -->
<script type="text/javascript" src="../assets/plugins/fontawesome-free-5.5.0-web/js/all.min.js"></script>
<!-- DataTables Plugin JS -->
<script type="text/javascript" src="../assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="../assets/js/datepicker.all.min.js"></script>
<script type="text/javascript" src="../assets/js/datepicker.en.js"></script>
<!-- <script type="text/javascript" src="../"></script> -->

<script>
    $(document).ready(function() {
        //load data ke datatable
        var dataTable = $('#paym_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "spp_action.php",
                method: "POST",
                data: {
                    action: 'fetch'
                },
            },
            "columnDefs": [{
                "targets": [0,2, 3],
                "orderable": false,
            }, ],
        });

        $('.year').datePicker({
            format: 'YYYY',
            min: '2000'
        });

        //menampilkan modal tambah kelas
        $('#add_button').click(function() {
            $('#modal_title').text('Tambah Kelas');
            $('#button_action').val('Add');
            $('#action').val('Add');
            $('#formModal').modal('show');
            clear_field();
        });

        function clear_field() {
            $('#paym_form')[0].reset();
            $('#error_paym_year').text('');
            $('#error_paym_amount').text('');
        }

        //aksi setelah submit form tambah kelas
        $('#paym_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "spp_action.php",
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
                        //hide modal
                        $('#formModal').modal('hide');
                    }
                    if (data.error) {
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

        var paym_id = '';
        //load edit modal
        $(document).on('click', '.edit_paym', function() {
            paym_id = $(this).attr('id');
            clear_field();
            $.ajax({
                url: "spp_action.php",
                method: "POST",
                data: {
                    action: 'edit_fetch',
                    paym_id: paym_id
                },
                dataType: "json",
                success: function(data) {
                    $('#paym_year').val(data.paym_year);
                    $('#paym_amount').val(data.paym_amount);
                    $('#paym_id').val(data.paym_id);
                    $('#modal_title').text('Edit SPP');
                    $('#button_action').val('Edit');
                    $('#action').val('Edit');
                    $('#formModal').modal('show');
                }
            })
        });

        $(document).on('click', '.delete_paym', function() {
            paym_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "spp_action.php",
                method: "POST",
                data: {
                    paym_id: paym_id,
                    action: 'delete'
                },
                success: function(data) {
                    $('#message_operation').html('<div class="alert alert-success">' + data + '</div>');
                    $('#deleteModal').modal('hide');
                    dataTable.ajax.reload();
                }
            })
        });

    });
</script>