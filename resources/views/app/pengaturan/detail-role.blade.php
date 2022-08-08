@extends('layouts.app')
@section('title', 'Pengaturan Role Permission')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Role Permission</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                        <li class="breadcrumb-item active">Role Permission</li>
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
                                <a class="nav-link active" data-toggle="tab" href="#viaPembayaran" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-bookmark-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Histori Jabatan dan Permission</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="viaPembayaran" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Histori</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="table-responsive">
                                                {{-- @dd($detail->toArray()) --}}
                                                <table class="table table-hover table-stripped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4" class="text-left">
                                                                Detail Jabatan {{ $detail->nama_petugas }} 
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Jenis Jabatan</th>
                                                            <th>
                                                                Permission
                                                                <i class="ti-control-record mx-2 font-weight-bold text-info">Aktif</i>
                                                                <i class="ti-control-record mx-2 font-weight-bold text-danger">Nonaktif</i>
                                                            </th>
                                                            <th width="20%">Tanggal Jabatan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($detail->detail_jabatan as $dj)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $dj->jenis_jabatan->nama_jabatan }}</td>
                                                                <td width="50%">
                                                                    @forelse ($dj->detail_permission as $dp)
                                                                        <span class="badge badge-{{ $dp->status == 'a' ? 'info' : 'danger' }} py-1">
                                                                            {{ $dp->permission->nama_permission }}
                                                                        </span>
                                                                    @empty
                                                                        Tidak ada permission petugas!
                                                                    @endforelse
                                                                </td>
                                                                <td>{{ $dj->tanggal_jabatan }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center text-capitalize">Tidak ada histori jabatan!</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                {{-- <div class="float-right">
                                                    {{ $detail->detail_jabatan->render() }}
                                                </div> --}}
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
    {{-- Modals --}}
@endsection
