@extends('layouts.app')
@section('title', 'Tambah Transaksi')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Buat Transaksi</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Buat Transaksi</li>
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
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="search" name="langganan" class="form-control"
                                            placeholder="Masukkan ID Langganan">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-outline-primary btn-block">
                                            <i class="ti-bookmark-alt font-weight-bold"></i>
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if (request()->langganan)
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h4 class="card-title text-center font-weight-bold">Data Langganan</h4>
                        <div class="row">
                            <input type="hidden" name="langganan" required readonly
                                value="{{ $langganan->id_langganan }}">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs customtab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#langgananGeneral"
                                            role="tab">
                                            <span class="hidden-sm-up">
                                                <i class="ti-bookmark-alt"></i>
                                            </span>
                                            <span class="hidden-xs-down">Detail Langganan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#pelanggan" role="tab">
                                            <span class="hidden-sm-up">
                                                <i class="ti-user"></i>
                                            </span>
                                            <span class="hidden-xs-down">Detail Pelanggan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#historiLangganan" role="tab">
                                            <span class="hidden-sm-up">
                                                <i class="ti-bookmark-alt"></i>
                                            </span>
                                            <span class="hidden-xs-down">Transaksi</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="langgananGeneral" role="tabpanel">
                                        <div class="custom-tab user-profile-tab">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active">
                                                    <a aria-controls="1" role="tab" data-toggle="tab">Detail
                                                        Langganan</a>
                                                    <a class="btn btn-link p-0 m-0"
                                                        href="{{ route('langganan.show', $langganan->id_langganan) }}">
                                                        <i class="ti-eye text-primary font-weight-bold"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="1">
                                                    <div class="basic-information">
                                                        <h4>Langganan</h4>
                                                        <div class="birthday-content">
                                                            <span class="contact-title">ID Langganan</span>
                                                            <span
                                                                class="birth-date">{{ $langganan->kode_langganan }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Produk</span>
                                                            <span
                                                                class="gender">{{ $langganan->nama_produk . ' | ' . $langganan->nama_kategori }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Status</span>
                                                            <span
                                                                class="gender">{{ $langganan->status_langganan == 'a' ? 'Aktif' : 'Nonaktif' }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Tanggal
                                                                Verifikasi</span>
                                                            <span
                                                                class="gender">{{ $langganan->tanggal_verifikasi }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Tanggal
                                                                Instalasi</span>
                                                            <span
                                                                class="gender">{{ $langganan->tanggal_instalasi ?? '-' }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Histori</span>
                                                            <span class="gender">{{ $langganan->histori }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="contact-information">
                                                        <h4>Alamat Pemasangan</h4>
                                                        <div class="phone-content">
                                                            <span class="contact-title">Provinsi</span>
                                                            <span class="phone-number">{{ $langganan->provinsi }}</span>
                                                        </div>
                                                        <div class="email-content">
                                                            <span class="contact-title">Kabupaten</span>
                                                            <span
                                                                class="contact-email">{{ $langganan->kabupaten }}</span>
                                                        </div>
                                                        <div class="email-content">
                                                            <span class="contact-title">Kecamatan</span>
                                                            <span
                                                                class="contact-email">{{ $langganan->kecamatan }}</span>
                                                        </div>
                                                        <div class="email-content">
                                                            <span class="contact-title">Desa</span>
                                                            <span class="contact-email">{{ $langganan->desa }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="contact-information">
                                                        <h4>Keterangan Berlangganan Saat Ini</h4>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Tanggal Mulai</span>
                                                            <span
                                                                class="gender">{{ $langganan->tanggal_mulai ?? '-' }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Tanggal
                                                                Kadaluarsa</span>
                                                            <span
                                                                class="gender">{{ $langganan->tanggal_kadaluarsa ?? '-' }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Tanggal Selesai</span>
                                                            <span
                                                                class="gender">{{ $langganan->tanggal_selesai ?? '-' }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Sisa Tagihan</span>
                                                            <span
                                                                class="gender">{{ $langganan->sisa_tagihan ?? '-' }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Status</span>
                                                            <span
                                                                class="gender">{{ $langganan->status_pembayaran == 'bl' ? 'Belum Lunas' : 'Lunas' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-20" id="pelanggan" role="tabpanel">
                                        <div class="custom-tab user-profile-tab">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active">
                                                    <a aria-controls="1" role="tab" data-toggle="tab">Pelanggan</a>
                                                    <a href="{{ route('pelanggan.show', $langganan->id_pelanggan) }}"
                                                        class="btn btn-link p-0 m-0">
                                                        <i class="ti-eye text-primary font-weight-bold"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="1">
                                                    <div class="basic-information">
                                                        <h4>Biodata</h4>
                                                        <div class="birthday-content">
                                                            <span class="contact-title">Nama:</span>
                                                            <span
                                                                class="birth-date">{{ $langganan->nama_pelanggan }}</span>
                                                        </div>
                                                        <div class="birthday-content">
                                                            <span class="contact-title">NIK:</span>
                                                            <span class="birth-date">{{ $langganan->nik }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Jenis Kelamin:</span>
                                                            <span
                                                                class="gender">{{ $langganan->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                        </div>
                                                        <div class="gender-content">
                                                            <span class="contact-title">Status
                                                                Pelanggan:</span>
                                                            <span
                                                                class="gender {{ $langganan->status_pelanggan == 'a' ? '' : 'text-danger' }}">
                                                                {{ $langganan->status_pelanggan == 'a' ? 'Aktif' : 'Tidak Aktif' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="contact-information">
                                                        <h4>Kontak Informasi</h4>
                                                        <div class="phone-content">
                                                            <span class="contact-title">No. Telp:</span>
                                                            <span
                                                                class="phone-number">{{ '+' . $langganan->nomor_hp }}</span>
                                                        </div>
                                                        <div class="email-content">
                                                            <span class="contact-title">Email:</span>
                                                            <span class="contact-email">{{ $langganan->email }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-20" id="historiLangganan" role="tabpanel">
                                        <div class="custom-tab user-profile-tab">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active">
                                                    <a aria-controls="1" role="tab" data-toggle="tab">Transaksi</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="1">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-stripped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>ID Transaksi</th>
                                                                    <th>ID Langganan</th>
                                                                    <th>Petugas</th>
                                                                    <th>Metode</th>
                                                                    <th>Via</th>
                                                                    <th>Total Bayar</th>
                                                                    <th>Status</th>
                                                                    <th>Tanggal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                {{-- @dd($transaksi) --}}
                                                                @forelse ($transaksi as $t)
                                                                    <tr>
                                                                        <th scope="row">
                                                                            {{ $loop->iteration }}</th>
                                                                        <td>{{ $t->id_transaksi }}</td>
                                                                        <td>{{ $langganan->kode_langganan }}
                                                                        </td>
                                                                        <td>{{ $t->petugas->nama_petugas ?? '-' }}
                                                                        </td>
                                                                        <td>{{ $t->metode_pembayaran->metode_pembayaran ?? '-' }}
                                                                        </td>
                                                                        <td>
                                                                            <img src="{{ url($t->metode_pembayaran->logo ?? '-') }}"
                                                                                alt="Logo" width="50">
                                                                        </td>
                                                                        <td>{{ 'Rp.' . number_format($t->total_bayar) }}
                                                                        </td>
                                                                        <td>
                                                                            @if ($t->status_transaksi == 'settlement' ||
                                                                                $t->status_transaksi == 'capture' ||
                                                                                $t->status_transaksi == 'refund')
                                                                                <span
                                                                                    class="badge badge-success">{{ $t->status_transaksi }}</span>
                                                                            @elseif($t->status_transaksi == 'expire' ||
                                                                                $t->status_transaksi == 'deny' ||
                                                                                $t->status_transaksi == 'authorize' ||
                                                                                $t->status_transaksi == 'cancel' ||
                                                                                $t->status_transaksi == 'failure')
                                                                                <span
                                                                                    class="badge badge-danger">{{ $t->status_transaksi }}</span>
                                                                            @elseif($t->status_transaksi == 'pending')
                                                                                <span
                                                                                    class="badge badge-warning">{{ $t->status_transaksi }}</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge badge-primary">{{ $t->status_transaksi }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $t->tanggal_transaksi }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="9" class="text-center">
                                                                            Belum ada
                                                                            transaksi!</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @dd() --}}
                    @if ($langganan->tanggal_kadaluarsa == null ||
                        \Carbon\Carbon::now()->toDateString() > $langganan->tanggal_kadaluarsa)
                        <form action="{{ route('transaksi.store', $langganan->kode_langganan) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('POST')
                            <div class="card mb-4">
                                <h4 class="card-title text-center font-weight-bold">Jenis Pembayaran</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-stripped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Jenis Pembayaran</th>
                                                        <th>Banyak</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($langganan->tanggal_instalasi == null)
                                                        @forelse ($jenis_bayar as $key => $jb)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $jb->jenis_pembayaran }}</td>
                                                                <td>
                                                                    1
                                                                </td>
                                                                <td>{{ $jb->jenis_biaya == 'f' ? 'Rp.' . number_format($jb->harga) : 'Rp.' . number_format(($jb->harga / 100) * $langganan->withmargin) }}
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Belum ada
                                                                    transaksi!</td>
                                                            </tr>
                                                        @endforelse
                                                        <tr>
                                                            <th scope="row">{{ count($jenis_bayar) + 1 }}</th>
                                                            <td>{{ $langganan->nama_produk }}</td>
                                                            <td>
                                                                <input type="number" id="tagihan" class="form-control"
                                                                    style="width: 60px" onchange="changePrice()" value="1"
                                                                    max="{{ $langganan->sisa_tagihan }}" min="1"
                                                                    name="jumlah_tagihan">
                                                                @error('tagihan')
                                                                    <strong>
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    </strong>
                                                                @enderror
                                                            </td>
                                                            <td id="priceDinamis">
                                                                {{ 'Rp.' . number_format($langganan->withmargin) }}
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @forelse ($jenis_bayar as $key => $jb)
                                                            @if ($key != 0)
                                                                <tr>
                                                                    <th scope="row">{{ $loop->iteration - 1 }}</th>
                                                                    <td>{{ $jb->jenis_pembayaran }}</td>
                                                                    <td>
                                                                        1
                                                                    </td>
                                                                    <td>{{ $jb->jenis_biaya == 'f' ? 'Rp.' . number_format($jb->harga) : 'Rp.' . number_format(($jb->harga / 100) * $langganan->withmargin) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Belum ada
                                                                    transaksi!</td>
                                                            </tr>
                                                        @endforelse
                                                        <tr>
                                                            <th scope="row">{{ count($jenis_bayar) }}</th>
                                                            <td>{{ $langganan->nama_produk }}</td>
                                                            <td>
                                                                <input type="number" id="tagihan" class="form-control"
                                                                    style="width: 60px" onchange="changePrice()" value="1"
                                                                    max="{{ $langganan->sisa_tagihan }}" min="1"
                                                                    name="jumlah_tagihan">
                                                                @error('tagihan')
                                                                    <strong>
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    </strong>
                                                                @enderror
                                                            </td>
                                                            <td id="priceDinamis">
                                                                {{ 'Rp.' . number_format($langganan->withmargin) }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="4">
                                                            <button type="button" id="btn-total"
                                                                class="btn btn-info text-right" onclick="changeTotal()">Hitung
                                                                Total</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3" class="font-weight-bold" scope="row">Total</th>
                                                        <td id="totalDinamis">Rp.0</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <h4 class="card-title text-center font-weight-bold">Metode Pembayaran</h4>
                                <div class="row">
                                    @forelse ($metode_bayar as $mb)
                                    <div class="col-md-4 mx-auto">
                                        <label>
                                            <input type="radio" name="metode_bayar" class="card-input-element" {{ old('metode_bayar') == $mb->id_metode_pembayaran ? 'checked' : '' }} value="{{ $mb->id_metode_pembayaran }}"/>
                                            <div class="card card-pricing text-center">
                                                <span class="h6 mx-auto px-4 py-2 rounded-bottom bg-primary text-white"
                                                    style="width: 150px">{{ $mb->metode_pembayaran }}</span>
                                                <div class="bg-transparent card-header pt-4 border-0">
                                                    <img src="{{ url($mb->logo) }}" alt="logo" width="210" height="130">
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @empty
                                        Tidak ada data metode pembayaran!
                                    @endforelse
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-block">Buat Transaksi</button>
                        </form>
                    @else
                        Langganan anda belum kadaluarsa.
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
@if (request()->langganan)
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
    @push('js')
        <script>
            function changePrice() {
                let val = $('#tagihan').val()
                let price = {{ $langganan->withmargin }}
                $('#priceDinamis').empty()
                $('#totalDinamis').empty()
                const total = price * val;
                let html = '';
                html += '<span>' + 'Rp.' + total.toLocaleString('id-ID') + '</span>'
                $('#priceDinamis').append(html)
                $('#btn-total').prop('disabled', false);
                // changeTotal()
            }

            function changeTotal() {
                $('#totalDinamis').empty()
                let tagihan = $('#tagihan').val();
                var kode = '{{ $langganan->kode_langganan }}'
                var url = '{{ route('change-total', ':id') }}';
                url = url.replace(':id', kode);
                $.ajax({
                    url,
                    data: {
                        tagihan
                    },
                    success: function(res) {
                        $('#btn-total').prop('disabled', true);
                        let html = '';
                        html += '<span>' + 'Rp.' + res.toLocaleString('id-ID') + '</span>'
                        $('#totalDinamis').append(html)
                    },
                    error: function(err) {
                        alert(err)
                    }
                })
            }
        </script>
    @endpush
@endif
