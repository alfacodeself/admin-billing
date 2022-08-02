@extends('layouts.app')
@section('title', 'Edit Role Permission')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Ubah Role Permission</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('pengaturan.rolepermission.index') }}">Role
                                Permission</a></li>
                        <li class="breadcrumb-item active">Ubah Role Permission</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.my-alert')
    <section id="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card profile-card-5">
                    <div class="card-img-block">
                        <img class="card-img-top" src="{{ url($petugas->foto) }}" alt="Card image cap" height="250">
                    </div>
                    <div class="card-body pt-0">
                        <h5 class="card-title">{{ $petugas->nama_petugas }}</h5>
                        <p class="card-text">{{ 'Admin' }} Pelanggan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs customtab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-user"></i>
                                    </span>
                                    <span class="hidden-xs-down">Profil</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="profile" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Tentang</a>
                                            <a href="{{ route('petugas.show', $petugas->id_petugas) }}" class="btn btn-link p-0 m-0">
                                                <i class="ti-eye text-primary font-weight-bold"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="basic-information">
                                                <h4>Biodata</h4>
                                                <div class="birthday-content">
                                                    <span class="contact-title">Nama:</span>
                                                    <span class="birth-date">{{ $petugas->nama_petugas }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Jenis Kelamin:</span>
                                                    <span
                                                        class="gender">{{ $petugas->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status petugas:</span>
                                                    <span
                                                        class="gender {{ $petugas->status == 'a' ? '' : 'text-danger' }}">{{ $petugas->status == 'a' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Kontak Informasi</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">No. Telp:</span>
                                                    <span class="phone-number">{{ '+' . $petugas->nomor_hp }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Email:</span>
                                                    <span class="contact-email">{{ $petugas->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('pengaturan.rolepermission.store', $petugas->id_petugas) }}" method="post">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select name="jabatan" id="jabatan" class="form-control text-capitalize">
                                    @forelse ($jabatan as $j)
                                        <option
                                            value="{{ $j->id_jenis_jabatan }}"
                                            class="text-capitalize"
                                            {{ $j->id_jenis_jabatan == $jabatanPetugas->id_jenis_jabatan ? 'selected' : '' }}>
                                            {{ $j->nama_jabatan }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada data jabatan!</option>
                                    @endforelse
                                </select>
                                @error('jabatan')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="permission">Permission</label><br>
                                @forelse ($permission as $p)
                                    <input
                                        type="checkbox"
                                        name="permission[]"
                                        id="permission"
                                        value="{{ $p->id_permission }}"
                                        @foreach ($petugas->detail_jabatan->where('status', 'a')->first()->detail_permission as $dp)
                                            {{ $dp->id_permission == $p->id_permission ? 'checked' : '' }}
                                        @endforeach
                                        ><span class="mx-1 text-capitalize">{{ $p->nama_permission }}</span>
                                @empty
                                    Tidak ada data permission
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-primary">Set Role Permission</button>
        </form>
    </section>
@endsection
