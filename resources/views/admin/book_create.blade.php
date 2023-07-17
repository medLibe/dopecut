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
                <div class="row justify-content-center">
                    <div class="col-md-8 col-12">
                        <a href="/admin/book" class="btn btn-default mb-2"><i class="fas fa-arrow-circle-left"></i>
                            Kembali</a>
                        <form action="/admin/book/create-process" id="createForm">
                            @csrf
                            <div class="card">
                                <div class="card-header bg-primary p-0"></div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tanggal Booking</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" name="book_date" id="book_date" readonly style="background-color: white;">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">No. Booking</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-hashtag"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" name="book_no" value="{{ $book_no }}" readonly style="background-color: white;">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Hair Artist</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user-tag"></i>
                                                </span>
                                            </div>
                                            <select id="ha_id" name="ha_id" class="custom-select" required>
                                                <option value="">-- Pilih Hair Artist --</option>
                                                @foreach ($hair_artist as $ha)
                                                <option value="{{ $ha->id }}">{{ $ha->ha_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Jam Booking</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-clock"></i>
                                                </span>
                                            </div>
                                            <select id="book_time" name="book_time" class="custom-select" required>
                                                <option value="">-- Pilih Jam --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama Customer</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" name="name" placeholder="Nama Customer" required value="Customer 01">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Gender</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-venus-mars"></i>
                                                </span>
                                            </div>
                                            <select name="gender" id="gender" class="custom-select" required>
                                                <option value="1">Pria</option>
                                                <option value="2">Wanita</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Whatsapp</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fab fa-whatsapp"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Tidak wajib apabila booking manual">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-secondary p-0"></div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap" id="detail">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select id="service" name="service_id[]" class="custom-select" required>
                                                        <option value="">-- Pilih Service --</option>
                                                        @foreach ($service as $s)
                                                        <option value="{{ $s->id }}">{{ $s->service_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-success" id="addBtn"><i class="fas fa-plus"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="text-right mb-3">
                                <button class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#book_date').daterangepicker({
                singleDatePicker: true,
                minDate: moment(),
                maxDate: moment().add(2, 'days'),
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('#ha_id').on('change', function(){
                let ha_id = $(this).val();
                let book_date = moment($('#book_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');

                $.ajax({
                    url: '/admin/ha-schedule/id-' + ha_id,
                    type: 'GET',
                    cache: false,
                    data: {
                        ha_id: ha_id,
                        book_date: book_date,
                    },
                    dataType: 'JSON',
                    success: function(response){
                        $('#book_time').empty();
                        $('#book_time').append($('<option>', {
                            value: '',
                            text: '-- Pilih Jam --',
                        }));
                        let data = response.data;
                        for(let x = 0; x < data.length; ++x){
                            $('#book_time').append($('<option>', {
                                value: data[x].time,
                                text: data[x].time
                            }));
                        }
                    },
                    error: function(xhr, status, error){
                        console.log(error);
                    }
                })
            });

            let i = 1;
            $('#addBtn').on('click', function() {
                i += 1;
                let service_row = '<tr class="append-row"><td><select name="service_id[]" id="service' + i +'" class="custom-select" required><option value="">-- Pilih Service --</option>@foreach ($service as $s)<option value="{{ $s->id }}">{{ $s->service_name }}</option>@endforeach</select></td>';
                let button_row = ' <td class="text-center"><button type="button" class="btn btn-sm btn-danger removeBtn" id="removeBtn' + i +'"><i class="fas fa-trash"></i></button></td></tr>';

                $('#detail').append(service_row + button_row);
            });

            $('#detail').on('click', '.removeBtn', function() {
                $(this).parents('.append-row').remove();
            });
        });
    </script>
@endsection
