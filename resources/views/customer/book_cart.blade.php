<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dopecut Barbershop | Superior Hair Cut, Nice Services & Best Hair Style</title>

    <!-- CSS -->
    <link rel="icon" type="image/x-icon" href="/assets/image/logo-circle.png">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/book.css" rel="stylesheet">

    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="/assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/dark-hive/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- <script src="/assets/js/home.js"></script> --}}
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark py-3 fixed-top navCarousel">
            <div class="container-fluid">
                <a class="navbar-brand dope" href="/">DOPECUT</a>
                <div id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active" aria-current="page" href="/">HOME</a>
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active" aria-current="page" href="/book">BOOK NOW</a>
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active" aria-current="page" href="/book/history">BOOK HISTORY</a>
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a href="/book/cart" class="nav-link active selected position-relative" aria-current="page">
                                <i class="fas fa-book-open fs-4"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="count-cart">{{ Session::get('countCart') == null ? 0 : Session::get('countCart') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main id="content">
        <div class="container-fluid pt-5 mt-5" id="container-card">
            <div class="row justify-content-center" id="cartCard">
                <div class="col-xxl-8 col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 mt-3">
                    <div class="card card-cart mb-2">
                        {{-- <div class="card-header header-cart">
                            <span class="card-title">{{ $branch->branch_name }}</span>
                        </div> --}}
                        @if ($cart->isNotEmpty())
                            @php
                                $sumPrice = 0;
                                $sumEstimation = 0;
                            @endphp
                            @foreach ($cart as $c) 
                            @php
                                $sumPrice += $c->price;
                                $sumEstimation += $c->estimation;
                                $time = $c->estimation;
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

                                if($sumEstimation >= 60){
                                    $hours = floor($sumEstimation / 60);
                                    $minutes = ($sumEstimation % 60);
                                    if($minutes == 0){
                                        $sumTimeEstimation = intval($hours) . ' jam';
                                    }else{
                                        $sumTimeEstimation = intval($hours) . ' jam ' . intval($minutes) . ' menit';
                                    }
                                }elseif($sumEstimation < 60){
                                    $sumTimeEstimation = $sumEstimation . ' menit';
                                }

                                if ($c->thumbnail !== '/assets/image/no-image.png') {
                                    $thumbnail = asset('storage/' . $c->thumbnail);
                                } else {
                                    $thumbnail = $c->thumbnail;
                                }
                            @endphp
                            <div class="row g-0 mt-3 mb-3 underline-row-cart pe-5 ps-5 rowCart" id="rowCart{{ $c->id }}">
                                <div class="col-md-3 col-sm-4 col-auto">
                                    <img src="{{ $thumbnail }}" alt="cart-list" class="img-fluid" style="width: 100%;">
                                </div>
                                <div class="col-md-9 col-sm-8 col-12">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">{{ $c->service_name }}</h5>
                                        <div class="card-text fw-bold mb-3">
                                            {{ 'Rp ' . number_format(floatval($c->price), 0,',','.') }}
                                            <input type="hidden" readonly id="price{{ $c->id }}" value="{{ floatval($c->price) }}">
                                        </div>
                                        <div class="card-text">
                                            <small class="text-muted fst-italic">
                                            Estimasi waktu: {{ $estimation }}
                                            <input type="hidden" readonly id="estimation{{ $c->id }}" value="{{ $c->estimation }}">
                                            </small>
                                        </div>
                                        <div class="card-text text-end">
                                            <button class="btn btn-sm btn-danger removeBtn" id="btn{{ $c->id }}"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="card-footer footer-cart">
                                <div class="row justify-content-start">
                                    <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-4">
                                        <table>
                                            <tr>
                                                <th style="width: 40%">Total Estimasi</th>
                                                <td>:</td>
                                                <td style="width: 40%" class="text-end"><span id="total-estimation-view">{{ $sumTimeEstimation }}</span>
                                                    <input type="hidden" id="total-estimation" value="{{ $sumEstimation }}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 40%">Total Harga</th>
                                                <td>:</td>
                                                <td style="width: 30%" class="text-end">
                                                    <span id="total-price-view">{{ 'Rp ' . number_format(floatval($sumPrice), 0,',','.') }}</span>
                                                    <input type="hidden" id="total-price" value="{{ $sumPrice }}" readonly>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card-footer footer-cart">
                                <div class="row justify-content-end">
                                    <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-4">
                                        <table>
                                            <tr>
                                                <th style="width: 35%">Total Estimasi</th>
                                                <td class="text-end">:</td>
                                                <td style="width: 35%" class="text-end"><span id="total-estimation-view">0 menit</span>
                                                    <input type="hidden" id="total-estimation" value="0" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 30%">Total Harga</th>
                                                <td class="text-end">:</td>
                                                <td style="width: 30%" class="text-end">
                                                    <span id="total-price-view">Rp 0</span>
                                                    <input type="hidden" id="total-price" value="0" readonly>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($cart->isNotEmpty())
                        <div class="text-white text-end mb-3">
                            <div class="btn-group">
                                <a href="/book" class="btn backToBookBtn">Not Sure</a>
                                <button type="button" class="btn ms-3 bookNowBtn">Book Now</button>
                            </div>
                        </div>
                    @else
                        <div class="text-white text-end mb-3">
                            <div class="btn-group">
                                <a href="/book" class="btn backToBookBtn">Add More</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center" id="hairartistCard" style="display: none;">
                <div class="text-white text-center fs-3 fw-bold mb-3" id="text-form">PICK OUR CREW</div>
                <div class="col-auto col-sm-4 col-md-3 col-lg-auto col-xl-2 col-xxl-auto mt-3 mb-3">
                    <div class="card card-hairartist text-center">
                        <div class="card-body">
                            <span class="badge text-bg-primary mb-2">Pick Random</span> <br>
                            <img src="/assets/image/kapster.jpg" alt="hairartist" class="img-rounded mb-2" style="width:100px;"> <br>
                            <input type="button" class="btn hairartist-name pickBtn" value="Anyone" id="ha0">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center" id="scheduleCard" style="display: none;">
                <div class="text-white text-center fs-3 fw-bold mb-3" id="text-form">SET A SCHEDULE</div>
                <div class="col-12 mb-3">
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-6 col-md-10 col-lg-8 col-xl-6">
                            <div class="card card-schedule text-center">
                                <div class="row justify-content-center my-5">
                                    <div class="col-auto mb-3">
                                        <div id="schedule_date" class="mx-auto input-group"></div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-8" id="container-schedule">
                                        <div class="fw-bold fs-5 mb-3">Barberman Tersedia</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-white text-center" style="display: none;" id="refreshPage">Gak yakin sama Barbermannya? Yuk pilih <a href="#" id="refreshBtn">ulang</a>.</div> 
        </div>         
    </main>

    <script>
        $('.removeBtn').on('click', function() {
            let htmlID = $(this).attr('id');
            let cart_id = htmlID.slice(3);
            let count_cart = $('#count-cart').text();
            let total_price = $('#total-price').val();
            let estimation = $('#estimation' + cart_id).val();
            let price = $('#price' + cart_id).val();
            let total_estimation = $('#total-estimation').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            let creator = '{{ Auth::user()->name }}';
            
            $.ajax({
                url: '{{ '/book/remove-from-cart/' }}' + cart_id,
                type: 'POST',
                cache: false,
                data: {
                    _token: _token,
                    count_cart: count_cart,
                    estimation: estimation,
                    price: price,
                    total_price: total_price,
                    total_estimation: total_estimation,
                    creator: creator,
                },
                dataType: 'JSON',
                success: function(response){
                    $('#count-cart').text(response.count);
                    $('#total-estimation-view').text(response.total_estimation_view);
                    $('#total-estimation').val(response.total_estimation);
                    $('#total-price-view').text(response.total_price_view);
                    $('#total-price').val(response.total_price);
                    $('#rowCart' + cart_id).remove();

                    let rowLength = $('.rowCart').length;
                    if(rowLength < 1){
                        $('.bookNowBtn').remove();
                    }

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
                }
            });
        });

        $('.bookNowBtn').on('click', function() {
            $.ajax({
                url: '{{ '/book/hair-artist/' }}',
                type: 'GET',
                cache: false,
                dataType: 'JSON',
                success: function(response){
                    var data = response.data;
                    $('#cartCard').hide();
                    $('#hairartistCard').show();
                    
                    for(var i = 0; i < data.length; i ++){
                        let profile_picture;
                        if(data[i].profile_picture != '/assets/image/no-image.png'){
                            profile_picture = '{{ asset('storage/') }}' + '/' + data[i].profile_picture;
                        }else{
                            profile_picture = data[i].profile_picture;
                        }
                        let ha_id = data[i].id;
                        let ha_name = data[i].ha_name;
                        let is_active = data[i].is_active;
                        let status;
                        let isClass;

                        if(is_active == 1){
                            isClass = 'text-bg-success';
                            status = 'Available';
                        }else{
                            isClass = 'text-bg-danger';
                            status = 'Busy';
                        }
                        let startCol = '<div class="col-auto col-sm-4 col-md-3 col-lg-auto col-xl-2 col-xxl-auto mt-3 mb-3">';
                        let endCol = '</div>';
                        let startCard = '<div class="card card-hairartist text-center">';
                        let endCard = '</div>';
                        let startCardBody = '<div class="card-body">';
                        let endCardBody = '</div>';
                        let imageProfile = '<img src="' + profile_picture +'" alt="hairartist" class="img-rounded mb-2" style="height:100px; width:100px;"> <br>';
                        let spanName = '<input type="button" class="btn hairartist-name pickBtn" value="' + ha_name +'" id="ha' + ha_id +'">';
                        let haStatus = '<span class="badge ' + isClass +' mb-2 fw-bold">' + status +'</span> <br>';

                        $('#hairartistCard').append(startCol + startCard + startCardBody + haStatus + imageProfile + spanName + endCardBody + endCard + endCol);
                    }

                    $('.pickBtn').on('click', function() {
                        let htmlID = $(this).attr('id');
                        let ha_id = htmlID.slice(2);
                        let user_id = '{{ Auth::user()->id }}';
                        let creator = '{{ Auth::user()->name }}';

                        $('#hairartistCard').hide();
                        $('#scheduleCard').show();

                        $('#schedule_date').datepicker({
                            todayHighlight: false,
                            dateFormat: 'yy-mm-dd',
                            minDate: '0',
                            maxDate: '+2',
                            onSelect: function pickedDate(dateText){
                                let picked_date = dateText;
                                $.ajax({
                                    url: '{{ '/book/ha-schedule/' }}',
                                    type: 'GET',
                                    cache: false,
                                    data: {
                                        picked_date: picked_date,
                                        ha_id: ha_id,
                                    },
                                    dataType: 'JSON',
                                    success: function(response){
                                        if(response.status == 200){
                                            $('#container-schedule').find('.timeBtn').remove();
                                            let data = response.data;
                                            let hair_artist_id = response.ha_id;
                                            for(var i = 0; i < data.length; i++){
                                                let schedule = data[i].time;
                                                let type = data[i].type;
                                                let className;
                                                let today = new Date();
                                                let date_now = today.toISOString().slice(0, 10);
                                                let now = today.getHours()+ "." + today.getMinutes();
                                                
                                                if(picked_date == date_now){
                                                    if(now < schedule){
                                                        let input_schedule = '<input type="button" class="btn btn-sm text-white bg-dark-matte timeBtn mb-3 mx-1" value="' + schedule +'">';
                                                        $('#container-schedule').append(input_schedule);
                                                    }else{
                                                        let input_schedule = '';
                                                        $('#container-schedule').append(input_schedule);
                                                    }
                                                }else{
                                                    let input_schedule = '<input type="button" class="btn btn-sm text-white bg-dark-matte timeBtn mb-3 mx-1" value="' + schedule +'">';
                                                    $('#container-schedule').append(input_schedule);
                                                }
    
                                            }
    
                                            $('.timeBtn').on('click', function() {
                                                let time = $(this).val();
                                                _token = $('meta[name="csrf-token"]').attr('content');

                                                $.ajax({
                                                    url: '/book/create',
                                                    type: 'POST',
                                                    cache: false,
                                                    data: {
                                                        _token: _token,
                                                        user_id: user_id,
                                                        hair_artist_id: hair_artist_id,
                                                        book_date: picked_date,
                                                        book_time: time,
                                                    },
                                                    success: function(response){
                                                        if(response.status == 200){
                                                            let book_transaction_no = response.book_transaction_no;
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

                                                            setTimeout(function() {
                                                                window.location.href = '/book/detail/' + book_transaction_no;
                                                            }, 3000);
                                                        }
                                                    }
                                                });
                                            });
                                        }else{
                                            toastr["error"](response.message);
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
                                        }
                                    }
                                });
                            }
                        });

                        $('#refreshPage').show();
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#refreshBtn').on('click', function() {
                $('#content').load('#content');
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
        });
    </script>
</body>

</html>
