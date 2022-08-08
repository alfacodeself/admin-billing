@extends('layouts.app')
@section('title', 'Edit Alamat Langganan')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Update Jenis Langganan</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Update Langganan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@include('partials.my-alert')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('langganan.updatejenislangganan', $langganan->kode_langganan) }}" method="post">
            @csrf
            @method('POST')
            <div class="card mb-4">
                <h4 class="card-title text-center font-weight-bold">Pilih Langganan</h4>
                <br>
                <div class="card-body">
                    <div class="row">
                        @forelse ($jenis_langganan as $jenis)
                            <div class="col-md-4">
                                <label>
                                    <input type="radio" name="jenis_langganan" class="card-input-element"
                                        {{ old('jenis_langganan') == $jenis->id_jenis_langganan ? 'checked' : '' }}
                                        value="{{ $jenis->id_jenis_langganan }}" />
                                    <div class="card card-pricing text-center px-3">
                                        <span class="h6 mx-auto px-4 py-2 rounded-bottom bg-primary text-white"
                                            style="width: 250px">{{ $jenis->lama_berlangganan }}
                                        </span>
                                        <div class="bg-transparent card-header border-0">
                                            <h1 class="h4 font-weight-normal text-primary text-center mb-0"
                                                data-pricing-value="15">
                                                <span class="price">{{ $jenis->banyak_tagihan }} Bulan</span><br>
                                                <span class="h6 text-muted ml-2"> Berlangganan selama
                                                    {{ $jenis->banyak_tagihan }} bulan.</span>
                                            </h1>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @empty
                            Tidak ada data jenis berlangganan!
                        @endforelse
                    </div>
                    <button type="submit" class="btn btn-info btn-block">Update Langganan Anda</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('css')
    <style>
        label {
            width: 100%;
        }

        .card-input-element {
            display: none;
        }

        .card-pricing:hover {
            cursor: pointer;
        }

        .card-input-element:checked+.card-pricing {
            box-shadow: 0 0 3px 3px #2ecc71;
        }
    </style>
@endpush
