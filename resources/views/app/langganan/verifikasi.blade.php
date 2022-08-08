@extends('layouts.app')
@section('title', 'Mitra')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Verifikasi Langganan</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Langganan</a></li>
                    <li class="breadcrumb-item active">Verifikasi Langganan</li>
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
                <h4 class="card-title font-weight-bold">
                    Data Langganan
                </h4>
                <br>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Langganan</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Berlangganan</th>
                                    <th>Status</th>
                                    <th>Histori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($langganan as $l)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th scope="row">{{ $l->kode_langganan }}</th>
                                    <td>{{ $l->nama_pelanggan }}</td>
                                    <td>{{ $l->nama_produk . ' | ' . $l->nama_kategori }}</td>
                                    <td>
                                        {{ $l->lama_berlangganan }}
                                    </td>
                                    <td>
                                        @if ($l->status == "pn")
                                            <span class="badge badge-warning">Pengajuan</span>
                                        @elseif($l->status == "dt" || $l->status == "n")
                                            <span class="badge badge-danger">{{ $l->status == "dt" ? 'Ditolak' : 'Nonaktif' }}</span>
                                        @elseif ($l->status == "a")
                                            <span class="badge badge-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-info py-0 btn-sm" data-toggle="modal" data-target="#historiModal" data-histori="{{ $l->histori }}">Lihat Histori</button>
                                    </td>
                                    <td width="15%">
                                        <a href="{{ route('langganan.show', $l->id_langganan) }}" class="btn btn-outline-info btn-sm">
                                            <i class="ti-eye font-weight-bold"></i>
                                        </a>
                                        @if ($l->status != 'dt')
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#rejectModal" data-title="{{ $l->kode_langganan }}" data-route="{{ route('langganan.verifikasi.reject', $l->id_langganan) }}">
                                                <i class="ti-close font-weight-bold"></i>
                                            </button>
                                        @endif
                                        <form action="{{ route('langganan.verifikasi.verify', $l->id_langganan) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-outline-success btn-sm">
                                                <i class="ti-check-box font-weight-bold"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data langganan!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Modal --}}
<div class="modal fade" id="historiModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Histori Langganan</h5>
            </div>
            <div class="modal-body">
                <ul id="data-histori">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Langganan - JHBHK90218298</h5>
            </div>
            <form action="" method="POST" class="modal-action">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email" class="text-dark">Pesan untuk pelanggan :</label>
                        <textarea name="pesan" id="email" style="height: 100px" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info">Kirim Pesan <i class="ti-control-forward"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $('#historiModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget)
            let data = button.data('histori').split('|')
            let target = document.querySelector('#data-histori');
            let templateDanger = "<li class=\"text-capitalize\"> ~data~ <i class=\"ti-close font-weight-bold ml-1 text-danger\"></i> </li>";
            let templateSuccess = "<li class=\"text-capitalize\"> ~data~ <i class=\"ti-check-box font-weight-bold ml-1 text-success\"></i> </li>";

            $('#data-histori').empty();

            data.forEach((e, index) => {
                if (index != data.length-1 || e == 'langganan aktif') {
                    template = templateSuccess;
                } else {
                    template = templateDanger;
                }
                target.insertAdjacentHTML("beforeend", template.replace(/~data~/g, e))
            });
        });
        $('#rejectModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget)
            let title = button.data('title')
            let route = button.data('route')

            let modal = $(this)
            modal.find('.modal-title').text('Langganan - ' + title)
            modal.find('.modal-action').attr('action', route)
        });
    </script>
@endpush
