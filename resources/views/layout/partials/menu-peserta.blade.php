<div class="pcoded-navigatio-lavel">Peserta</div>
<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded-hasmenu active pcoded-trigger">
        <a href="{{ url('/peserta/index') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Home</span>
        </a>
    </li>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
            <span class="pcoded-mtext">Ujian</span>
        </a>
        <ul class="pcoded-submenu">
            <li class=" ">
                <a href="{{ url('/participants/quizlist') }}">
                    <span class="pcoded-mtext">List Ujian</span>
                </a>
            </li>
        </ul>
    </li>
</ul>