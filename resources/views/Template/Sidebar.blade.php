<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="./index.html" class="brand-link">
            <img src="./public/img/NP_MEDIKA_LOGO2.png" alt="AdminLTE Logo" class="brand-image shadow" />
            <span class="brand-text fw-bold">KLINIK PINTAR</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item ">
                    <a href="#" class="nav-link @if ($menu == 'dashboard') active @endif">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard Rawat Jalan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard Rawat Inap</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">REKAMEDIS</li>
                <li class="nav-item">
                    <a href="{{ route('indexdaftarpelayanan') }}"
                        class="nav-link @if ($menu == 'indexdaftarpelayanan') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Daftar Pelayanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdataantrian') }}"
                        class="nav-link @if ($menu == 'indexdataantrian') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Antrian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexriwayatpendaftaran') }}"
                        class="nav-link @if ($menu == 'indexriwayatpendaftaran') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Riwayat Pendaftaran</p>
                    </a>
                </li>
                  <li class="nav-item">
                    <a href="{{ route('indexmasterpasien') }}"
                        class="nav-link @if ($menu == 'indexmasterpasien') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Master Pasien</p>
                    </a>
                </li>
                <li class="nav-header">POLIKLINIK</li>
                <li class="nav-item">
                    <a href="{{ route('indexdatapasienpoli') }}"
                        class="nav-link @if ($menu == 'indexdatapasienpoli') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>
                <li class="nav-header">Kasir / Farmasi</li>
                <li class="nav-item">
                    <a href="{{ route('indexdatapasienkasirfarmasi') }}"
                        class="nav-link @if ($menu == 'indexdatapasienkasirfarmasi') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexlogtransaksikasir') }}"
                        class="nav-link @if ($menu == 'indexlogtransaksikasir') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Log Transaksi Kasir</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexriwayattagihan') }}"
                        class="nav-link @if ($menu == 'indexriwayatpembayaran') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Riwayat Tagihan Pasien</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexkartustokobat') }}"
                        class="nav-link @if ($menu == 'indexkartustokobat') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Kartu Stok Obat</p>
                    </a>
                </li>
                <li class="nav-header">DATA MASTER</li>
                <li class="nav-item">
                    <a href="{{ route('indexmasterpasien') }}"
                        class="nav-link @if ($menu == 'indexmasterpasien') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexmasterbarang') }}"
                        class="nav-link @if ($menu == 'indexmasterbarang') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdataobatgenerik') }}"
                        class="nav-link @if ($menu == 'indexdataobatgenerik') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Nama Generik</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdataicd10') }}"
                        class="nav-link @if ($menu == 'indexdataicd10') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data ICD 10</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdataicd9') }}"
                        class="nav-link @if ($menu == 'indexdataicd9') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data ICD 9</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdatatarifpelayanan') }}"
                        class="nav-link @if ($menu == 'indexdatatarifpelayanan') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Tarif Pelayanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdatapegawai') }}"
                        class="nav-link @if ($menu == 'indexdatapegawai') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Pegawai</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdataunit') }}"
                        class="nav-link @if ($menu == 'indexdataunit') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data Unit</p>
                    </a>
                </li>
                <li class="nav-item  @if ($menu_sub == 'masterlokasi') menu-open @endif">
                    <a href="#" class="nav-link  @if ($menu == 'dashboard') active @endif">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Master Lokasi
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('indexdataprovinsi') }}"
                                class="nav-link @if ($menu == 'indexdataprovinsi') active @endif">
                                <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                                <p>Data Provinsi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('indexdatakabupatenkota') }}"
                                class="nav-link @if ($menu == 'indexdatakabupatenkota') active @endif">
                                <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                                <p>Data Kabupaten / Kota</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('indexdatakecamatan') }}"
                                class="nav-link @if ($menu == 'indexdatakecamatan') active @endif">
                                <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                                <p>Data Kecamatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('indexdatadesa') }}"
                                class="nav-link @if ($menu == 'indexdatadesa') active @endif">
                                <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                                <p>Data Desa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('indexdatauser') }}"
                        class="nav-link @if ($menu == 'indexdatauser') active @endif">
                        <i class="nav-icon bi bi-file-bar-graph-fill"></i>
                        <p>Data User</p>
                    </a>
                </li>
                <li class="nav-header">INFO AKUN</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person-vcard"></i>
                        <p class="text">Detail Akun</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="logout()">
                        <i class="nav-icon bi bi-box-arrow-left"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
