<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dopecut Hairstudio: Jakarta Pusat</title>

    <!-- CSS -->
    <link rel="icon" type="image/x-icon" href="/assets/image/logo-circle.png">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/book.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/dark-hive/jquery-ui.css">
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="/assets/fontawesome/css/all.css">

    <!-- JS -->
    <script id="bootstrap-js" src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- <script src="/assets/js/home.js"></script> --}}
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark py-3 fixed-top navCarousel">
            <div class="container-fluid">
                <a class="navbar-brand dope" href="/">
                    <img src="/assets/image/logo-brand.png" alt="Dopecut" class="brand-image">
                </a>
                <div id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active" aria-current="page" href="/">HOME</a>
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active selected" aria-current="page" href="/book">BOOK NOW</a>
                        </li>
                        <li class="nav-item navItem mx-auto">
                            <a class="nav-link active selected" aria-current="page" href="/book/history">BOOK
                                HISTORY</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    @if (Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success') }}')
    </script>
    @endif

    @yield('content')
</body>

</html>
