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
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>Hair Artist</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Status</th>
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
    </div>

    <script>
        $(document).ready(function() {
            $('#schedule_date').daterangepicker({
                singleDatePicker: true,
                minDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $(function() {
                $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ '/admin/ha-schedule/list/1' }}',
                    columns: [
                        {
                            data: 'ha_name',
                            name: 'ha_name'
                        },
                        {
                            data: 'schedule_date',
                            name: 'schedule_date'
                        },
                        {
                            data: 'schedule_time',
                            name: 'schedule_time'
                        },
                        {
                            data: 'schedule_type',
                            name: 'schedule_type',
                            render: function(data, type, row){
                                if(data == 1){
                                    return "Customer's Book";
                                }else{
                                    return "Manual's Book";
                                }
                            }
                        },
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "autoWidth": false,
                    "responsive": true,
                    "order": [
                        [1, 'desc']
                    ],
                });
            });
        });
    </script>
@endsection
