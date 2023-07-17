@extends('customer.layout')
@section('content')
    <main id="content">
        <div class="container-fluid pt-5 mt-5" id="container-card">
            <div class="row justify-content-center" id="historyCard">
                @foreach ($history as $h)
                    <div class="col-xxl-6 col-xl-8 col-lg-10 col-md-12 col-sm-12 col-12 mt-3">
                        <div class="card card-card-history">
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 35%;">No. Booking</th>
                                        <td>:</td>
                                        <td style="width: 60%;">{{ $h->book_no }}</td>
                                    </tr>
                                    <tr> 
                                        <th style="width: 35%;">Tanggal</th>
                                        <td>:</td>
                                        <td style="width: 60%;">{{ date('d', strtotime($h->book_date)) }}
                                            {{ $month[date('m', strtotime($h->book_date))] }}
                                            {{ date('Y', strtotime($h->book_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 35%;">Jam</th>
                                        <td>:</td>
                                        <td style="width: 60%;">{{ $h->book_time }} WIB</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 35%;">Whatsapp</th>
                                        <td>:</td>
                                        <td style="width: 60%;">{{ $h->phone == null ? '-' : $h->phone }}</td>
                                    </tr>
                                    {{-- <tr>
                                <th style="width: 35%;">Outlet</th>
                                <td style="width: 50%;">:</td>
                                <td style="width: 35%;">{{ $h->branch_name }}</td>
                            </tr> --}}
                                    <tr>
                                        <th style="width: 35%;">Status</th>
                                        <td>:</td>
                                        @if ($h->is_active == 1)
                                            <td style="width: 60%;"><span class="badge text-bg-primary">Booked</span></td>
                                        @else
                                            <td style="width: 60%;"><span class="badge text-bg-danger">Canceled</span></td>
                                        @endif
                                    </tr>
                                </table>
                                @if ($h->is_active == 1)
                                    <div class="mt-3">
                                        <div class="btn-group">
                                            @if (date('Y-m-d') != $h->book_date)
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal{{ $h->id }}"
                                                    class="btn btn-secondary me-3"
                                                    style="border-radius: 0px;">Cancel</button>
                                            @endif
                                            <button id="{{ $h->book_no }}" class="btn btn-danger btnMail"
                                                style="border-radius: 0px;"><i class="fas fa-envelope"></i> Mail Me</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @foreach ($history as $h1)
            <div class="modal fade" id="cancelModal{{ $h1->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border: none;">
                            <h1 class="modal-title fs-5">Konfirmasi Cancel</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/book/cancel/{{ $h1->id }}" id="cancelForm{{ $h1->id }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" id="label{{ $h1->id }}">Alasan</label>
                                    <textarea name="cancel_reason" id="cancel_reason{{ $h1->id }}" cols="10" rows="3" place
                                        class="form-control" placeholder="Misal: saya ada urusan mendadak di tanggal tersebut" style="resize: none;"></textarea>
                                    <span class="text-danger" id="error{{ $h1->id }}"></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between" style="border: none;">
                            <button type="button" class="btn" data-bs-dismiss="modal"
                                style="border-radius: 0px; border: 1px solid #999;">Close</button>
                            <button type="button" class="btn btn-primary btnCancel" id="btn{{ $h1->id }}"
                                style="border-radius: 0px;">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </main>

    <script>
        $(document).ready(function() {
            $('.btnMail').on('click', function() {
                let book_no = $(this).attr('id');

                $.ajax({
                    url: '/book/send-mail/' + book_no,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-left",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr["success"](response.message);
                    },
                    error: function(xhr, dataText, error) {
                        console.error(error);
                    }
                });
            });

            $(window).scroll(function() {
                var height = $('.navCarousel').height();
                var scrollTop = $(window).scrollTop();
                if (scrollTop >= height - 40) {
                    $('.navbar').addClass('bg-dark-matte');
                } else {
                    $('.navbar').removeClass('bg-dark-matte');
                }
            });

            $('.btnCancel').on('click', function() {
                let htmlID = $(this).attr('id');
                let book_transaction_id = htmlID.slice(3);
                let cancel_reason = $('#cancel_reason' + book_transaction_id).val();

                if (cancel_reason.length === 0) {
                    $('#label' + book_transaction_id).addClass('text-danger');
                    $('#error' + book_transaction_id).text('Input field harus diisi.');
                } else {
                    $('#label' + book_transaction_id).removeClass('text-danger');
                    $('#error' + book_transaction_id).text('');

                    $('#cancelForm' + book_transaction_id).submit();
                }
            });
        });
    </script>
@endsection
