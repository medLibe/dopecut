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
                        <a href="/admin/book/create" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Tambah</a>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Customer</th>
                                            <th class="text-center">Whatsapp</th>
                                            <th>No. Boking</th>
                                            <th>Jam</th>
                                            <th>Hair Artist</th>
                                            <th>Alasan Cancel</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>

        @foreach ($book as $b)
            {{-- Detail Booking --}}
            <div class="modal fade" id="detail-booking{{ $b->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:0px;">
                            <h4 class="modal-title">Detail Booking #{{ $b->book_no }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-detail">
                                <thead class="bg-dark">
                                    <th>Service</th>
                                    <th>Estimation</th>
                                </thead>
                                <tbody></tbody>
                                <tfoot class="bg-dark"></tfoot>
                            </table>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cancel Booking --}}
            <div class="modal fade" id="cancel-booking{{ $b->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:0px;">
                            <h4 class="modal-title">Cancel Booking #{{ $b->book_no }}</h4>
                            <input type="hidden" value="{{ $b->book_no }}" id="book_no{{ $b->id }}">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <input type="hidden" class="form-control" id="token{{ $b->id }}" readonly value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="form-label">Alasan Cancel</label>
                                    <textarea id="cancel_reason{{ $b->id }}" rows="2" class="form-control" style="resize: none;" placeholder="Alasan Cancel"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-warning cancelBtn" id="cancel{{ $b->id }}">Save</button>
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
                    ajax: '{{ '/admin/book/list' }}',
                    columns: [{
                            data: 'book_date',
                            name: 'book_date'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'book_no',
                            name: 'book_no'
                        },
                        {
                            data: 'book_time',
                            name: 'book_time'
                        },
                        {
                            data: 'ha_name',
                            name: 'ha_name'
                        },
                        {
                            data: 'cancel_reason',
                            name: 'cancel_reason'
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
                    "ordering": false,
                    "autoWidth": false,
                    "responsive": true,
                });
            });

            $('#table-list').on('click', '.detailBtn', function() {
                let htmlID = $(this).attr('id');
                let book_transaction_id = htmlID.slice(3);
                
                $.ajax({
                    url: '/admin/book/detail-list/' + book_transaction_id,
                    type: 'GET',
                    cache: false,
                    dataType: 'JSON',
                    success: function(response){
                        let data = response.data;
                        let rupiah = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0,
                                minimumFractionDigits: 0,
                        });
                        let total_price = 0;
                        for(var i = 0; i < data.length; i++){
                            let service_name = data[i].service_name;
                            let estimation = data[i].estimation;
                            let td_service_name = '<td>' + service_name +'</td>';
                            let td_estimation = '<td>' + estimation +'</td>';

                            $('#detail-booking' + book_transaction_id).find('.modal-body tbody').append('<tr>' + td_service_name + td_estimation  + '</tr>');               
                        }
                    }
                });
            });

            $('.cancelBtn').on('click', function() {
                let htmlID = $(this).attr('id');
                let book_transaction_id = htmlID.slice(6);
                let book_no = $('#book_no' + book_transaction_id).val();
                let _token = $('#token' + book_transaction_id).val();
                let cancel_reason = $('#cancel_reason' + book_transaction_id).val();
                let creator = '{{ Auth::user()->username }}';
                
                $.ajax({
                    url: '{{ '/admin/book/update' }}',
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        book_id: book_transaction_id,
                        book_no: book_no,
                        cancel_reason: cancel_reason,
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
                                ajax: '{{ '/admin/book/list' }}',
                                columns: [{
                                        data: 'book_date',
                                        name: 'book_date'
                                    },
                                    {
                                        data: 'name',
                                        name: 'name'
                                    },
                                    {
                                        data: 'phone',
                                        name: 'phone'
                                    },
                                    {
                                        data: 'book_no',
                                        name: 'book_no'
                                    },
                                    {
                                        data: 'book_time',
                                        name: 'book_time'
                                    },
                                    {
                                        data: 'ha_name',
                                        name: 'ha_name'
                                    },
                                    {
                                        data: 'cancel_reason',
                                        name: 'cancel_reason'
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
                                "ordering": false,
                                "autoWidth": false,
                                "responsive": true,
                            });

                            toastr.success(response.message);
                        }
                    }
                });
            });
        });
    </script>
@endsection
