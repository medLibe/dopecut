@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $page }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $page }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">

        @if ($view_mode == false)
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#memberModal"><i
                                    class="fas fa-plus"></i> Tambah Member</button>
                            <button class="btn btn-success mb-2" data-toggle="modal" data-target="#absentModal"><i
                                    class="fas fa-calendar"></i> Absen Member</button>
                            <div class="card">
                                <div class="card-header bg-primary p-0"></div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table-list" class="table table-bordered table-striped">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th>Customer</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Akhir</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="memberModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:0px;">
                            <h4 class="modal-title">Tambah Member</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="memberForm">
                                <div class="alert alert-info" role="alert">Tips: Sebelum klik save, mohon cek apakah nomor
                                    sudah
                                    terdaftar atau belum.</div>
                                <div class="form-group mb-3">
                                    <label class="form-label" id="label_no_hp">No. HP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text" id="checkPhone">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="no_hp" class="form-control" placeholder="0812xxxxxxxx"
                                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                    </div>
                                    <span id="error_no_hp" style="font-size: 10pt;"></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" id="label_name">Nama</label>
                                    <input type="text" id="name" class="form-control" placeholder="Nama">
                                    <span class="text-danger" id="error_name" style="font-size: 10pt;"></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" id="label_member_date">Tanggal Daftar <sup class="text-muted">
                                            (Tanggal
                                            Member utk 1 tahun)</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="member_date"
                                            placeholder="dd/mm/yyyy" readonly style="background-color: white;">
                                    </div>
                                    <span class="text-danger" id="member_date" style="font-size: 10pt;"></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" form="createForm" id="createBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="absentModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:0px;">
                            <h4 class="modal-title">Absen Member</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="absentForm">
                                <div class="form-group mb-3">
                                    <label class="form-label" id="label_membership_id">Pilih Member</label>
                                    <select id="membership_id" class="custom-select">
                                        <option value="">-- Pilih member untuk di absen --</option>
                                        @foreach ($member as $m)
                                        <option value="{{ $m->id }}">{{ $m->no_hp }}: {{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="error_no_hp" style="font-size: 10pt;"></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="absentBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#membership_id').select2({
                        'theme': 'bootstrap4'
                    });

                    $('#member_date').daterangepicker({
                        singleDatePicker: true,
                        minDate: moment(),
                        locale: {
                            format: 'DD/MM/YYYY'
                        }
                    });

                    $('#checkPhone').on('click', function() {
                        const no_hp = $('#no_hp').val();
                        const _token = $('#token').val();

                        if (no_hp.length < 10 || no_hp.length > 13) {
                            $('#no_hp').addClass('is-invalid');
                            $('#error_no_hp').removeClass('text-success');
                            $('#error_no_hp').addClass('text-danger');
                            $('#error_no_hp').text(
                                'No. HP tidak boleh kurang dari 10 digit atau lebih dari 13 digit.');
                            return;
                        }

                        $.ajax({
                            type: 'POST',
                            url: '/admin/exist-member',
                            data: {
                                _token: _token,
                                no_hp: no_hp
                            },
                            success: function(response) {
                                const exist_member = response.is_available;

                                if (exist_member) {
                                    $('#error_no_hp').removeClass('is-valid');
                                    $('#no_hp').addClass('is-invalid');
                                    $('#error_no_hp').removeClass('text-success');
                                    $('#error_no_hp').addClass('text-danger');
                                    $('#error_no_hp').text(
                                        'No. HP sudah terdaftar menjadi member, silahkan lakukan absen.'
                                    );
                                } else {
                                    $('#error_no_hp').removeClass('is-invalid');
                                    $('#no_hp').addClass('is-valid');
                                    $('#error_no_hp').removeClass('text-danger');
                                    $('#error_no_hp').addClass('text-success');
                                    $('#error_no_hp').text('No. HP belum terdaftar, silahkan daftarkan member.');
                                }
                            },
                            error: function(xhr, sts, msg) {
                                console.error(xhr);
                            }
                        });
                    });

                    function dateFormat(dateInput) {
                        var parts = dateInput.split('/');
                        var dateOutput = parts[2] + '-' + parts[1] + '-' + parts[0];
                        return dateOutput;
                    }

                    $('#createBtn').on('click', function() {
                        const _token = $('#token').val();
                        const no_hp = $('#no_hp').val();
                        const name = $('#name').val();
                        // format to yyyy-mm-dd start date
                        const start_date = dateFormat($('#member_date').val());
                        // get 1 year after start date
                        const date = new Date(dateFormat($('#member_date').val()));
                        date.setDate(date.getDate() + 365);
                        const end_date = date.toISOString().split('T')[0];

                        $.ajax({
                            url: '/admin/member',
                            type: 'POST',
                            data: {
                                _token: _token,
                                no_hp: no_hp,
                                name: name,
                                start_date: start_date,
                                end_date: end_date
                            },
                            dataType: 'JSON',
                            cache: false,
                            success: function(response) {
                                $('#table-list').DataTable().destroy();

                                $('#table-list').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    ajax: {
                                        url: "/admin/member",
                                        cache: false,
                                    },
                                    columns: [{
                                            data: 'name',
                                            name: 'name'
                                        },
                                        {
                                            data: 'start_date',
                                            name: 'start_date'
                                        },
                                        {
                                            data: 'end_date',
                                            name: 'end_date'
                                        },
                                        {
                                            data: 'status',
                                            name: 'status'
                                        },
                                        {
                                            data: 'action',
                                            name: 'action',
                                            orderable: true,
                                            searchable: true,
                                        }
                                    ],
                                });

                                $('#membership_id').empty();
                                $('#memberModal').modal('hide');
                                $('#memberForm')[0].reset();

                                $.ajax({
                                    url: '/admin/member-fetch',
                                    cache: false,
                                    dataType: 'JSON',
                                    success: function(response){
                                        console.log(response);
                                        const membership = response.data;
                                        $('#membership_id').append('<option value="">--Pilih member untuk di absen --</option>');
                                        $.each(membership, function(index, data) {
                                            $('#membership_id').append(`<option value="${data.id}">${data.no_hp}: ${data.name}</option>`);
                                        });
                                    }
                                });
                                toastr.success(response.message);
                            },
                            error: function(xhr, error, sts) {
                                toastr.error('Oops.. something went wrong.', `Error ${xhr.status}`);

                                if (xhr.status == 400) {
                                    const error_no_hp = xhr.responseJSON.message.no_hp;
                                    const error_name = xhr.responseJSON.message.name;
                                    const error_start_date = xhr.responseJSON.message.start_date;
                                    const error_end_date = xhr.responseJSON.message.end_date;

                                    if (error_no_hp != undefined) {
                                        $('#no_hp').addClass('is-invalid');
                                        $('#error_no_hp').addClass('text-danger');
                                        $('#error_no_hp').text(error_no_hp);
                                    } else {
                                        $('#no_hp').removeClass('is-invalid');
                                        $('#error_no_hp').text('');
                                    }

                                    if (error_name != undefined) {
                                        $('#name').addClass('is-invalid');
                                        $('#error_name').addClass('text-danger');
                                        $('#error_name').text(error_name);
                                    } else {
                                        $('#name').removeClass('is-invalid');
                                        $('#error_name').text('');
                                    }

                                    if (error_start_date != undefined) {
                                        $('#start_date').addClass('is-invalid');
                                        $('#error_start_date').addClass('text-danger');
                                        $('#error_start_date').text(error_start_date);
                                    } else {
                                        $('#start_date').removeClass('is-invalid');
                                        $('#error_start_date').text('');
                                    }
                                }


                            }
                        });
                    });

                    $('#absentBtn').on('click', function() {
                        const _token = $('#token').val();
                        const membership_id = $('#membership_id').val();

                        $.ajax({
                            url: '/admin/member-absent',
                            type: 'POST',
                            data: {
                                _token: _token,
                                membership_id: membership_id,
                            },
                            dataType: 'JSON',
                            cache: false,
                            success: function(response) {
                                toastr.success(response.message);
                            },
                            error: function(xhr, error, sts) {
                                toastr.error('Oops.. something went wrong.', `Error ${xhr.status}`);

                                if (xhr.status == 400) {
                                    const error_no_hp = xhr.responseJSON.message.no_hp;
                                    const error_name = xhr.responseJSON.message.name;
                                    const error_start_date = xhr.responseJSON.message.start_date;
                                    const error_end_date = xhr.responseJSON.message.end_date;

                                    if (error_no_hp != undefined) {
                                        $('#no_hp').addClass('is-invalid');
                                        $('#error_no_hp').addClass('text-danger');
                                        $('#error_no_hp').text(error_no_hp);
                                    } else {
                                        $('#no_hp').removeClass('is-invalid');
                                        $('#error_no_hp').text('');
                                    }

                                    if (error_name != undefined) {
                                        $('#name').addClass('is-invalid');
                                        $('#error_name').addClass('text-danger');
                                        $('#error_name').text(error_name);
                                    } else {
                                        $('#name').removeClass('is-invalid');
                                        $('#error_name').text('');
                                    }

                                    if (error_start_date != undefined) {
                                        $('#start_date').addClass('is-invalid');
                                        $('#error_start_date').addClass('text-danger');
                                        $('#error_start_date').text(error_start_date);
                                    } else {
                                        $('#start_date').removeClass('is-invalid');
                                        $('#error_start_date').text('');
                                    }
                                }


                            }
                        });
                    });

                    $(function() {
                        $('#table-list').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "/admin/member",
                                cache: false,
                            },
                            columns: [{
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'start_date',
                                    name: 'start_date'
                                },
                                {
                                    data: 'end_date',
                                    name: 'end_date'
                                },
                                {
                                    data: 'status',
                                    name: 'status'
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: true,
                                    searchable: true,
                                }
                            ],
                        });
                    });
                });
            </script>
        @else
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <input type="hidden" class="form-control" value="{{ $member_id }}" id="member_id" readonly>
                    <div class="col-12">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>Tanggal Absen</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $(function() {
                    const member_id = $("#member_id").val();
                    $('#table-list').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/admin/member-absent/" + member_id,
                            cache: false,
                        },
                        columns: [
                            {
                                data: 'created_at',
                                name: 'created_at'
                            },
                        ],
                    });
                });
            });
        </script>
        @endif
    </div>
@endsection
