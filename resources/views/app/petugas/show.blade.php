@extends('layouts.app')
@section('title', 'Detail Petugas')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Detail Petugas</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('petugas.index') }}">Petugas</a></li>
                        <li class="breadcrumb-item active">Detail Petugas</li>
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
                        <img class="card-img-top" src="{{ url($petugas->foto) }}" alt="Card image cap" height="250">
                    </div>
                    <div class="card-body pt-0">
                        <h5 class="card-title">{{ $petugas->nama_petugas }}</h5>
                        <p class="card-text">{{ 'Admin' }} Pelanggan</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#fotoModal">
                            Ubah Foto Petugas
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
                                <a class="nav-link" data-toggle="tab" href="#detailJabatan" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-bookmark-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Detail Jabatan</span>
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
                                                    <span class="birth-date">{{ $petugas->nama_petugas }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Jenis Kelamin:</span>
                                                    <span
                                                        class="gender">{{ $petugas->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status petugas:</span>
                                                    <span
                                                        class="gender {{ $petugas->status == 'a' ? '' : 'text-danger' }}">{{ $petugas->status == 'a' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Kontak Informasi</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">No. Telp:</span>
                                                    <span class="phone-number">{{ '+' . $petugas->nomor_hp }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Email:</span>
                                                    <span class="contact-email">{{ $petugas->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20" id="detailJabatan" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Histori Jabatan</a>
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#jabatanModal">
                                                <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-inverse table-responsive text-capitalize">
                                                            <thead class="thead-default">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th style="width: 270px">Petugas</th>
                                                                    <th>Jabatan</th>
                                                                    <th>Tanggal</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse ($history as $h)
                                                                        <tr>
                                                                            <td scope="row">{{ $loop->iteration }}</td>
                                                                            <td>{{ $petugas->nama_petugas }}</td>
                                                                            <td>{{ $h->jabatan }}</td>
                                                                            <td>
                                                                                {{ $h->tanggal_jabatan }}
                                                                            </td>
                                                                            <td>
                                                                                <span class="badge badge-{{ $h->status == 'a' ? 'success' : 'danger' }}">{{ $h->status == 'a' ? 'Aktif' : 'Nonaktif' }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="5" class="text-center">Tidak ada pelanggan!</td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                        </table>
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
            </div>
        </div>
    </section>
    {{-- ===============> Modal Section <======================= --}}
    <div class="modal fade" id="profilModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Profil Petugas</h5>
                </div>
                <form action="{{ route('petugas.show.update-profil', $petugas->id_petugas) }}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-5">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ $petugas->nama_petugas }}" placeholder="Nama">
                                    @error('nama')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Jenis Kelamin</label>
                                <div class="col-sm-8">
                                    <input type="radio" name="jenis_kelamin" value="l"
                                        {{ $petugas->jenis_kelamin == 'l' ? 'checked' : '' }}> Laki-Laki
                                    <input type="radio" name="jenis_kelamin" value="p"
                                        {{ $petugas->jenis_kelamin == 'p' ? 'checked' : '' }}> Perempuan
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
                                        value="{{ $petugas->email }}" placeholder="Email">
                                    @error('email')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">No. Handphone</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="nomor_hp"
                                        value="{{ $petugas->nomor_hp }}" placeholder="No Handphone">
                                    @error('nomor_hp')
                                        <small><strong class="text-danger">{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="status" id="status" name="status" class="form-control">
                                        <option value="a" {{ $petugas->status == 'a' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="n" {{ $petugas->status == 'n' ? 'selected' : '' }}>
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
                        <button type="submit" class="btn btn-primary">Update Profil Petugas</button>
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
                    <h5 class="modal-title">Ubah Foto Petugas</h5>
                </div>
                <form action="{{ route('petugas.show.update-foto', $petugas->id_petugas) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="foto">Foto Petugas</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Foto Petugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="jabatanModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Jabatan Petugas</h5>
                </div>
                <form action="{{ route('petugas.show.update-jabatan', $petugas->id_petugas) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jabatan">Ganti Jabatan Petugas</label>
                            <select name="jabatan" id="jabatan" class="form-control">
                                @forelse ($jabatan as $j)
                                    <option value="{{ $j->id_jenis_jabatan }}">{{ $j->nama_jabatan }}</option>
                                @empty
                                    <option disabled selected>Tidak ada jabatan</option>
                                @endforelse
                            </select>
                            @error('jabatan')
                            <small><strong class="text-danger">{{ $message }}</strong></small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ubah Jabatan Petugas</button>
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
