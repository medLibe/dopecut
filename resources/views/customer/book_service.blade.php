@extends('customer.layout')
@section('content')
    <main id="content">
        <!-- Section 1 -->
        <div class="container-fluid pt-5 mt-5">
            <div class="text-white text-center fs-3 fw-bold mb-3 mt-2" id="text-form">HI
                {{ strtoupper(Auth::user()->name) }}
            </div>
            <div class="text-center">
                <div class="badge mb-2" style="background-color:steelblue" id="step-form">Please pick your services</div>
            </div>

            <form action="/book/create" method="POST">
                @csrf
                <div class="row justify-content-center mt-3">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <th width="40%">Book Date</th>
                                        <td>:</td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Book Date" readonly value="{{ date('d-m-Y', strtotime($book_date)) }}">
                                            <input type="hidden" name="book_date" class="form-control" placeholder="Book Date" readonly value="{{ $book_date }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Book Time</th>
                                        <td>:</td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Book Time" readonly value="{{ $book_time }} WIB">
                                            <input type="hidden" name="book_time" class="form-control" placeholder="Book Time" readonly value="{{ $book_time }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Hair Artist</th>
                                        <td>:</td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Hair Artist" readonly value="{{ $ha_name }}">
                                            <input type="hidden" name="ha_id" class="form-control" placeholder="Hair Artist" readonly value="{{ $ha_id }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Name <b class="text-danger">*</b></th>
                                        <td>:</td>
                                        <td><input type="text" name="name" class="form-control" placeholder="Name" value="{{ Auth::user()->name }}" required autofocus></td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Gender <b class="text-danger">*</b></th>
                                        <td>:</td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Gender" value="{{ $gender == 1 ? 'Man' : 'Woman' }}" readonly>
                                            <input type="hidden" name="gender" class="form-control" placeholder="Gender" readonly value="{{ $gender }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Whatsapp <b class="text-danger">*</b></th>
                                        <td>:</td>
                                        <td><input type="text" name="phone" class="form-control" placeholder="Please fill your number" required></td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Email</th>
                                        <td>:</td>
                                        <td><input type="text" name="email" class="form-control" placeholder="Email" readonly value="{{ Auth::user()->email }}"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-borderless bg-white">
                                    <thead>
                                        <tr>
                                            <th>{{ $gender == 1 ? 'Man' : 'Woman' }}'s Service</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service as $s)
                                            <tr>
                                                <td>
                                                    {{ $s->service_name }}
                                                    <input type="hidden" id="service_name{{ $s->id }}" readonly
                                                        class="form-control" value="{{ $s->service_name }}">
                                                </td>
                                                <td>
                                                    <div class="text-center" id="td-button{{ $s->id }}">
                                                        <button class="btn-choose" id="btn{{ $s->id }}">Choose</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-3 mb-3">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <strong>My Service:</strong>
                                <div class="mt-2">
                                    <ul class="list-group" id="my-service"></ul>
                                    <span id="alert-service" class="text-danger" style="display: none;">Please choose at least one service.</span>
                                </div>
                            </div>
                            <div class="card-footer bg-white text-end" style="border: none;">
                                <button type="button" class="btn btn-sm btn-success" id="book-now">Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure want to book service?
                            </div>
                            <div class="modal-footer justify-content-end">
                                <button type="submit" class="btn btn-sm btn-success btn-confirm">Yes, Book</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row justify-content-center">
                <div class="col-auto text-white fw-bold" style="font-size: 10pt;">
                    You can start from <a href="/book">beginning</a> if you're not sure.
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('.btn-choose').on('click', function() {
                let btnID = $(this).attr('id');
                let service_id = btnID.slice(3);
                let service_name = $('#service_name' + service_id).val();
                $('#alert-service').hide();

                let my_service = '<li class="list-group-item" id="list' + service_id +
                    '"><button class="btn-remove btn btn-sm btn-danger" id="remove' + service_id +
                    '"><i class="fas fa-trash"></i></button>&ensp; ' + service_name + '<input type="hidden" class="form-control" name="service_id[]" value="' + service_id +'" readonly></li>';

                $('#my-service').append(my_service);
                $('#btn' + service_id).prop('disabled', 'true');

                $('#remove' + service_id).on('click', function() {
                    let service_list = '<button class="btn-choose" id="btn' + service_id +
                        '">Choose</button>';
                    $('#list' + service_id).remove();
                    $('#btn' + service_id).removeAttr('disabled');
                });

                $('#book-now').on('click', function() {
                    let check_li = $('#my-service li').length;
                    if(check_li < 1){
                        $('#alert-service').show();
                    }else{
                        $('#alert-service').hide();
                        $('#confirmModal').modal('show');
                    }
                });
            });

            $('#book-now').on('click', function() {
                let check_li = $('#my-service li').length;
                if(check_li < 1){
                    $('#alert-service').show();
                }else{
                    $('#alert-service').hide();
                }
            });
        });
    </script>
@endsection
