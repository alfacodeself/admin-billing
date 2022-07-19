@extends('layouts.app')
@section('title', 'Tambah Petugas')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Tambah Petugas</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('petugas.index') }}">Petugas</a></li>
                        <li class="breadcrumb-item active">Tambah Petugas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.my-alert')
    <section id="main-content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('petugas.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold">Data Petugas</h4>
                            <br>
                            <div class="input-sizes">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3"><label for="foto">Foto Petugas</label></div>
                                                <div class="col-md-8">
                                                    <input type="file" class="form-control" id="foto" name="foto">
                                                    @error('foto')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"><label for="nama">Nama Petugas</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" placeholder="Nama Petugas" class="form-control"
                                                        id="nama" name="nama">
                                                    @error('nama')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"><label for="jenis_kelamin">Jenis Kelamin</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="l"
                                                        checked> Laki-Laki
                                                    <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="p">
                                                    Perempuan
                                                    @error('jenis_kelamin')
                                                        <br>
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="nomor_hp">Nomor Handphone</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" placeholder="Nomor Handphone"
                                                        class="form-control" id="nomor_hp" name="nomor_hp">
                                                    @error('nomor_hp')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="email">E-mail</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="email" placeholder="E-mail Petugas"
                                                        class="form-control" id="email" name="email">
                                                    @error('email')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="jabatan">Jabatam</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select name="jabatan" id="jabatan" class="form-control text-capitalize">
                                                        @forelse ($jabatan as $j)
                                                            <option class="text-capitalize" value="{{ $j->id_jenis_jabatan }}">{{ $j->nama_jabatan }}</option>
                                                        @empty
                                                            <option value="">Tidak ada data jabatan!</option>
                                                        @endforelse
                                                    </select>
                                                    @error('jabatan')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-sm-none d-md-block"></div>
                                                <div class="col-md-8 col-sm-12">
                                                    <button type="submit" class="btn btn-outline-primary float-md-right">Tambah Petugas</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection
