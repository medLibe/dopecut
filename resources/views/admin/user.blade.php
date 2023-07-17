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
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal">
                            <i class="fas fa-plus"></i>
                            User</button>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>User Name</th>
                                            <th>Role</th>
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
                        <h4 class="modal-title">Tambah User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-label" id="label_username">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Username (Untuk Akun Admin)">
                                <span class="text-danger" id="error_username" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password">
                                <span class="text-danger" id="error_password" style="font-size: 10pt;"></span>
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

        @foreach ($user as $u)
        <div class="modal fade" id="updateModal{{ $u->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:0px;">
                        <h4 class="modal-title">Update User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" class="form-control" id="token{{ $u->id }}" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password{{ $u->id }}" placeholder="Password">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-warning updateBtn" id="btn{{ $u->id }}">Save</button>
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
                    ajax: '{{ '/admin/user/list' }}',
                    columns: [
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'role',
                            name: 'role'
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
                let username = $('#username').val();
                let password = $('#password').val();
                let _token = $('#token').val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/user/create' }}',
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        username: username,
                        password: password,
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
                                ajax: '{{ '/admin/user/list' }}',
                                columns: [
                                    {
                                        data: 'username',
                                        name: 'username'
                                    },
                                    {
                                        data: 'role',
                                        name: 'role'
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
                            if(typeof(response.message.username) !== 'undefined'){
                                $('#error_username').text(response.message.username);
                                $('#label_username').addClass('text-danger');
                            }else{
                                $('#error_username').text('');
                                $('#label_username').removeClass('text-danger');
                            }

                            if(typeof(response.message.password) !== 'undefined'){
                                $('#error_password').text(response.message.password);
                                $('#label_password').addClass('text-danger');
                            }else{
                                $('#error_password').text('');
                                $('#label_password').removeClass('text-danger');
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
                let user_id = htmlID.slice(3);
                let password = $('#password' + user_id).val();
                let _token = $('#token' + user_id).val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/user/update/' }}' + user_id,
                    type: 'POST',
                    cache: false,
                    data: {
                        password: password,
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
                                ajax: '{{ '/admin/user/list' }}',
                                columns: [
                                    {
                                        data: 'username',
                                        name: 'username'
                                    },
                                    {
                                        data: 'role',
                                        name: 'role'
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
