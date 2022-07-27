@extends('layouts.app')
@section('title', 'Jenis Langganan')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Jenis Langganan</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Jenis Langganan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@include('partials.my-alert')
<section id="main-content">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-title font-weight-bold">
                    Data Jenis Langganan
                </h4>
                <br>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Berlangganan</th>
                                    <th>Banyak Tagihan per Bulan</th>
                                    <th>Status</th>
                                    <th>Status Berlangganan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jenis_langganan as $jl)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $jl->lama_berlangganan }}</td>
                                    <td>{{ $jl->banyak_tagihan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $jl->status == 'a' ? 'success' : 'danger' }}">{{ $jl->status == 'a' ? 'aktif' : 'nonaktif' }}</span>
                                    </td>
                                    <td>{{ $jl->status_berlangganan ? 'Berlangganan' : 'Tidak Berlangganan' }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-link m-0 p-0"
                                            data-toggle="modal"
                                            data-target="#editModal"
                                            data-id="{{ $jl->id_jenis_langganan }}"
                                            data-jenis="{{ $jl->lama_berlangganan }}"
                                            data-tagihan="{{ $jl->banyak_tagihan }}"
                                            data-status="{{ $jl->status }}"
                                            data-idL="{{ $jl->status_berlangganan ? '1' : '0' }}"
                                            data-route="{{ route('jenis-langganan.update', $jl->id_jenis_langganan) }}">
                                            <i class="ti-pencil-alt text-warning font-weight-bold"></i>
                                        </button>
                                        <form action="{{ route('jenis-langganan.delete', $jl->id_jenis_langganan) }}" method="post" class="d-inline">
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
                                        <td colspan="4" class="text-center text-capitalize">Tidak ada data kategori!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $jenis_langganan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h4 class="card-title text-center font-weight-bold">Buat Jenis Langganan Baru</h4>
                <div class="card-body px-3 py-3">
                    <form action="{{ route('jenis-langganan.store') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="jenis">Jenis Langganan</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Jenis Langganan">
                            @error('jenis')
                            <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tagihan">Tagihan per Bulan</label>
                            <input type="number" class="form-control" id="tagihan" name="tagihan" placeholder="Tagihan">
                            @error('tagihan')
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
                        <div class="form-group">
                            <label for="status_langganan">Status Berlangganan</label>
                            <select name="status_langganan" id="status_langganan" class="form-control">
                                <option value="0">Tidak Berlangganan</option>
                                <option value="1">Berlangganan</option>
                            </select>
                            @error('status_langganan')
                            <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-block btn-outline-primary">Buat Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Modals --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editCategory" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">Edit Jenis Langganan</h5>
            </div>
            <form action="" method="post" class="modal-form">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="form-group">
                        <label for="jenis">Jenis Langganan</label>
                        <input type="text" class="form-control modal-jenis" id="jenis" name="jenis" placeholder="">
                        @error('jenis')
                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tagihan">Tagihan per Bulan</label>
                        <input type="number" class="form-control modal-tagihan" id="tagihan" name="tagihan" placeholder="">
                        @error('tagihan')
                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control modal-status">
                            <option value="a">Aktif</option>
                            <option value="n">Nonaktif</option>
                        </select>
                        @error('status')
                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status_langganan">Status Berlangganan</label>
                        <select name="status_langganan" id="status_langganan" class="form-control modal-statusLangganan">
                            <option value="0">Tidak Berlangganan</option>
                            <option value="1">Berlangganan</option>
                        </select>
                        @error('status_langganan')
                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah Jenis Langganan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget)
            let id = button.data('id')
            let jenis = button.data('jenis')
            let tagihan = button.data('tagihan')
            let idl = button.data('idl')
            let status = button.data('status')
            let route = button.data('route')


            let modal = $(this)
            modal.find('.modal-title').text('Edit Jenis Langganan - ' + jenis)
            modal.find('.modal-jenis').val(jenis)
            modal.find('.modal-tagihan').val(tagihan)
            modal.find('.modal-statusLangganan').val(idl)
            modal.find('.modal-status').val(status)
            modal.find('.modal-form').attr('action', route);
        });
    </script>
@endpush
