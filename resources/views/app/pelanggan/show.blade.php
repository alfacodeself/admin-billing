@extends('layouts.app')
@section('title', 'Detail Pelanggan')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Detail Pelanggan</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                        <li class="breadcrumb-item active">Detail Pelanggan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.my-alert')
    <section id="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card profile-card-5 mt-5">
                    <div class="card-img-block">
                        <img class="card-img-top" src="{{ url($pelanggan->foto) }}" alt="Card image cap" height="250">
                    </div>
                    <div class="card-body pt-0">
                        <h5 class="card-title">{{ $pelanggan->nama_pelanggan }}</h5>
                        <p class="card-text">{{ $pelanggan->alamat }}</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#fotoModal">Ubah Foto
                            Pelanggan</button>
                    </div>
                </div>
            </div>
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
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#profilModal">
                                                <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                            </button>
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
                                                    <span
                                                        class="gender">{{ $pelanggan->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status Pelanggan:</span>
                                                    <span
                                                        class="gender {{ $pelanggan->status == 'a' ? '' : 'text-danger' }}">{{ $pelanggan->status == 'a' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Kontak Informasi</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">No. Telp:</span>
                                                    <span class="phone-number">{{ '+' . $pelanggan->nomor_hp }}</span>
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
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#alamatModal">
                                                <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                            </button>
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
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#dokumenModal">
                                                <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                            </button>
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
    </section>
    {{-- ===============> Modal Section <======================= --}}
    <div class="modal fade" id="dokumenModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Dokumen Pelanggan</h5>
                </div>
                <form action="{{ route('pelanggan.show.update-dokumen', $pelanggan->id_pelanggan) }}" enctype="multipart/form-data" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-5">
                        <div class="form-group">
                            @foreach ($jenis_dokumen as $dokumen)
                                @php
                                    $name = Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen));
                                @endphp
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="id_provinsi">{{ $dokumen->nama_dokumen }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control form-control" name="{{ $name }}">
                                        @error($name)
                                            <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Dokumen Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="alamatModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Alamat Pelanggan</h5>
                </div>
                <form action="" method="post" class="form-horizontal">
                    @csrf
                    <div class="modal-body px-5">
                        <div class="row">
                            <div class="col-md-6">
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
                                        <div class="col-md-4 col-sm-6">
                                            <input type="number" value="{{ old('rt') }}" name="rt" id="rt/rw" class="form-control" placeholder="RT">
                                            @error('rt')
                                                <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <input type="number" value="{{ old('rw') }}" name="rw" id="rt/rw" class="form-control" placeholder="RW">
                                            @error('rw')
                                                <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3"><label for="alamat">Alamat Lengkap</label></div>
                                        <div class="col-md-8">
                                            <textarea name="alamat" id="alamat" class="form-control" style="height: 100px">{{ old('alamat') }}</textarea>
                                            @error('alamat')
                                                <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="map" style="height: 370px; width:100%"></div>
                                <input type="hidden" name="longitude" id="longitude" value="{{ old('latitude') }}" readonly>
                                <input type="hidden" name="latitude" id="latitude" value="{{ old('langitude') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Alamat Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="profilModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Profil Pelanggan</h5>
                </div>
                <form action="{{ route('pelanggan.show.update-profil', $pelanggan->id_pelanggan) }}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-5">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ $pelanggan->nama_pelanggan }}" placeholder="Nama">
                                    @error('nama')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">NIK</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="nik"
                                        value="{{ $pelanggan->nik }}" placeholder="NIK">
                                    @error('nik')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Jenis Kelamin</label>
                                <div class="col-sm-8">
                                    <input type="radio" name="jenis_kelamin" value="l"
                                        {{ $pelanggan->jenis_kelamin == 'l' ? 'checked' : '' }}> Laki-Laki
                                    <input type="radio" name="jenis_kelamin" value="p"
                                        {{ $pelanggan->jenis_kelamin == 'p' ? 'checked' : '' }}> Perempuan
                                    @error('nik')
                                        <br>
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ $pelanggan->email }}" placeholder="Email">
                                    @error('email')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">No. Handphone</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="nomor_hp"
                                        value="{{ $pelanggan->nomor_hp }}" placeholder="No Handphone">
                                    @error('nomor_hp')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="status" id="status" name="status" class="form-control">
                                        <option value="a" {{ $pelanggan->status == 'a' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="n" {{ $pelanggan->status == 'n' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Profil Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Foto Pelanggan</h5>
                </div>
                <form action="{{ route('pelanggan.show.update-foto', $pelanggan->id_pelanggan) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="foto">Foto Pelanggan</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Foto Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
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
    </style>
@endpush
@push('js')
    <script>
        const userLat = {{ $pelanggan->latitude == null ? '-7.756928' : $pelanggan->latitude }};
        const userLng = {{ $pelanggan->longitude == null ? '113.211502' : $pelanggan->longitude }};
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

            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: userLat,
                    lng: userLng
                },
                zoom: 18,
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
            // Make marker use click
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
