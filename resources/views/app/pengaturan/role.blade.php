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
                                <a class="nav-link active" data-toggle="tab" href="#pengaturanGeneral" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-user"></i>
                                    </span>
                                    <span class="hidden-xs-down">Role Permission Petugas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#viaPembayaran" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-bookmark-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Histori Jabatan dan Permission</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pengaturanGeneral" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Pengaturan Role
                                                Permission</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-stripped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nama Petugas</th>
                                                            <th>Jabatan</th>
                                                            <th>Permission</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($petugas as $p)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $p['nama_petugas'] }}</td>
                                                                <td>
                                                                    <span class="badge badge-success">
                                                                        {{ $p['jabatan'] }}
                                                                    </span>
                                                                </td>
                                                                <td width="50%">
                                                                    @forelse ($p['permission'] as $dp)
                                                                        <span class="badge badge-info text-small">
                                                                            {{ $dp }}
                                                                        </span>
                                                                    @empty
                                                                        Tidak ada permission petugas!
                                                                    @endforelse
                                                                </td>
                                                                <td width="15%">
                                                                    <a href="{{ route('pengaturan.rolepermission.edit', $p['id_petugas']) }}" class="btn btn-outline-warning btn-sm">
                                                                        <i class="ti-pencil-alt font-weight-bold"></i>
                                                                    </a>
                                                                    <a href="{{ route('pengaturan.rolepermission.show', $p['id_petugas']) }}" class="btn btn-outline-info btn-sm">
                                                                        <i class="ti-eye font-weight-bold"></i>
                                                                    </a>
                                                                    <form action="{{ route('pengaturan.rolepermission.offPermission', $p['id_petugas']) }}" method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                            <i class="ti-power-off font-weight-bold"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center text-capitalize">Tidak
                                                                    ada data petugas!</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20" id="viaPembayaran" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Histori</a>
                                        </li>
                                    </ul>
                                    {{-- <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="table-responsive">
                                                @forelse ($petugas as $p)
                                                    <hr>
                                                    <h4 class="font-weight-bold">{{ $p->nama_petugas }}</h4>
                                                    <hr>
                                                        <table class="table table-hover table-stripped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Jabatan</th>
                                                                    <th>Status</th>
                                                                    <th>Permission</th>
                                                                    <th>Tanggal Jabatan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($p->detail_jabatan as $dj)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td class="text-capitalize">{{ $dj->jenis_jabatan->nama_jabatan }}</td>
                                                                    <td>
                                                                        <span class="badge badge-{{ $dj->status == 'a' ? 'success' : 'danger' }}">
                                                                            {{ $dj->status == 'a' ? 'Aktif' : 'Nonaktif' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @forelse ($dj->detail_permission as $dp)
                                                                            <span class="badge badge-{{ $dp->status == 'a' ? 'info' : 'danger' }}">
                                                                                {{ $dp->permission->nama_permission }}
                                                                            </span>
                                                                        @empty
                                                                            Belum ada permission!
                                                                        @endforelse
                                                                    </td>
                                                                    <td>{{ $dj->tanggal_jabatan }}</td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="4">Belum ada histori jabatan untuk petugas {{ $p->nama_petugas }}</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                @empty
                                                    Tidak ada data petugas
                                                @endforelse
                                            </div>
                                        </div>
                                    </div> --}}
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
