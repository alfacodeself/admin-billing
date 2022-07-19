@extends('layouts.app')
@section('title', 'Pengaturan Dokumen')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Profil</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@include('partials.my-alert')
<section id="main-content">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body pt-3 text-center">
                    <img src="{{ asset('assets/images/3.jpg') }}" alt="" class="rounded-circle" width="100" height="100">
                    <form action="" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group mt-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="file" class="form-control" id="foto" name="foto" placeholder="">
                                    @error('foto')
                                    <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-outline-primary">Change</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="list-group">
                    <li class="list-group-item active">Profil</li>
                    <li class="list-group-item">Alfa Code</li>
                    <li class="list-group-item">Laki-Laki</li>
                    <li class="list-group-item">alfa@example.com</li>
                    <li class="list-group-item">+62871929781298</li>
                    <li class="list-group-item">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsam, officia iste. Saepe placeat consequatur ab, quaerat iste optio accusamus explicabo.</li>
                </ul>
                <div id="address" style="width: 100%; height: 200px;"></div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <p class="text-danger"><strong><small>{{ $message }}</small></strong></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="laki-laki">Laki-Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                @error('nama')
                                    <p class="text-danger"><strong><small>{{ $message }}</small></strong></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-danger"><strong><small>{{ $message }}</small></strong></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor_hp">No. Hp</label>
                                <input type="number" class="form-control" name="nomor_hp" value="{{ old('nomor_hp') }}">
                                @error('nomor_hp')
                                    <p class="text-danger"><strong><small>{{ $message }}</small></strong></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-danger"><strong><small>{{ $message }}</small></strong></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kode_pos">Kode Pos</label>
                                <input type="number" class="form-control" name="kode_pos" value="{{ old('kode_pos') }}">
                                @error('kode_pos')
                                    <p class="text-danger"><strong><small>{{ $message }}</small></strong></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="map">Map</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="latitude" readonly name="latitude" class="form-control" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <p class="text-danger"><strong><small>{{ $message }}</small></strong></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="longitude" readonly name="longitude" class="form-control" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <p class="text-danger"><strong><small>{{ $message }}</small></strong></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="map" style="height: 260px"></div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block btn-outline-primary">Tambah Petugas</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
