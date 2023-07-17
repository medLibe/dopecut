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
                        <div class="mb-3">
                            <a href="/admin/hair-artist" class="btn btn-default"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
                        </div>

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <form>
                                    <input type="hidden" class="form-control" id="token_profile" value="{{ csrf_token() }}">
                                    <div class="text-center">
                                        @if ($ha->profile_picture !== '/assets/image/no-image.png')
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' .  $ha->profile_picture) }}" alt="profile_picture" id="profile-preview">
                                        @else
                                        <img class="profile-user-img img-fluid img-circle" src="{{ $ha->profile_picture }}" alt="profile_picture" id="profile-preview">
                                        @endif
                                        <input type="hidden" id="ha_id" value="{{ $ha->id }}" readonly>
                                    
                                    </div>
                                    <div class="mt-1 text-center">
                                        <label class="btn btn-sm text-secondary">
                                            <i class="fas fa-edit"></i><input type="file" hidden class="form-control" id="profile_picture" accept="image/*">
                                        </label>
                                    </div>
                                </form>

                                <h3 class="profile-username text-center">{{ $ha->ha_name }}</h3>

                                <p class="text-muted text-center"><i class="fas fa-star" style="color: gold;"></i> {{ $ha->rating }} </p>
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
                                <h3 class="card-title">Update Hair Artist</h3>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <form>
                                        <input type="hidden" class="form-control" id="token_service_detail" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <label class="text-secondary">Hair Artist</label>
                                            <input type="text" class="form-control" id="ha_name" placeholder="Hair Artist" value="{{ $ha->ha_name }}">
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
            $("#profile_picture").on("change", function () {
                let file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(e){
                    $('#profile-preview').attr('src', e.target.result);
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

                    let ha_id = $('#ha_id').val();
                    let _token = $('#token_profile').val();
                    let creator = '{{ Auth::user()->username }}';

                    $.ajax({
                        url: '{{ '/admin/hair-artist/update-profile/' }}' + ha_id,
                        type: 'POST',
                        cache: false,
                        data: {
                            profile_picture: dataURL,
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
                let ha_id = $('#ha_id').val();
                let ha_name = $('#ha_name').val();
                let _token = $('#token_service_detail').val();
                let creator = '{{ Auth::user()->username }}';

                $.ajax({
                    url: '{{ '/admin/hair-artist/update/' }}' + ha_id,
                    type: 'POST',
                    cache: false,
                    data: {
                        _token: _token,
                        ha_name: ha_name,
                        creator: creator,
                    },
                    dataType: 'JSON',
                    success: function(response){
                        if(response.status == 200){
                            const arrId = {'id': ha_id};
                            let json = JSON.stringify(arrId);
                            let base64_encode = btoa(json);
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href = '{{ '/admin/hair-artist/edit/' }}' + base64_encode;
                            }, 2000);
                        }else{
                            toastr.error(response.message);
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
