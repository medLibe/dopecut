<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Dopecut Hair Studio didirikan pada tahun 2023 untuk melayani hair service untuk pria.">
    <meta name="keywords"
        content="dopecut, dopecuthairstudio, hair studio, barberman, hair artist, potong rambut pria, potong rambut, potong rambut tanah abang, tanah abang, jakarta, jakarta pusat">
    <meta name="google-site-verification" content="YOEppHJk69BMbN_ZApfcfeDOcN0wCBvcih-kOCFdSSU" />
    <meta name="robots" content="index, follow">

    <title>Dopecut's Blog: {{ $article->title }}</title>

    <!-- CSS -->
    <link rel="icon" type="image/x-icon" href="/assets/image/logo-circle.png">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/article.css" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="/assets/fontawesome/css/all.css">

    <!-- JS -->
    <script id="bootstrap-js" src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-matte py-3 fixed-top" id="topNav">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://dopecutbarbershop.com">
                <img src="/assets/image/logo-brand.png" alt="Dopecut" class="brand-image">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item navItem mx-auto">
                        <a href="/" class="nav-link active" href="#SecondSection">HOME</a>
                    </li>
                    <li class="nav-item navItem mx-auto">
                        @if (!empty(Auth::user()))
                            <a class="nav-link active" href="/book">BOOK</a>
                        @else
                            <a class="nav-link active" href="/login/google">BOOK</a>
                        @endif
                    </li>
                    <li class="nav-item navItem mx-auto">
                        <a class="nav-link active" href="/article">BLOG</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <main class="container-fluid">
        <div class="content-article mt-5 pt-5 mb-5">
            <div class="row justify-content-between row-content pt-3 ms-3 me-1">
                <div class="col-md-8 col-lg-8">
                    <header>
                        <input type="hidden" class="form-control" readonly value="{{ $article->id }}" id="article_id">
                        <div class="fs-2 fw-bold">{{ $article->title }}</div>
                        <div class="text-end text-secondary mt-3 mb-2" style="font-size: 10pt;">by
                            <strong>{{ $article->author }}</strong> -
                            {{ date('d M Y', strtotime($article->created_at)) }}</div>
                        <div class="divider-content"></div>
                    </header>
                    <article>
                        <?= $article->content ?>
                    </article>
                    <div class="card card-like shadow rounded-2 mb-3">
                        <div class="card-body d-flex justify-content-between">
                            <div class="text-start">
                                <button class="btn-like"><i class="fas fa-heart"></i> <span
                                        id="like-counter">{{ $like }}</span></button>
                            </div>
                            <div class="text-end">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                    target="_blank" class="btn-share btn-facebook"><i class="fab fa-facebook"></i></a>
                                <a href="https://wa.me/?text={{ url()->current() }}" target="_blank"
                                    class="btn-share btn-whatsapp"><i class="fab fa-whatsapp"></i></a>
                                <a href="https://www.instagram.com/?url={{ url()->current() }}"
                                    class="btn-share btn-instagram"><i class="fab fa-instagram"></i></a>
                                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank"
                                    class="btn-share btn-twitter"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="fw-bold">ARTIKEL LAINNYA</div>
                    <div class="divider-recommendation"></div>
                    @foreach ($articles as $a)
                        <a href="/admin/article/{{ $a->slug }}"
                            class="recommendation d-flex align-items-start mb-4 hit-link"
                            style="text-decoration: none; color: black;" id="{{ $a->slug }}">
                            {!! $a->image_headline !!}
                            <div class="ms-2">
                                <div class="fw-bold" style="font-size: 10pt;">{{ $a->title }}</div>
                                <div class="text-secondary" style="font-size: 8pt;">
                                    {{ date('d M Y', strtotime($a->created_at)) }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <footer class="container-fluid">
        <!-- Section 6 -->
        <div class="row justify-content-center" id="jumbotron-about">
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

    <script>
        $(document).ready(function() {
            const article_id = $('#article_id').val();
            const likeButton = $('.btn-like');

            // check if button like is liked or not
            if (localStorage.getItem('liked_' + article_id)) {
                likeButton.removeClass('btn-like').addClass('btn-liked');
                likeButton.prop('disabled', true);
            }

            $('.hit-link').on('click', function(event) {
                event.preventDefault();

                const slug = $(this).attr('id');
                const _token = '{{ csrf_token() }}';

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

            $('.btn-like').on('click', function() {
                const like = parseInt($('#like-counter').text());
                const article_id = $('#article_id').val();
                const _token = '{{ csrf_token() }}';
                const likeButton = $(this);

                if (localStorage.getItem('liked_' + article_id)) {
                    return;
                }

                $.ajax({
                    url: '/article/like/' + article_id,
                    method: 'POST',
                    cache: false,
                    dataType: 'JSON',
                    data: {
                        like: like,
                        article_id: article_id,
                        _token: _token,
                    },
                    success: function(response) {
                        if (response.success == true) {
                            likeButton.removeClass('btn-like').addClass('btn-liked');

                            // update like counter
                            $('#like-counter').text(response.like);

                            // disable like button after change class to liked
                            likeButton.prop('disabled', true);

                            // save to localstorage
                            localStorage.setItem('liked_' + article_id, true);
                        }
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
