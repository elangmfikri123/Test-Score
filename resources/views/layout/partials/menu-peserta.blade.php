<div class="pcoded-navigatio-lavel">Peserta</div>
<ul class="pcoded-item pcoded-left-item">

    {{-- Menu Home --}}
    <li class="{{ request()->is('peserta/index') ? 'active pcoded-trigger' : '' }}">
        <a href="{{ url('/peserta/index') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Home</span>
        </a>
    </li>

    {{-- Menu Ujian --}}
    <li class="pcoded-hasmenu {{ request()->is('participants/*') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
            <span class="pcoded-mtext">Tes Online</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('participants/quizlist') ? 'active' : '' }}">
                <a href="{{ url('/participants/quizlist') }}">
                    <span class="pcoded-mtext">Daftar Ujian</span>
                </a>
            </li>
        </ul>
    </li>

</ul>
