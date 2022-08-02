@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Kategori</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@include('partials.my-alert')
<section id="main-content">
    <div class="row">
        <div class="col-md-{{ auth()->user()->can('tambah kategori') ? '7' : '12' }} }}">
            <div class="card">
                <h4 class="card-title font-weight-bold">
                    Data Kategori
                </h4>
                <br>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategori as $k)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $k->nama_kategori }}</td>
                                    <td>
                                        <span class="badge badge-{{ $k->status == 'a' ? 'success' : 'danger' }}">{{ $k->status == 'a' ? 'aktif' : 'nonaktif' }}</span>
                                    </td>
                                    <td>
                                        @can('edit kategori')
                                            <button
                                                type="button"
                                                class="btn btn-link m-0 p-0"
                                                data-toggle="modal"
                                                data-target="#editModal"
                                                data-id="{{ $k->id_kategori }}"
                                                data-kategori="{{ $k->nama_kategori }}"
                                                data-status="{{ $k->status }}"
                                                data-route="{{ route('kategori.update', $k->id_kategori) }}">
                                                <i class="ti-pencil-alt text-warning font-weight-bold"></i>
                                            </button>
                                        @endcan
                                        @can('hapus kategori')
                                            <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link m-0 p-0">
                                                    <i class="ti-trash text-danger font-weight-bold"></i>
                                                </button>
                                            </form>
                                        @endcan
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
                            {{ $kategori->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('tambah kategori')
        <div class="col-md-5">
            <div class="card">
                <h4 class="card-title text-center font-weight-bold">Buat Kategori Baru</h4>
                <div class="card-body px-3 py-3">
                    <form action="{{ route('kategori.store') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="kategori" value="{{ old('kategori') }}" name="kategori" placeholder="Nama Kategori">
                            @error('kategori')
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
                        <button type="submit" class="btn btn-block btn-outline-primary">Buat Kategori</button>
                    </form>
                </div>
            </div>
        </div>
        @endcan
    </div>
</section>
{{-- Modals --}}
@can('edit kategori')
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editCategory" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">Edit Kategori</h5>
            </div>
            <form action="" method="post" class="modal-form">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control modal-category" id="kategori" name="kategori" placeholder="">
                        @error('kategori')
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection
@can('edit kategori')
@push('js')
<script>
    $('#editModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget)
        let id = button.data('id')
        let kategori = button.data('kategori')
        let status = button.data('status')
        let route = button.data('route')

        let modal = $(this)
        modal.find('.modal-title').text('Edit Kategori - ' + kategori)
        modal.find('.modal-category').val(kategori)
        modal.find('.modal-status').val(status)
        modal.find('.modal-form').attr('action', route);
    });
</script>
@endpush
@endcan
