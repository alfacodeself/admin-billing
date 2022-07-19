@extends('layouts.app')
@section('title', 'Tambah Langganan')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Buat Langganan</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('langganan.index') }}">Langganan</a></li>
                        <li class="breadcrumb-item active">Buat Langganan</li>
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
                                        <input type="search" name="nik" class="form-control" placeholder="Masukkan NIK Pelanggan">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-outline-primary btn-block">
                                            <i class="ti-user font-weight-bold"></i>
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if (request()->nik)
                <div class="col-md-12">
                    <form action="{{ route('langganan.store') }}" method="POST" class="form-horizontal">
                        @csrf
                        @method('POST')
                        <div class="card mb-4">
                            <h4 class="card-title text-center font-weight-bold">Data Pelanggan</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card profile-card-5 mt-5">
                                        <div class="card-img-block">
                                            <img class="card-img-top" src="{{ url($pelanggan->foto) }}" alt="Card image cap" height="250">
                                        </div>
                                        <div class="card-body pt-0">
                                            <h5 class="card-title">{{ $pelanggan->nama_pelanggan }}</h5>
                                            <p class="card-text">{{ $pelanggan->alamat }}</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="pelanggan" required readonly value="{{ $pelanggan->id_pelanggan }}">
                                <div class="col-md-8">
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <ul class="nav nav-tabs customtab2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                                                        <span class="hidden-sm-up">
                                                            <i class="ti-user"></i>
                                                        </span>
                                                        <span class="hidden-xs-down">Profil</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#alamat" role="tab">
                                                        <span class="hidden-sm-up">
                                                            <i class="ti-map-alt"></i>
                                                        </span>
                                                        <span class="hidden-xs-down">Alamat</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#dokumen" role="tab">
                                                        <span class="hidden-sm-up">
                                                            <i class="ti-agenda"></i>
                                                        </span>
                                                        <span class="hidden-xs-down">Dokumen</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="profile" role="tabpanel">
                                                    <div class="custom-tab user-profile-tab">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active">
                                                                <a aria-controls="1" role="tab" data-toggle="tab">Tentang</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane active" id="1">
                                                                <div class="basic-information">
                                                                    <h4>Biodata</h4>
                                                                    <div class="birthday-content">
                                                                        <span class="contact-title">Nama:</span>
                                                                        <span class="birth-date">{{ $pelanggan->nama_pelanggan }}</span>
                                                                    </div>
                                                                    <div class="birthday-content">
                                                                        <span class="contact-title">NIK:</span>
                                                                        <span class="birth-date">{{ $pelanggan->nik }}</span>
                                                                    </div>
                                                                    <div class="gender-content">
                                                                        <span class="contact-title">Jenis Kelamin:</span>
                                                                        <span class="gender">
                                                                            {{ $pelanggan->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="gender-content">
                                                                        <span class="contact-title">Status Pelanggan:</span>
                                                                        <span class="gender">{{ $pelanggan->status == 'a' ? 'Aktif' : 'Nonaktif' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="contact-information">
                                                                    <h4>Kontak Informasi</h4>
                                                                    <div class="phone-content">
                                                                        <span class="contact-title">No. Telp:</span>
                                                                        <span class="phone-number">{{ $pelanggan->nomor_hp }}</span>
                                                                    </div>
                                                                    <div class="email-content">
                                                                        <span class="contact-title">Email:</span>
                                                                        <span class="contact-email">{{ $pelanggan->email }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-20" id="alamat" role="tabpanel">
                                                    <div class="custom-tab user-profile-tab">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active">
                                                                <a aria-controls="1" role="tab" data-toggle="tab">Alamat</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane active" id="1">
                                                                <div class="basic-information">
                                                                    <h4>Detail Alamat</h4>
                                                                    <div class="birthday-content">
                                                                        <span class="contact-title">Desa:</span>
                                                                        <span class="birth-date">{{ $pelanggan->desa->nama_desa }}</span>
                                                                    </div>
                                                                    <div class="birthday-content">
                                                                        <span class="contact-title">Kecamatan:</span>
                                                                        <span
                                                                            class="birth-date">{{ $pelanggan->desa->kecamatan->nama_kecamatan }}</span>
                                                                    </div>
                                                                    <div class="gender-content">
                                                                        <span class="contact-title">Kabupaten:</span>
                                                                        <span
                                                                            class="gender">{{ $pelanggan->desa->kecamatan->kabupaten->nama_kabupaten }}</span>
                                                                    </div>
                                                                    <div class="gender-content">
                                                                        <span class="contact-title">Provinsi:</span>
                                                                        <span
                                                                            class="gender">{{ $pelanggan->desa->kecamatan->kabupaten->provinsi->nama_provinsi }}</span>
                                                                    </div>
                                                                    <div class="gender-content">
                                                                        <span class="contact-title">RT/RW:</span>
                                                                        <span class="gender">{{ $pelanggan->rt }} /
                                                                            {{ $pelanggan->rw }}</span>
                                                                    </div>
                                                                    <div class="gender-content">
                                                                        <span class="contact-title">Kode Pos:</span>
                                                                        <span class="gender">{{ $pelanggan->desa->kode_pos }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="contact-information">
                                                                    <h4>Pemetaan</h4>
                                                                    <div id="addressMap" style="width: 100%; height:300px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-20" id="dokumen" role="tabpanel">
                                                    <div class="custom-tab user-profile-tab">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active">
                                                                <a aria-controls="1" role="tab" data-toggle="tab">Dokumen</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane active" id="1">
                                                                <div class="basic-information">
                                                                    <h4>Dokumen Pelanggan</h4>
                                                                    @foreach ($pelanggan->dokumen_pelanggan as $dokumen)
                                                                        @if ($dokumen->jenis_dokumen->status == 'a')
                                                                            <div class="birthday-content">
                                                                                <span class="contact-title">{{ $dokumen->jenis_dokumen->nama_dokumen }}:</span>
                                                                                <span class="birth-date">
                                                                                    <a href="{{ url($dokumen->path_dokumen) }}"
                                                                                        class="btn btn-link text-success py-0" target="__blank">
                                                                                        <i class="ti-files font-weight-bold text-primary"></i>
                                                                                        Link {{ $dokumen->jenis_dokumen->nama_dokumen }}
                                                                                    </a>
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
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
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title text-center font-weight-bold">Alamat Berlangganan</h4>
                                <br>
                                <div class="input-sizes">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="id_provinsi">Provinsi</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="provinsi" id="provinsi" class="form-control" onchange="updateKabupaten()">
                                                            <option value="" selected disabled>Pilih Provinsi</option>
                                                            @forelse ($provinsi as $p)
                                                                <option value="{{ $p->id_provinsi }}" {{ old('provinsi') == $p->id_provinsi ? 'selected' : '' }}>
                                                                    {{ $p->nama_provinsi }}
                                                                </option>
                                                            @empty
                                                                <option>Tidak ada provinsi!</option>
                                                            @endforelse
                                                        </select>
                                                        @error('provinsi')
                                                            <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="kabupaten">Kabupaten</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="kabupaten" id="kabupaten" Class="form-control" onchange="updateKecamatan()" disabled>
                                                            <option value="" selected>Pilih Kabupaten</option>
                                                        </select>
                                                        @error('kabupaten')
                                                            <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="kecamatan">Kecamatan</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="kecamatan" id="kecamatan" class="form-control" onchange="updateDesa()" disabled>
                                                            <option value="" selected>Pilih Kecamatan</option>
                                                        </select>
                                                        @error('kecamatan')
                                                            <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="desa">Desa</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="desa" id="desa" class="form-control" disabled>
                                                            <option value="" selected disabled>Pilih Desa</option>
                                                        </select>
                                                        @error('desa')
                                                            <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="rt/rw">RT/RW</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="number" name="rt" value="{{ old('rt') }}" id="rt/rw" class="form-control"
                                                            placeholder="RT">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="number" name="rw" id="rt/rw" value="{{ old('rw') }}" class="form-control"
                                                            placeholder="RW">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3"><label for="alamat">Alamat Lengkap</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <textarea name="alamat" id="alamat" class="form-control" style="height: 100px">{{ old('alamat') }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">Latitude/Longitude</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="latitude" value="{{ old('latitude') }}" class="form-control" id="latitude"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="longitude" value="{{ old('longitude') }}" class="form-control"
                                                            id="longitude" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="map">Map</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div id="map" style="height: 250px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <h4 class="card-title text-center font-weight-bold">Pilih Produk</h4>
                            <br>
                            <div class="card-body">
                                {{-- @dd($kategori) --}}
                                @forelse ($kategori as $k)
                                <div class="row">
                                    @forelse ($k->produk as $p)
                                    <div class="col-md-4 mx-auto">
                                        <label>
                                            <input type="radio" name="produk" class="card-input-element" {{ old('produk') == $p->id_produk ? 'checked' : '' }} value="{{ $p->id_produk }}"/>
                                            <div class="card card-pricing text-center px-3 mb-4">
                                                <span class="h6 mx-auto px-4 py-2 rounded-bottom bg-primary text-white"
                                                    style="width: 150px">{{ $k->nama_kategori }}</span>
                                                <div class="bg-transparent card-header pt-4 border-0">
                                                    <h1 class="h1 font-weight-normal text-primary text-center mb-0"
                                                        data-pricing-value="15">
                                                        <span class="price">{{ $p->harga }}</span>
                                                        <h6 class="h6 text-muted">per bulan</h6>
                                                    </h1>
                                                </div>
                                                <div class="card-body pt-0 px-3">
                                                    <ul class="list-unstyled mb-4">
                                                        @foreach ($p->fitur as $fitur)
                                                            <li>{{ $fitur }}</li>
                                                        @endforeach
                                                        <li>{{ $p->deskripsi }}</li>
                                                    </ul>
                                                    <a class="btn btn-info text-white mb-3">Klik Untuk Memilih</a>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @empty
                                        Tidak ada data dari produk {{ $k->nama_kategori }}
                                    @endforelse
                                </div>
                                @empty
                                    Tidak Ada Data Kategori!
                                @endforelse
                            </div>
                        </div>
                        <div class="card mb-4">
                            <h4 class="card-title text-center font-weight-bold">Pilih Langganan</h4>
                            <br>
                            <div class="card-body">
                                {{-- @dd($jenis_langganan) --}}
                                <div class="row">
                                    @forelse ($jenis_langganan as $jenis)
                                    <div class="col-md-4">
                                        <label>
                                            <input type="radio" name="jenis_langganan" class="card-input-element" {{ old('jenis_langganan') == $jenis->id_jenis_langganan ? 'checked' : '' }} value="{{ $jenis->id_jenis_langganan }}"/>
                                            <div class="card card-pricing text-center px-3">
                                                <span class="h6 mx-auto px-4 py-2 rounded-bottom bg-primary text-white"
                                                    style="width: 250px">{{ $jenis->lama_berlangganan }}
                                                </span>
                                                <div class="bg-transparent card-header border-0">
                                                    <h1 class="h4 font-weight-normal text-primary text-center mb-0"
                                                        data-pricing-value="15">
                                                        <span class="price">{{ $jenis->banyak_tagihan }} Bulan</span><br>
                                                        <span class="h6 text-muted ml-2"> Berlangganan selama {{ $jenis->banyak_tagihan }} bulan.</span>
                                                    </h1>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @empty
                                        Tidak ada data jenis berlangganan!
                                    @endforelse
                                </div>
                                <button type="submit" class="btn btn-info btn-block">Buat Langganan</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </section>
@endsection
@if (request()->nik)
@push('css')
<style>
    .profile-card-5 {
        margin-top: 20px;
    }

    .profile-card-5 .btn {
        border-radius: 2px;
        text-transform: uppercase;
        font-size: 12px;
        padding: 7px 20px;
    }

    .profile-card-5 .card-img-block {
        width: 91%;
        margin: 0 auto;
        position: relative;
        top: -50px;

    }

    .profile-card-5 .card-img-block img {
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.63);
    }

    .profile-card-5 h5 {
        color: #4E5E30;
        font-weight: 600;
    }

    .profile-card-5 p {
        font-size: 14px;
        font-weight: 300;
    }

    .profile-card-5 .btn-primary {
        background-color: #4E5E30;
        border-color: #4E5E30;
    }
    .card-pricing.popular {
        z-index: 1;
        border: 3px solid #007bff;
    }

    .card-pricing .list-unstyled li {
        padding: .5rem 0;
        color: #000000;
    }

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
    const userLat = {{ old('latitude') == null ? '-7.756928' : old('latitude')}};
    const userLng = {{ old('longitude') == null ? '113.211502' : old('longitude') }};
    // console.log(userLat, userLng);
    function initMap() {
        address = new google.maps.Map(document.getElementById("addressMap"), {
            center: {
                lat: {{ $pelanggan->latitude != null ? $pelanggan->latitude : '-7.756928' }},
                lng: {{ $pelanggan->longitude != null ? $pelanggan->longitude : '113.211502' }}
            },
            zoom: 16,
            scrollwheel: true,
        });
        let addressMarker = new google.maps.Marker({
            position: {
                lat: {{ $pelanggan->latitude != null ? $pelanggan->latitude : '-7.756928' }},
                lng: {{ $pelanggan->longitude != null ? $pelanggan->longitude : '-113.211502' }}
            },
            map: address,
            draggable: false
        });
        // Show MAP
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: userLat,
                lng: userLng
            },
            zoom: 13,
            scrollwheel: true,
        });
        // Make marker use drag
        const uluru = {
            lat: userLat,
            lng: userLng
        };
        let marker = new google.maps.Marker({
            position: uluru,
            map: map,
            draggable: true
        });
        // // Make marker use click
        google.maps.event.addListener(map, 'click', function(event) {
            pos = event.latLng
            marker.setPosition(pos);
        })
        // Add to form
        google.maps.event.addListener(marker, 'position_changed', function() {
            let lat = marker.position.lat();
            let lng = marker.position.lng();
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        });
    }
</script>
<script async
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCWY-q7-nQ4ESJpVa1Jx4ErwzDCoJ73cAo&callback=initMap&libraries=&v=weekly">
</script>
<script>
    function updateKabupaten() {
        let prov = $('#provinsi').val();
        $('#kabupaten').children().remove();
        $('#kabupaten').val('');
        $('#kabupaten').append('<option value="" selected disabled>Pilih Kabupaten</option>');
        $('#kabupaten').prop('disabled', true);
        updateKecamatan();
        var url = '{{ route('kabupaten.update', ':id') }}';
        url = url.replace(':id', prov);
        if (prov != '' && prov != null) {
            $.ajax({
                url,
                success: function(res) {
                    $('#kabupaten').prop('disabled', false);
                    let html = '';
                    $.each(res, function(index, data) {
                        html += '<option value="' + data.id_kabupaten + '">' + data.nama_kabupaten +
                            '</option>';
                    })
                    $('#kabupaten').append(html)
                }
            })
        }
    }

    function updateKecamatan() {
        let kab = $('#kabupaten').val();
        $('#kecamatan').children().remove();
        $('#kecamatan').val('');
        $('#kecamatan').append('<option value="" selected disabled>Pilih Kecamatan</option>');
        $('#kecamatan').prop('disabled', true);
        updateDesa();
        var url = '{{ route('kecamatan.update', ':id') }}';
        url = url.replace(':id', kab);
        if (kab != '' && kab != null) {
            $.ajax({
                url,
                success: function(res) {
                    $('#kecamatan').prop('disabled', false);
                    let html = '';
                    $.each(res, function(index, data) {
                        html += '<option value="' + data.id_kecamatan + '">' + data.nama_kecamatan +
                            '</option>';
                    })
                    $('#kecamatan').append(html)
                }
            })
        }
    }

    function updateDesa() {
        let kec = $('#kecamatan').val();
        $('#desa').children().remove();
        $('#desa').val('');
        $('#desa').append('<option value="" selected disabled>Pilih Desa</option>');
        $('#desa').prop('disabled', true);
        var url = '{{ route('desa.update', ':id') }}';
        url = url.replace(':id', kec);
        if (kec != '' && kec != null) {
            $.ajax({
                url,
                success: function(res) {
                    $('#desa').prop('disabled', false);
                    let html = '';
                    $.each(res, function(index, data) {
                        html += '<option value="' + data.id_desa + '">' + data.nama_desa + ' (' +
                            data.kode_pos + ')</option>';
                    })
                    $('#desa').append(html)
                }
            })
        }
    }
</script>
@endpush
@endif
