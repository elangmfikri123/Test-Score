<div class="pcoded-navigatio-lavel">Admin</div>
<ul class="pcoded-item pcoded-left-item">

    {{-- Dashboard --}}
    <li class="{{ request()->is('admin') ? 'active pcoded-trigger' : '' }}">
        <a href="{{ url('/admin') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Dashboard</span>
        </a>
    </li>

    {{-- Data User --}}
    <li class="pcoded-hasmenu {{ request()->is('listuser') || request()->is('listjuri') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
            <span class="pcoded-mtext">Data User</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('listuser') ? 'active' : '' }}">
                <a href="{{ url('/listuser') }}"><span class="pcoded-mtext">Data User</span></a>
            </li>
            <li class="{{ request()->is('listjuri') ? 'active' : '' }}">
                <a href="{{ url('/listjuri') }}"><span class="pcoded-mtext">Data Juri</span></a>
            </li>
        </ul>
    </li>

    {{-- Data Registrasi --}}
    <li class="pcoded-hasmenu {{ request()->is('listpeserta') || request()->is('submission/klhr') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ion-ios-people"></i></span>
            <span class="pcoded-mtext">Data Registrasi</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('listpeserta') ? 'active' : '' }}">
                <a href="{{ url('/listpeserta') }}"><span class="pcoded-mtext">Data Peserta</span></a>
            </li>
            <li class="{{ request()->is('submission/klhr') ? 'active' : '' }}">
                <a href="{{ url('/submission/klhr') }}"><span class="pcoded-mtext">Submission KLHR</span></a>
            </li>
        </ul>
    </li>

    {{-- Other --}}
    <li class="pcoded-hasmenu {{ request()->is('categorylist') || request()->is('maindealerlist') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ion-android-settings"></i></span>
            <span class="pcoded-mtext">Other</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('categorylist') ? 'active' : '' }}">
                <a href="{{ url('/categorylist') }}"><span class="pcoded-mtext">Category</span></a>
            </li>
            <li class="{{ request()->is('maindealerlist') ? 'active' : '' }}">
                <a href="{{ url('/maindealerlist') }}"><span class="pcoded-mtext">Main Dealer</span></a>
            </li>
        </ul>
    </li>

    {{-- Course --}}
    <li class="pcoded-hasmenu {{ request()->is('admin/exams') || request()->is('admin/manage-participants') || request()->is('admin/results') || request()->is('admin/results/details') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-edit-1"></i></span>
            <span class="pcoded-mtext">Course</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('admin/exams') ? 'active' : '' }}">
                <a href="{{ url('/admin/exams') }}"><span class="pcoded-mtext">Manage Course</span></a>
            </li>
            <li class="{{ request()->is('admin/manage-participants') ? 'active' : '' }}">
                <a href="{{ url('/admin/manage-participants') }}"><span class="pcoded-mtext">Manage Participants</span></a>
            </li>
            <li class="{{ request()->is('admin/results') ? 'active' : '' }}">
                <a href="{{ url('/admin/results') }}"><span class="pcoded-mtext">Result Course</span></a>
            </li>
            <li class="{{ request()->is('admin/results/details') ? 'active' : '' }}">
                <a href="{{ url('/admin/results/details') }}"><span class="pcoded-mtext">Result Answers</span></a>
            </li>
        </ul>
    </li>

    {{-- Score Card --}}
    <li class="pcoded-hasmenu {{ request()->is('admin/scorecardlist') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
            <span class="pcoded-mtext">Score Card</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('admin/scorecardlist') ? 'active' : '' }}">
                <a href="{{ url('/admin/scorecardlist') }}"><span class="pcoded-mtext">Manage Score Card</span></a>
            </li>
            <li class="{{ request()->is('admin/resultscorecard') ? 'active' : '' }}">
                <a href="/admin/resultscorecard"><span class="pcoded-mtext">Results Scoring</span></a>
            </li>
        </ul>
    </li>

</ul>
