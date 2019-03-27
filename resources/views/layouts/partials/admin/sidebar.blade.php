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
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-box-open"></i> Bahan Baku</a>
                    {{-- <ul class="sub-menu children dropdown-menu fa-ul">
                        <li><i class="fas fa-puzzle-piece"></i><a href="ui-buttons.html">Inventory List</a></li>
                        <li><i class="fa fa-id-badge"></i><a href="ui-badges.html">Badges</a></li>
                        <li><i class="fa fa-bars"></i><a href="ui-tabs.html">Tabs</a></li>
                        <li><i class="fa fa-share-square-o"></i><a href="ui-social-buttons.html">Social Buttons</a></li>
                        <li><i class="fa fa-id-card-o"></i><a href="ui-cards.html">Cards</a></li>
                        <li><i class="fa fa-exclamation-triangle"></i><a href="ui-alerts.html">Alerts</a></li>
                        <li><i class="fa fa-spinner"></i><a href="ui-progressbar.html">Progress Bars</a></li>
                        <li><i class="fa fa-fire"></i><a href="ui-modals.html">Modals</a></li>
                        <li><i class="fa fa-book"></i><a href="ui-switches.html">Switches</a></li>
                        <li><i class="fa fa-th"></i><a href="ui-grids.html">Grids</a></li>
                        <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li>
                    </ul> --}}
                </li>
                {{-- <h3 class="menu-title">Forecasting</h3> --}}
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-chart-line"></i> Peramalan</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fas fa-history fa-flip-horizontal"></i><a href="">Ramal</a></li>
                        <li><i class="menu-icon fas fa-poll"></i><a href="">Hasil Peramalan</a></li>
                    </ul>
                </li>
                <li class="">
                    <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="menu-icon fas fa-sign-out-alt"></i>
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</aside>