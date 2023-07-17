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
                                            <th>*</th>
                                            {{-- <th>Outlet</th> --}}
                                            <th>Hair Artist</th>
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

        <div class="modal fade" id="createModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:0px;">
                        <h4 class="modal-title">Tambah Hair Artist</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">
                            <div class="text-center">
                                <img src="/assets/image/no-image.png" id="profile_output" alt="preview" style="width: 150px; height: 150px;">
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_profile_picture">Foto Hair Artist</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="profile_picture" id="profile_picture" accept="image/png, image/jpg, image/jpeg, image/svg">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                  </div>
                                </div>
                                <span class="text-danger" id="error_profile_picture" style="font-size: 10pt;"></span>
                            </div> 
                            <div class="form-group">
                                <label class="form-label" id="label_ha_name">Hair Artist</label>
                                <input type="text" class="form-control" id="ha_name" placeholder="Hair Artist">
                                <span class="text-danger" id="error_ha_name" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_day_off">Day Off</label>
                                <select id="day_off" class="custom-select">
                                    <option value="">-- Select Day Off --</option>
                                    <option value="0">Sunday</option>
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5">Friday</option>
                                    <option value="6">Saturday</option>
                                </select>
                                <span class="text-danger" id="error_day_off" style="font-size: 10pt;"></span>
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

        @foreach ($ha as $h)
        <div class="modal fade" id="haModal{{ $h->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:0px;">
                        <h4 class="modal-title">Day Off {{ $h->ha_name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-default-info">
                            Keterangan:
                            <ul>
                                <li>Hari berwarna hijau: Available</li>
                                <li>Hari berwarna abu-abu: Off</li>
                            </ul>
                        </div>
                        <table class="table text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Day</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($days as $key => $val)
                                <tr>
                                    <td><div class="badge {{ $h->day_off != $key ? 'badge-success' : 'badge-secondary' }}">{{ $val }}</div></td>
                                    <td>
                                        @if ($h->day_off != $key)
                                            <button class="btn-dayoff btn btn-sm btn-danger" data-dayoff="{{ $key }}" data-haid="{{ $h->id }}"><i class="fas fa-power-off"></i></button>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary haBtn" id="btn{{ $h->id }}">Save</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {   
            // Custom file input
            $(function() {
                bsCustomFileInput.init();
            });

            // Trigger image upload
            $("#profile_picture").on("change", function () {
                let file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(e){
                    $('#profile_output').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            });

            $(function() {
                $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ '/admin/hair-artist/list' }}',
                    columns: [
                        {
                            data: 'profile_picture',
                            name: 'profile_picture'
                        },
                        // {
                        //     data: 'branch_name',
                        //     name: 'branch_name'
                        // },
                        {
                            data: 'ha_name',
                            name: 'ha_name'
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
            });

            $('#createBtn').on('click', function() {
                let fileInput = document.getElementById('profile_picture');
                let ha_name = $('#ha_name').val();
                let day_off = $('#day_off').val();
                let creator = '{{ Auth::user()->username }}';
                let _token = $('#token').val();

                if(fileInput.files && fileInput.files[0]){
                    let file = fileInput.files[0];
                    let reader = new FileReader();
                    reader.onload = function(event){
                        let img = new Image();
                        img.onload = function(){
                            let canvas = document.createElement('canvas');
                            let ctx = canvas.getContext('2d');

                            // Set width & height
                            let MAX_WIDTH = 600;
                            let MAX_HEIGHT = 600;
                            let width = img.width;
                            let height = img.height;
                            if(width > MAX_WIDTH){
                                height *= MAX_WIDTH / width;
                                width = MAX_WIDTH;
                            }else{
                                if(height > MAX_HEIGHT){
                                    width *= MAX_HEIGHT / height;
                                    height = MAX_HEIGHT;
                                }
                            }

                            canvas.width = width;
                            canvas.height = height;

                            // Get canvas image
                            ctx.drawImage(img, 0, 0, width, height);

                            // Get URL data image compressed
                            let dataUrl = canvas.toDataURL(file.type);

                            $.ajax({
                                url: '{{ '/admin/hair-artist/create' }}',
                                type: 'POST',
                                data: {
                                    profile_picture: dataUrl,
                                    ha_name: ha_name,
                                    day_off: day_off,
                                    creator: creator,
                                    _token: _token,
                                },
                                dataType: 'JSON',
                                success: function(response){
                                    if(response.status == 200){
                                        let table_list = $('#table-list').DataTable();
                                        table_list.destroy();

                                        $('#table-list').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            ajax: '{{ '/admin/hair-artist/list' }}',
                                            columns: [
                                                {
                                                    data: 'profile_picture',
                                                    name: 'profile_picture'
                                                },
                                                {
                                                    data: 'ha_name',
                                                    name: 'ha_name'
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

                                        toastr.success(response.message);
                                    }else{
                                        if(typeof(response.message.profile_picture) !== 'undefined'){
                                            $('#error_profile_picture').text(response.message.profile_picture);
                                            $('#label_profile_picture').addClass('text-danger');
                                        }else{
                                            $('#error_profile_picture').hide();
                                            $('#error_profile_picture').text('');
                                            $('#label_profile_picture').removeClass('text-danger');
                                        }

                                        if(typeof(response.message.ha_name) !== 'undefined'){
                                            $('#error_ha_name').text(response.message.ha_name);
                                            $('#label_ha_name').addClass('text-danger');
                                        }else{
                                            $('#error_ha_name').text('');
                                            $('#label_ha_name').removeClass('text-danger');
                                        }

                                        if(typeof(response.message.day_off) !== 'undefined'){
                                            $('#error_day_off').text(response.message.day_off);
                                            $('#label_day_off').addClass('text-danger');
                                        }else{
                                            $('#error_day_off').text('');
                                            $('#label_day_off').removeClass('text-danger');
                                        }

                                        toastr.error('Input gagal, mohon periksa error.');
                                    }
                                },
                                error: function(xhr, textStatus, error){
                                    console.error(error);
                                }
                            });
                        }
                        img.src = event.target.result;
                    }
                    reader.readAsDataURL(file);
                }
                else{
                    if(fileInput.files){
                        $('#error_profile_picture').text('Hair Artist tidak boleh kosong.');
                        $('#label_profile_picture').addClass('text-danger');
                    }else{
                        $('#error_profile_picture').text('');
                        $('#label_profile_picture').removeClass('text-danger');
                    }

                    if(ha_name == ''){
                        $('#error_ha_name').text('Foto Hair Artist tidak boleh kosong.');
                        $('#label_ha_name').addClass('text-danger');
                    }else{
                        $('#error_ha_name').text('');
                        $('#label_ha_name').removeClass('text-danger');
                    }

                    if(day_off == ''){
                        $('#error_day_off').text('Day off tidak boleh kosong.');
                        $('#label_day_off').addClass('text-danger');
                    }else{
                        $('#error_day_off').text('');
                        $('#label_day_off').removeClass('text-danger');
                    }

                    toastr.error('Input gagal, mohon periksa error.');
                }
            });
        });

        $('.btn-dayoff').on('click', function() {
            let day_off = $(this).attr('data-dayoff');
            let ha_id = $(this).attr('data-haid');

            $.ajax({
                url: '/admin/hair-artist/day-off',
                type: 'GET',
                cache: false,
                data: {
                    day_off: day_off,
                    ha_id: ha_id,
                },
                dataType: 'JSON',
                success: function(response){
                    if(response.status == 200){
                        toastr.success(response.message);

                        setTimeout(() => {
                            window.location.reload()
                        }, 1500);
                    }
                }
            });
        });
    </script>
@endsection