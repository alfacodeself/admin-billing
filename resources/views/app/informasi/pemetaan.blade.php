@extends('layouts.app')
@section('title', 'Pemetaan Layanan')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Pemetaan Langganan</h1>
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
                        <form action="{{ route('pemetaan.informasi') }}" method="get">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <select name="jenis" id="jenis" class="form-control" onchange="changeStatus()">
                                            <option value="">Pilih Jenis Pencarian</option>
                                            <option value="status">Status</option>
                                            <option value="provinsi">Provinsi</option>
                                            <option value="kabupaten">Kabupaten</option>
                                            <option value="kecamatan">Kecamatan</option>
                                            <option value="desa">Desa</option>
                                            <option value="pelanggan">Pelanggan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="status" id="status" class="form-control">
                                            <option value="" selected disabled>Pilih Status Pencarian</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-outline-primary btn-block">
                                            <i class="ti-map-alt font-weight-bold"></i>
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- @dd(isset($data)) --}}
            @isset($data)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="map" style="width:100%; height:100vh"></div>
                    </div>
                </div>
            </div>
            @endisset
        </div>
    </section>

@endsection
@push('js')
    @isset ($data)
        <script>
            let data = {!! $data !!}
            const userLat = Number(data[0][1]);
            const userLng = Number(data[0][2]);
            let map;
            function initMap() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: {
                        lat: userLat,
                        lng: userLng
                    },
                    zoom: 14,
                    scrollwheel: true,
                });
                setMarkers(map);
            }

            // Z indek untuk menentukan prioritas ketika menumpuk
            const services = data;
            // const services = ["Service 1", -7.887537188453385, 112.90761844744871, 4],
            //     ["Service 2", -8.100614768736964, 114.08319803307863, 3],
            //     ["Service 3", -7.920183068645684, 111.99575321307371, 2],
            //     ["Service 4", -7.822237706960744, 113.47066776385496, 1],;
            function setMarkers(map) {

                // Shapes define the clickable region of the icon. The type defines an HTML
                // <area> element 'poly' which traces out a polygon as a series of X,Y points.
                // The final coordinate closes the poly by connecting to the first coordinate.
                const shape = {
                    coords: [1, 1, 1, 20, 18, 20, 18, 1],
                    type: "poly",
                };
                for (let i = 0; i < services.length; i++) {
                    const service = services[i];
                    const contentString = '<div class="card" style="border-left: 4px blue solid; width: 16rem">' +
                                '<div class="card-body">' +
                                    '<h5 class="card-title text-capitalize">'+service[0] +'</h5>'+ service[8] +
                                    '<hr>' +
                                    '<p class="card-text text-capitalize">Alamat : '+service[6]+'</p>' +
                                    '<p class="card-text">Produk : '+service[4]+' <span class="badge badge-primary px-2 py-1">'+service[5]+'</span></p>' +
                                    '<p class="card-text">Status Langganan : '+service[9]+'</p>' +
                                    '<p class="card-text">Pemasangan Instalasi : '+service[7]+'</p>' +
                                '</div>' +
                            '</div>';
                    const infowindow = new google.maps.InfoWindow({
                        content: contentString,
                    });

                    const marker = new google.maps.Marker({
                        position: { lat: Number(service[1]), lng: Number(service[2]) },
                        map,
                        icon: {
                            url: service[8] ? '{{ asset('assets/images/icon/verify.png') }}' : '{{ asset('assets/images/icon/noverify.png') }}',
                            // url: '{{ asset('assets/images/icon/icons8-place-marker-32.png') }}',
                            size: new google.maps.Size(32,32),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(0,32),
                        },
                        shape: shape,
                        title: service[0],
                        zIndex: service[3],
                    });
                    marker.addListener("click", () => {
                        infowindow.open({
                            anchor: marker,
                            map,
                            shouldFocus: true,
                        });
                    });
                }
            }
        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCWY-q7-nQ4ESJpVa1Jx4ErwzDCoJ73cAo&callback=initMap&libraries=&v=weekly">
        </script>
    @endisset
    <script>
        function changeStatus() {
            let jenis = $('#jenis').val();
            $('#status').children().remove();
            $('#status').val('');
            $('#status').append('<option value="" selected disabled>Pilih Status Pencarian</option>');
            $('#status').prop('disabled', true);
            var html = '';
            if (jenis == 'status') {
                html += '<option value="a">Aktif</option>';
                html += '<option value="n">Nonaktif</option>';
                html += '<option value="pn">Pengajuan</option>';
                html += '<option value="pni">Pengajuan Instalasi</option>';
                html += '<option value="pmi">Pemasangan Instalasi</option>';
                html += '<option value="dt">Ditolak</option>';
                html += '<option value="dtr">Diterima</option>';
                $('#status').prop('disabled', false);
                $('#status').html(html)
            }else if (jenis == 'pelanggan') {
                html += '<option value="a">Aktif</option>';
                html += '<option value="n">Nonaktif</option>';
                $('#status').prop('disabled', false);
                $('#status').html(html)
            }else if (jenis == 'provinsi') {
                $.ajax({
                    url:'{{ route("pemetaan.set-status") }}',
                    data:{jenis},
                    success:function(res){
                        res.forEach(e => {
                            html += '<option value="' + e.id_provinsi + '">' + e.nama_provinsi + '</option>';
                        });
                        $('#status').prop('disabled', false);
                        $('#status').html(html)
                    }
                })

            }else if (jenis == 'kabupaten') {
                $.ajax({
                    url:'{{ route("pemetaan.set-status") }}',
                    data:{jenis},
                    success:function(res){
                        res.forEach(e => {
                            html += '<option value="' + e.id_kabupaten + '">' + e.nama_kabupaten + '</option>';
                        });
                        $('#status').prop('disabled', false);
                        $('#status').html(html)
                    }
                })
            }else if (jenis == 'kecamatan') {
                $.ajax({
                    url:'{{ route("pemetaan.set-status") }}',
                    data:{jenis},
                    success:function(res){
                        res.forEach(e => {
                            html += '<option value="' + e.id_kecamatan + '">' + e.nama_kecamatan + '</option>';
                        });
                        $('#status').prop('disabled', false);
                        $('#status').html(html)
                    }
                })
            }else if (jenis == 'desa') {
                $.ajax({
                    url:'{{ route("pemetaan.set-status") }}',
                    data:{jenis},
                    success:function(res){
                        res.forEach(e => {
                            html += '<option value="' + e.id_desa+ '">' + e.nama_desa+ '</option>';
                        });
                        $('#status').prop('disabled', false);
                        $('#status').html(html)
                    }
                })
            }else {
                html += '<option value="" selected disabled>Pilih Status Pencarian</option>'
                $('#status').html(html)
            }
        }
    </script>
@endpush
