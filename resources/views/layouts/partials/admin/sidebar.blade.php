<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button> {{-- <a class="navbar-brand" href="./"><img src="{{asset('img/logo.png')}}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{asset('img/logo2.png')}}" alt="Logo"></a> --}}
            <a class="navbar-brand font-weight-bolder" href="./">{{config('app.sort_name')}}</a>
            <a class="navbar-brand font-weight-bolder hidden" href="./">{{config('app.name')[0]}}</a>
        </div>
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="/{{auth()->user()->roles[0]->name}}"> <i class="menu-icon fas fa-tachometer-alt"></i> Dasbor </a>
                </li>
                {{-- <h3 class="menu-title">Kelola Bahan Baku</h3> --}}
                
                @hasrole('administrator|production')
                {{-- Sell History --}}
                <li class="">
                    <a href="{{route('sh.index')}}"><i class="menu-icon fas fa-chart-bar"></i> Data Penjualan</a>
                </li>
                @endhasrole
                @hasrole('administrator')
                {{-- peramalan --}}
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-chart-line"></i> Peramalan</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fas fa-history fa-flip-horizontal"></i><a href="{{route('forecast.define')}}">Ramal</a></li>
                        <li><i class="menu-icon fas fa-calculator"></i><a href="{{route('forecast.history')}}">Riwayat Perhitungan</a></li>
                    </ul>
                </li>
                @endhasrole
                {{-- production --}}
                @hasrole('administrator|production')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-warehouse"></i>Produksi</a>
                    <ul class="sub-menu children dropdown-menu fa-ul">
                        <li><i class="fas fa-tasks"></i><a href="{{route('production',['role'=>Auth::user()->getRoleNames()[0]])}}">Data Produksi</a></li>
                        <li><i class="fa fa-hourglass-half"></i><a href="{{route('runningproduction',['role'=>Auth::user()->getRoleNames()[0]])}}">Produksi Berjalan</a></li>
                        <li><i class="fa fa-hourglass-end"></i><a href="{{route('finishproduction',['role'=>Auth::user()->getRoleNames()[0]])}}">Produksi Selesai</a></li>
                    </ul>
                </li>
                @endhasrole
                {{-- bahan baku --}}
                @hasrole('administrator|production|logistic')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-boxes"></i> Bahan Baku</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fas fa-layer-group"></i><a href="{{route('materialstock',['role'=>Auth::user()->getRoleNames()[0]])}}">Stok Bahan Baku</a></li>
                        @hasrole('administrator|logistic')
                        <li><i class="fas fa-shopping-basket"></i><a href="{{route('materialneeds.logistic',['role'=>Auth::user()->getRoleNames()[0]])}}">Kebutuhan Bahan Baku</a></li>
                        <li><i class="fas fa-shopping-cart"></i><a href="{{route('purchasedata',['role'=>Auth::user()->getRoleNames()[0]])}}">Pembelian Bahan Baku</a></li>
                        @endhasrole
                    </ul>
                </li>
                @endhasrole
                {{-- product --}}
                @hasrole('administrator|production')
                <li class="">
                    <a href="{{route('productview',['role'=>Auth::user()->getRoleNames()[0]])}}">
                        <i class="menu-icon fas fa-box-open"></i> 
                        Data Produk
                    </a>
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