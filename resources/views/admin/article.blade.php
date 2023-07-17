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
                        <a class="btn btn-primary mb-2" href="/admin/article/post">
                            <i class="fas fa-plus"></i>
                            Artikel</a>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>Author</th>
                                            <th>Title</th>
                                            <th>Posted At</th>
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

        @foreach ($article as $a)
        <div class="modal fade" id="takedownModal{{ $a->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:0px;">
                        <h4 class="modal-title">Takedown Artikel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah kamu yakin ingin men-takedown artikel ini?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a href="/admin/article/takedown/{{ $a->slug }}" class="btn btn-danger">Takedown</a>
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
                    ajax: '{{ '/admin/article/list' }}',
                    columns: [
                        {
                            data: 'author',
                            name: 'author'
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
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
        });
    </script>
@endsection
