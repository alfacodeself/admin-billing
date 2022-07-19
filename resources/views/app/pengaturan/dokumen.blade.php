@extends('layouts.app')
@section('title', 'Pengaturan Dokumen')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Dokumen</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Dokumen</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@include('partials.my-alert')
<section id="main-content">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Status</th>
                                    <th>Status Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jenis_dokumen as $dokumen)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $dokumen->nama_dokumen }}</td>
                                    <td class="text-uppercase">
                                        {{ $dokumen->status_dokumen == 'm' ? 'mitra' : 'pelanggan' }}
                                        {{-- <span class="badge badge-{{ $dokumen->status_dokumen == 'm' ? 'success' : 'primary' }}">
                                        </span> --}}
                                    </td>
                                    <td>
                                        <div class="checkbox switcher">
                                            <label for="test">
                                                <input
                                                    type="checkbox"
                                                    class="change"
                                                    data-set="{{ $dokumen->id_jenis_dokumen }}"
                                                    data-type="jenis_dokumen"
                                                    {{ $dokumen->status == 'a' ? 'checked' : '' }}>
                                                <span><small></small></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-link m-0 p-0"
                                            data-toggle="modal"
                                            data-target="#editModal"
                                            data-jenis="{{ $dokumen->nama_dokumen }}"
                                            data-status="{{ $dokumen->status_dokumen }}"
                                            data-route="{{ route('pengaturan.dokumen.update', $dokumen->id_jenis_dokumen) }}">
                                            <i class="ti-pencil-alt text-warning font-weight-bold"></i>
                                        </button>
                                        <form action="{{ route('pengaturan.dokumen.delete', $dokumen->id_jenis_dokumen) }}" method="post" class="d-inline">
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
                                        <td colspan="5" class="text-center">Tidak ada jenis dokumen!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <h4 class="card-title text-center font-weight-bold">Buat Syarat Dokumen Baru</h4>
                <div class="card-body px-3 py-3">
                    <form action="{{ route('pengaturan.dokumen.store') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="jenis_dokumen">Jenis Dokumen</label>
                            <input type="text" class="form-control" id="jenis_dokumen" name="jenis_dokumen" placeholder="">
                            @error('jenis_dokumen')
                            <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <div class="form-group">
                        <label for="status">Status Dokumen</label>
                            <select name="status" id="status" class="form-control">
                                <option value="p">Pelanggan</option>
                                <option value="m">Mitra</option>
                            </select>
                            @error('status')
                            <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-block btn-outline-primary">Buat Syarat Baru</button>
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
                <h5 class="modal-title">Edit Jenis Dokumen</h5>
            </div>
            <form action="" method="post" class="modal-route-metode">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="form-group">
                        <label for="jenis_dokumen">Jenis Dokumen</label>
                        <input type="text" class="form-control modal-jenis-metode" id="jenis_dokumen" name="jenis_dokumen" placeholder="">
                        @error('jenis_dokumen')
                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control modal-status-metode">
                            <option value="p">Pelanggan</option>
                            <option value="m">Mitra</option>
                        </select>
                        @error('status')
                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah Syarat Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $('#editModal').on('show.bs.modal', function(event){
            const button = $(event.relatedTarget)

            let status = button.data('status');
            let jenis = button.data('jenis');
            let route = button.data('route');

            let modal = $(this)
            modal.find('.modal-route-metode').attr('action', route)
            modal.find('.modal-jenis-metode').val(jenis)
            modal.find('.modal-status-metode').val(status);
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
