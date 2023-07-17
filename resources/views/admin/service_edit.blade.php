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
                                        @if ($service->thumbnail !== '/assets/image/no-image.png')
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' .  $service->thumbnail) }}" alt="thumbnail-service" id="thumbnail-preview">
                                        @else
                                        <img class="profile-user-img img-fluid img-circle" src="{{ $service->thumbnail }}" alt="thumbnail-service" id="thumbnail-preview">
                                        @endif
                                        <input type="hidden" id="service_id" value="{{ $service->id }}" readonly>
                                    
                                    </div>
                                    <div class="mt-1 text-center">
                                        <label class="btn btn-sm text-secondary">
                                            <i class="fas fa-edit"></i><input type="file" hidden class="form-control" id="thumbnail" accept="image/*">
                                        </label>
                                    </div>
                                </form>

                                <h3 class="profile-username text-center">{{ $service->service_name }}</h3>

                                <p class="text-muted text-center">My Service </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Estimasi</b> 
                                        <a class="float-right text-dark">
                                            @php
                                                $time = $service->estimation;
                                                if($time >= 60){
                                                    $hours = floor($time / 60);
                                                    $minutes = ($time % 60);
                                                    if($minutes == 0){
                                                        $estimation = intval($hours) . ' jam ';
                                                    }else{
                                                        $estimation = intval($hours) . ' jam ' . intval($minutes) . ' menit';
                                                    }
                                                }elseif($time < 60){
                                                    $estimation = $time . ' menit';
                                                }
                                            @endphp
                                            {{ $estimation }}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Harga</b> <a class="float-right text-dark">Rp {{ number_format($service->price, 0, ',', '.') }}</a>
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
                                <h3 class="card-title">Update Service</h3>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <form>
                                        <input type="hidden" class="form-control" id="token_service" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <label class="text-secondary">Service</label>
                                            <input type="text" class="form-control" id="service_name" placeholder="Service" value="{{ $service->service_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-secondary">Estimasi (Satuan Menit)</label>
                                            <input type="text" class="form-control number" id="estimation" placeholder="Estimasi" value="{{ $service->estimation }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-secondary">Harga</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text" class="form-control number" id="price_view" placeholder="Harga" value="{{ number_format($service->price, 0, ',', '.') }}">
                                                <input type="hidden" class="form-control number" readonly id="price" placeholder="Harga" value="{{ floatval($service->price) }}">
                                            </div>
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

                    let service_id = $('#service_id').val();
                    let _token = $('#token_thumbnail').val();
                    let creator = '{{ Auth::user()->username }}';

                    $.ajax({
                        url: '{{ '/admin/service/update-thumbnail/' }}' + service_id,
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
                let service_id = $('#service_id').val();
                let service_name = $('#service_name').val();
                let estimation = $('#estimation').val();
                let price = $('#price').val();
                let _token = $('#token_service').val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/service/update/' }}' + service_id,
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        service_name: service_name,
                        estimation: estimation,
                        price: price,
                        creator: creator,
                    },
                    dataType: 'JSON',
                    success: function(response){
                        if(response.status == 200){
                            const arrId = {'id': service_id};
                            let json = JSON.stringify(arrId);
                            let base64_encode = btoa(json);
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href = '{{ '/admin/service/edit/' }}' + base64_encode;
                            }, 3000);
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
