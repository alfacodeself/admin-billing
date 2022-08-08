@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Selamat datang {{ Auth::user()->nama_petugas }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @include('partials.my-alert')
    <section id="main-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-money color-success border-success"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Profit</div>
                            <div class="stat-digit">{{ 'Rp.' . number_format($total_transaksi) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Pelanggan Nonaktif</div>
                        <div class="stat-digit">{{ number_format($pelanggan_nonaktif) }} Pelanggan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-layers-alt color-pink border-pink"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Langganan Kadaluarsa</div>
                            <div class="stat-digit">{{ number_format($langganan_kadaluarsa) }} Langganan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-alert color-danger border-danger"></i></div>
                        <div class="stat-content dib">
                            <div class="stat-text">Langganan Nonaktif</div>
                            <div class="stat-digit">{{ number_format($langganan_nonaktif) }} Langganan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-title">
                        <h4>Income Statistic</h4>
                    </div>
                    <div class="card-body">
                        <div class="ct-bar-chart m-t-30"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="ct-pie-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card p-0">
                    <div class="stat-widget-three home-widget-three">
                        <div class="stat-icon bg-facebook">
                            <i class="ti-layout"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-digit">{{ $kategori }}</div>
                            <div class="stat-text">Jenis Produk</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-0">
                    <div class="stat-widget-three home-widget-three">
                        <div class="stat-icon bg-youtube">
                            <i class="ti-view-list-alt"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-digit">{{ $produk }}</div>
                            <div class="stat-text">Produk</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-0">
                    <div class="stat-widget-three home-widget-three">
                        <div class="stat-icon bg-twitter">
                            <i class="ti-wallet"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-digit">{{ $semua_transaksi }}</div>
                            <div class="stat-text">Transaksi</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card p-0">
                    <div class="stat-widget-three home-widget-three">
                        <div class="stat-icon bg-success">
                            <i class="ti-bookmark-alt"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-digit">{{ $jenis_langganan }}</div>
                            <div class="stat-text">Jenis Langganan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-title">
                        <h4>Admin Log </h4>
                    </div>
                    <div class="recent-comment m-t-15">
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="assets/images/avatar/1.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-primary">Soeng Souy</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <p class="comment-date">10 min ago</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="assets/images/avatar/2.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-success">Mr. Soeng Souy</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <p class="comment-date">1 hour ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-title">
                        <h4>User Log </h4>
                    </div>
                    <div class="recent-comment m-t-15">
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="assets/images/avatar/1.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-primary">Soeng Souy</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <p class="comment-date">10 min ago</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#"><img class="media-object" src="assets/images/avatar/2.jpg"
                                        alt="..."></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading color-success">Mr. Soeng Souy</h4>
                                <p>Cras sit amet nibh libero, in gravida nulla.</p>
                                <p class="comment-date">1 hour ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('css')
    <link href="{{ asset('assets/css/lib/chartist/chartist.min.css') }}" rel="stylesheet">
@endpush
@push('js')
    <script>
        let data1 = {!! $presentase_kategori !!};
        let data2 = {!! $transaksi !!};
        let labels1 = [], labels2 = Object.keys(data2);
        let val = [], val2 = [];
        data1.forEach(e => {
            labels1.push(e.nama_kategori)
            val.push({value: e.jumlah_langganan})
        });
        for (const i in data2) {
            val2.push(data2[i].length)
        }
        (function($) {
            "use strict";
            var data = {
                labels: labels1,
                series: val,
                colors: ["#999", "#111", "#444"]
            };

            var options = {
                labelInterpolationFnc: function(value) {
                    return value[0]
                }
            };

            var responsiveOptions = [
                ['screen and (min-width: 640px)', {
                    chartPadding: 30,
                    labelOffset: 100,
                    labelDirection: 'explode',
                    labelInterpolationFnc: function(value) {
                        return value;
                    }
                }],
                ['screen and (min-width: 1024px)', {
                    labelOffset: 80,
                    chartPadding: 30
                }]
            ];

            new Chartist.Pie('.ct-pie-chart', data, options, responsiveOptions);
            var data = {
                labels: labels2,
                series: [val2],
                // colors: ["#3", "#111", "#444"]

            };

            var options = {
                seriesBarDistance: 3
            };
            var responsiveOptions = [
                ['screen and (max-width: 640px)', {
                    seriesBarDistance: 5,
                    axisX: {
                        labelInterpolationFnc: function(value) {
                            return value[0];
                        }
                    }
                }]
            ];
            new Chartist.Bar('.ct-bar-chart', data, options, responsiveOptions);
        })(jQuery);
    </script>
@endpush
