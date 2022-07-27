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
                <li><a href="{{ route('kategori.index') }}"><i class="ti-layout"></i> Kategori </a></li>
                <li><a href="{{ route('produk.index') }}"><i class="ti-view-list-alt"></i> Produk </a></li>
                <li><a href="{{ route('jenis-langganan.index') }}"><i class="ti-check-box"></i> Jenis Langganan </a></li>
                <li>
                    <a class="sidebar-sub-toggle">
                        <i class="ti-user"></i> User
                        <span class="sidebar-collapse-icon ti-angle-down"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('petugas.index') }}"></i> Data Petugas </a></li>
                        <li><a href="{{ route('pelanggan.index') }}">Data Pelanggan</a></li>
                        <li><a href="{{ route('mitra.index') }}">Data Mitra</a></li>
                    </ul>
                </li>
                <li>
                    <a class="sidebar-sub-toggle">
                        <i class="ti-bookmark-alt"></i> Berlangganan
                        <span class="sidebar-collapse-icon ti-angle-down"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('langganan.index') }}">Data Langganan</a></li>
                        <li><a href="{{ route('langganan.verifikasi.index') }}">Verifikasi Langganan</a></li>
                        <li><a href="{{ route('langganan.schedule') }}">Jadwal Instalasi</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('transaksi.index') }}"><i class="ti-credit-card"></i> Transaksi </a></li>
                <li class="label">Information</li>
                <li><a href="#"><i class="ti-map-alt"></i> Pemetaan Layanan</a></li>
                <li class="label">Settings</li>
                <li><a href="{{ route('pengaturan.pembayaran.index') }}"><i class="ti-wallet"></i> Pembayaran</a></li>
                <li><a href="{{ route('pengaturan.dokumen.index') }}"><i class="ti-agenda"></i> Dokumen</a></li>
                <li><a href="{{ route('pengaturan.profil.index') }}"><i class="ti-id-badge"></i> Profil</a></li>
            </ul>
        </div>
    </div>
</div>
