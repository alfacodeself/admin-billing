@extends('layouts.app')
@section('title', 'Produk')
@section('content')
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Data Produk</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">E-Billing</a></li>
                        <li class="breadcrumb-item active">Produk</li>
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
                        Data Produk
                    </h4>
                    <br>
                    <div class="card-body">
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#tambahModal">
                            <i class="ti-plus font-weight-bold"></i> Tambah Produk
                        </button>
                        <div class="table-responsive">
                            <table class="table table-hover table-stripped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th width=30%>Deskripsi</th>
                                        <th>Fitur</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produk as $p)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $p->nama_produk }}</td>
                                            <td>{{ $p->kategori->nama_kategori }}</td>
                                            <td>{{ $p->deskripsi }}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-sm py-0"
                                                    data-toggle="modal"
                                                    data-target="#fiturModal"
                                                    data-fitur="{{ $p->fitur }}">
                                                    Fitur
                                                </button>
                                            </td>
                                            <td>{{ 'Rp.' . number_format($p->harga) }}</td>
                                            <td>
                                                <span class="badge badge-{{ $p->status == 'a' ? 'success' : 'danger' }}">{{ $p->status == 'a' ? 'aktif' : 'nonaktif' }}</span>
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-link m-0 p-0"
                                                    data-toggle="modal"
                                                    data-target="#editModal"
                                                    data-produk="{{ $p->nama_produk }}"
                                                    data-kategori="{{ $p->kategori->id_kategori }}"
                                                    data-deskripsi="{{ $p->deskripsi }}"
                                                    data-harga="{{ $p->harga }}"
                                                    data-status="{{ $p->status }}"
                                                    data-fitur="{{ $p->fitur }}"
                                                    data-route="{{ route('produk.update', $p->id_produk) }}">
                                                    <i class="ti-pencil-alt text-warning font-weight-bold"></i>
                                                </button>
                                                <form action="{{ route('produk.destroy', $p->id_produk) }}" method="post" class="d-inline">
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
                                            <td colspan="8" class="text-center text-capitalize">Tidak ada data produk!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="float-right">
                                {{ $produk->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modals --}}
    {{-- ===========> Modal Fitur ============= --}}
    <div class="modal fade" id="fiturModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Fitur Produk</h5>
                </div>
                <div class="modal-body px-4">
                    <ul class="fitur">

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- ===========> Tambah Modal <============== --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="editCategory"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                </div>
                <form action="{{ route('produk.store') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="produk">Produk</label>
                                    <input type="text" class="form-control" id="produk" name="produk" placeholder="">
                                    @error('produk')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        @forelse ($kategori as $k)
                                            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                        @empty
                                            <option disabled>Tidak ada kategori!</option>
                                        @endforelse
                                    </select>
                                    @error('status')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" style="height: 120px"></textarea>
                                    @error('deskripsi')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga"
                                        placeholder="">
                                    @error('harga')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
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
                            <div class="col-md-6">
                                <label for="fitur">Fitur</label>
                                <br>
                                <table class="fitur-field">
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Buat Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ============> Edit Modal <=============== --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editCategory"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Produk</h5>
                </div>
                <form action="" method="post" class="modal-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="produk">Produk</label>
                                    <input type="text" class="form-control modal-produk" id="produk" name="produk"
                                        placeholder="Nama Produk">
                                    @error('produk')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control modal-kategori">
                                        @forelse ($kategori as $k)
                                            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                        @empty
                                            <option disabled>Tidak ada kategori!</option>
                                        @endforelse
                                    </select>
                                    @error('status')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control modal-deskripsi" style="height: 120px"></textarea>
                                    @error('deskripsi')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control modal-harga" id="harga" name="harga"
                                        placeholder="">
                                    @error('harga')
                                        <p class="text-danger"><small><strong>{{ $message }}</strong></small></p>
                                    @enderror
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
                            <div class="col-md-6">
                                <label for="fitur">Fitur</label>
                                <br>
                                <table class="fitur-field">

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ubah Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // ============> Insert Modal Jquery <================
        $('#tambahModal').on('show.bs.modal', function (event) {
            $('.fitur-field').empty();
            var html = '';
            html += '<tr>';
            html += '<td width="80%"><input type="text" class="form-control" name="fitur[]"></td>';
            html += '<td><button class="btn btn-info" type="button" id="add_btn"><i class="ti-plus"></i></button></td>';
            html += '</tr>';
            $('.fitur-field').html(html);
        });
        $(document).on('click', '#add_btn', function() {
            var html = '';
            html += '<tr>';
                html += '<td width="80%"><input type="text" class="form-control" name="fitur[]"></td>';
                html +=
                '<td><button class="btn btn-danger" type="button" id="remove_btn"><i class="ti-trash"></i></button></td>';
                html += '</tr>';
                $('.fitur-field').append(html)
            });
        $(document).on('click', '#remove_btn', function() {
            $(this).closest('tr').remove();
        });
        // ============> Edit Modal Jquery <===============
        $(document).on('click', '#add_btn_edit', function() {
            var html = '';
            html += '<tr>';
            html += '<td width="80%"><input type="text" class="form-control" name="fitur[]"></td>';
            html +=
                '<td><button class="btn btn-danger" type="button" id="remove_btn"><i class="ti-trash"></i></button></td>';
                html += '</tr>';
                $('.fitur-field').append(html)
            });
        $(document).on('click', '#remove_btn_edit', function() {
            $(this).closest('tr').remove();
        });
        $('#editModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget)

            let produk = button.data('produk')
            let harga = button.data('harga')
            let kategori = button.data('kategori')
            let deskripsi = button.data('deskripsi')
            let status = button.data('status')
            let route = button.data('route')
            let fitur = button.data('fitur').split('|')

            let modal = $(this)
            modal.find('.modal-produk').val(produk)
            modal.find('.modal-kategori').val(kategori)
            modal.find('.modal-deskripsi').val(deskripsi)
            modal.find('.modal-harga').val(harga)
            modal.find('.modal-status').val(status)
            modal.find('.modal-form').attr('action', route)
            var html = '';
            fitur.forEach((e, k) => {
                if (k == 0) {
                    html += '<tr>';
                        html += '<td width="80%"><input type="text" class="form-control" name="fitur[]" value="'+e+'"></td>';
                        html += '<td><button class="btn btn-info" type="button" id="add_btn_edit"><i class="ti-plus"></i></button></td>';
                        html += '</tr>';
                }else {
                    html += '<tr>';
                    html += '<td width="80%"><input type="text" class="form-control" name="fitur[]" value="'+e+'"></td>';
                    html += '<td><button class="btn btn-danger" type="button" id="remove_btn_edit"><i class="ti-trash"></i></button></td>';
                    html += '</tr>';
                }
            });
            $('.fitur-field').html(html)
        });
        // ============> Fitur Modal Jquery <================
        $('#fiturModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget)
            let fitur = button.data('fitur').split('|')
            var html = '';
            fitur.forEach(e => {
                html += '<li>'+ e +'</li>';
            });
            let modal = $(this)
            modal.find('.fitur').html(html)
        });
    </script>
@endpush
