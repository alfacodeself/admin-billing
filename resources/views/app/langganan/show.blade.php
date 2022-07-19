@extends('layouts.app')
@section('title', 'Detail Langganan')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Data Detail Langganan</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                        <li class="breadcrumb-item active">Detail Langganan</li>
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
                                <a class="nav-link active" data-toggle="tab" href="#langgananGeneral" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-bookmark-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Detail Langganan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#pelanggan" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-user"></i>
                                    </span>
                                    <span class="hidden-xs-down">Detail Pelanggan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#historiLangganan" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-bookmark-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Histori Berlangganan</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="langgananGeneral" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Detail Langganan</a>
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#profilModal">
                                                <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="basic-information">
                                                <h4>Langganan</h4>
                                                <div class="birthday-content">
                                                    <span class="contact-title">ID Langganan</span>
                                                    <span class="birth-date">{{ $langganan->kode_langganan }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Produk</span>
                                                    <span class="gender">{{ $langganan->nama_produk . ' | ' . $langganan->nama_kategori }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status</span>
                                                    <span class="gender">{{ $langganan->status_langganan == 'a' ? 'Aktif' : 'Nonaktif' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Verifikasi</span>
                                                    <span class="gender">{{ $langganan->tanggal_verifikasi }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Instalasi</span>
                                                    <span class="gender">{{ $langganan->tanggal_instalasi ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Histori</span>
                                                    <span class="gender">{{ $langganan->histori }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Alamat Pemasangan</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">Provinsi</span>
                                                    <span class="phone-number">{{ $langganan->nama_provinsi }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Kabupaten</span>
                                                    <span class="contact-email">{{ $langganan->nama_kabupaten }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Kecamatan</span>
                                                    <span class="contact-email">{{ $langganan->nama_kecamatan }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Desa</span>
                                                    <span class="contact-email">{{ $langganan->nama_desa }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Keterangan Berlangganan Saat Ini</h4>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Mulai</span>
                                                    <span class="gender">{{ $detailLangganan->tanggal_mulai ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Kadaluarsa</span>
                                                    <span class="gender">{{ $detailLangganan->tanggal_kadaluarsa ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Tanggal Selesai</span>
                                                    <span class="gender">{{ $detailLangganan->tanggal_selesai ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Sisa Tagihan</span>
                                                    <span class="gender">{{ $detailLangganan->sisa_tagihan ?? '-' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status</span>
                                                    <span class="gender">{{ $detailLangganan->status_pembayaran == 'bl' ? 'Belum Lunas' : 'Lunas' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20" id="pelanggan" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Pelanggan</a>
                                            <a href="{{ route('pelanggan.show', $langganan->id_pelanggan) }}" class="btn btn-link p-0 m-0">
                                                <i class="ti-eye text-primary font-weight-bold"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="basic-information">
                                                <h4>Biodata</h4>
                                                <div class="birthday-content">
                                                    <span class="contact-title">Nama:</span>
                                                    <span class="birth-date">{{ $langganan->nama_pelanggan }}</span>
                                                </div>
                                                <div class="birthday-content">
                                                    <span class="contact-title">NIK:</span>
                                                    <span class="birth-date">{{ $langganan->nik }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Jenis Kelamin:</span>
                                                    <span
                                                        class="gender">{{ $langganan->jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Status Pelanggan:</span>
                                                    <span
                                                        class="gender {{ $langganan->status_pelanggan == 'a' ? '' : 'text-danger' }}">
                                                        {{ $langganan->status_pelanggan == 'a' ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Kontak Informasi</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">No. Telp:</span>
                                                    <span class="phone-number">{{ '+' . $langganan->nomor_hp }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Email:</span>
                                                    <span class="contact-email">{{ $langganan->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20" id="historiLangganan" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Histori Langganan</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-stripped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>ID Langganan</th>
                                                            <th>Jenis Langganan</th>
                                                            <th>Tanggal Mulai</th>
                                                            <th>Tanggal Kadaluarsa</th>
                                                            <th>Tanggal Selesai</th>
                                                            <th>Status</th>
                                                            <th>Status Pembayaran</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($semuaDetailLangganan as $s)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $langganan->kode_langganan }}</td>
                                                                <td>{{ $s->jenis_berlangganan }}</td>
                                                                <td>{{ $s->tanggal_mulai ?? '-' }}</td>
                                                                <td>{{ $s->tanggal_kadaluarsa ?? '-' }}</td>
                                                                <td>{{ $s->tanggal_selesai ?? '-' }}</td>
                                                                <td>{{ $s->status == 'a'? 'Aktif' : 'Nonaktif' }}</td>
                                                                <td>{{ $s->status_pembayaran == 'bl'? 'Belum Lunas' : 'Lunas' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center">Tidak ada data histori berlangganan!</td>
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
    </section>
    {{-- Modals --}}
    <div class="modal fade" id="editModalMetode" tabindex="-1" role="dialog" aria-labelledby="editCategory"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Metode Pembayaran</h5>
                </div>
                <form action="" method="post" enctype="multipart/form-data" class="modal-route-metode">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" placeholder="">
                            <small>
                                <strong>
                                    <a href="" class="modal-logo-metode" class="text-info" target="__blank">Link logo sekarang!</a>
                                </strong>
                            </small>
                            @error('logo')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="metode-bayar">Metode Pembayaran</label>
                            <select name="metode_bayar" id="metode-bayar" class="form-control modal-jenis-metode">
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="E Money">E Money</option>
                                <option value="Direct Debit">Direct Debit</option>
                            </select>
                            @error('metode-bayar')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="via">Via</label>
                            <input type="text" class="form-control modal-via-metode text-capitalize" id="via" name="via" placeholder="">
                            @error('via')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ubah Metode Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal bagi hasil --}}
    <div class="modal fade" id="tambahModalBagi" tabindex="-1" role="dialog" aria-labelledby="tambahCategory"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengaturan Bagi Hasil Mitra</h5>
                </div>
                <form action="{{ route('bagi-hasil.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body px-4">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="">
                            @error('keterangan')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="besaran">Besaran</label>
                            <input type="number" class="form-control" id="besaran" name="besaran" placeholder="">
                            @error('besaran')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis Bagi Hasil</label>
                            <select name="jenis" id="jenis" class="form-control">
                                <option value="p">Persentase</option>
                                <option value="f">Flat</option>
                            </select>
                            @error('jenis')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Buat Pengaturan Bagi Hasil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModalBagi" tabindex="-1" role="dialog" aria-labelledby="tambahCategory"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Pengaturan Bagi Hasil Mitra</h5>
                </div>
                <form action="" method="post" class="modal-route-metode" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control modal-keterangan-metode" id="keterangan" name="keterangan" placeholder="">
                            @error('keterangan')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="besaran">Besaran</label>
                            <input type="number" class="form-control modal-besaran-metode" id="besaran" name="besaran" placeholder="">
                            @error('besaran')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis Bagi Hasil</label>
                            <select name="jenis" id="jenis" class="form-control modal-jenis-metode">
                                <option value="p">Persentase</option>
                                <option value="f">Flat</option>
                            </select>
                            @error('jenis')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Buat Pengaturan Bagi Hasil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        div.checkbox.switcher, div.radio.switcher {
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
        $('#updateModalBagi').on('show.bs.modal', function(event){
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
        $('#editModalMetode').on('show.bs.modal', function(event){
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
        $('.change').on('change', function(){
            let value = $(this).data('set')
            let type = $(this).data('type')
            $.ajax({
                url:"{{ route('change.status.metode-pembayaran') }}",
                data:{
                    value, type
                },
                success:function(res){
                    alert(res);
                    location.reload();
                },
                error:function(err){
                    alert(err)
                }
            })
        });
    </script>
@endpush
