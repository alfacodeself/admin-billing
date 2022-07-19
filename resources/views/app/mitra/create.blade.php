@extends('layouts.app')
@section('title', 'Tambah Mitra')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Tambah Mitra</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mitra.index') }}">Mitra</a></li>
                        <li class="breadcrumb-item active">Tambah Mitra</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.my-alert')
    <section id="main-content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('mitra.create') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold">Data Mitra</h4>
                            <br>
                            <div class="input-sizes">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3"><label for="foto">Foto Mitra</label></div>
                                                <div class="col-md-8">
                                                    <input type="file" class="form-control" id="foto" name="foto">
                                                    @error('foto')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"><label for="nama">Nama Mitra</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" placeholder="Nama Mitra" class="form-control"
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
                                                    <input type="email" placeholder="E-mail Mitra"
                                                        class="form-control" id="email" name="email">
                                                    @error('email')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold">Dokumen Mitra</h4>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jenis_dokumen as $dokumen)
                                            @php
                                                $name = Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen));
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">
                                                    {{ $dokumen->nama_dokumen }}
                                                </td>
                                                <td class="text-left">
                                                    <input type="file" class="form-control form-control-sm" value="{{ old($name) }}" name="{{ $name }}">
                                                    @error($name)
                                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-capitalize">Tidak ada syarat dokumen!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-block btn-outline-primary">Tambah Data Mitra</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection
