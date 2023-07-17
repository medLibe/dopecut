<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dopecut Barbershop | Login Admin</title>
    <!-- CSS -->
    <link rel="icon" type="image/x-icon" href="/assets/image/logo-circle.png">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css">
</head>

<body>
    <!-- Section: Design Block -->
    <section class="text-center text-lg-start">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Amaranth&family=Luckiest+Guy&family=Merriweather+Sans:wght@300&display=swap');

            body{
                font-family: 'Merriweather Sans', sans-serif;
            }

            .cascading-right {
                margin-right: -50px;
            }

            @media (max-width: 991.98px) {
                .cascading-right {
                    margin-right: 0;
                }
            }

            @media screen and (max-width: 991px){
                #image-login{
                    display: none;

                }

                #form-column{
                    margin-top: 88px;
                }

                .card{
                    border: none !important;
                }

                .card-header{
                    display: none;
                }
            }
        </style>

        <!-- Jumbotron -->
        <div class="container py-4">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 col-12 mb-5 mb-lg-0" id="form-column">
                    <div class="card cascading-right" style="background: hsla(0, 0%, 100%, 0.55); backdrop-filter: blur(30px);">
                        <div class="card-header bg-primary p-0"></div>
                        <div class="card-body p-5 shadow-5 text-center">
                            <h2 class="fw-bold mb-5">Login</h2>
                            <form action="/login/admin/auth" method="POST">
                                @csrf
                                <!-- Username input -->
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control" name="username" placeholder="@john_doe" required value="{{ old('username') }}">
                                    <label class="text-secondary" for="floatingInput">Username</label>
                                </div>

                                <!-- Password input -->
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control" name="password" placeholder="password" required value="{{ old('password') }}">
                                    <label class="text-secondary" for="floatingInput">Password</label>
                                </div>

                                <!-- Submit button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btn-block mb-4">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0" id="image-login">
                    <img src="/assets/image/index4.jpg"
                        class="w-100 rounded-4 shadow-4" alt="" />
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
    <!-- JS -->
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
    
    @if (Session::has('error'))
        <script>
            Swal.fire({
                title: 'Oops...',
                text: '{{ Session::get('error') }}',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
            })
        </script>
    @endif
</body>

</html>
