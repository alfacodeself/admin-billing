@extends('layouts.app')
@section('title', 'Pelanggan')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Pelanggan</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Pelanggan</li>
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
                    Data Pelanggan
                </h4>
                <br>
                <div class="card-body">
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-outline-primary">
                        <i class="ti-plus font-weight-bold"></i> Tambah Pelanggan
                    </a>
                    <a href="" class="btn btn-outline-info float-right">
                        <i class="ti-printer"></i> Cetak
                    </a>
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th width="35%">Alamat</th>
                                    <th width="25%">Dokumen</th>
                                    <th>Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pelanggan as $p)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $p->nik }}</td>
                                    <td>{{ $p->nama_pelanggan }}</td>
                                    <td>
                                        {{ $p->alamat }}
                                    </td>
                                    <td>
                                        <ul>
                                            @forelse ($p->dokumen_pelanggan as $dokumen)
                                            <li>
                                                @if ($dokumen->jenis_dokumen->status == 'a')
                                                    <a href="{{ url($dokumen->path_dokumen) }}" target="__blank" class="text-primary">{{ $dokumen->jenis_dokumen->nama_dokumen }}</a>
                                                @endif
                                            </li>
                                            @empty
                                            <li>Tidak memiliki dokumen</li>
                                            @endforelse
                                        </ul>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $p->status == 'a' ? 'success' : 'danger' }}">{{ $p->status == 'a' ? 'aktif' : 'nonaktif' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pelanggan.show', $p->id_pelanggan) }}" class="btn btn-link m-0 p-0">
                                            <i class="ti-eye text-primary font-weight-bold"></i>
                                        </a>
                                        <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link m-0 p-0">
                                                <i class="ti-trash text-danger font-weight-bold"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-capitalize">Tidak ada data pelanggan!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $pelanggan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
