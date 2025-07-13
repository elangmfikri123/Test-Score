<div class="pcoded-navigatio-lavel">Admin Main Dealer</div>
<ul class="pcoded-item pcoded-left-item">

    {{-- Dashboard --}}
    <li class="{{ request()->is('admin-maindealers/index') ? 'active pcoded-trigger' : '' }}">
        <a href="{{ url('/admin-maindealers/index') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Dashboard</span>
        </a>
    </li>

    {{-- Administrasi --}}
    <li class="pcoded-hasmenu {{ request()->is('listpeserta') || request()->is('submission/klhr') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
            <span class="pcoded-mtext">Administrasi</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('listpeserta') ? 'active' : '' }}">
                <a href="{{ url('/listpeserta') }}">
                    <span class="pcoded-mtext">Registrasi Peserta</span>
                </a>
            </li>
            <li class="{{ request()->is('submission/klhr') ? 'active' : '' }}">
                <a href="{{ url('/submission/klhr') }}">
                    <span class="pcoded-mtext">Submission KLHR</span>
                </a>
            </li>
        </ul>
    </li>

    {{-- Lampiran & Panduan --}}
    <li class="pcoded-hasmenu {{ request()->is('admin-maindealers/lampiran') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
            <span class="pcoded-mtext">Lampiran & Panduan</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('admin-maindealers/lampiran') ? 'active' : '' }}">
                <a href="{{ url('/admin-maindealers/lampiran') }}">
                    <span class="pcoded-mtext">File Lampiran</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
