<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Reset Password | CALMA POS KMEANS</title>

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
                        class="col-lg-4 col-md-6 col-12  min-vh-100  d-flex justify-content-center align-items-center bg-white">
                        <div class="">
                            {{-- <img src="{{ asset('img/stisla-fill.svg') }}" alt="logo" width="80"
                            class="shadow-light rounded-circle mb-5 mt-2"> --}}
                            <h1 class="text-primary font-weight-bold">Reset Password</h4>
                                <h4 class="font-weight-bold text-dark">
                                    Calma POS Kmeans
                                </h4>
                            <p class="text-muted">
                                Mohon isi password dengan benar
                            </p>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.update') }}" class="needs-validation"
                                novalidate="">
                                @csrf
                                <div class="form-group">
                                    <input id="token" type="hidden"
                                        class="form-control @error('token') is-invalid

                                @enderror"
                                        value="{{ old('token') ?? $request->token }}" name="token" tabindex="1"
                                        autofocus readonly>
                                    @error('token')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid

                                @enderror"
                                        value="{{ old('email') ?? $request->email }}" name="email" tabindex="1"
                                        readonly>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    </div>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid

                                @enderror"
                                        name="password" tabindex="2" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Konfirmsi Password</label>
                                    </div>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid

                                @enderror"
                                        name="password_confirmation" tabindex="2" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="d-block bg-danger">
                                    <button class="btn btn-primary btn-lg btn-block">Reset Password</button>
                                </div>

                            </form>


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
