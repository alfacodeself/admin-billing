<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>
    @include('layouts.style')
    <style>
    </style>
</head>

<body>
    <div class="content-wrap">
        <div class="main">
            <div class="container mt-5">
                <div class="row justify-content-center align-items-center text-center p-2">
                    <div class="m-1 col-sm-8 col-md-6 col-lg-4 shadow-sm p-3 mb-5 bg-white border rounded">
                        <div class="pt-2 pb-2">
                            <img class="rounded mx-auto d-block"
                                src="https://freelogovector.net/wp-content/uploads/logo-images-13/microsoft-cortana-logo-vector-73233.png"
                                alt="" width=70px height=70px>
                            <p class="text-center text-uppercase mt-3">Login</p>
                            @include('partials.my-alert')
                            <form class="form text-center" action="{{ route('login') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="form-group input-group-md">
                                    <input type="email" class="form-control @error('email')is-invalid @enderror" name="email" id="email"
                                        placeholder="Masukkan Email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group input-group-md">
                                    <input type="password" class="form-control @error('password')is-invalid @enderror" id="password" name="password"
                                        placeholder="Masukkan Password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <button class="btn btn-block btn-primary mt-4" type="submit">
                                    Login
                                </button>
                                @if (session('verify'))
                                <a href="{{ route('verifikasi-email') }}" class="float-left mt-2">Kirim ulang email verifikasi! </a>
                                @endif
                                <a href="#" class="float-right mt-2">Forgot Password? </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.script')
    @include('sweetalert::alert')

</body>

</html>
