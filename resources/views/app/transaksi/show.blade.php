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
                                    <th>Status</th>
                                    <th>Tanggungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>HHK9830138</td>
                                    <td>Pemasangan Instalasi</td>
                                    <td>
                                        <span class="badge badge-success">Lunas</span>
                                    </td>
                                    <td>Rp.390,000</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>HHK9830138</td>
                                    <td>Tagihan Produk Langganan</td>
                                    <td>
                                        <span class="badge badge-success">Lunas</span>
                                    </td>
                                    <td>Rp.390,000</td>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        <strong>Total Bayar</strong>
                                    </th>
                                    <td>
                                        Rp.710.000
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
