<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Masuk | CALMA POS KMEANS</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch flex-wrap">
                <div
                    class="col-lg-4 col-md-6 col-12 min-vh-100 d-flex justify-content-center align-items-center bg-whitef">
                    <div class="">
                        {{-- <img src="{{ asset('img/logo/logo.png') }}" alt="logo" class="img-fluid shadow-light"
                            style="max-width: 100px;"> --}}
                        <h1 class="text-primary font-weight-bold">Masuk</h4>
                            <h4 class="font-weight-bold text-dark">
                                Calma POS Kmeans
                            </h4>
                            <p class="text-muted">
                                @if (session('status'))
                                    Password berhasil di ubah silahkan masuk kembali.
                                @else
                                    Harap masuk menggunakan email dan password anda.
                                @endif
                            </p>
                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid
                                    @enderror"
                                        name="email" tabindex="1" required autofocus>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    </div>
                                    <input id="password" type="password"
                                        class="form-control @error('email') is-invalid

                                    @enderror"
                                        name="password" tabindex="2" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            Email atau password salah!
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group text-left">
                                    <a href="{{ route('password.request') }}" class="">
                                        Lupa Password?
                                    </a>
                                </div>

                                <div class="d-block bg-danger">
                                    <button class="btn btn-primary btn-lg btn-block">Masuk</button>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                            </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 d-none d-md-block"
                    style="background-repeat: no-repeat; background-size: cover"
                    data-background="https://www.darmajaya.ac.id/wp-content/uploads/3-161.jpg">
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
