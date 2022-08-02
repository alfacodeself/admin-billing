@extends('layouts.app')
@section('title', 'Data Langganan')
@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Data Langganan</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                    <li class="breadcrumb-item active">Langganan</li>
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
                    @can('tambah langganan')
                    <a href="{{ route('langganan.create') }}" class="btn btn-outline-primary">
                        <i class="ti-plus font-weight-bold"></i> <span class="d-none d-md-inline">Tambah Langganan</span>
                    </a>
                    @endcan
                    <a href="{{ route('langganan.create') }}" class="btn btn-outline-info float-right">
                        <i class="ti-printer"></i> <span class="d-none d-md-inline">Cetak</span>
                    </a>
                    <div class="table-responsive">
                        <table class="table table-hover table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Langganan</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Berlangganan</th>
                                    <th width="15%">Alamat</th>
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
                                        {{ Str::limit($l->alamat_pemasangan, 20, '...') }}
                                    </td>
                                    <td>
                                        @if ($l->status == "pn")
                                            <span class="badge badge-warning">Pengajuan</span>
                                        @elseif($l->status == "dt" || $l->status == "n")
                                            <span class="badge badge-warning">{{ $l->status == "dt" ? 'Ditolak' : 'Nonaktif' }}</span>
                                        @elseif($l->status == "pmi")
                                            <span class="badge badge-warning">Pemasangan Instalasi</span>
                                        @elseif ($l->status == "a" || $l->status == 'dtr')
                                            <span class="badge badge-success">{{ $l->status == 'a' ? 'Aktif' : 'Diterima' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-info py-0 btn-sm" data-toggle="modal" data-target="#historiModal" data-histori="{{ $l->histori }}">Lihat Histori</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-link m-0 p-0" data-toggle="modal" data-target="#emailModal">
                                            <i class="ti-email text-info font-weight-bold"></i>
                                        </button>
                                        @can('detail langganan')
                                        <a href="{{ route('langganan.show', $l->id_langganan) }}" class="btn btn-link m-0 p-0">
                                            <i class="ti-eye text-primary font-weight-bold"></i>
                                        </a>
                                        @endcan
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
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Langganan - JHBHK90218298</h5>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email" class="text-dark">Pesan untuk pelanggan :</label>
                        <textarea name="email" id="email" style="height: 100px" class="form-control"></textarea>
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
    </script>
@endpush
