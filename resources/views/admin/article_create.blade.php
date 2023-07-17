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
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="submit" class="btn btn-primary" id="btnCreate"><i class="fas fa-plus"></i> Artikel</button>
                                </h3>
                            </div>
                            <div class="card-body">
                                <form>
                                    <input type="hidden" class="form-control" readonly id="_token" value="{{ csrf_token() }}">
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label" id="label_title">Judul</label>
                                        <input type="text" class="form-control" id="title" placeholder="Judul">
                                        <span class="text-danger" id="error_title"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="author" class="form-label" id="label_author">Penulis</label>
                                        <input type="text" class="form-control" id="author" placeholder="Penulis" value="{{ Auth::user()->name }}">
                                        <span class="text-danger" id="error_author"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="craeted_at" class="form-label">Dibuat Pada</label>
                                        <input type="text" class="form-control" id="created_at" placeholder="Dibuat Pada" value="{{ date('d F Y') }}" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label" id="label_image_headline">Gambar Headline (200px*300px)</label>
                                        <input type="file" class="form-control" id="image_headline" accept="image/*">
                                        <div class="mt-2" id="preview"></div>
                                        <span class="text-danger" id="error_image_headline"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label" id="label_content_headline">Konten Headline (Maksimal 255 Karakter, Jumlah : <span id="content_headline_counter">0</span> Karakter)</label>
                                        <input type="text" class="form-control" id="content_headline" placeholder="Konten Headline">
                                        <span class="text-danger" id="error_content_headline"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="content" class="form-label" id="label_content">Konten</label>
                                        <textarea id="content">
                                            Tulis artikelmu sekarang...
                                        </textarea>
                                        <span class="text-danger" id="error_content"></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#content_headline').on('keyup paste', function() {
                setTimeout(() => {
                    const counter_string = this.value.length;
                    $('#content_headline_counter').text(counter_string);

                    if(counter_string > 255){
                        $('#error_content_headline').text('Jika lebih dari 255 karakter maka akan terpotong otomatis setelah di simpan.');
                    }else{
                        $('#error_content_headline').text('');
                    }
                }, 100);
            });

            // $('#content').summernote();
            $('#content').summernote({
                placeholder: 'Tulis artikelmu sekarang...',
                tabsize: 2,
                height: 300,
                toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
                ]
            });

            $('#image_headline').on('change', function(e) {
                const file = e.target.files[0];

                // read file with FileReader
                const reader = new FileReader();
                reader.onload = function() {
                    // make img element to image preview
                    const imgElement = $('<img id="imgPreview" style="width: 300px; height: 200px;">').attr('src', reader.result);
                    $('#preview').html(imgElement);
                }

                // read file as data URL
                reader.readAsDataURL(file);
            });

            $('#btnCreate').on('click', function() {
                const fileInput = $('#image_headline')[0];
                const file = fileInput.files[0];
                const title = $('#title').val();
                const author = $('#author').val();
                const content = $('#content').val();
                const content_headline = $('#content_headline').val();
                const _token = $('#_token').val();

                // create object FormData
                const formData = new FormData();
                formData.append('image_headline', file);
                formData.append('title', title);
                formData.append('author', author);
                formData.append('content', content);
                formData.append('content_headline', content_headline);
                formData.append('_token', _token);

                $.ajax({
                    url: '/admin/article/create',
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: formData,
                    success: function(response){
                        if(response.status == 200){
                            toastr.success(response.message);
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };

                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 5000);
                            console.log(response);
                        }else{
                            if (typeof(response.message.title) !== 'undefined') {
                                $('#error_title').text(response.message.title);
                                $('#label_title').addClass('text-danger');
                            } else {
                                $('#error_title').text('');
                                $('#label_title').removeClass('text-danger');
                            }

                            if (typeof(response.message.author) !== 'undefined') {
                                $('#error_author').text(response.message.author);
                                $('#label_author').addClass('text-danger');
                            } else {
                                $('#error_author').text('');
                                $('#label_author').removeClass('text-danger');
                            }

                            if (typeof(response.message.content) !== 'undefined') {
                                $('#error_content').text(response.message.content);
                                $('#label_content').addClass('text-danger');
                            } else {
                                $('#error_content').text('');
                                $('#label_content').removeClass('text-danger');
                            }

                            if (typeof(response.message.image_headline) !== 'undefined') {
                                $('#error_image_headline').text(response.message.image_headline);
                                $('#label_image_headline').addClass('text-danger');
                            } else {
                                $('#error_image_headline').text('');
                                $('#label_image_headline').removeClass('text-danger');
                            }

                            if (typeof(response.message.content_headline) !== 'undefined') {
                                $('#error_content_headline').text(response.message.content_headline);
                                $('#label_content_headline').addClass('text-danger');
                            } else {
                                $('#error_content_headline').text('');
                                $('#label_content_headline').removeClass('text-danger');
                            }

                            toastr.error('Input gagal, mohon periksa error.');
                        }
                    },
                    error: function(xhr, status, error){
                        console.error(xhr);
                    }
                });

            });
        });
    </script>
@endsection
