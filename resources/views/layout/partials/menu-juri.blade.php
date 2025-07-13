<div class="pcoded-navigatio-lavel">Juri</div>
<ul class="pcoded-item pcoded-left-item">

    {{-- Home Juri --}}
    <li class="{{ request()->is('juri/index') ? 'active pcoded-trigger' : '' }}">
        <a href="{{ url('/juri/index') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Home</span>
        </a>
    </li>

    {{-- Score Card --}}
    <li class="pcoded-hasmenu {{ request()->is('peserta/list') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
            <span class="pcoded-mtext">Score Card</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('peserta/list') ? 'active' : '' }}">
                <a href="{{ url('/peserta/list') }}">
                    <span class="pcoded-mtext">Peserta List</span>
                </a>
            </li>
        </ul>
    </li>

</ul>
