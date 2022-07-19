@extends('layouts.app')
@section('title', 'Petugas')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Petugas</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Petugas</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@include('partials.my-alert')
<section id="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-title font-weight-bold">
                    Data Petugas
                </h4>
                <br>
                <div class="card-body">
                    <a href="{{ route('petugas.create') }}" class="btn btn-outline-primary">
                        <i class="ti-plus font-weight-bold"></i> Tambah Petugas
                    </a>
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal Menjabat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($petugas) --}}
                                @forelse ($petugas as $p)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td><img src="{{ url($p->foto) }}" alt="Foto Petugas" class="rounded-circle" width="40"></td>
                                        <td>{{ $p->nama_petugas }}</td>
                                        <td>{{ $p->nama_jabatan}}</td>
                                        <td>{{ $p->tanggal_jabatan }}</td>
                                        <td>
                                            <span class="badge badge-{{ $p->status == 'a' ? 'success' : 'danger' }}">
                                                {{ $p->status == 'a' ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('petugas.show', $p->id_petugas) }}" class="btn btn-link m-0 p-0">
                                                <i class="ti-eye text-primary font-weight-bold"></i>
                                            </a>
                                            <a href="" class="btn btn-link m-0 p-0">
                                                <i class="ti-trash text-danger font-weight-bold"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data petugas!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $petugas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
