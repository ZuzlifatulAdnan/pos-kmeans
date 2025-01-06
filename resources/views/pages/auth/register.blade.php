<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Daftar | CALMA POS KMEANS</title>

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
            @include('layouts.alert')
            <div class="d-flex align-items-stretch flex-wrap">
                <div
                    class="col-lg-4 col-md-6 col-12 min-vh-100 d-flex justify-content-center align-items-center bg-whitef">
                    <div class="">
                        <br>
                        <h1 class="text-primary font-weight-bold">Login</h4>
                            <h4 class="font-weight-bold text-dark">
                                Calma POS Kmeans
                            </h4>
                            {{-- <p class="text-muted">
                                @if (session('status'))
                                    Password berhasil di ubah silahkan login kembali.
                                @else
                                    Harap login menggunakan email dan password anda.
                                @endif
                            </p> --}}
                            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate="">
                                @csrf
                            
                                <div class="form-group">
                                    <label for="name">FullName</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="form-group">
                                    <label for="role">Pilih Status</label>
                                    <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Mahasiswa" @if(old('role') == 'Mahasiswa') selected @endif>Mahasiswa</option>
                                        <option value="Dosen" @if(old('role') == 'Dosen') selected @endif>Dosen</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="form-group" id="npm-group" style="display: none;">
                                    <label for="npm">NPM</label>
                                    <input id="npm" type="text" class="form-control @error('npm') is-invalid @enderror" name="npm" value="{{ old('npm') }}">
                                    @error('npm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="form-group" id="nip-group" style="display: none;">
                                    <label for="nip">NIP</label>
                                    <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}">
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            
                                <div class="form-group">
                                    <label for="no_whatsapp">Nomor WhatsApp</label>
                                    <input id="no_whatsapp" type="text" class="form-control @error('no_whatsapp') is-invalid @enderror" name="no_whatsapp" value="{{ old('no_whatsapp') }}" required>
                                    @error('no_whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Daftar</button>
                            </form>
                            <div class="text-center mt-3">
                                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
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
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <!-- Custom Script -->
    <script>
        document.getElementById('role').addEventListener('change', function () {
            const role = this.value;
            const npmGroup = document.getElementById('npm-group');
            const nipGroup = document.getElementById('nip-group');
    
            if (role === 'Mahasiswa') {
                npmGroup.style.display = 'block';
                nipGroup.style.display = 'none';
            } else if (role === 'Dosen') {
                nipGroup.style.display = 'block';
                npmGroup.style.display = 'none';
            } else {
                npmGroup.style.display = 'none';
                nipGroup.style.display = 'none';
            }
        });
    </script>
</body>

</html>
