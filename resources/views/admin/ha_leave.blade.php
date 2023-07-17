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
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Manual Day Off</button>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>Hair Artist</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
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
                        <h4 class="modal-title">Manual Day Off</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">
                            <div class="form-group mb-3">
                                <label class="form-label" id="label_ha_id">Hair Artist</label>
                                <select id="ha_id" class="custom-select">
                                    <option value="">-- Pilih Hair Artist --</option>
                                    @foreach ($hair_artist as $ha)
                                    <option value="{{ $ha->id }}">{{ $ha->ha_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="error_ha_id" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" id="label_schedule_date">Tanggal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="schedule_date" readonly style="background-color: white;">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" id="label_description">Keterangan</label>
                                <textarea id="description" cols="20" rows="2" class="form-control" placeholder="Keterangan" style="resize: none;"></textarea>
                                <span class="text-danger" id="error_description" style="font-size: 10pt;"></span>
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
                    ajax: '{{ '/admin/ha-schedule/list/2' }}',
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
                            data: 'description',
                            name: 'description'
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
            })

            $('#createBtn').on('click', function() {
                let ha_id = $('#ha_id').val();
                let schedule_date = moment($('#schedule_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');;
                let description = $('#description').val().replace(/\n/g, '<br>');
                let _token = $('#token').val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/ha-schedule/create' }}',
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        ha_id: ha_id,
                        schedule_date: schedule_date,
                        description: description,
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
                                ajax: '{{ '/admin/ha-schedule/list/2' }}',
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
                                        data: 'description',
                                        name: 'description'
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

                            $('#createModal').modal('hide');
                            $('#createForm')[0].reset();

                            toastr.success(response.message);
                        }else if(response.status == 400){
                            toastr.info(response.message);
                        }else{
                            if(typeof(response.message.ha_id) !== 'undefined'){
                                $('#error_ha_id').text(response.message.ha_id);
                                $('#label_ha_id').addClass('text-danger');
                            }else{
                                $('#error_ha_id').text('');
                                $('#label_ha_id').removeClass('text-danger');
                            }

                            if(typeof(response.message.schedule_date) !== 'undefined'){
                                $('#error.schedule_date').text(response.message.schedule_date);
                                $('#label.schedule_date').addClass('text-danger');
                            }else{
                                $('#error_schedule_date').text('');
                                $('#label_schedule_date').removeClass('text-danger');
                            }

                            if(typeof(response.message.description) !== 'undefined'){
                                $('#error_description').text(response.message.description);
                                $('#label_description').addClass('text-danger');
                            }else{
                                $('#error_description').text('');
                                $('#label_description').removeClass('text-danger');
                            }

                            toastr.error('Input gagal, mohon periksa error.');
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
