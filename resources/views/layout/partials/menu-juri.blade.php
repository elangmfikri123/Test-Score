<div class="pcoded-navigatio-lavel">Juri</div>
<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu active pcoded-trigger">
        <a href="{{ url('/juri/index') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Home</span>
        </a>
    </li>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
            <span class="pcoded-mtext">Score Card</span>
        </a>
        <ul class="pcoded-submenu">
            <li class=" ">
                <a href="{{ url('/peserta/list') }}">
                    <span class="pcoded-mtext">Peserta List</span>
                </a>
            </li>
        </ul>
    </li>
</ul>