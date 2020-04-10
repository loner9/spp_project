<?php

include('header.php');
?>
<div class="container" style="margin-top:30px">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">Daftar siswa</div>
                <!-- <div class="col-sm-1">
                    <button type="button" id="report_button" class="btn btn-info btn-sm">Laporan</button>
                </div> -->
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-info btn-sm">Tambah</button>
                </div>
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
                            <th>Edit</th>
                            <th>Hapus</th>
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
        <form method="post" id="student_form">
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
                            <label class="col-md-4 text-right">NISN<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_id" id="student_id" class="form-control" />
                                <span id="error_student_id" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Nama Siswa <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_name" id="student_name" class="form-control" />
                                <span id="error_student_name" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">No. Absen<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_school_id" id="student_school_id" class="form-control" />
                                <span id="error_student_school_id" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Alamat<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_address" id="student_address" class="form-control" />
                                <span id="error_student_address" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">No. Hp<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_phone" id="student_phone" class="form-control" />
                                <span id="error_student_phone" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Kelas <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="student_grade_id" id="student_grade_id" class="form-control">
                                    <option value="">Pilih Kelas</option>
                                    <?php
                                    echo load_grade_list($connect);
                                    ?>
                                </select>
                                <span id="error_student_grade_id" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SPP <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="student_paym_id" id="student_paym_id" class="form-control">
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                    echo load_paym_list($connect);
                                    ?>
                                </select>
                                <span id="error_student_paym_id" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!-- <input type="hidden" name="student_id" id="student_id" /> -->
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
                <h4 class="modal-title">Konfirmasi Hapus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h3 align="center">Anda yakin ingin menghapus?</h3>
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
                "targets": [0, 6, 7,8],
                "orderable": false,
            }, ]
        });

        function clear_field() {
            $('#student_form')[0].reset();
            $('#error_student_id').text('');
            $('#error_student_name').text('');
            $('#error_student_school_id').text('');
            $('#error_student_address').text('');
            $('#error_student_phone').text('');
            $('#error_student_grade_id').text('');
            $('#error_student_paym_id').text('');
        }

        $('#add_button').click(function() {
            $('#modal_title').text('Tambah Siswa');
            $('#button_action').val('Add');
            $('#action').val('Add');
            $('#formModal').modal('show');
            clear_field();
        });

        $('#student_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "siswa_action.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#button_action').val('Validate...');
                    $('#button_action').attr('disabled', 'disabled');
                },
                success: function(data) {
                    $('#button_action').attr('disabled', false);
                    $('#button_action').val($('#action').val());
                    if (data.success) {
                        $('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
                        clear_field();
                        $('#formModal').modal('hide');
                        dataTable.ajax.reload();
                    }
                    if (data.error) {
                        if (data.error_student_id != '') {
                            $('#error_student_id').text(data.error_student_id);
                        } else {
                            $('#error_student_id').text('');
                        }
                        if (data.error_student_name != '') {
                            $('#error_student_name').text(data.error_student_name);
                        } else {
                            $('#error_student_name').text('');
                        }
                        if (data.error_student_school_id != '') {
                            $('#error_student_school_id').text(data.error_student_school_id);
                        } else {
                            $('#error_student_school_id').text('');
                        }
                        if (data.error_student_address != '') {
                            $('#error_student_address').text(data.error_student_address);
                        } else {
                            $('#error_student_address').text('');
                        }
                        if (data.error_student_phone != '') {
                            $('#error_student_phone').text(data.error_student_phone);
                        } else {
                            $('#error_student_phone').text('');
                        }
                        if (data.error_student_grade_id != '') {
                            $('#error_student_grade_id').text(data.error_student_grade_id);
                        } else {
                            $('#error_student_grade_id').text('');
                        }
                        if (data.error_student_paym_id != '') {
                            $('#error_student_paym_id').text(data.error_student_paym_id);
                        } else {
                            $('#error_student_paym_id').text('');
                        }
                    }
                }
            })
        });

        var student_id = $('#student_id').val();

        $(document).on('click', '.edit_student', function() {
            student_id = $(this).attr('id');
            clear_field();
            $.ajax({
                url: "siswa_action.php",
                method: "POST",
                data: {
                    action: 'edit_fetch',
                    student_id: student_id
                },
                dataType: "json",
                success: function(data) {
                    $('#student_name').val(data.student_name);
                    $('#student_school_id').val(data.student_school_id);
                    $('#student_address').val(data.student_address);
                    $('#student_phone').val(data.student_phone);
                    $('#student_grade_id').val(data.student_grade_id);
                    $('#student_paym_id').val(data.student_paym_id);
                    $('#student_id').val(data.student_id);
                    $('#modal_title').text('Edit Siswa');
                    $('#button_action').val('Edit');
                    $('#action').val('Edit');
                    $('#formModal').modal('show');
                }
            })
        });

        $(document).on('click', '.check_student', function() {
            var student_id = $(this).attr('id');
            var paym_id = $(this).attr('value');
            window.open("transaksi.php?student_id="+student_id+"&paym_id="+paym_id);
        });

        $(document).on('click', '.delete_student', function() {
            student_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "siswa_action.php",
                method: "POST",
                data: {
                    student_id: student_id,
                    action: "delete"
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