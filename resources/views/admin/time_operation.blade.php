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

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Tambah</button>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            {{-- <th>Outlet</th> --}}
                                            <th class="text-center">Jadwal</th>
                                            <th class="text-center">Pagi/Siang/Sore</th>
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

        <div class="modal fade" id="createModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:0px;">
                        <h4 class="modal-title">Tambah Jadwal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-label" id="label_operation_time">Jadwal</label>
                                <div class="input-group date" id="operation_timepicker" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="operation_time" placeholder="Jadwal" data-target="#operation_timepicker" style="pointer-events: none;"/>
                                  <div class="input-group-append" data-target="#operation_timepicker" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="far fa-clock"></i></div>
                                  </div>
                                </div>
                                <span class="text-danger" id="error_operation_time" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_type">Waktu</label>
                                <select name="type" id="type" class="custom-select">
                                    <option value="">-- Pilih Waktu --</option>
                                    <option value="1">Pagi</option>
                                    <option value="2">Siang</option>
                                    <option value="3">Sore</option>
                                </select>
                                <span class="text-danger" id="error_type" style="font-size: 10pt;"></span>
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

        @foreach ($time_operation as $to)
        <div class="modal fade" id="updateModal{{ $to->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:0px;">
                        <h4 class="modal-title">Update Jadwal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" class="form-control" id="token{{ $to->id }}" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-label">Jadwal</label>
                                <div class="input-group date" id="operation_timepicker{{ $to->id }}" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="operation_time{{ $to->id }}" value="{{ $to->time }}" placeholder="Jadwal" data-target="#operation_timepicker{{ $to->id }}" style="pointer-events: none;"/>
                                  <div class="input-group-append" data-target="#operation_timepicker{{ $to->id }}" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="far fa-clock"></i></div>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Waktu</label>
                                <select name="type" id="type{{ $to->id }}" class="custom-select">
                                    <option value="{{ $to->type }}">
                                    @if ($to->type == 1)
                                        {{ 'Pagi' }}
                                    @elseif($to->type == 2)
                                        {{ 'Siang' }}
                                    @else
                                        {{ 'Sore' }}
                                    @endif</option>
                                    <option value="1">Pagi</option>
                                    <option value="2">Siang</option>
                                    <option value="3">Sore</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-warning updateBtn" id="btn{{ $to->id }}">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                //Timepicker update
                let branch_operation_id = '{{ $to->id }}';
                $('#operation_timepicker' + branch_operation_id).datetimepicker({
                    format: 'HH:mm',
                });

                $('#operation_time' + branch_operation_id).on('keypress', function(e){
                    e.preventDefault();
                    return false;
                });

                $('#operation_time' + branch_operation_id).on('keydown', function(e){
                    e.preventDefault();
                    return false;
                });
            });
        </script>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {
             //Timepicker
            $('#operation_timepicker').datetimepicker({
                format: 'HH:mm',
            });

            $('#operation_time').on('keypress', function(e){
                e.preventDefault();
                return false;
            });

            $('#operation_time').on('keydown', function(e){
                e.preventDefault();
                return false;
            });

            $(function() {
                $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ '/admin/time-operation/list' }}',
                    columns: [
                        {
                            data: 'operation_time',
                            name: 'operation_time'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: true,
                        }
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            })

            $('#createBtn').on('click', function() {
                let operation_time = $('#operation_time').val();
                let type = $('#type').val();
                let _token = $('#token').val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/time-operation/create' }}',
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        operation_time: operation_time,
                        type: type,
                        creator: creator,
                    },
                    dataType: 'JSON',
                    success: function(response){
                        if(response.status == 200){
                            let table_list = $('#table-list').DataTable();
                            table_list.destroy();
                            $('#table-list').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: '{{ '/admin/time-operation/list' }}',
                                columns: [
                                    {
                                        data: 'operation_time',
                                        name: 'operation_time'
                                    },
                                    {
                                        data: 'type',
                                        name: 'type'
                                    },
                                    {
                                        data: 'action',
                                        name: 'action',
                                        searchable: true,
                                    }
                                ],
                                "paging": true,
                                "lengthChange": true,
                                "searching": true,
                                "ordering": true,
                                "autoWidth": false,
                                "responsive": true,
                            });

                            toastr.success(response.message);
                        }else{
                            if(typeof(response.message.operation_time) !== 'undefined'){
                                $('#error_operation_time').text(response.message.operation_time);
                                $('#label_operation_time').addClass('text-danger');
                            }else{
                                $('#error_operation_time').text('');
                                $('#label_operation_time').removeClass('text-danger');
                            }

                            if(typeof(response.message.type) !== 'undefined'){
                                $('#error_type').text(response.message.type);
                                $('#label_type').addClass('text-danger');
                            }else{
                                $('#error_type').text('');
                                $('#label_type').removeClass('text-danger');
                            }
                            toastr.error('Input gagal, mohon periksa error.');
                        }
                    },
                    error: function(xhr, textStatus, error){
                        console.error(error);
                    }
                });
            });

            $('.updateBtn').on('click', function() {
                let htmlID = $(this).attr('id');
                let time_operation_id = htmlID.slice(3);
                let operation_time = $('#operation_time' + time_operation_id).val();
                let type = $('#type' + time_operation_id).val();
                let _token = $('#token' + time_operation_id).val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/time-operation/update/' }}' + time_operation_id,
                    type: 'POST',
                    cache: false,
                    data: {
                        operation_time: operation_time,
                        type: type,
                        _token: _token,
                        creator: creator,
                    },
                    dataType: 'JSON',
                    success: function(response){
                        if(response.status == 200){
                            let table_list = $('#table-list').DataTable();
                            table_list.destroy();
                            $('#table-list').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: '{{ '/admin/time-operation/list' }}',
                                columns: [
                                    {
                                        data: 'operation_time',
                                        name: 'operation_time'
                                    },
                                    {
                                        data: 'type',
                                        name: 'type'
                                    },
                                    {
                                        data: 'action',
                                        name: 'action',
                                        searchable: true,
                                    }
                                ],
                                "paging": true,
                                "lengthChange": true,
                                "searching": true,
                                "ordering": true,
                                "autoWidth": false,
                                "responsive": true,
                            });

                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr, textStatus, error){
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
