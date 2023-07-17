<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dopecut Hair Studio | Superior Hair Cut, Nice Services & Best Hair Style</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dopecut Hair Studio didirikan pada tahun 2023 untuk melayani hair service untuk pria.">
    <meta name="keywords" content="dopecut, dopecuthairstudio, hair studio, barberman, hair artist, potong rambut pria, potong rambut, potong rambut tanah abang, tanah abang, jakarta, jakarta pusat">
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
        <nav class="navbar navbar-expand-lg navbar-dark py-3 fixed-top navCarousel">
            <div class="container-fluid">
                <a class="navbar-brand dope" href="/">
                    <img src="/assets/image/logo-circle.png" alt="Dopecut" class="brand-image">
                </a>
                <div id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item navItem mx-3">
                            @if (!empty(Auth::user()))
                            <a class="nav-link active" aria-current="page" href="/book">BOOK NOW</a>
                            @else
                            <a class="nav-link active" aria-current="page" href="/login/google">BOOK NOW</a>
                            @endif
                        </li>
                        <li class="nav-item navItem mx-3">
                            <a class="nav-link active" aria-current="page" href="#firstSection">HAIR ARTISTS</a>
                        </li>
                        <li class="nav-item navItem mx-3">
                            <a class="nav-link active" aria-current="page" href="#thirdSection">SERVICES</a>
                        </li>
                        <li class="nav-item navItem mx-3" id="aboutUs">
                            <a class="nav-link active" aria-current="page" href="#fourthSection">ABOUT US</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="carouselNav" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselNav" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselNav" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselNav" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/assets/image/index1.jpg" class="img-fluid d-block" alt="index-gallery">
                    <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                        <span class="fw-bold" style="font-size: 12pt;">DOPECUT HAIR STUDIO</span>
                        <p class="text-carousel">Dopecut Hair Studio is a trendy new Hair Studio located in Jakarta that offers high-quality haircuts and grooming services for men. With its skilled barbers and stylish atmosphere, Dopecut Hair Studio is the perfect destination for those seeking a fresh and modern look.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/assets/image/index2.jpg" class="img-fluid d-block" alt="index-gallery">
                    <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                        <span class="fw-bold" style="font-size: 12pt;">OUR SERVICE</span>
                        <p class="text-carousel">Dopecut Hair Studio is committed to providing the best possible experience for its customers, with a focus on high-quality services and personalized attention. Their skilled barbers and stylish atmosphere create a welcoming environment where customers can relax and enjoy a top-notch grooming experience.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/assets/image/index3.jpg" class="img-fluid d-block" alt="index-gallery">
                    <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                        <span class="fw-bold" style="font-size: 12pt;">HAIR ARTIST</span>
                        <p class="text-carousel">Dopecut Hair Studio's hair artist is a team of highly skilled and experienced barbers who are passionate about their craft. They are committed to providing personalized grooming services to each customer, creating a comfortable atmosphere, and leaving customers looking and feeling their best.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselNav" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselNav" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </header>


    <main>
        <!-- Section 1 -->
        <div class="container-fluid">
            <div class="row justify-content-center" id="firstSection">
                <div class="p-5 text-dark" id="jumbotron-two">
                    <h1 class="text-center mb-5"><strong>HAIR ARTISTS</strong></h1>
                    <div class="row justify-content-center flex-row flex-nowrap scrolling-wrapper">
                        <div class="col-md-auto col-auto mb-4 text-center">
                            <img src="/assets/image/kapster.jpg" class="img-rounded" alt="services"
                                style="width: 150px;">
                            <div class="fw-bold fs-5 text-center mt-3">LILO</div>
                        </div>
                        <div class="col-md-auto col-auto mb-4 text-center">
                            <img src="/assets/image/kapster.jpg" class="img-rounded" alt="services"
                                style="width: 150px;">
                            <div class="fw-bold fs-5 text-center mt-3">NAZ</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="row justify-content-center" id="secondSection">
                <div class="p-5 text-white text-center" id="jumbotron-three">
                    <div class="fs-1 mt-5 pt-5 mb-3"><strong>WALKIN'S ARE GOOD, <br> BUT BETTER TO BOOK!</strong></div>
                    @if (!empty(Auth::user()))
                    <a href="/book" class="btn btn-lg" id="book-now">BOOK NOW</a>
                    @else
                    <a href="/login/google" class="btn btn-lg" id="book-now">BOOK NOW</a>
                    @endif
                </div>
            </div>

            <!-- Section 3 -->
            <div class="row justify-content-center" id="thirdSection">
                <div class="p-5 text-dark" id="jumbotron-one">
                    <h1 class="text-center mb-5"><strong>SERVICES</strong></h1>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <table class="table table-bordered text-center">
                                <thead class="table-dark">
                                   <tr>
                                        <th>Men</th>
                                        <th>Women</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service as $s)
                                    <tr>
                                        <td>{{ $s->service_name }}</td>
                                        <td>{{ $s->estimation }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4 -->
            <div class="row justify-content-center" id="fourthSection">
                <div class="p-5 text-white" id="jumbotron-fourth">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                            <div class="dope text-center"><img src="/assets/image/logo-transparent.png" alt="brand-image" style="width: 200px; height: 200px;"></div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-3 mb-3">
                            <div class="fs-6 mb-3">ABOUT US</div>
                            Dopecut Hair Studio didirikan pada tahun 2023 untuk melayani hair service untuk pria.

                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="fs-6 mb-3">FIND US AT</div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                            </svg>
                            Jl. Tanah Abang II No.76, Petojo Sel., Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10160
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="fs-6 mb-3">FIND US IN</div>
                            <table>
                                <tr>
                                    <td><a href="https://www.instagram.com/dopecuthairstudio/" target="_blank" class="text-white fs-5" style="text-decoration: none;">
                                            <i class="fab fa-instagram"></i> dopecuthairstudio</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href = "mailto: dopecutHair Studio@gmail.com" target="_blank" class="text-white" style="text-decoration: none; font-size: 10pt;">
                                            <i class="fas fa-envelope"></i> dopecutbarbershop@gmail.com</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- JS -->
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    <script>
        $(document).ready(function() {

            $(window).scroll(function() {
                var height = $('#carouselNav').height();
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
