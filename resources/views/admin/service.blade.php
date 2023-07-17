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
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal"><i
                                class="fas fa-plus"></i> Tambah</button>
                        <div class="card">
                            <div class="card-header bg-primary p-0"></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table-list" class="table table-bordered table-striped">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>Service</th>
                                            <th>Jenis Service</th>
                                            <th>Estimasi</th>
                                            <th>Harga</th>
                                            <th>Harga Tentative</th>
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
                            {{-- <div class="text-center">
                                <img src="/assets/image/no-image.png" id="thumbnail_output" alt="preview" style="width: 150px; height: 150px;">
                            </div> --}}
                            {{-- <div class="form-group">
                                <label class="form-label" id="label_thumbnail">Foto Service</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" accept="image/png, image/jpg, image/jpeg, image/svg">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                  </div>
                                </div>
                                <span class="text-danger" id="error_thumbnail" style="font-size: 10pt;"></span>
                            </div> --}}
                            <div class="form-group">
                                <label class="form-label" id="label_service_name">Service</label>
                                <input type="text" class="form-control" id="service_name" name="service_name"
                                    placeholder="Service">
                                <span class="text-danger" id="error_service_name" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_gender_service">Service untuk?</label>
                                <select id="gender_service" class="custom-select">
                                    <option value="">-- Pilih untuk pria/wanita --</option>
                                    <option value="1">Pria</option>
                                    <option value="2">Wanita</option>
                                </select>
                                <span class="text-danger" id="error_gender_service" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_estimation">Estimasi</label>
                                <input type="text" class="form-control number" id="estimation" name="estimation"
                                    placeholder="Nilai satuan menit">
                                <span class="text-danger" id="error_estimation" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_price">Harga</label>
                                <input type="text" class="form-control number" id="price_view" name="price"
                                    placeholder="Harga">
                                <input type="hidden" class="form-control number" id="price" readonly name="price"
                                    placeholder="Harga">
                                <span class="text-danger" id="error_price" style="font-size: 10pt;"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" id="label_tentative_price">Harga Tentative?</label>
                                <select id="tentative_price" class="custom-select">
                                    <option value="">-- Apakah harga dapat berubah/tidak --</option>
                                    <option value="1">Ya</option>
                                    <option value="2">Tidak</option>
                                </select>
                                <span class="text-danger" id="error_tentative_price" style="font-size: 10pt;"></span>
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

        @foreach ($service as $s)
            <div class="modal fade" id="editModal{{ $s->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:0px;">
                            <h4 class="modal-title">Tambah Service</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <input type="hidden" class="form-control" id="token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="form-label" id="label_service_name">Service</label>
                                    <input type="text" class="form-control" id="service_name{{ $s->id }}"
                                        placeholder="Service" value="{{ $s->service_name }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" id="label_gender_service">Service untuk?</label>
                                    <select id="gender_service{{ $s->id }}" class="custom-select">
                                        <option value="{{ $s->gender_service }}">
                                            {{ $s->gender_service == 1 ? 'Pria' : 'Wanita' }}</option>
                                        <option value="1">Pria</option>
                                        <option value="2">Wanita</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" id="label_estimation">Estimasi</label>
                                    <input type="text" class="form-control number" id="estimation{{ $s->id }}"
                                        placeholder="Nilai satuan menit" value="{{ $s->estimation }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" id="label_price">Harga</label>
                                    <input type="text" class="form-control number" id="price_view{{ $s->id }}" name="price"
                                        placeholder="Harga" value="{{ number_format($s->price,0,',','.') }}">
                                    <input type="hidden" class="form-control number" id="price{{ $s->id }}" readonly name="price"
                                        placeholder="Harga" value="{{ $s->price }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" id="label_tentative_price">Harga Tentative?</label>
                                    <select id="tentative_price{{ $s->id }}" class="custom-select">
                                        <option value="{{ $s->tentative_price }}">
                                            {{ $s->tentative_price == 1 ? 'Ya' : 'Tidak' }}</option>
                                        <option value="1">Ya</option>
                                        <option value="2">Tidak</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-warning updateBtn"
                                id="btn{{ $s->id }}">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                // Keyup base price
                $('#price_view' + <?= $s->id ?>).on('keyup', function() {
                    var view = $(this).val();
                    var num = parseFloat(view.replace(/\./g, ''));

                    if (event.which >= 37 && event.which <= 40) return;
                    $(this).val(function(index, value) {
                        return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    });

                    $('#price' + <?= $s->id ?>).val(parseFloat(num) || 0);
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

            // Keyup base price
            $('#price_view').on('keyup', function() {
                var view = $(this).val();
                var num = parseFloat(view.replace(/\./g, ''));

                if (event.which >= 37 && event.which <= 40) return;
                $(this).val(function(index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                });

                $('#price').val(parseFloat(num) || 0);
            });

            // Custom file input
            $(function() {
                bsCustomFileInput.init();
            });

            $(function() {
                $('#table-list').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ '/admin/service/list' }}',
                    columns: [{
                            data: 'service_name',
                            name: 'service_name'
                        },
                        {
                            data: 'gender_service',
                            name: 'gender_service'
                        },
                        {
                            data: 'estimation',
                            name: 'estimation'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'tentative_price',
                            name: 'tentative_price'
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
            // $("#thumbnail").on("change", function () {
            //     let file = this.files[0];
            //     let reader = new FileReader();
            //     reader.onload = function(e){
            //         $('#thumbnail_output').attr('src', e.target.result);
            //     }
            //     reader.readAsDataURL(file);
            // });

            $('#createBtn').on('click', function() {
                // let fileInput = document.getElementById('thumbnail');
                let service_name = $('#service_name').val();
                let estimation = $('#estimation').val();
                let gender_service = $('#gender_service').val();
                let tentative_price = $('#tentative_price').val();
                let price = $('#price').val();
                let creator = '{{ Auth::user()->username }}';
                let _token = $('#token').val();

                // if(fileInput.files && fileInput.files[0]){
                //     let file = fileInput.files[0];
                //     let reader = new FileReader();
                //     reader.onload = function(event){
                //         let img = new Image();
                //         img.onload = function(){
                //             let canvas = document.createElement('canvas');
                //             let ctx = canvas.getContext('2d');

                //             // Set width & height
                //             let MAX_WIDTH = 600;
                //             let MAX_HEIGHT = 600;
                //             let width = img.width;
                //             let height = img.height;
                //             if(width > MAX_WIDTH){
                //                 height *= MAX_WIDTH / width;
                //                 width = MAX_WIDTH;
                //             }else{
                //                 if(height > MAX_HEIGHT){
                //                     width *= MAX_HEIGHT / height;
                //                     height = MAX_HEIGHT;
                //                 }
                //             }

                //             canvas.width = width;
                //             canvas.height = height;

                //             // Get canvas image
                //             ctx.drawImage(img, 0, 0, width, height);

                //             // Get URL data image compressed
                //             let dataUrl = canvas.toDataURL(file.type);

                //             $.ajax({
                //                 url: '{{ '/admin/service/create' }}',
                //                 type: 'POST',
                //                 data: {
                //                     thumbnail: dataUrl,
                //                     service_name: service_name,
                //                     estimation: estimation,
                //                     price: price,
                //                     creator: creator,
                //                     _token: _token,
                //                 },
                //                 dataType: 'JSON',
                //                 success: function(response){
                //                     if(response.status == 200){
                //                         let table_list = $('#table-list').DataTable();
                //                         table_list.destroy();

                //                         $('#table-list').DataTable({
                //                             processing: true,
                //                             serverSide: true,
                //                             ajax: '{{ '/admin/service/list' }}',
                //                             columns: [
                //                                 {
                //                                     data: 'thumbnail',
                //                                     name: 'thumbnail'
                //                                 },
                //                                 {
                //                                     data: 'service_name',
                //                                     name: 'service_name'
                //                                 },
                //                                 {
                //                                     data: 'estimation',
                //                                     name: 'estimation'
                //                                 },
                //                                 {
                //                                     data: 'price',
                //                                     name: 'price'
                //                                 },
                //                                 {
                //                                     data: 'action',
                //                                     name: 'action',
                //                                     searchable: true,
                //                                 }
                //                             ],
                //                             "paging": true,
                //                             "lengthChange": true,
                //                             "searching": true,
                //                             "ordering": true,
                //                             "autoWidth": false,
                //                             "responsive": true,
                //                         });

                //                         toastr.success(response.message);
                //                     }else{
                //                         if(typeof(response.message.thumbnail) !== 'undefined'){
                //                             $('#error_thumbnail').text(response.message.thumbnail);
                //                             $('#label_thumbnail').addClass('text-danger');
                //                         }else{
                //                             $('#error_thumbnail').hide();
                //                             $('#error_thumbnail').text('');
                //                             $('#label_thumbnail').removeClass('text-danger');
                //                         }

                //                         if(typeof(response.message.service_name) !== 'undefined'){
                //                             $('#error_service_name').text(response.message.service_name);
                //                             $('#label_service_name').addClass('text-danger');
                //                         }else{
                //                             $('#error_service_name').text('');
                //                             $('#label_service_name').removeClass('text-danger');
                //                         }

                //                         if(typeof(response.message.estimation) !== 'undefined'){
                //                             $('#error_estimation').text(response.message.estimation);
                //                             $('#label_estimation').addClass('text-danger');
                //                         }else{
                //                             $('#error_estimation').text('');
                //                             $('#label_estimation').removeClass('text-danger');
                //                         }

                //                         if(typeof(response.message.price) !== 'undefined'){
                //                             $('#error_price').text(response.message.price);
                //                             $('#label_price').addClass('text-danger');
                //                         }else{
                //                             $('#error_price').text('');
                //                             $('#label_price').removeClass('text-danger');
                //                         }

                //                         toastr.error('Input gagal, mohon periksa error.');
                //                     }
                //                 },
                //                 error: function(xhr, textStatus, error){
                //                     console.error(error);
                //                 }
                //             });
                //         }
                //         img.src = event.target.result;
                //     }
                //     reader.readAsDataURL(file);
                // }else{
                //     $.ajax({
                //         url: '{{ '/admin/service/create' }}',
                //         type: 'POST',
                //         data: {
                //             service_name: service_name,
                //             estimation: estimation,
                //             price: price,
                //             creator: creator,
                //             _token: _token,
                //         },
                //         dataType: 'JSON',
                //         success: function(response){
                //             if(response.status == 200){
                //                 let table_list = $('#table-list').DataTable();
                //                 table_list.destroy();

                //                 $('#table-list').DataTable({
                //                     processing: true,
                //                     serverSide: true,
                //                     ajax: '{{ '/admin/service/list' }}',
                //                     columns: [
                //                         {
                //                             data: 'thumbnail',
                //                             name: 'thumbnail'
                //                         },
                //                         {
                //                             data: 'service_name',
                //                             name: 'service_name'
                //                         },
                //                         {
                //                             data: 'estimation',
                //                             name: 'estimation'
                //                         },
                //                         {
                //                             data: 'price',
                //                             name: 'price'
                //                         },
                //                         {
                //                             data: 'action',
                //                             name: 'action',
                //                             searchable: true,
                //                         }
                //                     ],
                //                     "paging": true,
                //                     "lengthChange": true,
                //                     "searching": true,
                //                     "ordering": true,
                //                     "autoWidth": false,
                //                     "responsive": true,
                //                 });

                //                 toastr.success(response.message);
                //             }else{
                //                 console.log(response.message)
                //                 if(typeof(response.message.thumbnail) !== 'undefined'){
                //                     $('#error_thumbnail').text(response.message.thumbnail);
                //                     $('#label_thumbnail').addClass('text-danger');
                //                 }else{
                //                     $('#error_thumbnail').text('');
                //                     $('#label_thumbnail').removeClass('text-danger');
                //                 }

                //                 if(typeof(response.message.service_name) !== 'undefined'){
                //                     $('#error_service_name').text(response.message.service_name);
                //                     $('#label_service_name').addClass('text-danger');
                //                 }else{
                //                     $('#error_service_name').text('');
                //                     $('#label_service_name').removeClass('text-danger');
                //                 }

                //                 if(typeof(response.message.estimation) !== 'undefined'){
                //                     $('#error_estimation').text(response.message.estimation);
                //                     $('#label_estimation').addClass('text-danger');
                //                 }else{
                //                     $('#error_estimation').text('');
                //                     $('#label_estimation').removeClass('text-danger');
                //                 }

                //                 if(typeof(response.message.price) !== 'undefined'){
                //                     $('#error_price').text(response.message.price);
                //                     $('#label_price').addClass('text-danger');
                //                 }else{
                //                     $('#error_price').text('');
                //                     $('#label_price').removeClass('text-danger');
                //                 }

                //                 toastr.error('Input gagal, mohon periksa error.');
                //             }
                //         },
                //         error: function(xhr, textStatus, error){
                //             console.error(error);
                //         }
                //     });
                // }

                $.ajax({
                    url: '{{ '/admin/service/create' }}',
                    type: 'POST',
                    data: {
                        service_name: service_name,
                        gender_service: gender_service,
                        price: price,
                        tentative_price: tentative_price,
                        estimation: estimation,
                        creator: creator,
                        _token: _token,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 200) {
                            let table_list = $('#table-list').DataTable();
                            table_list.destroy();

                            $('#table-list').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: '{{ '/admin/service/list' }}',
                                columns: [{
                                        data: 'service_name',
                                        name: 'service_name'
                                    },
                                    {
                                        data: 'gender_service',
                                        name: 'gender_service'
                                    },
                                    {
                                        data: 'estimation',
                                        name: 'estimation'
                                    },
                                    {
                                        data: 'price',
                                        name: 'price'
                                    },
                                    {
                                        data: 'tentative_price',
                                        name: 'tentative_price'
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
                        } else {

                            if (typeof(response.message.service_name) !== 'undefined') {
                                $('#error_service_name').text(response.message.service_name);
                                $('#label_service_name').addClass('text-danger');
                            } else {
                                $('#error_service_name').text('');
                                $('#label_service_name').removeClass('text-danger');
                            }

                            if (typeof(response.message.gender_service) !== 'undefined') {
                                $('#error_gender_service').text(response.message.gender_service);
                                $('#label_gender_service').addClass('text-danger');
                            } else {
                                $('#error_gender_service').text('');
                                $('#label_gender_service').removeClass('text-danger');
                            }

                            if (typeof(response.message.estimation) !== 'undefined') {
                                $('#error_estimation').text(response.message.estimation);
                                $('#label_estimation').addClass('text-danger');
                            } else {
                                $('#error_estimation').text('');
                                $('#label_estimation').removeClass('text-danger');
                            }

                            if (typeof(response.message.price) !== 'undefined') {
                                $('#error_price').text(response.message.price);
                                $('#label_price').addClass('text-danger');
                            } else {
                                $('#error_price').text('');
                                $('#label_price').removeClass('text-danger');
                            }

                            if (typeof(response.message.tentative_price) !== 'undefined') {
                                $('#error_tentative_price').text(response.message.tentative_price);
                                $('#label_tentative_price').addClass('text-danger');
                            } else {
                                $('#error_tentative_price').text('');
                                $('#label_tentative_price').removeClass('text-danger');
                            }

                            toastr.error('Input gagal, mohon periksa error.');
                        }
                    },
                    error: function(xhr, textStatus, error) {
                        console.error(error);
                    }
                });
            });

            $('.updateBtn').on('click', function() {
                let htmlID = $(this).attr('id');
                let service_id = htmlID.slice(3);
                let estimation = $('#estimation' + service_id).val();
                let gender_service = $('#gender_service' + service_id).val();
                let tentative_price = $('#tentative_price' + service_id).val();
                let price = $('#price' + service_id).val();
                let service_name = $('#service_name' + service_id).val();
                let creator = '{{ Auth::user()->username }}';
                let _token = $('#token').val();

                $.ajax({
                    url: '/admin/service/update/' + service_id,
                    type: 'POST',
                    data: {
                        service_name: service_name,
                        gender_service: gender_service,
                        price: price,
                        tentative_price: tentative_price,
                        estimation: estimation,
                        creator: creator,
                        _token: _token,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 200) {
                            let table_list = $('#table-list').DataTable();
                            table_list.destroy();

                            $('#table-list').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: '{{ '/admin/service/list' }}',
                                columns: [{
                                        data: 'service_name',
                                        name: 'service_name'
                                    },
                                    {
                                        data: 'gender_service',
                                        name: 'gender_service'
                                    },
                                    {
                                        data: 'estimation',
                                        name: 'estimation'
                                    },
                                    {
                                        data: 'price',
                                        name: 'price'
                                    },
                                    {
                                        data: 'tentative_price',
                                        name: 'tentative_price'
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
                    error: function(xhr, textStatus, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
