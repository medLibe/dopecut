<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dopecut Hairstudio: Jakarta Pusat</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Dopecut Hair Studio didirikan pada tahun 2023 untuk melayani hair service untuk pria.">
    <meta name="keywords"
        content="dopecut, dopecuthairstudio, hair studio, barberman, hair artist, potong rambut pria, potong rambut, potong rambut tanah abang, tanah abang, jakarta, jakarta pusat">
    <meta name="google-site-verification" content="YOEppHJk69BMbN_ZApfcfeDOcN0wCBvcih-kOCFdSSU" />
    <meta name="robots" content="index, follow">

    <!-- CSS -->
    <link rel="icon" type="image/x-icon" href="/assets/image/logo-circle.png">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/home.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="/assets/fontawesome/css/all.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark-matte py-3 fixed-top" id="topNav">
            <div class="container-fluid">
                <a class="navbar-brand" href="https://dopecutbarbershop.com">
                    <img src="/assets/image/logo-brand.png" alt="Dopecut" class="brand-image">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item navItem mx-auto">
                            @if (!empty(Auth::user()))
                                <a class="nav-link active" href="/book">BOOK</a>
                            @else
                                <a class="nav-link active" href="/login/google">BOOK</a>
                            @endif
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active" data-bs-toggle="modal"
                                data-bs-target="#PriceListAndService">PRICE LIST</a>
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active" data-bs-toggle="modal"
                                data-bs-target="#PriceListAndService">SERVICES</a>
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active" href="/article">BLOG</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main class="container-fluid">
        <!-- Section 1 -->
        <div class="row justify-content-center" id="HeadIntro">
            <div class="text-white text-center" id="jumbotron-intro">
                <div class="my-5" style="font-size: 24pt"><strong>DOPECUT <br> BEST HAIR STUDIO IN CENTRAL
                        JAKARTA</strong></div>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="row" id="Services">
            <div class="p-5" id="jumbotron-service">
                <h1 class="text-center mb-5"><strong>SERVICES</strong></h1>
                <div class="row justify-content-center text-center">
                    <div class="col-xl-auto col-lg-auto col-md-auto col-12 mb-3">
                        <div class="position-relative">
                            <img src="/assets/image/home_haircut.jpg" class="img-service" alt="Haircut">
                            <div class="overlay d-flex align-items-center justify-content-center">
                                <div class="service-name">HAIRCUT</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-auto col-lg-auto col-md-auto col-12 mb-3">
                        <div class="position-relative">
                            <img src="/assets/image/home_color.jpg" class="img-service"
                                alt="Hair Color image by pressfoto on Freepik https://www.freepik.com/free-photo/cropped-hairstylist-giving-final-touch-hairdo-male-client_5839684.htm#page=3&query=hair%20color%20man&position=19&from_view=search&track=ais">
                            <div class="overlay d-flex align-items-center justify-content-center">
                                <div class="service-name">HAIR COLOR</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-auto col-lg-auto col-md-auto col-12 mb-3">
                        <div class="position-relative">
                            <img src="/assets/image/home_shaving.jpg" class="img-service" alt="Shaving">
                            <div class="overlay d-flex align-items-center justify-content-center">
                                <div class="service-name">SHAVING</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-auto col-lg-auto col-md-auto col-12 mb-3">
                        <div class="position-relative">
                            <img src="/assets/image/home_more.jpg" class="img-service"
                                alt="More Service image on Freepik https://www.freepik.com/free-photo/side-view-professional-arranging-bride-s-hair_32298591.htm#query=hair%20service&position=32&from_view=search&track=ais">
                            <div class="overlay d-flex align-items-center justify-content-center">
                                <div class="service-name">AND MORE</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3 -->


        <!-- Section 4 -->
        <div class="row justify-content-center" id="Book">
            <div class="text-white text-center" id="jumbotron-book">
                <div class="fs-3 mb-5"><strong>WALKIN'S ARE GOOD, <br> BUT BETTER TO BOOK!</strong></div>
                @if (!empty(Auth::user()))
                    <a href="/book" id="book-now">BOOK NOW!</a>
                @else
                    <a href="/login/google" id="book-now">BOOK NOW!</a>
                @endif
            </div>
        </div>
        <div class="row justify-content-center" id="Blog">
            <div class="p-5" id="jumbotron-blog">
                <h1 class="text-center mb-5"><strong><a href="/article" class="text-dark" style="text-decoration:none;">BLOG</a></strong></h1>
                <div class="row justify-content-center">
                    @foreach ($article as $a)
                        <div class="col-auto col-md-auto mb-3">
                            <div class="card-article card shadow" style="width: 18rem;">
                                {!! $a->image_headline !!}
                                <div class="card-body">
                                    <span class="blog-tag">Dopecut's Blog</span>
                                    <h5 class="card-title mt-3 fw-bold"><a href="/article/{{ $a->slug }}"
                                            class="text-dark hit-link" id="{{ $a->slug }}"
                                            style="text-decoration: none;">{{ $a->title }}</a></h5>
                                    <p class="card-text mb-3" style="font-size: 10pt;">
                                        @if (strlen($a->content_headline) > 50)
                                            {{ substr($a->content_headline, 0, 50) . '...' }}
                                        @else
                                            {{ $a->content_headline }}
                                        @endif
                                    </p>
                                    <div class="end-card">
                                        <span class="author-tag blog-card-footer">oleh
                                            <strong>{{ $a->author }}</strong></span>
                                        <span
                                            class="date-tag blog-card-footer">{{ date('d M Y', strtotime($a->created_at)) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section 5 -->
        {{-- Google Place ID : ChIJuQ6sGhj3aS4RTDlw-5aX3Nc --}}
        <div class="row" id="Reviews">
            <div class="p-5" id="jumbotron-review">
                <h1 class="text-center mb-5"><strong>REVIEWS</strong></h1>
                <div class="row justify-content-center text-center" id="google-review">
                </div>
            </div>
        </div>
    </main>

    <footer class="container-fluid">
        <!-- Section 6 -->
        <div class="row justify-content-center" id="AboutUs">
            <div class="col-md-4 col-12 mb-3">
                <div class="dope text-center"><img src="/assets/image/logo-transparent.png" alt="brand-image" style="max-width: 60%;"></div>
                <div class="text-center"><a class="text-white" href="https://www.instagram.com/dopecuthairstudio/" target="_blank" style="text-decoration: none;"><i class="fab fa-instagram"></i> dopecuthairstudio</a></div>
                <div class="text-center"><a class="text-white" href="mailto: dopecuthairstudio@gmail.com" target="_blank" style="text-decoration: none;"><i class="fas fa-envelope"></i> dopecutbarbershop@gmail.com</a></div>
            </div>
            <div class="col-md-6 col-12 mt-3">
                <div class="row text-white mb-3">
                    <div class="fw-bold fs-5">TENTANG KAMI</div>
                    <div class="">Dopecut Hair Studio di Cideng, Gambir, Jakarta Pusat yang didirikan pada tahun 2023, kami berkomitmen untuk melakukan berbagai jenis pelayanan rambut terbaik untuk pria dan wanita.</div>
                </div>
                <div class="row text-white mb-3">
                    <div class="fw-bold fs-5">TEMUKAN KAMI</div>
                    <div><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" /></svg> Jl. Tanah Abang II No.76, Petojo Sel., Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus
                        Ibukota Jakarta 10160</div>
                        <iframe class="mt-2" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15866.670916989573!2d106.79376003596624!3d-6.175218549374062!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f7181aac0eb9%3A0xd7dc9796fb70394c!2sDopecut%20Hairstudio!5e0!3m2!1sen!2sid!4v1688375531382!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="text-center">
                <a href="https://dopecutbarbershop.com" style="font-size: 10pt; text-decoration:none; color:white;">&copy;2023 Dopecut
                    Hairstudio</a>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="PriceListAndService" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 0">
                <div class="modal-header" style="border-bottom: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link nav-pills active" data-bs-toggle="tab" href="#men">Men</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-pills" data-bs-toggle="tab" href="#women">Women</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="men" class="container tab-pane active">
                            <table class="table table-bordered bg-white text-dark">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Women's Service</th>
                                        <th class="text-center">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($men_service as $ms)
                                        <tr>
                                            <td>
                                                @if ($ms->sub_service == 1)
                                                    {{ $ms->service_name }}
                                                @else
                                                    &emsp;+{{ $ms->service_name }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($ms->tentative_price == 1)
                                                    Start from
                                                    {{ $ms->price == 'Rp 0' ? 'Free' : 'Rp ' . number_format($ms->price, 0, ',', '.') }}
                                                @else
                                                    {{ $ms->price == 'Rp 0' ? 'Free' : 'Rp ' . number_format($ms->price, 0, ',', '.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="women" class="container tab-pane fade">
                            <table class="table table-bordered bg-white text-dark">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Women's Service</th>
                                        <th class="text-center">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($women_service as $ws)
                                        <tr>
                                            <td>{{ $ws->service_name }}</td>
                                            <td class="text-center">
                                                @if ($ws->tentative_price == 1)
                                                    Start from
                                                    {{ $ws->price == 'Rp 0' ? 'Free' : 'Rp ' . number_format($ws->price, 0, ',', '.') }}
                                                @else
                                                    {{ $ws->price == 'Rp 0' ? 'Free' : 'Rp ' . number_format($ws->price, 0, ',', '.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    <script>
        $(document).ready(function() {

            $(function() {
                $.ajax({
                    url: 'https://mybusiness.googleapis.com/v4/locations/ChIJuQ6sGhj3aS4RTDlw-5aX3Nc/reviews',
                    type: 'GET',
                    dataType: 'JSON',
                    cache: false,
                    success: function(response){
                        console.log(response);
                    },
                    error: function(xhr, error, status){
                        console.error(error);
                    }
                });
            });

            $(window).scroll(function() {
                var height = $('#topNav').height();
                var scrollTop = $(window).scrollTop();
                if (scrollTop >= height - 40) {
                    $('.navbar').addClass('bg-dark-matte');
                } else {
                    $('.navbar').removeClass('bg-dark-matte');
                }
            });

            $('.hit-link').on('click', function(event) {
                event.preventDefault();

                const slug = $(this).attr('id');
                const _token = '{{ csrf_token() }}'

                $.ajax({
                    url: '/article/hit/' + slug,
                    method: 'POST',
                    cache: false,
                    dataType: 'JSON',
                    data: {
                        slug: slug,
                        _token: _token,
                    },
                    success: function(response) {
                        window.location.href = response.redirect;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error: ', error);
                    }
                });
            });
        });
    </script>
</body>

</html>
