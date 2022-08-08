@extends('layouts.app')
@section('title', 'Detail Langganan')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Data Detail Langganan</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                        <li class="breadcrumb-item active">Detail Langganan</li>
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
                        <ul class="nav nav-tabs customtab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#langgananGeneral" role="tab">
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
                                    <span class="hidden-xs-down">Histori Berlangganan</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="langgananGeneral" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Detail Langganan</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="basic-information">
                                                <h4>Langganan</h4>
                                                <div class="birthday-content">
                                                    <span class="contact-title">ID Langganan</span>
                                                    <span class="birth-date">{{ $langganan->kode_langganan }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Produk</span>
                                                    <span class="gender">{{ $langganan->nama_produk . ' | ' . $langganan->nama_kategori }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status</span>
                                                    <span class="gender">{{ $langganan->status_langganan == 'a' ? 'Aktif' : 'Nonaktif' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Verifikasi</span>
                                                    <span class="gender">{{ $langganan->tanggal_verifikasi }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Instalasi</span>
                                                    <span class="gender">{{ $langganan->tanggal_instalasi ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Histori</span>
                                                    <span class="gender">{{ str_replace('|', ' - ', $langganan->histori) }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>
                                                    Keterangan Berlangganan Saat Ini
                                                    @if (\Carbon\Carbon::parse($detailLangganan->tanggal_kadaluarsa) < \Carbon\Carbon::now('+0700') && $detailLangganan->status_pembayaran == 'l')
                                                    {{-- <a href="">Test</a> --}}
                                                    <a href="{{ route('langganan.editjenislangganan', $langganan->kode_langganan) }}" class="btn btn-link p-0 my-0 mx-2">
                                                        <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                                    </a>
                                                    @endif
                                                </h4>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Mulai</span>
                                                    <span class="gender">{{ $detailLangganan->tanggal_mulai ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Kadaluarsa</span>
                                                    <span class="gender">{{ $detailLangganan->tanggal_kadaluarsa ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Selesai</span>
                                                    <span class="gender">{{ $detailLangganan->tanggal_selesai ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Sisa Tagihan</span>
                                                    <span class="gender">{{ $detailLangganan->sisa_tagihan ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status</span>
                                                    <span class="gender">{{ $detailLangganan->status_pembayaran == 'bl' ? 'Belum Lunas' : 'Lunas' }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Alamat Pemasangan</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">Provinsi</span>
                                                    <span class="phone-number">{{ $langganan->nama_provinsi }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Kabupaten</span>
                                                    <span class="contact-email">{{ $langganan->nama_kabupaten }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Kecamatan</span>
                                                    <span class="contact-email">{{ $langganan->nama_kecamatan }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Desa</span>
                                                    <span class="contact-email">{{ $langganan->nama_desa }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">RT/RW</span>
                                                    <span class="contact-email">{{ $langganan->rt .' / ' . $langganan->rw }}</span>
                                                </div>
                                                <div class="contact-information">
                                                    <h4>Pemetaan</h4>
                                                    <div id="addressMap" style="width: 100%; height:300px;"></div>
                                                    {{ $langganan->alamat_pemasangan }}
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
                                            @can('detail pelanggan')
                                            <a href="{{ route('pelanggan.show', $langganan->id_pelanggan) }}" class="btn btn-link p-0 m-0">
                                                <i class="ti-eye text-primary font-weight-bold"></i>
                                            </a>
                                            @endcan
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="basic-information">
                                                <h4>Biodata</h4>
                                                <div class="birthday-content">
                                                    <span class="contact-title">Nama:</span>
                                                    <span class="birth-date">{{ $langganan->nama_pelanggan }}</span>
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
                                                    <span class="contact-title">Status Pelanggan:</span>
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
                                                    <span class="phone-number">{{ '+' . $langganan->nomor_hp }}</span>
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
                                            <a aria-controls="1" role="tab" data-toggle="tab">Histori Langganan</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-stripped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>ID Langganan</th>
                                                            <th>Jenis Langganan</th>
                                                            <th>Tanggal Mulai</th>
                                                            <th>Tanggal Kadaluarsa</th>
                                                            <th>Tanggal Selesai</th>
                                                            <th>Status</th>
                                                            <th>Status Pembayaran</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($semuaDetailLangganan as $s)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $langganan->kode_langganan }}</td>
                                                                <td>{{ $s->jenis_berlangganan }}</td>
                                                                <td>{{ $s->tanggal_mulai ?? '-' }}</td>
                                                                <td>{{ $s->tanggal_kadaluarsa ?? '-' }}</td>
                                                                <td>{{ $s->tanggal_selesai ?? '-' }}</td>
                                                                <td>{{ $s->status == 'a'? 'Aktif' : 'Nonaktif' }}</td>
                                                                <td>{{ $s->status_pembayaran == 'bl'? 'Belum Lunas' : 'Lunas' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center">Tidak ada data histori berlangganan!</td>
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
        </div>
    </section>
@endsection
@push('css')
    <style>
        div.checkbox.switcher, div.radio.switcher {
            label {
                padding: 0;
                * {
                    vertical-align: middle;
                }
                input {
                    display: none;
                    &+span {
                        position: relative;
                        display: inline-block;
                        margin-right: 10px;
                        width: 56px;
                        height: 28px;
                        background: #f2f2f2;
                        border: 1px solid #eee;
                        border-radius: 50px;
                        transition: all 0.3s ease-in-out;
                        small {
                            position: absolute;
                            display: block;
                            width: 50%;
                            height: 100%;
                            background: #fff;
                            border-radius: 50%;
                            transition: all 0.3s ease-in-out;
                            left: 0;
                        }
                    }
                    &:checked+span {
                        background: #269bff;
                        border-color: #269bff;
                        small {
                            left: 50%;
                        }
                    }
                }
            }
        }
    </style>
@endpush
@push('js')
    <script>
        const userLat = {{ $langganan->latitude == null ? '-7.756928' : $langganan->latitude }};
        const userLng = {{ $langganan->longitude == null ? '113.211502' : $langganan->longitude }};
        // let address, map;
        // console.log(userLat, userLng);
        function initMap() {
            // Show MAP
            address = new google.maps.Map(document.getElementById("addressMap"), {
                center: {
                    lat: userLat,
                    lng: userLng
                },
                zoom: 16,
                scrollwheel: true,
            });
            let addressMarker = new google.maps.Marker({
                position: {
                    lat: userLat,
                    lng: userLng
                },
                map: address,
                draggable: false
            });
        }
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCWY-q7-nQ4ESJpVa1Jx4ErwzDCoJ73cAo&callback=initMap&libraries=&v=weekly">
    </script>
@endpush
