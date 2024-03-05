<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="@yield('dashboard')"><a class="nav-link" href="#!"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
    
    <li class="menu-header">Aksesbilitas</li>
    @if (auth()->user()->role == 'Super Admin')
    <li class="@yield('user')"><a class="nav-link" href="{{ route('user.index') }}"><i class="fa-solid fa-users"></i>
            <span>User</span></a>
    </li>
    @endif
    <li class="@yield('sales')"><a class="nav-link" href="{{ route('sales.index') }}"><i class="fa-solid fa-users"></i>
            <span>Sales</span></a>
    </li>

    <li class="menu-header">Warehouse</li>
    <li class="@yield('toko')"><a class="nav-link" href="{{ route('toko.index') }}"><i class="fa-solid fa-store"></i>
            <span>Toko</span></a>
    </li>
    <li class="@yield('pelanggan')"><a class="nav-link" href="{{ route('pelanggan.index') }}"><i
                class="fa-solid fa-user"></i>
            <span>Pelanggan</span></a>
    </li>
    <li class="@yield('suplier')"><a class="nav-link" href="{{ route('suplier.index') }}"><i
                class="fa-solid fa-user"></i>
            <span>Suplier</span></a>
    </li>

    <li class="dropdown @yield('kategori-produk') @yield('produk')">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-boxes-stacked"></i>
            <span>Produk</span></a>
        <ul class="dropdown-menu">
            <li class="@yield('kategori-produk')"><a class="nav-link"
                    href="{{ route('kategori-produk.index') }}"><span>Kategori</span></a>
            </li>
            <li class="@yield('produk')"><a class="nav-link" href="{{ route('produk.index') }}"><span>Produk</span></a>
            </li>
            
            <li class="@yield('produk-masuk')"><a class="nav-link" href="{{ route('produk-masuk.index') }}"><span>Masuk</span></a>
            </li>
            <li class="@yield('produk-retur')"><a class="nav-link" href="{{ route('produk-retur.index') }}"><span>Retur</span></a>
            </li>
        </ul>
    </li>

    <li class="menu-header">Transaksi</li>
    <li class="@yield('bonus')"><a class="nav-link" href="{{ route('bonus.index') }}"><i class="fa-solid fa-star"></i> <span>Bonus</span></a>
    </li>
    <li class="@yield('bonus-history')"><a class="nav-link" href="{{ route('bonus-history.index') }}"><i class="fa-solid fa-history"></i> <span>Bonus History</span></a>
    </li>

    <li class="dropdown @yield('pemasukan') @yield('pengeluaran') @yield('pemasukan-sales') @yield('pengeluaran-sales')">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-comments-dollar"></i>
            <span>Transaksi</span></a>
        <ul class="dropdown-menu">
            <li class="@yield('pemasukan')"><a class="nav-link" href="{{ route('transaksi-pemasukan.index') }}">
                    <span>transaksi Pemasukan</span></a>
            </li>

            <li class="@yield('pengeluaran')"><a class="nav-link" href="{{ route('transaksi-pengeluaran.index')}}">
                    <span>transaksi Pengeluaran</span></a>
            </li>

            <li class="@yield('pemasukan-sales')"><a class="nav-link" href="{{ route('transaksi-pemasukan-sales.index') }}">
                    <span>Pemasukan Sales</span></a>
            </li>

            <li class="@yield('pengeluaran-sales')"><a class="nav-link" href="{{ route('transaksi-pengeluaran-sales.index')}}">
                    <span>Pengeluaran Sales</span></a>
            </li>
        </ul>
    </li>

    <li class="@yield('credit')"><a class="nav-link" href="{{ route('credit.index') }}"><i class="fa-solid fa-wallet"></i>
            <span>Credit</span></a>
    </li>

    <li class="menu-header">Laporan</li>
    <li class="dropdown @yield('report-pemasukan') @yield('report-pengeluaran') @yield('report-pengeluaran-sales') @yield('report-pemasukan-sales')">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-file"></i>
            <span>Report</span></a>
        <ul class="dropdown-menu">
            <li class="@yield('report-pemasukan')"><a class="nav-link" href="{{ route('report.pemasukan.index') }}">
                    <span>transaksi Pemasukan</span></a>
            </li>

            <li class="@yield('report-pengeluaran')"><a class="nav-link" href="{{ route('report.pengeluaran.index') }}">
                    <span>transaksi Pengeluaran</span></a>
            </li>

            <li class="@yield('report-pemasukan-sales')"><a class="nav-link" href="{{ route('report.pemasukan.sales.index') }}">
                    <span>Pemasukan Sales</span></a>
            </li>

            <li class="@yield('report-pengeluaran-sales')"><a class="nav-link" href="{{ route('report.pengeluaran.sales.index') }}">
                    <span>Pengeluaran Sales</span></a>
            </li>
        </ul>
    </li>
</ul>
