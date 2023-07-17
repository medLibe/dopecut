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
                            Outlet</button>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>Outlet</th>
                                            <th>Jam Buka</th>
                                            <th>Jam Tutup</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
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
                        <h4 class="modal-title">Tambah Outlet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-label" id="label_branch_name">Outlet</label>
                                <input type="text" class="form-control" id="branch_name" placeholder="Outlet">
                                <span class="text-danger" id="error_branch_name" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_open_at">Jam Buka</label>
                                <div class="input-group date" id="open_at_timepicker" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="open_at" placeholder="Jam Buka" data-target="#open_at_timepicker" style="pointer-events: none;"/>
                                  <div class="input-group-append" data-target="#open_at_timepicker" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="far fa-clock"></i></div>
                                  </div>
                                </div>
                                <span class="text-danger" id="error_open_at" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_closed_at">Jam Tutup</label>
                                <div class="input-group date" id="closed_at_timepicker" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="closed_at" placeholder="Jam Tutup" data-target="#closed_at_timepicker" style="pointer-events: none;"/>
                                  <div class="input-group-append" data-target="#closed_at_timepicker" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="far fa-clock"></i></div>
                                  </div>
                                </div>
                                <span class="text-danger" id="error_closed_at" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_phone">Telepon</label>
                                <input type="text" class="form-control number" id="phone" placeholder="Telepon">
                                <span class="text-danger" id="error_phone" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_address">Alamat</label>
                                <textarea id="address" cols="10" rows="2" class="form-control" placeholder="Alamat" style="resize: none;"></textarea>
                                <span class="text-danger" id="error_address" style="font-size: 10pt;"></span>
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

        @foreach ($branch as $b)
        <div class="modal fade" id="updateModal{{ $b->id }}">
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
                            <input type="hidden" class="form-control" id="token{{ $b->id }}" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-label">Outlet</label>
                                <input type="text" class="form-control" id="branch_name{{ $b->id }}" placeholder="Outlet" value="{{ $b->branch_name }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Buka</label>
                                <div class="input-group date" id="open_at_timepicker{{ $b->id }}" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="open_at{{ $b->id }}" placeholder="Jam Buka" value="{{ str_replace('.', ':', $b->open_at) }}" data-target="#open_at_timepicker{{ $b->id }}" style="pointer-events: none;"/>
                                  <div class="input-group-append" data-target="#open_at_timepicker{{ $b->id }}" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="far fa-clock"></i></div>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Tutup</label>
                                <div class="input-group date" id="closed_at_timepicker" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="closed_at{{ $b->id }}" placeholder="Jam Tutup" value="{{ str_replace('.', ':', $b->closed_at) }}"data-target="#closed_at_timepicker{{ $b->id }}" style="pointer-events: none;"/>
                                  <div class="input-group-append" data-target="#closed_at_timepicker{{ $b->id }}" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="far fa-clock"></i></div>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_phone">Telepon</label>
                                <input type="text" class="form-control number" id="phone{{ $b->id }}" placeholder="Telepon" value="{{ $b->phone }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_address">Alamat</label>
                                <textarea id="address{{ $b->id }}" cols="10" rows="2" class="form-control" placeholder="Alamat" style="resize: none;">{{ $b->address }}</textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-warning updateBtn" id="btn{{ $b->id }}">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                //Timepicker
                let branch_id = '{{ $b->id }}';
                $('#open_at_timepicker' + branch_id).datetimepicker({
                    format: 'HH:mm',
                });

                $('#open_at' + branch_id).on('keypress', function(e){
                    e.preventDefault();
                    return false;
                });

                $('#open_at' + branch_id).on('keydown', function(e){
                    e.preventDefault();
                    return false;
                });

                $('#closed_at_timepicker' + branch_id).datetimepicker({
                    format: 'HH:mm',
                });

                $('#closed_at' + branch_id).on('keypress', function(e){
                    e.preventDefault();
                    return false;
                });

                $('#closed_at' + branch_id).on('keydown', function(e){
                    e.preventDefault();
                    return false;
                });
            });
        </script>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {
            // Number only
            $(".number").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

             //Timepicker
             $('#open_at_timepicker').datetimepicker({
                format: 'HH:mm',
            });

            $('#open_at').on('keypress', function(e){
                e.preventDefault();
                return false;
            });

            $('#open_at').on('keydown', function(e){
                e.preventDefault();
                return false;
            });

             $('#closed_at_timepicker').datetimepicker({
                format: 'HH:mm',
            });

            $('#closed_at').on('keypress', function(e){
                e.preventDefault();
                return false;
            });

            $('#closed_at').on('keydown', function(e){
                e.preventDefault();
                return false;
            });
            
            $(function() {
                $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ '/admin/branch/list' }}',
                    columns: [{
                            data: 'branch_name',
                            name: 'branch_name'
                        },
                        {
                            data: 'address',
                            name: 'address'
                        },
                        {
                            data: 'open_at',
                            name: 'open_at'
                        },
                        {
                            data: 'closed_at',
                            name: 'closed_at'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
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
                let branch_name = $('#branch_name').val();
                let open_at = $('#open_at').val();
                let closed_at = $('#closed_at').val();
                let phone = $('#phone').val();
                let address = $('#address').val();
                let _token = $('#token').val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/branch/create' }}',
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        branch_name: branch_name,
                        open_at: open_at,
                        closed_at: closed_at,
                        phone: phone,
                        address: address,
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
                                ajax: '{{ '/admin/branch/list' }}',
                                columns: [{
                                        data: 'branch_name',
                                        name: 'branch_name'
                                    },
                                    {
                                        data: 'open_at',
                                        name: 'open_at'
                                    },
                                    {
                                        data: 'closed_at',
                                        name: 'closed_at'
                                    },
                                    {
                                        data: 'phone',
                                        name: 'phone'
                                    },
                                    {
                                        data: 'address',
                                        name: 'address'
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
                            if(typeof(response.message.branch_name) !== 'undefined'){
                                $('#error_branch_name').text(response.message.branch_name);
                                $('#label_branch_name').addClass('text-danger');
                            }else{
                                $('#error_branch_name').text('');
                                $('#label_branch_name').removeClass('text-danger');
                            }

                            if(typeof(response.message.open_at) !== 'undefined'){
                                $('#error_open_at').text(response.message.open_at);
                                $('#label_open_at').addClass('text-danger');
                            }else{
                                $('#error_open_at').text('');
                                $('#label_open_at').removeClass('text-danger');
                            }

                            if(typeof(response.message.closed_at) !== 'undefined'){
                                $('#error_closed_at').text(response.message.closed_at);
                                $('#label_closed_at').addClass('text-danger');
                            }else{
                                $('#error_closed_at').text('');
                                $('#label_closed_at').removeClass('text-danger');
                            }

                            if(typeof(response.message.phone) !== 'undefined'){
                                $('#error_phone').text(response.message.phone);
                                $('#label_phone').addClass('text-danger');
                            }else{
                                $('#error_phone').text('');
                                $('#label_phone').removeClass('text-danger');
                            }

                            if(typeof(response.message.address) !== 'undefined'){
                                $('#error_address').text(response.message.address);
                                $('#label_address').addClass('text-danger');
                            }else{
                                $('#error_address').text('');
                                $('#label_address').removeClass('text-danger');
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
                let branch_id = htmlID.slice(3);
                let branch_name = $('#branch_name' + branch_id).val();
                let open_at = $('#open_at' + branch_id).val();
                let closed_at = $('#closed_at' + branch_id).val();
                let phone = $('#phone' + branch_id).val();
                let address = $('#address' + branch_id).val();
                let _token = $('#token' + branch_id).val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/branch/update/' }}' + branch_id,
                    type: 'POST',
                    cache: false,
                    data: {
                        branch_name: branch_name,
                        open_at: open_at,
                        closed_at: closed_at,
                        phone: phone,
                        address: address,
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
                                ajax: '{{ '/admin/branch/list' }}',
                                columns: [{
                                        data: 'branch_name',
                                        name: 'branch_name'
                                    },
                                    {
                                        data: 'open_at',
                                        name: 'open_at'
                                    },
                                    {
                                        data: 'closed_at',
                                        name: 'closed_at'
                                    },
                                    {
                                        data: 'phone',
                                        name: 'phone'
                                    },
                                    {
                                        data: 'address',
                                        name: 'address'
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