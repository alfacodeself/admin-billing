@extends('layouts.app')
@section('title', 'Tambah Pelanggan')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Tambah Pelanggan</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                        <li class="breadcrumb-item active">Tambah Pelanggan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.my-alert')
    <section id="main-content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('pelanggan.create') }}" method="POST" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold">Data Pelanggan</h4>
                            <br>
                            <div class="input-sizes">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3"><label for="foto">Foto Pelanggan</label></div>
                                                <div class="col-md-8">
                                                    <input type="file" class="form-control" id="foto" name="foto" value="{{ old('foto') }}">
                                                    @error('foto')
                                                        <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"><label for="nik">NIK</label></div>
                                                <div class="col-md-8">
                                                    <input type="number" placeholder="Nomor Induk Keluarga" value="{{ old('nik') }}" class="form-control" id="nik" name="nik">
                                                    @error('nik')
                                                        <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"><label for="nama">Nama Pelanggan</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" placeholder="Nama Pelanggan" value="{{ old('nama') }}" class="form-control" id="nama" name="nama">
                                                    @error('nama')
                                                        <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"><label for="jenis_kelamin">Jenis Kelamin</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="l" checked> Laki-Laki
                                                    <input type="radio" name="jenis_kelamin" id="jenis_kelamin"value="p"> Perempuan
                                                    @error('jenis_kelamin')
                                                        <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="nomor_hp">Nomor Handphone</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="number" placeholder="Nomor Handphone" value="{{ old('nomor_hp') }}" class="form-control" id="nomor_hp" name="nomor_hp">
                                                    @error('nomor_hp')
                                                        <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="email">E-mail</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="email" placeholder="E-mail Pelanggan" value="{{ old('email') }}" class="form-control" id="email" name="email">
                                                    @error('email')
                                                        <p><small><strong class="text-danger">{{ $message }}</strong></small></p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="col-md-12">
                                        <div id="map" style="height: 500px; width:100%"></div>
                                        <input type="hidden" name="longitude" id="longitude" value="{{ old('latitude') }}" readonly>
                                        <input type="hidden" name="latitude" id="latitude" value="{{ old('langitude') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title font-weight-bold">Dokumen Pelanggan</h4>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="10%">#</th>
                                            <th width="50%">Jenis Dokumen</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jenis_dokumen as $dokumen)
                                            @php
                                                $name = Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen));
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">
                                                    {{ $dokumen->nama_dokumen }}
                                                </td>
                                                <td class="text-left">
                                                    <input type="file" class="form-control form-control-sm" value="{{ old($name) }}" name="{{ $name }}">
                                                    @error($name)
                                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-capitalize">Tidak ada syarat dokumen!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-block btn-outline-primary">Tambah Data
                                Pelanggan</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        const userLat = {{ old('latitude') == null ? '-7.756928' : old('latitude') }};
        const userLng = {{ old('langitude') == null ? '113.211502' : old('langitude') }};
        // console.log(userLat, userLng);
        function initMap() {
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
