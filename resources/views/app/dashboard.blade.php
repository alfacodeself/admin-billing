@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Hi, <span>Welcome Alfa Code As Super Admin</span></h1>
            </div>
        </div>
    </div>
    <!-- /# column -->
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
        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-money color-success border-success"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Total Profit</div>
                        <div class="stat-digit">1,012</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">New Customer</div>
                        <div class="stat-digit">961</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-layers-alt color-pink border-pink"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Service Active</div>
                        <div class="stat-digit">770</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-alert color-danger border-danger"></i></div>
                    <div class="stat-content dib">
                        <div class="stat-text">User Expire</div>
                        <div class="stat-digit">2,781</div>
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
    <!-- /# row -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card p-0">
                <div class="stat-widget-three home-widget-three">
                    <div class="stat-icon bg-facebook">
                        <i class="ti-layout"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-digit">10</div>
                        <div class="stat-text">Categories</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-0">
                <div class="stat-widget-three home-widget-three">
                    <div class="stat-icon bg-youtube">
                        <i class="ti-bar-chart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-digit">50</div>
                        <div class="stat-text">Products</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-0">
                <div class="stat-widget-three home-widget-three">
                    <div class="stat-icon bg-twitter">
                        <i class="ti-twitter"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-digit">200</div>
                        <div class="stat-text">Transactions</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- /# column -->
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
            <!-- /# card -->
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
            <!-- /# card -->
        </div>
    </div>
</section>
@endsection
@push('js')
    {{-- <!-- scripit init--> --}}
    <link href="{{ asset('assets/css/lib/chartist/chartist.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/dashboard2.js') }}"></script>
@endpush
