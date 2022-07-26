@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">E-Billing</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('langganan.index') }}">Langganan</a></li>
                            <li class="breadcrumb-item active">Jadwal Pemasangan Instalasi</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Jadwal</h4>
                </div>
            </div>
        </div>
        @include('partials.my-alert')
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <h4 class="header-title">
                        Jadwal Pemasangan Instalasi
                    </h4>
                    <p class="sub-header">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, soluta.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar-schedule"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ====================> Modal <==================== --}}

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
@endpush
@push('css')
    <link href="{{ asset('assets/css/lib/calendar/main.css') }}" rel="stylesheet" type="text/css" />
@endpush
