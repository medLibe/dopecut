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
                            <li class="breadcrumb-item"><a href="/admin/service">Service</a></li>
                            <li class="breadcrumb-item active">{{ $page }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <style>

        </style>

        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <form>
                                    <input type="hidden" class="form-control" id="token_thumbnail" value="{{ csrf_token() }}">
                                    <div class="text-center">
                                        @if ($sdetail->thumbnail !== '/assets/image/no-image.png')
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' .  $sdetail->thumbnail) }}" alt="thumbnail-service" id="thumbnail-preview">
                                        @else
                                        <img class="profile-user-img img-fluid img-circle" src="{{ $sdetail->thumbnail }}" alt="thumbnail-service" id="thumbnail-preview">
                                        @endif
                                        <input type="hidden" id="service_detail_id" value="{{ $sdetail->id }}" readonly>
                                    
                                    </div>
                                    <div class="mt-1 text-center">
                                        <label class="btn btn-sm text-secondary">
                                            <i class="fas fa-edit"></i><input type="file" hidden class="form-control" id="thumbnail" accept="image/*">
                                        </label>
                                    </div>
                                </form>

                                <h3 class="profile-username text-center">{{ $sdetail->sd_name }}</h3>

                                <p class="text-muted text-center">{{ $sdetail->service_name }} </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Link (IG/Youtube/Tiktok)</b> 
                                        @if($sdetail->url_service != null)
                                        <a href="{{ $sdetail->url_service }}" class="float-right">Click Here</a>
                                        @else
                                        <a class="float-right text-dark">N/A</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title">Update Sub Service</h3>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <form>
                                        <input type="hidden" class="form-control" id="token_service_detail" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <label class="text-secondary">Service</label>
                                            <select id="service_id" class="custom-select">
                                                <option value="{{ $sdetail->service_id }}">{{ $sdetail->service_name }}</option>
                                                @foreach ($service as $s)
                                                <option value="{{ $s->id }}">{{ $s->service_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-secondary" id="label_sd_name">Sub Service</label>
                                            <input type="text" class="form-control" id="sd_name" placeholder="Sub Service" value="{{ $sdetail->sd_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-secondary" id="label_url_service">Link (IG/Youtube/Tiktok)</label>
                                            <input type="text" class="form-control" id="url_service" placeholder="Link (IG/Youtube/Tiktok)" value="{{ $sdetail->url_service }}">
                                            <span class="text-danger" id="error_url_service" style="font-size: 10pt;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-secondary">Keterangan</label>
                                            <textarea id="description" cols="10" rows="2" class="form-control" placeholder="Keterangan" style="resize: none;">{{ $sdetail->description }}</textarea>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-primary" id="updateBtn">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#thumbnail").on("change", function () {
                let file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(e){
                    $('#thumbnail-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);

                let imageURL = URL.createObjectURL(file);
                let img = new Image();
                img.src = imageURL;

                img.onload = function() {
                    let canvas = document.createElement('canvas');

                    let MAX_WIDTH = 600;
                    let MAX_HEIGHT = 600;
                    let width = img.width;
                    let height = img.height;

                    if(width > height){
                        if(width > MAX_WIDTH){
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }
                    }else{
                        if(height > MAX_HEIGHT){
                            width *= MAX_HEIGHT / height;
                            height = MAX_HEIGHT;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;

                    let ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    let fileType = file.type;
                    let dataURL = canvas.toDataURL(fileType);

                    let service_detail_id = $('#service_detail_id').val();
                    let _token = $('#token_thumbnail').val();
                    let creator = '{{ Auth::user()->username }}';

                    $.ajax({
                        url: '{{ '/admin/sub-service/update-thumbnail/' }}' + service_detail_id,
                        type: 'POST',
                        cache: false,
                        data: {
                            thumbnail: dataURL,
                            _token: _token,
                            creator: creator,
                        },
                        success: function(response){
                            if(response.status == 200){
                                toastr.success(response.message);
                            }else{
                                toastr.warning(response.message);
                            }
                        },
                        error: function(xhr, textStatus, error){
                            console.error(error);
                        }
                    });

                }
            });

            $("#updateBtn").on('click', function() {
                let service_detail_id = $('#service_detail_id').val();
                let service_id = $('#service_id').val();
                let sd_name = $('#sd_name').val();
                let url_service = $('#url_service').val();
                let description = $('#description').val();
                let _token = $('#token_service_detail').val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/sub-service/update/' }}' + service_detail_id,
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        service_id: service_id,
                        sd_name: sd_name,
                        url_service: url_service,
                        description: description,
                        creator: creator,
                    },
                    dataType: 'JSON',
                    success: function(response){
                        if(response.status == 200){
                            const arrId = {'id': service_id};
                            let json = JSON.stringify(arrId);
                            let base64_encode = btoa(json);
                            toastr.success(response.message);
                            // setTimeout(() => {
                            //     window.location.href = '{{ '/admin/service/edit/' }}' + base64_encode;
                            // }, 3000);
                            $('.content').load('.content');
                        }else if(response.status == 404){
                            toastr.error(response.message);
                        }else{
                            toastr.error('Input gagal, mohon periksa error.');
                            if(typeof(response.message.url_service) !== 'undefined'){
                                $('#error_url_service').text(response.message.url_service);
                                $('#label_url_service').addClass('text-danger');
                            }else{
                                $('#error_url_service').text('');
                                $('#label_url_service').removeClass('text-danger');
                            }
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
