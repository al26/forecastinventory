<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button> {{-- <a class="navbar-brand" href="./"><img src="{{asset('img/logo.png')}}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{asset('img/logo2.png')}}" alt="Logo"></a> --}}
            <a class="navbar-brand font-weight-bolder" href="./">Forecastinventory</a>
            <a class="navbar-brand font-weight-bolder hidden" href="./">FI</a>
        </div>
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href=""> <i class="menu-icon fas fa-tachometer-alt"></i> Dasbor </a>
                </li>
                {{-- <h3 class="menu-title">Kelola Bahan Baku</h3> --}}
                
                @hasrole('administrator')
                {{-- peramalan --}}
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-chart-line"></i> Peramalan</a>
                    <ul class="sub-menu children dropdown-menu">
                    <li><i class="menu-icon fas fa-history fa-flip-horizontal"></i><a href="{{route('forecast.index')}}">Ramal</a></li>
                        {{-- <li><i class="menu-icon fas fa-poll"></i><a href="">Hasil Peramalan</a></li> --}}
                    </ul>
                </li>
                @endhasrole
                @hasrole('administrator|production')
                {{-- Sell History --}}
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-chart-line"></i> Data Penjualan</a>
                    <ul class="sub-menu children dropdown-menu">
                    <li><i class="menu-icon fas fa-history fa-flip-horizontal"></i><a href="{{route('sh.index')}}">Lihat Data Penjualan</a></li>
                        {{-- <li><i class="menu-icon fas fa-poll"></i><a href="">Hasil Peramalan</a></li> --}}
                    </ul>
                </li>
                @endhasrole
                {{-- production --}}
                @hasrole('administrator|production')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-box"></i>Production</a>
                    <ul class="sub-menu children dropdown-menu fa-ul">
                        <li><i class="fas fa-puzzle-piece"></i><a href="{{route('production',['role'=>Auth::user()->getRoleNames()[0]])}}">Data Produksi</a></li>
                        <li><i class="fa fa-id-badge"></i><a href="{{route('runningproduction',['role'=>Auth::user()->getRoleNames()[0]])}}">Produksi Berjalan</a></li>
                        <li><i class="fa fa-id-badge"></i><a href="{{route('finishproduction',['role'=>Auth::user()->getRoleNames()[0]])}}">Produksi Selesai</a></li>
                    </ul>
                </li>
                @endhasrole
                {{-- bahan baku --}}
                @hasrole('administrator|production|logistic')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-box-open"></i> Bahan Baku</a>
                    <ul class="sub-menu children dropdown-menu fa-ul">
                        <li><i class="fas fa-puzzle-piece"></i><a href="{{route('materialstock',['role'=>Auth::user()->getRoleNames()[0]])}}">Stock Bahanbaku</a></li>
                        @hasrole('administrator|logistic')
                        <li><i class="fas fa-puzzle-piece"></i><a href="{{route('materialneeds.logistic',['role'=>Auth::user()->getRoleNames()[0]])}}">Kebutuhan Bahanbaku</a></li>
                        @endhasrole
                    </ul>
                </li>
                @endhasrole
                @hasrole('administrator|logistic')
                {{-- pengadaan bahan baku --}}
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-boxes"></i>Restock Bahan Baku</a>
                    <ul class="sub-menu children dropdown-menu fa-ul">
                    <li><i class="fas fa-puzzle-piece"></i><a href="{{route('purchasedata',['role'=>Auth::user()->getRoleNames()[0]])}}">Data Pembelian</a></li>
                        
                    </ul>
                </li> 
                @endhasrole
                {{-- product --}}
                @hasrole('administrator|production')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-tshirt"></i>Product</a>
                    <ul class="sub-menu children dropdown-menu fa-ul">
                    <li><i class="fas fa-puzzle-piece"></i><a href="{{route('productview',['role'=>Auth::user()->getRoleNames()[0]])}}">Data Product</a></li>
                        
                    </ul>
                </li>
                @endhasrole
                {{-- <h3 class="menu-title">Forecasting</h3> --}}
               
                <li class="">
                    <a class="" href="{{ route('logout') }}" onclick="javascript:confirmLogout(this, event);" confirmation-text="Anda yakin akan keluar dari aplikasi ?">
                        <i class="menu-icon fas fa-sign-out-alt"></i>
                        Logout
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>