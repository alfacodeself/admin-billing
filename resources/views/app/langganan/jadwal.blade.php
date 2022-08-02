@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Jadwal Pemasangan Instalasi</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Jadwal</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.my-alert')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-title">
                    @can('tambah jadwal langganan')
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#tambahModal">
                        <i class="ti-plus font-weight-bold"></i> Tambah Jadwal Pemasangan
                    </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div id="calendar-schedule"></div>
                </div>
            </div>
        </div>
    </div>

{{-- ====================> Modal <==================== --}}
{{-- ===========> Tambah Modal <============== --}}
    @can('tambah jadwal langganan')
        <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="editCategory"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal Pemasangan</h5>
                </div>
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="{{ route('pengajuan.instalasi.store') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="langganan">ID Langganan</label>
                                    <input type="text" class="form-control" id="langganan" name="langganan" value="{{ old('langganan') }}" onkeyup="search()" placeholder="ID Langganan">
                                    @error('langganan')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                    <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                                    <input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}" id="tanggal_pengajuan" class="form-control">
                                    @error('tanggal_pengajuan')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                    <br>
                                    <button type="submit" class="btn btn-block btn-primary">Buat Jadwal</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <label for="table">Langganan</label>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <th>ID Langganan</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Status</th>
                                </thead>
                                <tbody id="bodysearch">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endcan
    {{-- ======> Calender Modal <======== --}}
    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize">Pemasangan Instalasi</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow card-border card-info">
                                <div class="card-header border-info bg-transparent">
                                    <center>
                                        <img src="" alt="avatar" class="rounded-circle shadow-lg mt-4 modal-avatar" width="100">
                                    </center>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title">
                                        <fieldset class="modal-id">ID Langganan</fieldset>
                                    </h5>
                                    <p class="card-text">
                                        <span class="modal-name text-uppercase">Alfa Code</span>
                                    </p>
                                    <span class="text-capitalize badge bg-info ml-1 modal-note">Nonaktif</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow card-border card-info">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-bold text-center mb-2">
                                        Alamat Lengkap
                                    </h5>
                                    <table>
                                        <tr style="border-bottom: 1px solid rgb(0, 132, 255);">
                                            <td class="py-2">Provinsi</td>
                                            <td>:</td>
                                            <td class="text-left modal-provinsi">Jawa Timur</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid rgb(0, 132, 255);">
                                            <td class="py-2">Kabupaten</td>
                                            <td>:</td>
                                            <td class="text-left modal-kabupaten">Probolinggo</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid rgb(0, 132, 255);">
                                            <td class="py-2">Kecamatan</td>
                                            <td>:</td>
                                            <td class="text-left modal-kecamatan">Paiton</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid rgb(0, 132, 255);">
                                            <td class="py-2">Desa</td>
                                            <td>:</td>
                                            <td class="text-left modal-desa">Karanganyar</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid rgb(0, 132, 255);">
                                            <td class="py-2">RT/RW</td>
                                            <td>:</td>
                                            <td class="text-left modal-rtrw">3/2</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid rgb(0, 132, 255);">
                                            <td class="py-2">Kode Pos</td>
                                            <td>:</td>
                                            <td class="text-left modal-kodepos">78772</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat Lengkap</td>
                                            <td>:</td>
                                            <td class="text-left modal-address">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit, perspiciatis!</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div id="map" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- @dd(json_encode($data)) --}}
    {{-- @dd($today) --}}
@endsection
@section('title', 'Jadwal Pemasangan Instalasi')
@push('js')
    <script src="{{ asset('assets/js/lib/calendar/main.js') }}"></script>
    <script src="{{ asset('assets/js/lib/calendar/locales-all.js') }}"></script>

    <script src="{{ asset('assets/js/lib/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        var calendarEl = document.getElementById("calendar-schedule");
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },

            height: 600,
            contentHeight: 500,
            aspectRatio: 2,

            nowIndicator: true,
            now: '{{ $today }}',
            locale: 'id',

            initialView: "listMonth",
            initialDate: '{{ $today }}',

            dayMaxEvents: true, // allow "more" link when too many events
            navLinks: true,
            events: {!! $data !!},
            eventClick:  function(event, jsEvent, view) {
                $('#calendarModal').modal();
                $('.modal-title').html(event.event.title);
                $('.modal-provinsi').html(event.event.provinsi);
                $('.modal-kabupaten').html(event.event.kabupaten);
                $('.modal-kecamatan').html(event.event.kecamatan);
                $('.modal-desa').html(event.event.desa);
                $('.modal-rtrw').html(event.event.rtrw);
                $('.modal-kodepos').html(event.event.kodepos);
                $('.modal-note').text(event.event.extendedProps.note);
                $('.modal-name').text(event.event.title);
                $('.modal-address').html(event.event.extendedProps.address);
                $('.modal-id').text(event.event.extendedProps.subscription_id);
                $('.modal-avatar').attr('src', event.event.extendedProps.avatar);

                // =================> Map <===================
                let lat = Number(event.event.extendedProps.lat);
                let long = Number(event.event.extendedProps.long);
                let map = new google.maps.Map(document.getElementById("map"), {
                    center: {
                        lat: lat,
                        lng: long
                    },
                    zoom: 17,
                    scrollwheel: true,
                });
                // Make marker use drag
                const uluru = {
                    lat: lat,
                    lng: long
                };
                let marker = new google.maps.Marker({
                    position: uluru,
                    map: map,
                    draggable: false
                });
            },
        });
        calendar.render();
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCWY-q7-nQ4ESJpVa1Jx4ErwzDCoJ73cAo&libraries=&v=weekly">
    </script>
    @can('tambah jadwal langganan')
    <script>
        function search() {
            let jenis = $('#langganan').val();
            $.ajax({
                data: {jenis},
                url: '{{ route("cari.langganan") }}',
                success:function(res){
                    var html = '';
                    if (res.length == 0) {
                        html += '<tr>';
                        html += '<td colspan="4" class="text-center">Langganan tidak ditemukan!</td>';
                        html += '</tr>';
                    }else {
                        res.forEach(e => {
                            html += '<tr>';
                            html += '<td>'+ e.kode_langganan +'</td>';
                            html += '<td>'+ e.nama_pelanggan +'</td>';
                            html += '<td>'+ e.nama_produk +'</td>';
                            html += '<td>'+ e.status_langganan +'</td>';
                            html += '</tr>';
                        });
                    }
                    $('#bodysearch').html(html)
                },
                error:function(err){
                    console.error(err);
                }
            })
        }
    </script>
    @endcan
@endpush
@push('css')
    <link href="{{ asset('assets/css/lib/calendar/main.css') }}" rel="stylesheet" type="text/css" />
@endpush
