<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <!-- Logo image -->
            <a href="{{ route('beranda.index') }}">
                <img src="{{ asset('img/logo/logo_nama.png') }}" alt="Logo" style="width: 180px; height: auto;">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <!-- Small logo version -->
            <a href="{{ route('beranda.index') }}">
                <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" style="width: 40px; height: auto;">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Beranda</li>
            <li class="nav-item dropdown {{ $type_menu === 'beranda' ? 'active' : '' }}">
                <a href="{{ route('beranda.index') }}" class="nav-link ha"><i
                        class="fas fa-home"></i><span>Beranda</span></a>
            </li>
            <li class="menu-header">Menu</li>
            <li class="nav-item dropdown {{ $type_menu === 'kasir' ? 'active' : '' }}">
                <a href="{{ route('kasir.index') }}" class="nav-link ha"><i
                        class="fas fa-cash-register"></i><span>Kasir</span></a>

            </li>
            <li class="nav-item dropdown {{ $type_menu === 'order' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i
                        class="fas fa-shopping-cart"></i><span>Order</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('order') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('order.index') }}">Order</a>
                    </li>
                    <li class='{{ Request::is('kmeans') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('kmeans.index') }}">Kmeans</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'pembayaran' ? 'active' : '' }}">
                <a href="{{ route('pembayaran.index') }}" class="nav-link ha"><i
                        class="fas fa-wallet"></i><span>Pembayaran</span></a>

            </li>
            <li class="nav-item dropdown {{ $type_menu === 'produk' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-tags"></i><span>Produk</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('produk') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('produk.index') }}">Daftar Produk</a>
                    </li>
                    <li class="{{ Request::is('kategori') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('kategori.index') }}">Kategori Produk</a>
                    </li>
                </ul>
            </li>
            @if (Auth::user()->role == 'Admin')
                <li class="nav-item dropdown {{ $type_menu === 'user' ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="nav-link ha"><i
                            class="fas fa-users"></i><span>Users</span></a>

                </li>
            @else
            @endif

        </ul>
    </aside>
</div>
