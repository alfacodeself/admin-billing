@extends('layouts.app')
@section('title', 'Pengaturan Pembayaran')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Data Pembayaran</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                        <li class="breadcrumb-item active">Pembayaran</li>
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
                                    <span class="hidden-xs-down">General</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#viaPembayaran" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-bookmark-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Via Pembayaran</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#jenisbayar" role="tab">
                                    <span class="hidden-sm-up">
                                        <i class="ti-bookmark-alt"></i>
                                    </span>
                                    <span class="hidden-xs-down">Jenis Pembayaran</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pengaturanGeneral" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Pengaturan Pembayaran</a>
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#profilModal">
                                                <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="basic-information">
                                                <h4>Pihak Ketiga</h4>
                                                <div class="birthday-content">
                                                    <span class="contact-title">Server Key</span>
                                                    <span class="birth-date">{{ $general->server_key }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Client Key</span>
                                                    <span class="gender">{{ $general->client_key }}</span>
                                                </div>
                                                <div class="gender-content">
                                                    <span class="contact-title">Charge Url</span>
                                                    <span class="gender">{{ $general->charge_url }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Batas Waktu</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">Durasi Batas Waktu</span>
                                                    <span class="phone-number">{{ $general->durasi_waktu }}</span>
                                                </div>
                                                <div class="email-content">
                                                    <span class="contact-title">Satuan Durasi</span>
                                                    <span class="contact-email">{{ $general->satuan_durasi }}</span>
                                                </div>
                                            </div>
                                            <div class="contact-information">
                                                <h4>Lainnya</h4>
                                                <div class="phone-content">
                                                    <span class="contact-title">Margin Harga Produk</span>
                                                    <span class="phone-number">{{ 'Rp.' . number_format($general->harga_margin) }}</span>
                                                </div>
                                                <div class="phone-content">
                                                    <span class="contact-title">
                                                        Bagi Hasil Mitra
                                                    </span>
                                                    <span class="phone-number">
                                                        @if ($bagi_hasil->status_jenis == 'f')
                                                            {{ 'Rp.' . number_format($bagi_hasil->besaran) }}
                                                        @else 
                                                            {{ $bagi_hasil->besaran . '%' }}
                                                        @endif
                                                        <button class="btn btn-link p-0 my-0 mx-2" data-toggle="modal"
                                                            data-target="#tambahModalBagi">
                                                            <i class="ti-pencil-alt text-primary font-weight-bold"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20" id="viaPembayaran" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Metode Pembayaran</a>
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#tambahModalMetode">
                                                <i class="ti-plus text-primary font-weight-bold"></i>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-stripped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Logo</th>
                                                            <th>Jenis Bayar</th>
                                                            <th>Via</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($metode_pembayaran as $metode)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <th><img src="{{ url($metode->logo) }}" alt="" width="50"
                                                                        height="25"></th>
                                                                <td>{{ $metode->metode_pembayaran }}</td>
                                                                <td class="text-uppercase">{{ str_replace('_', ' ', $metode->via) }}</td>
                                                                <td>
                                                                    <div class="checkbox switcher">
                                                                        <label for="test">
                                                                            <input
                                                                                type="checkbox"
                                                                                class="change"
                                                                                data-set="{{ $metode->id_metode_pembayaran }}"
                                                                                data-type="metode"
                                                                                {{ $metode->status == 'a' ? 'checked' : '' }}>
                                                                            <span><small></small></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-link m-0 p-0"
                                                                        data-toggle="modal"
                                                                        data-target="#editModalMetode"
                                                                        data-logo="{{ url($metode->logo) }}"
                                                                        data-jenis="{{ $metode->metode_pembayaran }}"
                                                                        data-via="{{ str_replace('_', ' ', $metode->via) }}"
                                                                        data-route="{{ route('metode-pembayaran.update', $metode->id_metode_pembayaran) }}">
                                                                        <i class="ti-pencil-alt text-warning font-weight-bold"></i>
                                                                    </button>
                                                                    <form action="{{ route('metode-pembayaran.delete', $metode->id_metode_pembayaran) }}" method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-link m-0 p-0">
                                                                            <i class="ti-trash text-danger font-weight-bold"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center">Tidak ada data metode pembayaran!</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20" id="jenisbayar" role="tabpanel">
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a aria-controls="1" role="tab" data-toggle="tab">Jenis Bayar</a>
                                            <button class="btn btn-link p-0 m-0" data-toggle="modal"
                                                data-target="#tambahModalJenis">
                                                <i class="ti-plus text-primary font-weight-bold"></i>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-stripped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Jenis Pembayaran</th>
                                                            <th>Besaran</th>
                                                            <th>Jenis Biaya</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($jenis_bayar as $j)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $j->jenis_pembayaran }}</td>
                                                                <td>{{ $j->harga }}</td>
                                                                <td>{{ $j->jenis_biaya == 'p'? 'Presentase' : 'Flat' }}</td>
                                                                <td>
                                                                    <div class="checkbox switcher">
                                                                        <label for="test">
                                                                            <input
                                                                                type="checkbox"
                                                                                class="change"
                                                                                data-set="{{ $j->id_jenis_pembayaran }}"
                                                                                data-type="jenis_bayar"
                                                                                {{ $j->status == 'a' ? 'checked' : '' }}>
                                                                            <span><small></small></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-link m-0 p-0"
                                                                        data-toggle="modal"
                                                                        data-target="#updateModalJenis"
                                                                        data-jenisbayar="{{ $j->jenis_pembayaran }}"
                                                                        data-harga="{{ $j->harga }}"
                                                                        data-jenisbiaya="{{ $j->jenis_biaya }}"
                                                                        data-route="{{ route('jenis-bayar.update', $j->id_jenis_pembayaran) }}">
                                                                        <i class="ti-pencil-alt text-warning font-weight-bold"></i>
                                                                    </button>
                                                                    <form action="{{ route('jenis-bayar.delete', $j->id_jenis_pembayaran) }}" method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-link m-0 p-0">
                                                                            <i class="ti-trash text-danger font-weight-bold"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center">Tidak ada data pengaturan bagi hasil!</td>
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
                                <option value="Billing">Billing</option>
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
    <div class="modal fade" id="tambahModalMetode" tabindex="-1" role="dialog" aria-labelledby="tambahCategory"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Metode Pembayaran</h5>
                </div>
                <form action="{{ route('metode-pembayaran.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body px-4">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" placeholder="">
                            @error('logo')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="metode-bayar">Metode Pembayaran</label>
                            <select name="metode_bayar" id="metode-bayar" class="form-control">
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="E Money">E Money</option>
                                <option value="Direct Debit">Direct Debit</option>
                                <option value="Billing">Billing</option>
                            </select>
                            @error('metode-bayar')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="via">Via</label>
                            <input type="text" class="form-control" id="via" name="via" placeholder="">
                            @error('via')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="a">Aktif</option>
                                <option value="n">Nonaktif</option>
                            </select>
                            @error('status')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Buat Metode Pembayaran</button>
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
    {{-- modal jenis bayar --}}
    <div class="modal fade" id="tambahModalJenis" tabindex="-1" role="dialog" aria-labelledby="tambahCategory"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Pembayaran</h5>
                </div>
                <form action="{{ route('jenis-bayar.store') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body px-4">
                        <div class="form-group">
                            <label for="jenis_bayar">Jenis Pembayaran</label>
                            <input type="text" class="form-control" id="jenis_bayar" name="jenis_bayar" placeholder="">
                            @error('jenis_bayar')
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
                            <label for="jenis">Jenis Biaya</label>
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
                        <button type="submit" class="btn btn-primary">Buat Jenis Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModalJenis" tabindex="-1" role="dialog" aria-labelledby="tambahCategory"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Jenis Pembayaran</h5>
                </div>
                <form action="" method="post" class="modal-route">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4">
                        <div class="form-group">
                            <label for="jenis_bayar">Jenis Pembayaran</label>
                            <input type="text" class="form-control modal-jenisBayar" id="jenis_bayar" name="jenis_bayar" placeholder="">
                            @error('jenis_bayar')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="besaran">Besaran</label>
                            <input type="number" class="form-control modal-harga" id="besaran" name="besaran" placeholder="">
                            @error('besaran')
                                <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis Biaya</label>
                            <select name="jenis" id="jenis" class="form-control modal-jenisBiaya">
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
                        <button type="submit" class="btn btn-primary">Ubah Jenis Pembayaran</button>
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
        $('#updateModalJenis').on('show.bs.modal', function(event){
            const button = $(event.relatedTarget)

            let jenisBayar = button.data('jenisbayar');
            let harga = button.data('harga');
            let jenisBiaya = button.data('jenisbiaya');
            let route = button.data('route');

            let modal = $(this)
            modal.find('.modal-route').attr('action', route)
            modal.find('.modal-jenisBayar').val(jenisBayar)
            modal.find('.modal-harga').val(harga);
            modal.find('.modal-jenisBiaya').val(jenisBiaya);
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
