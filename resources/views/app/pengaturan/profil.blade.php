@extends('layouts.app')
@section('title', 'Detail Pelanggan')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Detail Pelanggan</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                        <li class="breadcrumb-item active">Detail Pelanggan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.my-alert')
    <section id="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card profile-card-5 mt-5">
                    <div class="card-img-block">
                        <img class="card-img-top" src="{{ url($profil->foto) }}" alt="Card image cap" height="250">
                    </div>
                    <div class="card-body pt-0">
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#fotoModal">Ubah Foto
                            Profil</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mt-3">
                    <div class="card-body">
                        {{-- Start --}}
                        <ul class="nav nav-tabs customtab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-user"></i>
                                    </span>
                                    <span class="hidden-xs-down">Profil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#alamat" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-map-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Akun</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="profile" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Tentang</a>
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#profilModal">
                                                <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="basic-information">
                                                <h4>Biodata</h4>
                                                <div class="birthday-content">
                                                    <span class="contact-title">Nama:</span>
                                                    <span class="birth-date">{{ $profil->nama_petugas }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Jenis Kelamin:</span>
                                                    <span
                                                        class="gender">{{ $profil->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status:</span>
                                                    <span
                                                        class="gender {{ $profil->status == 'a' ? '' : 'text-danger' }}">{{ $profil->status == 'a' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Kontak Informasi</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">No. Telp:</span>
                                                    <span class="phone-number">{{ '+' . $profil->nomor_hp }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Email:</span>
                                                    <span class="contact-email">{{ $profil->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20" id="alamat" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Credential</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="basic-information">
                                                <h4>Ganti Password</h4>
                                                <form action="{{ route('pengaturan.profil.update.password') }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="birthday-content">
                                                        <span class="contact-title">Password Lama:</span>
                                                        <span class="birth-date">
                                                            <input type="password" class="form-control" name="old_password" value="{{ old('old_password') }}" placeholder="Password Lama">
                                                            @error('old_password')
                                                                <small><strong class="text-danger">{{ $message }}</strong></small>
                                                            @enderror
                                                        </span>
                                                        <hr>
                                                        <span class="contact-title">Password Baru:</span>
                                                        <span class="birth-date">
                                                            <input type="password" class="form-control" name="new_password" value="{{ old('new_password') }}" placeholder="Password Baru">
                                                            @error('new_password')
                                                                <small><strong class="text-danger">{{ $message }}</strong></small>
                                                            @enderror
                                                        </span>
                                                        <hr>
                                                        <span class="contact-title">Konfirmasi Password:</span>
                                                        <span class="birth-date">
                                                            <input type="password" class="form-control" name="new_password_confirmation" placeholder="Konfirmasi Password Baru">
                                                            @error('new_password_confirmation')
                                                                <small><strong class="text-danger">{{ $message }}</strong></small>
                                                            @enderror
                                                        </span>
                                                        <hr>
                                                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- ===============> Modal Section <======================= --}}
    <div class="modal fade" id="profilModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Profil</h5>
                </div>
                <form action="{{ route('pengaturan.profil.update.profil') }}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-5">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ $profil->nama_petugas }}" placeholder="Nama">
                                    @error('nama')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Jenis Kelamin</label>
                                <div class="col-sm-8">
                                    <input type="radio" name="jenis_kelamin" value="l"
                                        {{ $profil->jenis_kelamin == 'l' ? 'checked' : '' }}> Laki-Laki
                                    <input type="radio" name="jenis_kelamin" value="p"
                                        {{ $profil->jenis_kelamin == 'p' ? 'checked' : '' }}> Perempuan
                                    @error('nik')
                                        <br>
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ $profil->email }}" placeholder="Email">
                                    @error('email')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">No. Handphone</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="nomor_hp"
                                        value="{{ $profil->nomor_hp }}" placeholder="No Handphone">
                                    @error('nomor_hp')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Foto Profil</h5>
                </div>
                <form action="{{ route('pengaturan.profil.update.foto') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="foto">Foto Profil</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Foto Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .profile-card-5 {
            margin-top: 20px;
        }

        .profile-card-5 .btn {
            border-radius: 2px;
            text-transform: uppercase;
            font-size: 12px;
            padding: 7px 20px;
        }

        .profile-card-5 .card-img-block {
            width: 91%;
            margin: 0 auto;
            position: relative;
            top: -50px;

        }

        .profile-card-5 .card-img-block img {
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.63);
        }

        .profile-card-5 h5 {
            color: #4E5E30;
            font-weight: 600;
        }

        .profile-card-5 p {
            font-size: 14px;
            font-weight: 300;
        }

        .profile-card-5 .btn-primary {
            background-color: #4E5E30;
            border-color: #4E5E30;
        }
    </style>
@endpush
