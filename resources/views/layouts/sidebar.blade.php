<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <div class="logo">
                    <a href="">
                        {{-- <img src="assets/images/logo.png" alt=""/> --}}
                        <span>E-BILLING</span>
                    </a>
                </div>
                <li><a href="{{ route('dashboard') }}" class="sideba"><i class="ti-home"></i> Beranda</a></li>
                <li class="label">Data Management</li>
                @can('lihat kategori')
                    <li><a href="{{ route('kategori.index') }}"><i class="ti-layout"></i> Kategori </a></li>
                @endcan
                @can('lihat produk')
                    <li><a href="{{ route('produk.index') }}"><i class="ti-view-list-alt"></i> Produk </a></li>
                @endcan
                @can('lihat jenis langganan')
                <li><a href="{{ route('jenis-langganan.index') }}"><i class="ti-check-box"></i> Jenis Langganan </a></li>
                @endcan
                @if (Auth::user()->can('lihat petugas') || Auth::user()->can('lihat pelanggan') || Auth::user()->can('lihat mitra'))
                <li>
                    <a class="sidebar-sub-toggle">
                        <i class="ti-user"></i> User
                        <span class="sidebar-collapse-icon ti-angle-down"></span>
                    </a>
                    <ul>
                        @can('lihat petugas')
                        <li><a href="{{ route('petugas.index') }}"></i> Data Petugas </a></li>
                        @endcan
                        @can('lihat pelanggan')
                        <li><a href="{{ route('pelanggan.index') }}">Data Pelanggan</a></li>
                        @endcan
                        @can('lihat mitra')
                        <li><a href="{{ route('mitra.index') }}">Data Mitra</a></li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if (Auth::user()->can('lihat langganan') || Auth::user()->can('verifikasi langganan') || Auth::user()->can('jadwal langganan'))
                <li>
                    <a class="sidebar-sub-toggle">
                        <i class="ti-bookmark-alt"></i> Berlangganan
                        <span class="sidebar-collapse-icon ti-angle-down"></span>
                    </a>
                    <ul>
                        @can('lihat langganan')
                        <li><a href="{{ route('langganan.index') }}">Data Langganan</a></li>
                        @endcan
                        @can('verifikasi langganan')
                        <li><a href="{{ route('langganan.verifikasi.index') }}">Verifikasi Langganan</a></li>
                        @endcan
                        @can('jadwal langganan')
                        <li><a href="{{ route('langganan.schedule') }}">Jadwal Instalasi</a></li>
                        @endcan
                    </ul>
                </li>
                @endif
                @can('lihat transaksi')
                <li><a href="{{ route('transaksi.index') }}"><i class="ti-credit-card"></i> Transaksi </a></li>
                @endcan
                <li class="label">Information</li>
                @can('pemetaan langganan')
                <li><a href="{{ route('pemetaan.index') }}"><i class="ti-map-alt"></i> Pemetaan Layanan</a></li>
                @endcan
                <li class="label">Settings</li>
                @can('pengaturan pembayaran')
                <li><a href="{{ route('pengaturan.pembayaran.index') }}"><i class="ti-wallet"></i> Pembayaran</a></li>
                @endcan
                @can('pengaturan dokumen')
                <li><a href="{{ route('pengaturan.dokumen.index') }}"><i class="ti-agenda"></i> Dokumen</a></li>
                @endcan
                @can('pengaturan role permission')
                <li><a href="{{ route('pengaturan.rolepermission.index') }}"><i class="ti-lock"></i> Role Permission</a></li>
                @endcan
                @can('pengaturan profil')
                <li><a href="{{ route('pengaturan.profil.index') }}"><i class="ti-id-badge"></i> Profil</a></li>
                @endcan
            </ul>
        </div>
    </div>
</div>
