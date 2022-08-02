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
                                                                <td>{{ $p->nama_petugas }}</td>
                                                                <td>
                                                                    <span class="badge badge-success">
                                                                        {{ $p->jabatan->jenis_jabatan->nama_jabatan }}
                                                                    </span>
                                                                </td>
                                                                <td width="50%">
                                                                    @forelse ($p->permission as $dp)
                                                                        <span class="badge badge-info">
                                                                            {{ $dp->permission->nama_permission }}
                                                                        </span>
                                                                    @empty
                                                                        Tidak ada permission petugas!
                                                                    @endforelse
                                                                </td>
                                                                <td width="6%">
                                                                    <a href="{{ route('pengaturan.rolepermission.edit', $p->id_petugas) }}" class="btn btn-link p-0 m-0">
                                                                        <i
                                                                            class="ti-pencil-alt text-warning font-weight-bold"></i>
                                                                    </a>
                                                                    <form action="{{ route('pengaturan.rolepermission.offPermission', $p->id_petugas) }}" method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit" class="btn btn-link p-0 m-0">
                                                                            <i class="ti-power-off text-danger font-weight-bold"></i>
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
                                    <div class="tab-content">
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
@push('css')
    <style>
        div.checkbox.switcher,
        div.radio.switcher {
            label {
                padding: 0;

                * {
                    vertical-align: middle;
                }

                input {
                    display: none;

                    &+span {
                        position: relative;
                        display: inline-block;
                        margin-right: 10px;
                        width: 56px;
                        height: 28px;
                        background: #f2f2f2;
                        border: 1px solid #eee;
                        border-radius: 50px;
                        transition: all 0.3s ease-in-out;

                        small {
                            position: absolute;
                            display: block;
                            width: 50%;
                            height: 100%;
                            background: #fff;
                            border-radius: 50%;
                            transition: all 0.3s ease-in-out;
                            left: 0;
                        }
                    }

                    &:checked+span {
                        background: #269bff;
                        border-color: #269bff;

                        small {
                            left: 50%;
                        }
                    }
                }
            }
        }
    </style>
@endpush
@push('js')
    <script>
        $('#updateModalJenis').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget)

            let jenisBayar = button.data('jenisbayar');
            let harga = button.data('harga');
            let jenisBiaya = button.data('jenisbiaya');
            let route = button.data('route');

            console.log(jenisBayar, jenisBiaya);
            let modal = $(this)
            modal.find('.modal-route').attr('action', route)
            modal.find('.modal-jenisBayar').val(jenisBayar)
            modal.find('.modal-harga').val(harga);
            modal.find('.modal-jenisBiaya').val(jenisBiaya);
        });
        $('#updateModalBagi').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget)

            let keterangan = button.data('keterangan');
            let besaran = button.data('besaran');
            let jenis = button.data('jenis');
            let route = button.data('route');

            let modal = $(this)
            modal.find('.modal-route-metode').attr('action', route)
            modal.find('.modal-jenis-metode').val(jenis)
            modal.find('.modal-keterangan-metode').val(keterangan);
            modal.find('.modal-besaran-metode').val(besaran);
        });
        $('#editModalMetode').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget)

            let logo = button.data('logo');
            let jenis = button.data('jenis');
            let via = button.data('via');
            let route = button.data('route');

            let modal = $(this)
            modal.find('.modal-logo-metode').attr('href', logo)
            modal.find('.modal-route-metode').attr('action', route)
            modal.find('.modal-jenis-metode').val(jenis)
            modal.find('.modal-via-metode').val(via);
        });
        $('.change').on('change', function() {
            let value = $(this).data('set')
            let type = $(this).data('type')
            $.ajax({
                url: "{{ route('change.status.metode-pembayaran') }}",
                data: {
                    value,
                    type
                },
                success: function(res) {
                    alert(res);
                    location.reload();
                },
                error: function(err) {
                    alert(err)
                }
            })
        });
    </script>
@endpush
