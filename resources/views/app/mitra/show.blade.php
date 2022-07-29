@extends('layouts.app')
@section('title', 'Detail Mitra')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Detail Mitra</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mitra.index') }}">Mitra</a></li>
                        <li class="breadcrumb-item active">Detail Mitra</li>
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
                        <img class="card-img-top" src="{{ url($mitra->foto) }}" alt="Card image cap" height="250">
                    </div>
                    <div class="card-body pt-0">
                        <h5 class="card-title">{{ $mitra->nama_mitra }}</h5>
                        <p class="card-text">{{ $mitra->detail_mitra_pelanggan_count }} Pelanggan</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#fotoModal">
                            Ubah Foto Mitra
                        </button>
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
                                <a class="nav-link" data-toggle="tab" href="#pelangganMitra" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-map-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Pelanggan Mitra</span>
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
                                                    <span class="birth-date">{{ $mitra->nama_mitra }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Jenis Kelamin:</span>
                                                    <span
                                                        class="gender">{{ $mitra->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status Mitra:</span>
                                                    <span
                                                        class="gender {{ $mitra->status == 'a' ? '' : 'text-danger' }}">{{ $mitra->status == 'a' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Kontak Informasi</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">No. Telp:</span>
                                                    <span class="phone-number">{{ '+' . $mitra->nomor_hp }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Email:</span>
                                                    <span class="contact-email">{{ $mitra->email }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Bagi Hasil</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">Bagi Hasil per Transaksi:</span>
                                                    <span class="phone-number">
                                                        @if ($detail_bagi_hasil->pengaturan_bagi_hasil->status_jenis == 'p')
                                                            {{ $detail_bagi_hasil->pengaturan_bagi_hasil->besaran . '%' }}
                                                        @else
                                                            {{ 'Rp.' . number_format($detail_bagi_hasil->pengaturan_bagi_hasil->besaran) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20" id="pelangganMitra" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Pelanggan</a>
                                            {{-- <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#alamatModal">
                                                <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                            </button> --}}
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-inverse table-responsive">
                                                    <thead class="thead-default">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nama Pelanggan</th>
                                                            <th>No Handphone</th>
                                                            <th>Alamat</th>
                                                            <th>Status</th>
                                                            <th>Bergabung</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($mitra->detail_mitra_pelanggan as $mitraPelanggan)
                                                                <tr>
                                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                                    <td>{{ $mitraPelanggan->pelanggan->nama_pelanggan }}</td>
                                                                    <td>{{ '+' . $mitraPelanggan->pelanggan->nomor_hp }}</td>
                                                                    <td>
                                                                        {{ Str::limit($mitraPelanggan->pelanggan->alamat, 20, '...') }}
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge badge-{{ $mitraPelanggan->status == 'a' ? 'success' : 'danger' }}">{{ $mitraPelanggan->status == 'a' ? 'Aktif' : 'Nonaktif' }}</span>
                                                                    </td>
                                                                    <td>{{ $mitraPelanggan->tanggal_masuk }}</td>
                                                                    <td>
                                                                        <a href="{{ route('pelanggan.show', $mitraPelanggan->pelanggan->id_pelanggan) }}" class="btn btn-link m-0 p-0">
                                                                            <i class="ti-eye text-primary font-weight-bold"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center">Tidak ada pelanggan!</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                </table>
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
                                                @forelse ($mitra->dokumen_mitra as $dokumen)
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
                                                @empty
                                                    Mitra tidak memiliki dokumen!
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
    {{-- ===============> Modal Section <======================= --}}
    <div class="modal fade" id="dokumenModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Dokumen Mitra</h5>
                </div>
                <form action="{{ route('mitra.show.update-dokumen', $mitra->id_mitra) }}" enctype="multipart/form-data" method="post" class="form-horizontal">
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
    <div class="modal fade" id="profilModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Profil Mitra</h5>
                </div>
                <form action="{{ route('mitra.show.update-profil', $mitra->id_mitra) }}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-5">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ $mitra->nama_mitra }}" placeholder="Nama">
                                    @error('nama')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Jenis Kelamin</label>
                                <div class="col-sm-8">
                                    <input type="radio" name="jenis_kelamin" value="l"
                                        {{ $mitra->jenis_kelamin == 'l' ? 'checked' : '' }}> Laki-Laki
                                    <input type="radio" name="jenis_kelamin" value="p"
                                        {{ $mitra->jenis_kelamin == 'p' ? 'checked' : '' }}> Perempuan
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
                                        value="{{ $mitra->email }}" placeholder="Email">
                                    @error('email')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">No. Handphone</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="nomor_hp"
                                        value="{{ $mitra->nomor_hp }}" placeholder="No Handphone">
                                    @error('nomor_hp')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="status" id="status" name="status" class="form-control">
                                        <option value="a" {{ $mitra->status == 'a' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="n" {{ $mitra->status == 'n' ? 'selected' : '' }}>
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
                        <button type="submit" class="btn btn-primary">Update Profil Mitra</button>
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
                    <h5 class="modal-title">Ubah Foto Mitra</h5>
                </div>
                <form action="{{ route('mitra.show.update-foto', $mitra->id_mitra) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="foto">Foto Mitra</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Foto Mitra</button>
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
