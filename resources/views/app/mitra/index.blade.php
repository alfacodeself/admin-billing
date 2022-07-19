@extends('layouts.app')
@section('title', 'Mitra')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Data Mitra</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                        <li class="breadcrumb-item active">Mitra</li>
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
                        Data Mitra
                    </h4>
                    <br>
                    <div class="card-body">
                        <a href="{{ route('mitra.create') }}" class="btn btn-outline-primary">
                            <i class="ti-plus font-weight-bold"></i> Tambah Mitra
                        </a>
                        <a href="{{ route('langganan.create') }}" class="btn btn-outline-info float-right">
                            <i class="ti-printer"></i> Cetak
                        </a>
                        <div class="table-responsive">
                            <table class="table table-hover table-stripped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Dokumen</th>
                                        <th>Status</th>
                                        <th>Tanggal Verifikasi</th>
                                        <th>Jumlah Pelanggan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($mitra) --}}
                                    @forelse ($mitra as $m)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><img src="{{ url($m->foto) }}" alt="Foto Mitra" class="rounded-circle" width="50">
                                            </td>
                                            <td>{{ $m->nama_mitra }}</td>
                                            <td>
                                                <ul>
                                                    @forelse ($m->dokumen_mitra as $dokumen)
                                                        <li>
                                                            @if ($dokumen->jenis_dokumen->status == 'a')
                                                                <a href="{{ url($dokumen->path_dokumen) }}"
                                                                    target="__blank"
                                                                    class="text-primary">{{ $dokumen->jenis_dokumen->nama_dokumen }}</a>
                                                            @endif
                                                        </li>
                                                    @empty
                                                        <li>Tidak Ada Dokumen!</li>
                                                    @endforelse
                                                </ul>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $m->status == 'a' ? 'success' : 'danger' }}">{{ $m->status == 'a' ? 'Aktif' : 'Nonaktif' }}</span>
                                            </td>
                                            <td class="text-center">
                                                {!! $m->tanggal_verifikasi == null ? '<i class="ti-close text-danger font-weight-bold"></i>' : $m->tanggal_verifikasi !!}
                                            </td>
                                            <td>
                                                {{ $m->detail_mitra_pelanggan_count }} Pelanggan
                                            </td>
                                            <td>
                                                <a href="{{ route('mitra.show', $m->id_mitra) }}" class="btn btn-link m-0 p-0">
                                                    <i class="ti-eye text-primary font-weight-bold"></i>
                                                </a>
                                                <form action="{{ route('mitra.destroy', $m->id_mitra) }}" method="post" class="d-inline">
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
                                            <td colspan="8" class="text-center">Tidak ada data mitra!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="float-right">
                                {{ $mitra->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
