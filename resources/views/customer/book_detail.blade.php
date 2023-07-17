@extends('customer.layout')
@section('content')
    <main id="content">
        <div class="container-fluid pt-5 mt-5" id="container-card">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-book">
                        <div class="card-header header-book">
                            <h4 class="card-title fw-bold">Booking Details &nbsp;#{{ $transaction->book_no }}</h4>
                        </div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td class="text-secondary fw-bold" style="width: 50%">Tanggal</td>
                                    <td style="width: 5%">&nbsp;:&nbsp;</td>
                                    <td class="text-dark fw-bold">
                                        {{ date('d', strtotime($transaction->book_date)) . ' ' . $month[date('m', strtotime($transaction->book_date))] . ' ' . date('Y', strtotime($transaction->book_date)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-bold" style="width: 50%">Jam</td>
                                    <td style="width: 5%">&nbsp;:&nbsp;</td>
                                    <td class="text-dark fw-bold">{{ $transaction->book_time }} WIB</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-bold" style="width: 50%">Hair Artist</td>
                                    <td style="width: 5%">&nbsp;:&nbsp;</td>
                                    <td class="text-dark fw-bold">{{ $transaction->ha_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-bold" style="width: 50%">Customer</td>
                                    <td style="width: 5%">&nbsp;:&nbsp;</td>
                                    <td class="text-dark fw-bold">{{ $transaction->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-bold" style="width: 50%">Gender</td>
                                    <td style="width: 5%">&nbsp;:&nbsp;</td>
                                    <td class="text-dark fw-bold">{{ $transaction->gender == 1 ? 'Man' : 'Woman' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-bold" style="width: 50%">Whatsapp</td>
                                    <td style="width: 5%">&nbsp;:&nbsp;</td>
                                    <td class="text-dark fw-bold">{{ $transaction->phone }}</td>
                                </tr>
                            </table>

                            <div class="mt-3 mb-3">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Service</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction_detail as $td)
                                            <tr>
                                                <td class="text-center">{{ $td->service_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end">
                                <div class="btn-group">
                                    <button id="{{ $transaction->book_no }}" class="btn btn-danger btnMail"
                                        style="border-radius: 0px;"><i class="fas fa-envelope"></i> Mail Me</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {

            $(window).scroll(function() {
                var height = $('.navCarousel').height();
                var scrollTop = $(window).scrollTop();
                if (scrollTop >= height - 40) {
                    $('.navbar').addClass('bg-dark-matte');
                } else {
                    $('.navbar').removeClass('bg-dark-matte');
                }
            });

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
        });
    </script>
@endsection
