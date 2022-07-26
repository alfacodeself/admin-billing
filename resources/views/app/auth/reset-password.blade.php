<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Setel Ulang Password</title>
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
                            <p class="text-center text-uppercase mt-3">Reset Password</p>
                            @include('partials.my-alert')
                            <form class="form text-center" action="{{ route('reset_password.post') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" value="{{ $reset->token }}" name="token">
                                <div class="form-group input-group-md">
                                    <input type="password" class="form-control @error('new_password')is-invalid @enderror" name="new_password" id="new_password"
                                        placeholder="Masukkan Password Baru Anda">
                                    @error('new_password')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group input-group-md">
                                    <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation"
                                        placeholder="Konfirmasi Password Baru Anda">
                                </div>
                                <button class="btn btn-block btn-primary mt-4" type="submit">
                                    Ubah Password Anda
                                </button>
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
