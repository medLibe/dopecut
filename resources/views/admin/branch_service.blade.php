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
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal">Tambah
                            Jadwal</button>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>Outlet</th>
                                            <th class="text-center">Service</th>
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
                        <h4 class="modal-title">Tambah Service Outlet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-label" id="label_branch_id">Outlet</label>
                                <select name="branch_id" id="branch_id" class="custom-select">
                                    <option value="">-- Pilih Outlet --</option>
                                    @foreach ($branch as $b)
                                    <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="error_branch_id" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_service_id">Service</label>
                                <select name="type" id="service_id" class="custom-select">
                                    <option value="">-- Pilih Service --</option>
                                    @foreach ($service as $s)
                                    <option value="{{ $s->id }}">{{ $s->service_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="error_service_id" style="font-size: 10pt;"></span>
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

        @foreach ($branch_service as $bs)
        <div class="modal fade" id="updateModal{{ $bs->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:0px;">
                        <h4 class="modal-title">Update Service Outlet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <input type="hidden" class="form-control" id="token{{ $bs->id }}" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-label">Outlet</label>
                                <select name="branch_id" id="branch_id{{ $bs->id }}" class="custom-select">
                                    <option value="{{ $bs->id }}">{{ $bs->branch_name }}</option>
                                    @foreach ($branch as $b)
                                    <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="current_branch_id{{ $bs->id }}" readonly value="{{ $bs->branch_id }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Service</label>
                                <select name="type" id="service_id{{ $bs->id }}" class="custom-select">
                                    <option value="{{ $bs->service_id }}">{{ $bs->service_name }}</option>
                                    @foreach ($service as $s)
                                    <option value="{{ $s->id }}">{{ $s->service_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="current_service_id{{ $bs->id }}" readonly value="{{ $bs->service_id }}">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-warning updateBtn" id="btn{{ $bs->id }}">Save</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {
            $(function() {
                $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ '/admin/branch-service/list' }}',
                    columns: [{
                            data: 'branch_name',
                            name: 'branch_name'
                        },
                        {
                            data: 'service_name',
                            name: 'service_name'
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
                let branch_id = $('#branch_id').val();
                let service_id = $('#service_id').val();
                let _token = $('#token').val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/branch-service/create' }}',
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        branch_id: branch_id,
                        service_id: service_id,
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
                                ajax: '{{ '/admin/branch-service/list' }}',
                                columns: [{
                                        data: 'branch_name',
                                        name: 'branch_name'
                                    },
                                    {
                                        data: 'service_name',
                                        name: 'service_name'
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
                        }else if(response.status == 401){
                            if(typeof(response.message.branch_id) !== 'undefined'){
                                $('#error_branch_id').text(response.message.branch_id);
                                $('#label_branch_id').addClass('text-danger');
                            }else{
                                $('#error_branch_id').text('');
                                $('#label_branch_id').removeClass('text-danger');
                            }

                            if(typeof(response.message.service_id) !== 'undefined'){
                                $('#error_service_id').text(response.message.service_id);
                                $('#label_service_id').addClass('text-danger');
                            }else{
                                $('#error_service_id').text('');
                                $('#label_service_id').removeClass('text-danger');
                            }
                            toastr.error('Input gagal, mohon periksa error.');
                        }else{
                            toastr.info(response.message);
                        }
                    },
                    error: function(xhr, textStatus, error){
                        console.error(error);
                    }
                });
            });

            $('.updateBtn').on('click', function() {
                let htmlID = $(this).attr('id');
                let branch_service_id = htmlID.slice(3);
                let branch_id = $('#branch_id' + branch_service_id).val();
                let service_id = $('#service_id' + branch_service_id).val();
                let current_branch_id = $('#current_branch_id' + branch_service_id).val();
                let current_service_id = $('#current_service_id' + branch_service_id).val();
                let _token = $('#token' + branch_service_id).val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/branch-service/update/' }}' + branch_service_id,
                    type: 'POST',
                    cache: false,
                    data: {
                        branch_id: branch_id,
                        service_id: service_id,
                        current_branch_id: current_branch_id,
                        current_service_id: current_service_id,
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
                                ajax: '{{ '/admin/branch-service/list' }}',
                                columns: [{
                                        data: 'branch_name',
                                        name: 'branch_name'
                                    },
                                    {
                                        data: 'service_name',
                                        name: 'service_name'
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
                            toastr.info(response.message);
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
