@extends('layouts.app')
@section('title', 'Transaksi')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Transaksi</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
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
                    Data Transaksi
                </h4>
                <br>
                <div class="card-body">
                    @can('tambah transaksi')
                    <a href="{{ route('transaksi.create') }}" class="btn btn-outline-primary">
                        <i class="ti-plus font-weight-bold"></i> Buat Transaksi
                    </a>
                    @endcan
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Transaksi</th>
                                    <th>Petugas</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Via</th>
                                    <th>Nomor VA</th>
                                    <th>Total Bayar</th>
                                    <th>Status Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksi as $t)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $t->id_transaksi }}</td>
                                    <td> {{ $t->petugas->nama_petugas ?? "-" }} </td>
                                    <td>{{ $t->metode_pembayaran->metode_pembayaran ?? '-' }}</td>
                                    <td>{{ $t->metode_pembayaran->via ?? '-' }}</td>
                                    <td>{{ $t->nomor_va ?? '-' }}</td>
                                    <td>{{ 'Rp.' . number_format($t->total_bayar) }}</td>
                                    <td>
                                        @if ($t->status_transaksi == "settlement" || $t->status_transaksi == "capture" || $t->status_transaksi == "refund")
                                            <span class="badge badge-success">{{ $t->status_transaksi }}</span>
                                        @elseif ($t->status_transaksi == "expire" || $t->status_transaksi == "deny" || $t->status_transaksi == "authorize" || $t->status_transaksi == "cancel" || $t->status_transaksi == "failure")
                                            <span class="badge badge-danger">{{ $t->status_transaksi }}</span>
                                        @elseif ($t->status_transaksi == "pending")
                                            <span class="badge badge-warning">{{ $t->status_transaksi }}</span>
                                        @else
                                            <span class="badge badge-primary">{{ $t->status_transaksi }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $t->tanggal_transaksi }}
                                    </td>
                                    <td>
                                        @can('detail transaksi')
                                        <a href="{{ route('transaksi.show', $t->id_transaksi) }}" class="btn btn-link m-0 p-0">
                                            <i class="ti-eye text-primary font-weight-bold"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">Tidak ada data transaksi!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
