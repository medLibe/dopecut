<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DopeCut Barbershop | Superior Hair Cut, Nice Services & Best Hair Style</title>

    <!-- CSS -->
    <link rel="icon" type="image/x-icon" href="/assets/image/logo-circle.png">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/book.css" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="/assets/fontawesome/css/all.css">

    <!-- JS -->
    <script id="bootstrap-js" src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
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
                            <a class="nav-link active selected" aria-current="page" href="#">BOOK NOW</a>
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active selected" aria-current="page" href="/book/history">BOOK
                                HISTORY</a>
                        </li>
                        <li class="nav-item navItem mx-3">
                            {{-- Consider if someday have multiple branches --}}
                            {{-- @if (Session::get('branch_id') != null)
                            <a href="/book/cart" class="nav-link active selected position-relative" aria-current="page">
                                <i class="fas fa-book-open fs-4"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="count-cart">
                                    {{ Session::get('countCart') == null ? 0 : Session::get('countCart') }}
                                </span>
                            </a>
                            @else
                            <a href="#" class="nav-link active selected position-relative" id="nullBranchChecker" aria-current="page">
                                <i class="fas fa-book-open fs-4"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="count-cart">
                                    {{ Session::get('countCart') == null ? 0 : Session::get('countCart') }}
                                </span>
                            </a>
                            @endif --}}

                            <a href="/book/cart" class="nav-link active selected position-relative" aria-current="page">
                                <i class="fas fa-book-open fs-4"></i>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    id="count-cart">
                                    {{ Session::get('countCart') == null ? 0 : Session::get('countCart') }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main id="content">
        <!-- Section 1 -->
        <div class="container-fluid pt-5 mt-5">
            <div class="text-center">
                <div class="badge mb-2" style="background-color:steelblue" id="step-form">Choose your services</div>
            </div>
            <div class="text-white text-center fs-3 fw-bold mb-3 mt-2" id="text-form">HI
                {{ strtoupper(Auth::user()->name) }}</div>
            <div class="row justify-content-center mt-3" id="registerSection">

                {{-- Preparation if have more than 1 branch --}}
                {{-- @foreach ($branch as $b)
                <div class="col-md-auto mb-3 branchCard">
                    <div class="card card-form">
                        <img src="/assets/image/index3.jpg" class="img-top img-branch" alt="branch">
                        <div class="card-body card-branch">
                            <h6><i class="fas fa-map-marker-alt" style="color: #eb2020"></i> {{ $b->branch_name }}</h6>
                            <p class="mx-2 mb-3">{{ $b->address }} <br>
                                <i class="fas fa-mobile-alt"></i> {{ $b->phone }}</p>
                            <div class="mb-3">
                                <button type="button" class="branchBtn" id="btn{{ $b->id }}">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach --}}

                @foreach ($service as $s)
                    <div class="col-md-2 col-6 mb-3 serviceCard">
                        <div class="card card-form">
                            @php
                                $time = $s->estimation;
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
                                if ($s->thumbnail !== '/assets/image/no-image.png') {
                                    $thumbnail = asset('storage/' . $s->thumbnail);
                                } else {
                                    $thumbnail = $s->thumbnail;
                                }
                            @endphp
                            <img src="{{ $thumbnail }}" alt="service" class="img-top" width="100%">
                            <div class="card-body card-branch">
                                <div style="font-size: 12pt;">{{ $s->service_name }}</div>
                                <div style="font-size: 14pt; font-weight:bold;" class="mb-2">Rp
                                    {{ number_format($s->price,0,',','.') }}</div>
                                <div class="fst-italic text-secondary mb-3" style="font-size: 10pt;">
                                    {{ $estimation }}</div>
                                <button class="serviceBtn" id="btn{{ $s->id }}">Choose</button>
                                <input type="hidden" readonly id="branch_id{{ $s->id }}"
                                    value="{{ $s->branch_id }}">
                                <input type="hidden" readonly id="service_name{{ $s->id }}"
                                    value="{{ $s->service_name }}">
                                <input type="hidden" readonly id="price{{ $s->id }}"
                                    value="{{ floatval($s->price) }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    {{-- Preparation if have more than 1 branch --}}
    {{-- <script>
        $('.branchBtn').on('click', function() {
            let htmlID = $(this).attr('id');
            let branch_id = htmlID.slice(3);

            $.ajax({
                url: '{{ '/book/branch-service/' }}' + branch_id,
                type: 'GET',
                cache: false,
                dataType: 'JSON',
                success: function(response){
                    var data = response.data;
                    $('#step-form').text('STEP 2');
                    $('#text-form').text('CHOOSE SERVICE');
                    $('.branchCard').hide();

                    if(response.branch_session != null){
                        $('#nullBranchChecker').attr("href", "/book-cart");
                    }

                    for(var i = 0; i < data.length; i++){
                        let format = new Intl.NumberFormat('id-ID');
                        let service_id = data[i].service_id;
                        let service_name = data[i].service_name;
                        let price = data[i].price;
                        let estimation = data[i].estimation + ' menit';
                        let startCol = '<div class="col-md-2 col-6 mb-3 serviceCard">';
                        let endCol = '</div>';
                        let startCard = '<div class="card card-form">';
                        let endCard = '</div>';
                        let image = '<img src="/assets/image/index2.jpg" alt="service" class="img-top">';
                        let startCardBody = '<div class="card-body card-branch">';
                        let endCardBody = '</div>';
                        let serviceName = '<div style="font-size: 12pt;">' + service_name +'</div>';
                        let servicePrice = '<div style="font-size: 14pt; font-weight:bold;" class="mb-2">Rp ' + format.format(parseFloat(price)) +'</div>';
                        let serviceEstimation = '<div class="fst-italic text-secondary mb-3" style="font-size: 10pt;">Estimasi: 30 menit</div>';
                        let buttonChoose = '<button class="serviceBtn" id="btn' + service_id +'">Choose</button>';
                        let inputBranchId = '<input type="hidden" readonly id="branch_id' + service_id +'" value="' + branch_id +'" >';
                        let inputServiceName = '<input type="hidden" readonly id="service_name' + service_id +'" value="' + service_name +'" >';
                        let inputPrice = '<input type="hidden" readonly id="price' + service_id +'" value="' + parseFloat(price) +'" >';
    
                        $('#registerSection').append(startCol + startCard + image + startCardBody + serviceName + servicePrice + serviceEstimation + buttonChoose + inputBranchId + inputServiceName + inputPrice + endCardBody + endCard + endCol);

                    }
                    
                    $('.serviceBtn').on('click', function() {
                        let htmlID = $(this).attr('id');
                        let service_id = htmlID.slice(3);
                        let branch_id = $('#branch_id' + service_id).val();
                        let service_name = $('#service_name' + service_id).val();
                        let price = $('#price' + service_id).val();

                        $.ajax({
                            url: '{{ '/book/service-detail/' }}' + service_id,
                            type: 'GET',
                            cache: false,
                            dataType: 'JSON',
                            success: function(response){
                                var data = response.data;
                                $('#step-form').text('STEP 3');
                                $('#text-form').text('CHOOSE SERVICE');
                                $('.serviceCard').hide();
                                
                                for(var i = 0; i < data.length; i++){
                                    let service_detail_id = data[i].id;
                                    let sd_name = data[i].sd_name;
                                    let url_service = data[i].url_service;

                                    let startCol = '<div class="col-xxl-3 col-xl-4 col-lg-3 col-md-4 col-6 mb-3 serviceCard">';
                                    let endCol = '</div>';
                                    let startCard = '<div class="card card-form">';
                                    let endCard = '</div>';
                                    let image = '<img src="/assets/image/index2.jpg" alt="service-detail" class="img-top">';
                                    let startCardBody = '<div class="card-body card-branch">';
                                    let endCardBody = '</div>';
                                    let serviceName = '<div style="font-size: 8pt;" class="fw-bold">' + service_name +'</div>';
                                    let sdName = '<div style="font-size: 14pt; font-weight:bold;" class="mb-2">' + sd_name +'</div>';
                                    let startBtnGroup = '<div class="btn-group">';
                                    let endBtnGroup = '</div>';
                                    let buttonChoose = '<button class="serviceBtn sdBtn me-2" id="btn' + service_detail_id +'">Choose</button>';
                                    let buttonPreview = '<a href="' + url_service +'" class="previewBtn" target="_blank">Preview</a>';
                                    let inputBranchId = '<input type="hidden" readonly id="branch_id' + service_detail_id +'" value="' + branch_id +'" >';
                                    let inputServiceId = '<input type="hidden" readonly id="service_id' + service_detail_id +'" value="' + service_id +'" >';
                                    let inputPrice = '<input type="hidden" readonly id="price' + service_detail_id +'" value="' + price +'" >';

                                    $('#registerSection').append(startCol + startCard + image + startCardBody + serviceName + sdName + startBtnGroup + buttonChoose + buttonPreview + inputBranchId + inputServiceId + inputPrice + endBtnGroup + endCardBody + endCard + endCol);
                                }

                                $('.sdBtn').on('click', function() {
                                    var htmlID = $(this).attr('id');
                                    var service_detail_id = htmlID.slice(3);
                                    var service_id = $('#service_id' + service_detail_id).val();
                                    var branch_id = $('#branch_id' + service_detail_id).val();
                                    var price = $('#price' + service_detail_id).val();
                                    var _token = $('meta[name="csrf-token"]').attr('content');
                                    var user_id = '{{ Auth::user()->id }}';
                                    var creator = '{{ Auth::user()->name }}';

                                    $.ajax({
                                        url: '{{ '/book/add-to-cart' }}',
                                        type: 'POST',
                                        cache: false,
                                        data: {
                                            _token: _token,
                                            user_id: user_id,
                                            service_detail_id: service_detail_id,
                                            service_id: service_id,
                                            branch_id: branch_id,
                                            price: price,
                                            creator: creator,
                                        },
                                        dataType: 'JSON',
                                        success: function(response){
                                            $('#count-cart').text(response.count);
                                            toastr["success"](response.message);
                                            toastr.options = {
                                                "closeButton": false,
                                                "debug": false,
                                                "newestOnTop": false,
                                                "progressBar": false,
                                                "positionClass": "toast-top-right",
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

                                            setTimeout(() => {
                                                location.reload();
                                            }, 3000);
                                        }
                                    });
                                });
                            }
                        });
                    });
                }
            });

            $('#refreshPage').show();
        });

        $('#refreshBtn').on('click', function() {
            $('#content').load('#content');
        });

        $('#nullBranchChecker').on('click', function() {
            toastr["warning"]('Pilih outlet terlebih dahulu.');
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
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
        });
    </script> --}}

    <script>
        $('.serviceBtn').on('click', function() {
            let htmlID = $(this).attr('id');
            let service_id = htmlID.slice(3);
            let service_name = $('#service_name' + service_id).val();
            let price = $('#price' + service_id).val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            var user_id = '{{ Auth::user()->id }}';
            var creator = '{{ Auth::user()->name }}';

            $.ajax({
                url: '{{ '/book/add-to-cart' }}',
                type: 'POST',
                cache: false,
                data: {
                    _token: _token,
                    user_id: user_id,
                    service_id: service_id,
                    price: price,
                    creator: creator,
                },
                dataType: 'JSON',
                success: function(response) {
                    $('#count-cart').text(response.count);
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

        // $('#refreshBtn').on('click', function() {
        //     $('#content').load('#content');
        // });

        // $('#setBranchId').on('click', function() {
        //     sessionStorage.setItem('branch_id', 1);
        //     window.location.href = '/book/cart';
        // });
    </script>
</body>

</html>
