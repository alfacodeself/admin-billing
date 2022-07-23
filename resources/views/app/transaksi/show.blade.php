@extends('layouts.app')
@section('title', 'Tagihan')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Detail Transaksi</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                    <li class="breadcrumb-item active">Detail Transaksi</li>
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
                    Detail Transaksi
                </h4>
                <br>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID Transaksi</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Tanggungan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($detail_transaksi as $dt)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $dt->transaksi->id_transaksi }}</td>
                                    <td>
                                        {{ $dt->jenis_pembayaran->jenis_pembayaran ?? $dt->transaksi->langganan->produk->nama_produk . ' | ' . $dt->transaksi->langganan->produk->kategori->nama_kategori }}
                                    </td>
                                    <td>{{ 'Rp.' . number_format($dt->harga) }}</td>
                                    <td>{{ $dt->qty }}</td>
                                    <td>{{ 'Rp.' . number_format($dt->total_tanggungan) }}</td>
                                    <td>
                                        @if ($dt->transaksi->status_transaksi == "settlement" || $dt->transaksi->status_transaksi == "capture" || $dt->transaksi->status_transaksi == "refund")
                                            <span class="badge badge-success">{{ $dt->transaksi->status_transaksi }}</span>
                                        @elseif ($dt->transaksi->status_transaksi == "expire" || $dt->transaksi->status_transaksi == "deny" || $dt->transaksi->status_transaksi == "authorize" || $dt->transaksi->status_transaksi == "cancel" || $dt->transaksi->status_transaksi == "failure")
                                            <span class="badge badge-danger">{{ $dt->transaksi->status_transaksi }}</span>
                                        @elseif ($dt->transaksi->status_transaksi == "pending")
                                            <span class="badge badge-warning">{{ $dt->transaksi->status_transaksi }}</span>
                                        @else
                                            <span class="badge badge-primary">{{ $dt->transaksi->status_transaksi }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty

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
