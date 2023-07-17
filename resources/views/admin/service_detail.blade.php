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
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal">Tambah Service</button>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th class="text-center">*</th>
                                            <th>Service</th>
                                            <th>Sub Service</th>
                                            <th>Link (IG/Youtube/Tiktok)</th>
                                            <th>Keterangan</th>
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
                        <h4 class="modal-title">Tambah Service</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">
                            <div class="text-center">
                                <img src="/assets/image/no-image.png" id="thumbnail_output" alt="preview" style="width: 150px; height: 150px;">
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_thumbnail">Foto Sub Service</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" accept="image/png, image/jpg, image/jpeg, image/svg">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                  </div>
                                </div>
                                <span class="text-danger" id="error_thumbnail" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_service_id">Service</label>
                                <select id="service_id" class="custom-select">
                                    <option value="">-- Pilih Service --</option>
                                    @foreach ($service as $s)
                                    <option value="{{ $s->id }}">{{ $s->service_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="error_service_id" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_sd_name">Sub Service</label>
                                <input type="text" class="form-control" id="sd_name" placeholder="Sub Service">
                                <span class="text-danger" id="error_sd_name" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_url_service">Link (IG/Youtube/Tiktok)</label>
                                <input type="text" class="form-control" id="url_service" placeholder="Link (IG/Youtube/Tiktok)">
                                <span class="text-danger" id="error_url_service" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label">Keterangan</label>
                                <textarea id="description" cols="10" rows="3" class="form-control" placeholder="Keterangan" style="resize: none;"></textarea>
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
            // Custom file input
            $(function() {
                bsCustomFileInput.init();
            });

            $(function() {
                $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ '/admin/sub-service/list' }}',
                    columns: [
                        {
                            data: 'thumbnail',
                            name: 'thumbnail'
                        },
                        {
                            data: 'service_name',
                            name: 'service_name'
                        },
                        {
                            data: 'sd_name',
                            name: 'sd_name'
                        },
                        {
                            data: 'url_service',
                            name: 'url_service'
                        },
                        {
                            data: 'description',
                            name: 'description'
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

            // Trigger image upload
            $("#thumbnail").on("change", function () {
                let file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(e){
                    $('#thumbnail_output').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            });

            $('#createBtn').on('click', function() {
                let fileInput = document.getElementById('thumbnail');
                let sd_name = $('#sd_name').val();
                let service_id = $('#service_id').val();
                let url_service = $('#url_service').val();
                let description = $('#description').val();
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
                                url: '{{ '/admin/sub-service/create' }}',
                                type: 'POST',
                                data: {
                                    thumbnail: dataUrl,
                                    service_id: service_id,
                                    sd_name: sd_name,
                                    url_service: url_service,
                                    description: description,
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
                                            ajax: '{{ '/admin/sub-service/list' }}',
                                            columns: [
                                                {
                                                    data: 'thumbnail',
                                                    name: 'thumbnail'
                                                },
                                                {
                                                    data: 'service_name',
                                                    name: 'service_name'
                                                },
                                                {
                                                    data: 'sd_name',
                                                    name: 'sd_name'
                                                },
                                                {
                                                    data: 'url_service',
                                                    name: 'url_service'
                                                },
                                                {
                                                    data: 'description',
                                                    name: 'description'
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
                                        if(typeof(response.message.thumbnail) !== 'undefined'){
                                            $('#error_thumbnail').text(response.message.thumbnail);
                                            $('#label_thumbnail').addClass('text-danger');
                                        }else{
                                            $('#error_thumbnail').hide();
                                            $('#error_thumbnail').text('');
                                            $('#label_thumbnail').removeClass('text-danger');
                                        }

                                        if(typeof(response.message.service_id) !== 'undefined'){
                                            $('#error_service_id').text(response.message.service_id);
                                            $('#label_service_id').addClass('text-danger');
                                        }else{
                                            $('#error_service_id').text('');
                                            $('#label_service_id').removeClass('text-danger');
                                        }

                                        if(typeof(response.message.sd_name) !== 'undefined'){
                                            $('#error_sd_name').text(response.message.sd_name);
                                            $('#label_sd_name').addClass('text-danger');
                                        }else{
                                            $('#error_sd_name').text('');
                                            $('#label_sd_name').removeClass('text-danger');
                                        }

                                        if(typeof(response.message.url_service) !== 'undefined'){
                                            $('#error_url_service').text(response.message.url_service);
                                            $('#label_url_service').addClass('text-danger');
                                        }else{
                                            $('#error_url_service').text('');
                                            $('#label_url_service').removeClass('text-danger');
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
                }else{
                    $.ajax({
                        url: '{{ '/admin/sub-service/create' }}',
                        type: 'POST',
                        data: {
                            service_id: service_id,
                            sd_name: sd_name,
                            url_service: url_service,
                            description: description,
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
                                    ajax: '{{ '/admin/sub-service/list' }}',
                                    columns: [
                                        {
                                            data: 'thumbnail',
                                            name: 'thumbnail'
                                        },
                                        {
                                            data: 'service_name',
                                            name: 'service_name'
                                        },
                                        {
                                            data: 'sd_name',
                                            name: 'sd_name'
                                        },
                                        {
                                            data: 'url_service',
                                            name: 'url_service'
                                        },
                                        {
                                            data: 'description',
                                            name: 'description'
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
                                if(typeof(response.message.service_id) !== 'undefined'){
                                    $('#error_service_id').text(response.message.service_id);
                                    $('#label_service_id').addClass('text-danger');
                                }else{
                                    $('#error_thumbnail').text('');
                                    $('#label_thumbnail').removeClass('text-danger');
                                }

                                if(typeof(response.message.sd_name) !== 'undefined'){
                                    $('#error_sd_name').text(response.message.sd_name);
                                    $('#label_sd_name').addClass('text-danger');
                                }else{
                                    $('#error_sd_name').text('');
                                    $('#label_sd_name').removeClass('text-danger');
                                }

                                if(typeof(response.message.url_service) !== 'undefined'){
                                    $('#error_url_service').text(response.message.url_service);
                                    $('#label_url_service').addClass('text-danger');
                                }else{
                                    $('#error_url_service').text('');
                                    $('#label_url_service').removeClass('text-danger');
                                }

                                toastr.error('Input gagal, mohon periksa error.');
                            }
                        },
                        error: function(xhr, textStatus, error){
                            console.error(error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
